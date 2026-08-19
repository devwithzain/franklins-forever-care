<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $email = strtolower(trim($request->email ?? ''));
        $request->merge(['email' => $email]);

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'No account found with this email address.',
        ]);

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in database
        DB::table('otps')->updateOrInsert(
            ['email' => $email],
            [
                'code' => $otp,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Send Email
        try {
            Mail::to($email)->send(new ForgotPasswordOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP mail: ' . $e->getMessage());
        }

        return redirect()->route('password.verify-otp-view', ['email' => $email])
            ->with('status', 'An OTP code has been sent to your email address.');
    }

    public function verifyOtpView(Request $request): View
    {
        $email = strtolower(trim($request->query('email', session('email', ''))));
        return view('auth.verify-otp', ['email' => $email]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = strtolower(trim($request->email ?? ''));
        $request->merge(['email' => $email]);

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'array', 'size:6'],
        ]);

        $otpCode = implode('', $request->otp);

        $record = DB::table('otps')
            ->where('email', $email)
            ->where('code', $otpCode)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withInput(['email' => $email])->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        // Generate a temporary token for the reset page
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => \Hash::make($token), 'created_at' => now()]
        );

        // Delete OTP after verification
        DB::table('otps')->where('email', $email)->delete();

        return redirect()->route('password.reset', ['token' => $token, 'email' => $email]);
    }
}

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
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in database
        DB::table('otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $otp,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Send Email
        Mail::to($request->email)->send(new ForgotPasswordOtpMail($otp));

        return redirect()->route('password.verify-otp-view', ['email' => $request->email]);
    }

    public function verifyOtpView(Request $request): View
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'array', 'size:6'],
        ]);

        $otpCode = implode('', $request->otp);

        $record = DB::table('otps')
            ->where('email', $request->email)
            ->where('code', $otpCode)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        // Generate a temporary token for the reset page (mimicking Laravel's behavior)
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => \Hash::make($token), 'created_at' => now()]
        );

        // Delete OTP after verification
        DB::table('otps')->where('email', $request->email)->delete();

        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }
}

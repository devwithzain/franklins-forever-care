<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorMail;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->two_factor_enabled) {
            $code = rand(100000, 999999);

            $user->update([
                'two_factor_code' => Hash::make($code),
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new TwoFactorMail($code));

            $request->session()->put('2fa_user_id', $user->id);
            Auth::logout();

            return redirect()->route('2fa.view');
        }

        $request->session()->regenerate();

        return $this->redirectUser($user);
    }

    public function twoFactorView(): View
    {
        return view('auth.verify-2fa');
    }

    public function verifyTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'array', 'size:6'],
        ]);

        $userId = $request->session()->get('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);
        $otpCode = implode('', $request->otp);

        if (!Hash::check($otpCode, $user->two_factor_code) || now()->gt($user->two_factor_expires_at)) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        Auth::login($user);
        $request->session()->forget('2fa_user_id');
        $request->session()->regenerate();

        return $this->redirectUser($user);
    }

    protected function redirectUser($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'employee') {
            return redirect()->intended(route('employee.dashboard'));
        }

        if ($user->role === 'client' || $user->role === 'user') {
            return redirect()->intended(route('client.dashboard'));
        }

        return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

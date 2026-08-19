<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\User;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification for authenticated users.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        if ($request->user()) {
            $request->user()->sendEmailVerificationNotification();
        }

        return back()->with('status', 'A new verification link has been sent to your email address.');
    }

    /**
     * Resend verification email for guest users.
     */
    public function resend(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('status', 'If an account exists for that email address and is unverified, a new verification link has been sent.');
    }
}

@extends('layouts.auth')
@section('title', 'Login')
@section('auth-content')
    <div class="min-h-screen flex items-center justify-center relative">
        <div
            class="fixed top-[-120px] left-[-120px] w-[400px] h-[400px] bg-[radial-gradient(circle,rgba(26,60,220,0.12)_0%,transparent_70%)] rounded-full pointer-events-none">
        </div>
        <div
            class="fixed bottom-[-100px] right-[-100px] w-[350px] h-[350px] bg-[radial-gradient(circle,rgba(26,60,220,0.10)_0%,transparent_70%)] rounded-full pointer-events-none">
        </div>
        <div class="w-full max-w-[440px]">
            <div
                class="bg-theme-card rounded-[14px] border border-theme-border shadow-[0_4px_24px_rgba(26,60,220,0.12)] p-9">
                <div class="mb-7">
                    <div class="w-full flex items-center justify-center mb-5">
                        <img class="w-80 h-auto object-cover block dark:hidden" src="{{ asset('assets/logo.png') }}"
                            alt="Logo">
                        <img class="w-80 h-auto object-cover hidden dark:block"
                            src="{{ asset('assets/logoDark.png') }}" alt="Logo">
                    </div>
                    <div class="text-[22px] font-bold text-theme-text-main">Welcome Back</div>
                    <div class="text-[13px] text-theme-text-muted mt-1">Sign in to your account</div>
                </div>
                @if ($errors->any())
                    <div
                        class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-[9px] p-3 text-[13px] text-red-700 dark:text-red-400 mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        @if (str_contains(implode(' ', $errors->all()), 'verified') && old('email'))
                            <form method="POST" action="{{ route('verification.resend') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="email" value="{{ old('email') }}">
                                <button type="submit" class="text-[12px] font-bold text-theme-primary hover:underline bg-transparent border-none p-0 cursor-pointer">
                                    Click here to resend verification email
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
                @if (session('status'))
                    <div
                        class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-[9px] p-3 text-[13px] text-green-700 dark:text-green-400 mb-4">
                        {{ session('status') }}
                    </div>
                @endif <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5" for="email">Email
                            address</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-theme-text-muted pointer-events-none">
                                <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </span>
                            <input
                                class="w-full pl-9 pr-3.5 py-2.5 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                                type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="you@example.com" required autofocus autocomplete="email" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5"
                            for="password">Password</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-theme-text-muted pointer-events-none">
                                <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input
                                class="w-full pl-9 pr-3 py-2 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                                type="password" id="password" name="password" placeholder="••••••••" required
                                autocomplete="current-password" />
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-10">
                        <label class="flex items-center gap-1.5 text-[13px] text-theme-text-muted cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="accent-theme-primary w-[15px] h-[15px] rounded-sm border-theme-border bg-theme-card">
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[13px] text-theme-primary font-semibold no-underline hover:underline">Forgot
                                password?</a>
                        @endif
                    </div> <button type="submit"
                        class="w-full py-3 bg-theme-primary text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-theme-primary-hover hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" x2="3" y1="12" y2="12" />
                        </svg>
                        LogIn
                    </button>
                </form>
                 <div class="flex justify-center items-center mt-5 gap-2">
                        <p class="flex items-center gap-1.5 text-[13px] text-theme-text-muted cursor-pointer">
                            Don't have an account?
                        </p>
                        <a href="{{ route('register') }}"
                            class="text-[13px] text-theme-primary font-semibold no-underline hover:underline">Register</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
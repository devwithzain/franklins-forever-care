@extends('layouts.auth')
@section('title', 'Reset Password')
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
                    <div class="text-[22px] font-bold text-theme-text-main">Set New Password</div>
                    <div class="text-[13px] text-theme-text-muted mt-1">Your identity is verified. Create a strong new password.</div>
                </div>

                @if ($errors->any())
                    <div
                        class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-[9px] p-3 text-[13px] text-red-700 dark:text-red-400 mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <input type="hidden" name="token" value="{{ request()->token }}">

                    <div class="mb-4">
                        <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5" for="password">New
                            Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#64748b] pointer-events-none">
                                <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input
                                class="w-full pl-9 pr-3.5 py-2.5 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                                type="password" id="password" name="password" placeholder="••••••••" required autofocus />
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-[13px] font-semibold text-theme-text-main mb-1.5"
                            for="password_confirmation">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#64748b] pointer-events-none">
                                <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input
                                class="w-full pl-9 pr-3.5 py-2.5 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                                type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="••••••••" required />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-[#1a3cdc] text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-[#1230b0] hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
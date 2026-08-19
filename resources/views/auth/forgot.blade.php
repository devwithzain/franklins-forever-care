@extends('layouts.auth')
@section('title', 'Forgot Password')
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
                    <div class="text-[22px] font-bold text-theme-text-main">Forgot Password?</div>
                    <div class="text-[13px] text-[#64748b] mt-1">No worries, we'll send you an OTP to reset it.</div>
                </div>

                @if ($errors->any())
                    <div class="bg-[#fee2e2] border border-[#fecaca] rounded-[9px] p-3 text-[13px] text-[#b91c1c] mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-[13px] font-semibold text-[#1e293b] mb-1.5" for="email">Email
                            address</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#64748b] pointer-events-none">
                                <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </span>
                            <input
                                class="w-full pl-9 pr-3.5 py-2.5 border-[1.5px] border-theme-border rounded-[9px] text-[13.5px] text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light placeholder:text-theme-text-muted"
                                type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="you@example.com" required autofocus />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-[#1a3cdc] text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-[#1230b0] hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
                        Send OTP Code
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </button>

                    <div class="text-center mt-6">
                        <a href="{{ route('login') }}"
                            class="text-[13px] text-[#1a3cdc] font-semibold no-underline hover:underline flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
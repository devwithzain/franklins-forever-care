@extends('layouts.auth')
@section('title', 'OTP Verification')
@section('auth-content')
    <div class="bg-theme-bg min-h-screen flex items-center justify-center relative">
        <div
            class="fixed top-[-120px] left-[-120px] w-[400px] h-[400px] bg-[radial-gradient(circle,rgba(26,60,220,0.12)_0%,transparent_70%)] rounded-full pointer-events-none">
        </div>
        <div
            class="fixed bottom-[-100px] right-[-100px] w-[350px] h-[350px] bg-[radial-gradient(circle,rgba(26,60,220,0.10)_0%,transparent_70%)] rounded-full pointer-events-none">
        </div>
        <div class="w-full max-w-[440px]">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-9">
                <div class="mb-7">
                    <div class="w-full flex items-center justify-center mb-5">
                        <img class="w-60 h-auto object-cover" src="{{ asset('assets/logo.png') }}" alt="Logo">
                    </div>
                    <div class="text-[22px] font-bold text-theme-text-main">Verify Your Email</div>
                    <div class="text-[13px] text-theme-text-muted mt-1">Enter the 6-digit code we sent to your email.</div>
                </div>

                @if ($errors->any())
                    <div
                        class="bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-[9px] p-3 text-[13px] text-red-700 dark:text-red-400 mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('password.verify-otp') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->email }}">

                    <div class="flex justify-between gap-2 mb-8">
                        @for($i = 1; $i <= 6; $i++)
                            <input type="text" name="otp[]" maxlength="1"
                                class="otp-input w-12 h-14 border-[1.5px] border-theme-border rounded-[9px] text-center text-[20px] font-bold text-theme-text-main bg-theme-card outline-none transition focus:border-theme-primary focus:shadow-[0_0_0_3px_rgba(26,60,220,0.08)]"
                                required onkeyup="moveNext(this, {{ $i }})">
                        @endfor
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-[#1a3cdc] text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-[#1230b0] hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
                        Verify Code
                    </button>
                    <div class="text-center mt-6">
                        <p class="text-[13px] text-[#64748b]">Didn't receive the code?
                            <a href="#" class="text-[#1a3cdc] font-semibold hover:underline">Resend OTP</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function moveNext(input, index) {
                if (input.value.length === 1 && index < 6) {
                    document.querySelectorAll('.otp-input')[index].focus();
                }
            }
        </script>
    </div>
@endsection
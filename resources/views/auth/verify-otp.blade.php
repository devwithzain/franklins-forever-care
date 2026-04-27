<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP – Franklin's Forever Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f0f2f8] min-h-screen flex items-center justify-center relative">
    <div class="fixed top-[-120px] left-[-120px] w-[400px] h-[400px] bg-[radial-gradient(circle,rgba(26,60,220,0.12)_0%,transparent_70%)] rounded-full pointer-events-none"></div>
    <div class="fixed bottom-[-100px] right-[-100px] w-[350px] h-[350px] bg-[radial-gradient(circle,rgba(26,60,220,0.10)_0%,transparent_70%)] rounded-full pointer-events-none"></div>

    <div class="w-full max-w-[440px]">
        <div class="bg-white rounded-[14px] border border-[#e2e8f0] shadow-[0_4px_24px_rgba(26,60,220,0.12)] p-9">
            <div class="text-center mb-7">
                <div class="w-14 h-14 bg-[#1a3cdc] rounded-[16px] flex items-center justify-center mx-auto mb-3 shadow-[0_8px_24px_rgba(26,60,220,0.25)]">
                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 11 12 14 22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </div>
                <div class="text-[22px] font-bold text-[#1e293b]">Verify Your Email</div>
                <div class="text-[13px] text-[#64748b] mt-1">Enter the 6-digit code we sent to your email.</div>
            </div>

            @if ($errors->any())
                <div class="bg-[#fee2e2] border border-[#fecaca] rounded-[9px] p-3 text-[13px] text-[#b91c1c] mb-4">
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
                            class="otp-input w-12 h-14 border-[1.5px] border-[#e2e8f0] rounded-[9px] text-center text-[20px] font-bold text-[#1e293b] bg-white outline-none transition focus:border-[#1a3cdc] focus:shadow-[0_0_0_3px_rgba(26,60,220,0.08)]"
                            required onkeyup="moveNext(this, {{ $i }})">
                    @endfor
                </div>

                <button type="submit" class="w-full py-3 bg-[#1a3cdc] text-white border-none rounded-[9px] text-[14px] font-bold cursor-pointer transition hover:bg-[#1230b0] hover:shadow-[0_4px_16px_rgba(26,60,220,0.2)] flex items-center justify-center gap-2">
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
</body>
</html>

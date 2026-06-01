<div class="w-full padding-x padding-y bg-white flex items-center justify-center min-h-screen">
    <div class="max-w-2xl w-full text-center mx-auto p-16 border border-black/10 rounded-lg">
        <div
            class="mb-10 inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 text-green-500 shadow-xl shadow-green-100/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-[56px] lg:text-[48px] md:text-[40px] leading-tight font-bold text-black dmserif mb-6">
            Payment Received!
        </h1>
        <p class="text-gray-500 paragraph mb-12 max-w-lg mx-auto">
            Thank you for trusting Franklin's Forever Care. Your booking for
            <strong>{{ $booking->patient_name }}</strong> has been confirmed. Our care specialist will contact you
            within 24 hours to schedule the initial assessment.
        </p>


        <div class="bg-[#f8f9fa] rounded-3xl p-8 border border-gray-100 mb-12 text-left space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Booking ID</span>
                <span class="font-bold text-black">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Amount Paid</span>
                <span class="text-xl font-bold text-[#7E80B0]">${{ number_format($booking->amount, 2) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Plan Type</span>
                <span
                    class="px-3 py-1 bg-[#DDEEE7] text-[#4A9D7A] rounded-full text-[10px] font-black uppercase">{{ $booking->plan_type }}</span>
            </div>
        </div>

        <div class="flex items-center justify-center gap-6 flex-wrap">
            <a href="{{ route('client.dashboard') }}"
                class="bg-[#7E80B0] text-white px-10 py-5 rounded-md font-bold hover:bg-[#F0BB4C] hover:text-black transition-all duration-300 shadow-lg">
                Go to Dashboard
            </a>
            <a href="#" onclick="window.print()"
                class="text-gray-400 font-bold hover:text-black transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Receipt
            </a>
        </div>
    </div>
</div>
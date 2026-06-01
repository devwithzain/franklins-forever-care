@extends('layouts.frontend')

@section('title', 'Service Checkout - ' . $service->title)

@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <div class="w-full padding-x mt-20 padding-y bg-white">
        <div class="w-full padding-x">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-3 gap-10 lg:grid-cols-1">
                    <div class="col-span-2 space-y-8">
                        <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100">
                            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                                <div
                                    class="w-12 h-12 rounded-full bg-[#F0BB4C] flex items-center justify-center text-black font-bold">
                                    1</div>
                                <h2 class="text-2xl font-bold text-black dmserif">Patient Information</h2>
                            </div>
                            <form id="payment-form" action="{{ route('service.booking.store') }}" method="POST"
                                class="space-y-6">
                                @csrf
                                @if(session('error'))
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-red-700">
                                                    {{ session('error') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <input type="hidden" name="plan_type" value="{{ $planSlug }}">
                                <div class="grid grid-cols-2 gap-6 sm:grid-cols-1">
                                    <div class="space-y-1.5">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Patient
                                            Name</label>
                                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" required
                                            placeholder="e.g. Mary Doe"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                        @error('patient_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Patient
                                            Age</label>
                                        <input type="text" name="patient_age" value="{{ old('patient_age') }}" required
                                            placeholder="e.g. 75"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                        @error('patient_age') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Relationship
                                        to Patient</label>
                                    <select name="relationship" required
                                        class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all appearance-none">
                                        <option value="">Select Relationship</option>
                                        <option value="mother" {{ old('relationship') == 'mother' ? 'selected' : '' }}>Mother
                                        </option>
                                        <option value="father" {{ old('relationship') == 'father' ? 'selected' : '' }}>Father
                                        </option>
                                        <option value="spouse" {{ old('relationship') == 'spouse' ? 'selected' : '' }}>Spouse
                                        </option>
                                        <option value="other" {{ old('relationship') == 'other' ? 'selected' : '' }}>Other
                                            Relative</option>
                                    </select>
                                    @error('relationship') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                 <div class="space-y-1.5">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Contact
                                            No</label>
                                        <input type="number" name="phone" value="{{ old('phone') }}" required
                                            placeholder="e.g. 01712345678"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                        @error('phone') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                <div class="flex items-center gap-4 mb-8 pt-6 pb-6 border-b border-gray-50">
                                    <div
                                        class="w-12 h-12 rounded-full bg-[#F0BB4C] flex items-center justify-center text-black font-bold">
                                        2</div>
                                    <h2 class="text-2xl font-bold text-black dmserif">Care Location & Schedule</h2>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Street
                                        Address</label>
                                    <input type="text" name="address" value="{{ old('address') }}" required
                                        placeholder="123 Care Street"
                                        class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                    @error('address') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="grid grid-cols-3 gap-4 sm:grid-cols-1">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">City</label>
                                        <input type="text" name="city" value="{{ old('city') }}" required placeholder="City"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">State</label>
                                        <input type="text" name="state" value="{{ old('state') }}" required
                                            placeholder="State"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Zip
                                            Code</label>
                                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" required
                                            placeholder="Zip"
                                            class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Preferred
                                        Start Date</label>
                                    <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" required
                                        class="w-full h-14 rounded-md border border-gray-100 bg-gray-50 px-5 outline-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">
                                    @error('preferred_date') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Special
                                        Requirements / Notes</label>
                                    <textarea name="notes" rows="4"
                                        placeholder="Any specific medical conditions or requests..."
                                        class="w-full rounded-md border border-gray-100 bg-gray-50 p-5 outline-none resize-none focus:ring-1 focus:ring-[#7E80B0] focus:bg-white transition-all">{{ old('notes') }}</textarea>
                                </div>
                                <div class="flex items-center gap-4 mb-8 pt-6 pb-6 border-b border-gray-50">
                                    <div
                                        class="w-12 h-12 rounded-full bg-[#F0BB4C] flex items-center justify-center text-black font-bold">
                                        3</div>
                                    <h2 class="text-2xl font-bold text-black dmserif">Payment Information</h2>
                                </div>
                                <div class="space-y-4">
                                    <div class="space-y-1.5">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Card
                                            Details</label>
                                        <div id="card-element"
                                            class="w-full rounded-md border border-gray-100 bg-gray-50 p-4">
                                        </div>
                                        <div id="card-errors" role="alert" class="text-red-500 text-[11px] mt-1">
                                            @error('payment_method_id') {{ $message }} @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" id="submit-button"
                                        class="w-full bg-[#7E80B0] hover:bg-[#F0BB4C] text-white hover:text-black transition-all duration-300 font-bold px-8 h-16 rounded-md flex items-center justify-center gap-3 shadow-xl group">
                                        <span id="button-text">Complete Request & Pay</span>
                                        <div id="spinner"
                                            class="hidden w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin">
                                        </div>
                                        <svg id="arrow-icon" xmlns="http://www.w3.org/2000/svg"
                                            class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                    <p class="text-center text-gray-400 text-xs mt-4 italic">
                                        By clicking complete, you agree to our terms and conditions. No payment is required
                                        until care plan confirmation.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 sticky top-[160px]">
                            <h3 class="text-xl font-bold text-black dmserif mb-6 pb-4 border-b border-gray-50">Order Summary
                            </h3>
                            <div class="flex gap-4 mb-6">
                                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ $service->image ? asset($service->image) : asset('assets/service-detail.jpg') }}"
                                        alt="service" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-black leading-tight">{{ $service->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">{{ $package->name }}
                                        Plan</p>
                                </div>
                            </div>
                                 <div class="flex justify-between">
                                    <span class="text-gray-500">Care Plan Cost</span>
                                    <span
                                        class="font-bold text-black">{{ $package->price }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Service Fee</span>
                                    <span class="font-bold text-black">$0.00</span>
                                </div>
                                <div class="flex justify-between pt-4 border-t border-gray-50">
                                    <span class="text-lg font-bold text-black">Total</span>
                                    <span
                                        class="text-lg font-bold text-[#7E80B0]">{{ $package->price }}</span>
                                </div>
                            <div class="mt-8 bg-[#DDEEE7] p-4 rounded-xl flex gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#4A9D7A] shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-xs text-[#2E6A51] leading-relaxed">
                                    <strong>Free Assessment:</strong> This request includes a free in-home safety assessment
                                    by our lead care specialist.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stripeKey = "{{ config('services.stripe.key') }}";
        if (!stripeKey) {
            console.error("Stripe Key is missing! Please check your .env file.");
            document.getElementById('card-errors').textContent = "Payment system is not configured correctly.";
        }
        const stripe = Stripe(stripeKey);
        const elements = stripe.elements();

        const style = {
            base: {
                color: '#000000',
                fontFamily: '"DM Sans", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const card = elements.create('card', {
            style: style,
            hidePostalCode: true,
        });
        card.mount('#card-element');

        card.on('change', function (event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');
            const arrowIcon = document.getElementById('arrow-icon');

            submitButton.disabled = true;
            buttonText.textContent = 'Processing...';
            spinner.classList.remove('hidden');
            arrowIcon.classList.add('hidden');

            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', card, {
                billing_details: { name: document.querySelector('input[name="patient_name"]').value }
            }
            );

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;

                submitButton.disabled = false;
                buttonText.textContent = 'Complete Request & Pay';
                spinner.classList.add('hidden');
                arrowIcon.classList.remove('hidden');
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
@endsection
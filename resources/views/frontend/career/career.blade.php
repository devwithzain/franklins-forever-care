<div class="w-full padding-x padding-y bg-white">
    <div class="w-full">
        <div class="grid grid-cols-2 gap-16 items-center lg:grid-cols-1">
            <div
                class="bg-gradient-to-br from-[#DDEEE7] to-[#F6ECD9] rounded-3xl px-10 py-14 shadow-sm border border-white">
                <h2 class="subHeading font-semibold text-black mb-6 leading-tight dmserif text-center">
                    Application Form
                </h2>
                <form action="{{ route('career.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-1">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Full
                                Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                placeholder="e.g. John Doe"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('full_name') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Email
                                Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="e.g. john@example.com"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('email') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-1">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                placeholder="+1 (555) 000-0000"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('phone') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Zip
                                Code</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code') }}" required
                                placeholder="12345"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('zip_code') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Street
                            Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" required
                            placeholder="123 Main St, Apt 4B"
                            class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                        @error('address') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-1">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required placeholder="New York"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('city') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">State</label>
                            <input type="text" name="state" value="{{ old('state') }}" required placeholder="NY"
                                class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#7E80B0] transition-all">
                            @error('state') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1">Your Experience
                            / Message</label>
                        <textarea name="message" rows="4" placeholder="Tell us about your background in caregiving..."
                            class="w-full rounded-xl border-0 bg-white p-5 outline-none resize-none focus:ring-2 focus:ring-[#7E80B0] transition-all">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-[11px] ml-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#7E80B0] hover:bg-[#F0BB4C] text-white hover:text-black transition-all duration-300 font-bold px-8 h-14 rounded-xl flex items-center justify-center gap-2 shadow-lg group">
                        Submit Application
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="space-y-6">
                <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
                    <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
                        Careers
                    </p>
                </div>
                <h1 class="heading font-semibold leading-tight text-black dmserif">
                    Become Part Of Our<br>
                    <span class="relative inline-block text-[#7E80B0]">
                        Compassionate Team
                    </span>
                </h1>
                <p class="text-[#666666] font-medium paragraph leading-normal">
                    At Franklin's Forever Care, we are always looking for dedicated, compassionate, and professional
                    individuals to join our care team. If you have a passion for providing high-quality care and
                    want to make a difference in the lives of seniors, we'd love to hear from you.
                </p>
                <div class="space-y-4 pt-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#DDEEE7] flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#4A9D7A]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-black">Competitive Compensation</h4>
                            <p class="text-gray-500 smallParagraph">We offer industry-leading pay and benefits to
                                our valued team members.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#F6ECD9] flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#DFA15B]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-black">Flexible Scheduling</h4>
                            <p class="text-gray-500 smallParagraph">Work schedules that respect your work-life
                                balance and personal needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
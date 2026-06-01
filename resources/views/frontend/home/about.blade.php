<div class="w-full relative padding-x padding-y bg-white">
    <div class="w-full flex items-center gap-10">
        <div class="w-2/6 relative">
            <img src="{{ asset('assets/about.jpg') }}" alt="About Us"
                class="w-full h-[700px] object-cover rounded-3xl rounded-tr-[50%]">
        </div>
        <div class="w-2/3 flex flex-col gap-8 relative">
            <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
                <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
                    About Us
                </p>
            </div>
            <h2 class="heading text-black font-semibold dmserif leading-tight tracking-wide">
                Compassionate Home Care Services For Everyday
                Healthy Living
            </h2>
            <p class="paragraph text-[#666666] font-medium leading-normal max-w-3xl">
                Elderly Home and Senior Care services are dedicated to providing a nurturing, secure, and
                supportive environment for older adults who may require assistance with daily activities,
                medical needs, or simply companionship.
            </p>
            <div class="flex items-start gap-4">
                <div
                    class="w-20 h-20 shrink-0 rounded-full bg-white flex items-center justify-center border border-[#e0e0e0]">
                    <img src="{{ asset('assets/abouticon.png') }}" alt="About Us">
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="text-2xl text-black font-medium dmserif leading-tight">Maintaining Independence
                    </h3>
                    <p class="paragraph text-[#666666] font-medium leading-normal max-w-xl">
                        With trained caregivers, healthcare professionals, and a range of recreational programs,
                        elderly homes aim
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                @foreach (['Keeping Them Safe and Comfortable', 'Degenerative disorders, such as MS or ALS', 'Take Care of Medication Reminders'] as $item)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 shrink-0 rounded-full bg-[#F0BB4C] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </span>
                        <p class="paragraph text-black font-medium leading-tight">{{ $item }}</p>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center gap-5 mt-2">
                <a href="{{ route('about') }}"
                    class="bg-[#F0BB4C] text-white subparagraph flex items-center gap-2 font-medium px-6 py-4 rounded-md hover:bg-[#7E80B0] transition-all duration-300">
                    More About Us
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 7l-10 10" />
                        <path d="M8 7l9 0l0 9" />
                    </svg>
                </a>
                <div class="flex items-center gap-5">
                    <button
                        class="bg-[#7E80B0] text-white subparagraph flex items-center gap-2 font-medium px-4 py-4 rounded-full hover:bg-[#F0BB4C] hover:text-black transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="M3 7l9 6l9 -6" />
                        </svg>
                    </button>
                    <div class="flex flex-col items-start gap-2">
                        <p class="paragraph text-[#666666] font-medium leading-tight">Mail Us</p>
                        <p class="paragraph text-black font-semibold leading-tight">helpfranklins@gmail.com
                        </p>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 bg-[#D9ECFF] rounded-3xl p-7 flex flex-col gap-2">
                <div class="flex items-center justify-between gap-1">
                    <span class="heading text-black dmserif font-semibold leading-none">40+</span>
                    <span class="smallParagraph text-[#666666] font-medium leading-tight my-4 text-center">expert
                        team<br>member</span>
                </div>
                <div class="rounded-xl overflow-hidden h-40">
                    <img src="{{ asset('assets/about2.jpg') }}" alt="Team" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="w-full bg-white padding-x padding-y">
    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 space-y-4">
                <div class="w-fit mx-auto bg-[#F0BB4C] rounded-full px-5 py-2.5">
                    <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
                        Pricing Plans
                    </p>
                </div>
                <h1 class="heading font-semibold leading-tight text-black dmserif">
                    Choose The Best Care <br>
                    <span class="relative inline-block text-[#7E80B0]">
                        For Your Loved Ones
                        <svg class="absolute -bottom-10 left-0 w-full" viewBox="0 0 120 20" fill="none">
                            <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                </h1>
                <p class="max-w-2xl mx-auto text-[#666666] paragraph pt-7">
                    We offer flexible care packages tailored to meet the unique health and lifestyle needs of every
                    senior. Select a plan to begin the consultation.
                </p>
            </div>
            @if(isset($selectedService) && $selectedService)
                <div
                    class="mb-12 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#DDEEE7] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#4A9D7A]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Selected Service</p>
                            <h4 class="text-xl font-bold text-black">{{ $selectedService->title }}</h4>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        @foreach($services as $s)
                            <a href="{{ route('packages', ['service' => $s->id]) }}"
                                class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $selectedService->id == $s->id ? 'bg-[#7E80B0] text-white' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                                {{ $s->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-3 gap-8 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1">
                @foreach($packages as $package)
                    @php
                        $packagePlanKey = strtolower(str_replace(' ', '', $package['name']));
                        $isSubscribed = in_array($packagePlanKey, $userSubscriptions ?? []);
                    @endphp
                    <div class="relative group">
                        @if($package['popular'])
                            <div
                                class="absolute -top-4 left-1/2 -translate-x-1/2 z-10 bg-[#F0BB4C] text-black text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full shadow-lg">
                                Most Popular
                            </div>
                        @endif
                        @if($isSubscribed)
                            <div
                                class="absolute -top-4 right-4 z-10 bg-[#4A9D7A] text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full shadow-lg">
                                Active Subscription
                            </div>
                        @endif
                        <div
                            class="h-full bg-white rounded-lg p-10 shadow-sm border border-gray-100 flex flex-col transition-all duration-500 hover:shadow-md hover:-translate-y-2 {{ $package['popular'] ? 'ring-2 ring-[#7E80B0] ring-offset-2 ring-offset-[#f8f9fa]' : '' }} {{ $isSubscribed ? 'opacity-75' : '' }}">
                            <div class="mb-8">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6"
                                    style="background-color: {{ $package['color'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                                        stroke="{{ $package['text_color'] }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-black dmserif mb-2">{{ $package['name'] }}</h3>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl font-black text-black">{{ $package['price'] }}</span>
                                    <span class="text-gray-400 font-medium">{{ $package['duration'] }}</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <p class="text-xs font-black text-gray-300 uppercase tracking-[0.2em] mb-6">What's Included
                                </p>
                                <ul class="space-y-4 mb-10">
                                    @foreach($package['features'] as $feature)
                                        <li class="flex items-start gap-3">
                                            <div
                                                class="w-5 h-5 rounded-full bg-[#DDEEE7] flex items-center justify-center shrink-0 mt-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-[#4A9D7A]"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-[#666666] text-[15px] font-medium leading-tight">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($isSubscribed)
                                <div class="w-full py-5 rounded-lg font-bold text-sm bg-[#4A9D7A] text-white flex items-center justify-center gap-2 cursor-default">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Currently Subscribed
                                </div>
                            @else
                                <a href="{{ route('service.checkout', ['slug' => (isset($selectedService) ? $selectedService->slug : (isset($services) ? (collect($services)->first()->slug ?? 'default') : 'default')), 'plan' => strtolower(str_replace(' ', '', $package['name']))]) }}"
                                    class="w-full py-5 rounded-lg font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 {{ $package['popular'] ? 'bg-[#7E80B0] text-white hover:bg-[#F0BB4C] hover:text-black shadow-lg shadow-[#7E80B0]/20' : 'bg-gray-100 text-[#666666] hover:bg-[#7E80B0] hover:text-white' }}">
                                    Choose This Package
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-20 text-center bg-white p-12 rounded-lg shadow-sm border border-gray-100 max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-black dmserif mb-4">Need a custom plan?</h3>
                <p class="text-gray-500 mb-8 px-10">
                    If our standard packages don't fit your specific situation, our care team can build a custom roadmap
                    for you.
                </p>
                <div class="flex items-center justify-center gap-6 flex-wrap">
                    <a href="{{ route('contact') }}"
                        class="flex items-center gap-2 font-bold text-[#7E80B0] hover:text-[#F0BB4C] transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#f8f9fa] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Talk to a Specialist
                    </a>
                    <span class="w-px h-8 bg-gray-100 hidden sm:block"></span>
                    <a href="tel:+15551234567"
                        class="flex items-center gap-2 font-bold text-[#7E80B0] hover:text-[#F0BB4C] transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#f8f9fa] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        +1 (555) 123-4567
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
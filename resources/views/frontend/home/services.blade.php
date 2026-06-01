<section class="relative overflow-hidden bg-white padding-x padding-y">
   <div class="absolute inset-0 z-0">
      <img src="{{ asset('assets/services-bg.png') }}" alt="Services Background" class="w-full h-full object-cover">
   </div>
   <div class="w-full relative flex flex-col gap-10 z-10">
      <div class="w-full flex flex-col items-center justify-center gap-3">
         <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
               Our Services
            </p>
         </div>
         <div>
            <h2 class="heading font-semibold leading-tight text-black dmserif text-center">
               Dedicated To Quality Elderly Care <br> With
               Compassion And
               <span class="relative inline-block">
                  Respect
                  <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 120 20" fill="none">
                     <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
                  </svg>
               </span>
               Always
            </h2>
         </div>
      </div>
      <div
         class="grid grid-cols-3 gap-20 items-center justify-center lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 xm:grid-cols-1">
         <div class="space-y-6">
            @forelse ($services->take(3) as $service)
               <a href="{{ route('service-detail', $service->slug) }}"
                  class="relative bg-[#F0BB4C] rounded-md p-5 flex items-center gap-5 overflow-hidden hover:bg-[#7E80B0] hover:text-white transition-colors ease-linear duration-300 group">
                  <div
                     class="relative z-10 w-20 h-20 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0 overflow-hidden">
                     @if($service->image)
                        <img src="{{ asset($service->image) }}" alt="{{ $service->title }}"
                           class="w-full h-full object-cover">
                     @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor" stroke-width="1.5">
                           <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L12 12m6.894 5.785l-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864l-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                        </svg>
                     @endif
                  </div>
                  <h3
                     class="text-2xl lg:text-xl font-semibold text-black dmserif group-hover:text-white transition-colors duration-300">
                     {{ $service->title }}
                  </h3>
               </a>
            @empty
               <div class="text-gray-400 text-sm py-6">No services available yet.</div>
            @endforelse
         </div>

         <!-- CENTER: Image -->
         <div class="flex justify-center">
            <div class="overflow-hidden rounded-[40px]">
               <img src="{{ asset('assets/service-img.jpg') }}" alt=""
                  class="w-full h-full object-cover rounded-3xl rounded-bl-[50%] min-h-[600px]">
            </div>
         </div>

         <!-- RIGHT: Info + CTA -->
         <div class="flex flex-col gap-5">
            <h3 class="text-4xl font-semibold leading-snug text-black dmserif">
               Our Personalized Approach Ensures
               That Seniors Receive The Care
            </h3>
            <p class="text-[#666666] leading-relaxed paragraph">
               These facilities are designed to support the social
               well-being of older adults through personalized care
               plans, professional medical support engaging
            </p>
            <div class="space-y-5">
               @forelse ($services->slice(3)->take(3) as $service)
                  <div class="flex items-center gap-4">
                     <div class="w-7 h-7 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0">
                        ✓
                     </div>
                     <p class="text-xl text-black">{{ $service->title }}</p>
                  </div>
               @empty
                     {{-- Fallback static items if < 4 services exist --}} <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0">✓</div>
                        <p class="text-xl text-black">Nutritious meal planning</p>
                  </div>
                  <div class="flex items-center gap-4">
                     <div class="w-7 h-7 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0">✓</div>
                     <p class="text-xl text-black">Companionship and social activities</p>
                  </div>
                  <div class="flex items-center gap-4">
                     <div class="w-7 h-7 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0">✓</div>
                     <p class="text-xl text-black">Transportation assistance</p>
                  </div>
               @endforelse
         </div>
         <a href="{{ route('services') }}"
            class="w-fit bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
            View All Services
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
               class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
               <path d="M17 7l-10 10" />
               <path d="M8 7l9 0l0 9" />
            </svg>
         </a>
      </div>
   </div>
   </div>
</section>
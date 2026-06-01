<section class="w-full bg-white padding-x padding-y">
   <div class="w-full flex flex-col gap-5 items-center mb-14 relative z-20">
      <div class="bg-[#F0BB4C] rounded-full px-5 py-2.5">
         <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
            Our Team
         </p>
      </div>
      <div>
         <h2 class="heading font-semibold leading-tight text-black dmserif max-w-4xl text-center">
            Our Friendly Team Of Senior Care
            <span class="relative inline-block">
               Specialist
               <svg class="absolute -bottom-4 left-0 w-full" viewBox="0 0 120 20" fill="none">
                  <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
            And Advisors
         </h2>
      </div>
      <p class="paragraph text-[#666666] text-center max-w-2xl">
         Meet our dedicated team of caregiving professionals committed to providing the highest standard of senior care.
      </p>
   </div>

   @if(isset($employees) && $employees->count() > 0)
      <div class="swiper teamSwiper">
         <div class="swiper-wrapper">
            @foreach ($employees as $employee)
               <div class="swiper-slide h-auto">
                  <a href="{{ route('team.show', $employee->id) }}" class="block">
                     <div class="bg-white rounded-xl h-full flex flex-col group cursor-pointer">
                        <div class="overflow-hidden rounded-xl relative">
                           @if($employee->user->image)
                              <img src="{{ asset('storage/' . $employee->user->image) }}"
                                 alt="{{ $employee->user->name }}"
                                 class="w-full h-72 object-cover group-hover:scale-105 transition duration-500">
                           @else
                              <div class="w-full h-72 bg-gradient-to-br from-[#F0BB4C]/20 to-[#7E80B0]/20 flex items-center justify-center group-hover:scale-105 transition duration-500">
                                 <div class="w-24 h-24 rounded-full bg-[#7E80B0]/30 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#7E80B0]" viewBox="0 0 24 24" fill="currentColor">
                                       <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                    </svg>
                                 </div>
                              </div>
                           @endif
                           {{-- Hover overlay --}}
                           <div class="absolute inset-0 bg-[#7E80B0]/80 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center rounded-xl">
                              <span class="text-white font-semibold text-sm tracking-wide flex items-center gap-2">
                                 View Profile
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 7l-10 10"/><path d="M8 7l9 0l0 9"/>
                                 </svg>
                              </span>
                           </div>
                        </div>
                        <div class="flex flex-col gap-1.5 text-[#666666] text-sm pt-5">
                           <h3 class="text-2xl font-semibold leading-snug text-black dmserif">
                              {{ $employee->user->name }}
                           </h3>
                           <p class="text-[#666666] leading-relaxed text-base capitalize">
                              {{ $employee->type }} Care Specialist
                           </p>
                           {{-- Rating stars --}}
                           <div class="flex items-center gap-1 mt-1">
                              @for($i = 1; $i <= 5; $i++)
                                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="{{ $i <= round($employee->rating) ? '#F0BB4C' : 'none' }}"
                                    stroke="#F0BB4C" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                 </svg>
                              @endfor
                              <span class="text-xs text-[#999] ml-1">{{ number_format($employee->rating, 1) }}</span>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            @endforeach
         </div>
         <div class="swiper-pagination mt-14 !relative"></div>
      </div>

      <div class="flex justify-center mt-10">
         <a href="{{ route('team.index') }}"
            class="bg-[#7E80B0] text-white subparagraph flex items-center gap-2 font-medium px-8 py-4 rounded-md hover:bg-[#F0BB4C] hover:text-black transition-all duration-300">
            Meet The Full Team
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
               <path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" />
            </svg>
         </a>
      </div>
   @else
      <div class="flex flex-col items-center justify-center py-20 gap-4">
         <div class="w-20 h-20 rounded-full bg-[#F0BB4C]/20 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#F0BB4C]" viewBox="0 0 24 24" fill="currentColor">
               <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
         </div>
         <p class="text-[#666666] text-lg font-medium">No team members available at the moment.</p>
      </div>
   @endif
</section>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      if (document.querySelector(".teamSwiper")) {
         new Swiper(".teamSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
               el: ".teamSwiper .swiper-pagination",
               clickable: true,
            },
            breakpoints: {
               640: { slidesPerView: 1 },
               768: { slidesPerView: 2 },
               1024: { slidesPerView: 4 },
            },
         });
      }
   });
</script>
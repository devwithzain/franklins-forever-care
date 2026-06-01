<section class="relative overflow-hidden bg-[#f5f7fa] padding-x padding-y">
   <div class="w-full flex flex-col gap-12">
      <div class="w-full flex flex-col items-center justify-center gap-3">
         <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">Our Services</p>
         </div>
         <h2 class="heading font-semibold leading-tight text-black dmserif text-center max-w-3xl">
            Dedicated To Quality Elderly Care With
            <span class="relative inline-block">
               Compassion
               <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 120 20" fill="none">
                  <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
            And Respect Always
         </h2>
         <p class="text-[#666] paragraph text-center max-w-2xl mt-2">
            We offer a wide range of professional home care services tailored to meet the unique needs of every senior.
         </p>
      </div>
      @if($services->isNotEmpty())
         <div class="grid grid-cols-3 gap-8 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 xm:grid-cols-1">
            @foreach($services as $service)
               <div class="bg-white rounded-2xl p-6 flex flex-col group shadow-sm transition-all duration-500">
                  <a href="{{ route('service-detail', $service->slug) }}" class="overflow-hidden rounded-xl">
                     <img src="{{ $service->image ? asset($service->image) : asset('assets/service-detail.jpg') }}"
                        alt="{{ $service->title }}"
                        class="w-full h-[350px] object-cover group-hover:scale-105 transition duration-500">
                  </a>
                  <div class="flex flex-col gap-4 py-8">
                     <div class="flex items-center gap-4">
                        <h3
                           class="text-3xl font-semibold leading-tight text-black dmserif group-hover:text-[#F0BB4C] transition-colors">
                           <a href="{{ route('service-detail', $service->slug) }}">{{ $service->title }}</a>
                        </h3>
                     </div>
                     @if($service->short_description)
                        <p class="text-[#666] leading-relaxed text-[16px]">
                           {{ Str::limit($service->short_description, 120) }}
                        </p>
                     @endif
                     <a href="{{ route('service-detail', $service->slug) }}"
                        class="w-fit bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
                        Book Appointment
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
            @endforeach
         </div>
         @if($services->hasPages())
            <div class="flex justify-center mt-4">
               {{ $services->links() }}
            </div>
         @endif
      @else
         <div class="text-center py-24 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-5 text-gray-200" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-xl font-semibold text-gray-300">No services available yet.</p>
            <p class="mt-2 text-sm">Check back soon or contact us for more information.</p>
         </div>
      @endif
   </div>
</section>
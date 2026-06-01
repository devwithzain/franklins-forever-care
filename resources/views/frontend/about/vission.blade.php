@php
   $visions = [
      [
         'icon' => 'vision1.png',
         'image' => 'vision4.jpg',
         'title' => 'Our Mission',
         'desc' => 'Our mission is to create meaningful impact delivering innovative reliable and sustainable solutions empower individuals and communities we are committed.'
      ],
      [
         'icon' => 'vision2.png',
         'image' => 'vision5.jpg',
         'title' => 'Our Vision',
         'desc' => 'Our vision is to be a leading force for positive change shaping a future where innovation and drive progress for all we aspire to build a world where.'
      ],
      [
         'icon' => 'vision3.png',
         'image' => 'vision6.jpg',
         'title' => 'Our Success',
         'desc' => 'Our success is defined by the positive outcomes create the trust we build and the value deliver to those serve it reflected in the strong relationships.'
      ],
   ];
@endphp
<section class="padding-x padding-y overflow-hidden relative">
   <div class="absolute inset-0 z-0">
      <img src="{{ asset('assets/visionbg.png') }}" alt="Hero Background" class="w-full h-full object-cover">
   </div>
   <div class="w-full flex flex-col gap-5 items-center mb-14 relative z-20">
      <div class="bg-[#F0BB4C] rounded-full px-5 py-2.5">
         <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
            Our Vision
         </p>
      </div>
      <div>
         <h2 class="heading font-semibold leading-tight text-black dmserif max-w-4xl text-center">
            Dedicated To Quality Elderly Care With
            <span class="relative inline-block">
               Compassion
               <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 120 20" fill="none">

                  <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
            And Respect Always
         </h2>
      </div>
   </div>
   <div class="swiper vissionSwiper">
      <div class="swiper-wrapper">
         @foreach ($visions as $vision)
            <div class="swiper-slide h-auto">
               <div class="bg-white rounded-xl p-6 h-full flex flex-col group">
                  <div class="overflow-hidden rounded-xl">
                     <img src="{{ asset('assets/' . $vision['image']) }}" alt="{{ $vision['title'] }}"
                        class="w-full h-[400px] object-cover group-hover:scale-105 transition duration-500">
                  </div>
                  <div class="flex flex-col gap-4 text-[#666666] text-sm py-10">
                     <div class="flex items-center gap-2">
                        <div
                           class="w-20 h-20 rounded-full border border-[#e0e0e0] flex items-center justify-center shrink-0">
                           <img src="{{ asset('assets/' . $vision['icon']) }}" alt="{{ $vision['title'] }}">
                        </div>
                        <h3 class="text-3xl font-semibold leading-snug text-black">
                           {{ $vision['title'] }}
                        </h3>
                     </div>
                     <p class="text-[#666666] leading-relaxed text-lg">
                        {{ $vision['desc'] }}
                     </p>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
      <div class="swiper-pagination mt-14 !relative"></div>
   </div>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      new Swiper(".vissionSwiper", {
         slidesPerView: 1,
         spaceBetween: 30,
         loop: true,

         pagination: {
            el: ".vissionSwiper .swiper-pagination",
            clickable: true,
         },

         breakpoints: {
            640: {
               slidesPerView: 1,
            },

            768: {
               slidesPerView: 2,
            },

            1024: {
               slidesPerView: 3,
            },
         },
      });
   });
</script>
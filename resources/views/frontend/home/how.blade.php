<div class="w-full relative padding-x padding-y bg-white">
   <div class="w-full flex items-end gap-16">
      <div class="w-2/6 shrink-0 flex flex-col gap-5">
         <div class="bg-[#D9ECFF] rounded-3xl rounded-tr-[50%] p-8 flex flex-col justify-between gap-8 min-h-[620px]">
            <h3 class="text-2xl text-black font-medium dmserif leading-tight max-w-sm">
               We Believe In Fostering An Environment That Promotes Independence And Respects
            </h3>
            <div class="flex items-center justify-center">
               <img src="{{ asset('assets/work.png') }}" alt="" class="w-80 h-full object-cover">
            </div>
         </div>
      </div>
      <div class="w-2/3 flex flex-col gap-5">
         <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
               How We Work
            </p>
         </div>
         <h2 class="heading text-black font-semibold dmserif leading-tight">
            Delivering Holistic Senior Care That Honors Each Individual's
            <span class="relative inline-block">
               Lifestyle
               <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 160 10" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 7 Q40 0 80 5 Q120 10 160 4" stroke="#F0BB4C" stroke-width="2.5" fill="none"
                     stroke-linecap="round" />
               </svg>
            </span>
         </h2>
         <div class="grid grid-cols-2 overflow-hidden">
            @php
               $services = [
                  [
                     'title' => 'Home Care',
                     'desc' => 'Our Home Care services are designed to bring comfort, support, and peace of mind right to your doorstep.',
                     'icon' => 'work1.png',
                  ],
                  [
                     'title' => 'Personalized Care',
                     'desc' => 'We believe that every individual is unique; care should be too. Our personalized care approach is centered around you.',
                     'icon' => 'work2.png',
                  ],
                  [
                     'title' => 'Low-Cost Services',
                     'desc' => 'Quality care shouldn\'t come at a high cost; our services are designed to provide reliable, compassionate support affordably.',
                     'icon' => 'work3.png',
                  ],
                  [
                     'title' => 'Medical Support',
                     'desc' => 'Our Medical Support services are designed to ensure that you or your loved ones receive expert care whenever needed.',
                     'icon' => 'work4.png',
                  ],
               ];
             @endphp
            @foreach ($services as $i => $service)
               <div
                  class="p-6 flex flex-col gap-4 {{ $i % 2 === 0 ? 'border-r border-[#e5e7eb]' : '' }} {{ $i < 2 ? 'border-b border-[#e5e7eb]' : '' }} hover:bg-[#f9fafb] transition-colors duration-300">
                  <div class="flex items-center gap-4">
                     <div
                        class="w-20 h-20 rounded-full bg-[#f0f0f0] border border-[#e0e0e0] flex items-center justify-center shrink-0">
                        <img src="{{ asset('assets/' . $service['icon']) }}" alt="">
                     </div>
                     <h4 class="subHeading text-black font-bold dmserif leading-snug">{{ $service['title'] }}</h4>
                  </div>
                  <p class="paragraph text-[#666666] font-medium leading-normal">{{ $service['desc'] }}</p>
               </div>
            @endforeach
         </div>
      </div>
   </div>
</div>

<style>
   /* Snowflake / asterisk image mosaic */
   .snowflake-grid {
      position: relative;
      width: 260px;
      height: 260px;
   }

   .sf-cell {
      position: absolute;
      overflow: hidden;
      border-radius: 8px;
   }

   /* Top arm */
   .sf-top {
      width: 80px;
      height: 90px;
      top: 0;
      left: 50%;
      transform: translateX(-50%) rotate(0deg);
      clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%);
   }

   /* Middle left arm */
   .sf-mid-left {
      width: 90px;
      height: 80px;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      clip-path: polygon(0% 20%, 100% 0%, 100% 100%, 0% 80%);
   }

   /* Center square */
   .sf-mid-center {
      width: 100px;
      height: 100px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(45deg);
      border-radius: 12px;
      overflow: hidden;
   }

   .sf-mid-center img {
      transform: rotate(-45deg) scale(1.5);
      transform-origin: center;
   }

   /* Middle right arm */
   .sf-mid-right {
      width: 90px;
      height: 80px;
      top: 50%;
      right: 0;
      transform: translateY(-50%);
      clip-path: polygon(0% 0%, 100% 20%, 100% 80%, 0% 100%);
   }

   /* Bottom arm */
   .sf-bottom {
      width: 80px;
      height: 90px;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      clip-path: polygon(0% 0%, 100% 0%, 80% 100%, 20% 100%);
   }
</style>
<div class="w-full relative padding-x padding-y bg-white">
   <div class="w-full flex items-center gap-10">
      <div class="w-[60%] flex flex-col gap-5">
         <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
               Why Choose Us
            </p>
         </div>
         <h2 class="heading text-black font-bold dmserif leading-tight">
            Welcome To Senior Care. <br> Our Goal Is To Make Your Life
            <span class="relative inline-block italic">
               Better
               <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 120 10" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 7 Q30 0 60 5 Q90 10 120 4" stroke="#F0BB4C" stroke-width="2.5" fill="none"
                     stroke-linecap="round" />
               </svg>
            </span>
         </h2>
         <p class="paragraph text-[#666666] font-medium leading-normal max-w-3xl">
            We are dedicated to providing a safe, comfortable, and compassionate environment where seniors can
            spend their golden years with dignity and peace of mind. Our experienced caregivers are here for you.
         </p>
         <div class="grid grid-cols-2 gap-0 overflow-hidden">
            @php
               $features = [
                  [
                     'title' => 'Free Medical CheckUp',
                     'desc' => 'With a team of trained and compassionate people, we focus on promoting independence and comfort.',
                     'icon' => 'why-choose1.png',
                  ],
                  [
                     'title' => 'Low-Cost Services',
                     'desc' => 'Our team of compassionate caregivers is committed to delivering personalized care, including.',
                     'icon' => 'why-choose2.png',
                  ],
               ];
             @endphp
            @foreach ($features as $i => $feature)
               <div class="p-7 flex flex-col gap-4 {{ $i === 0 ? 'border-r-2 border-[#e5e7eb]' : '' }}">
                  <div class="w-20 h-20 rounded-full bg-[#7E80B0] flex items-center justify-center shrink-0">
                     <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['title'] }}">
                  </div>
                  <h4 class="subHeading text-black font-bold dmserif leading-snug">{{ $feature['title'] }}</h4>
                  <p class="paragraph text-[#666666] font-medium leading-normal">{{ $feature['desc'] }}</p>
               </div>
            @endforeach
         </div>
         <div class="flex items-center gap-6 mt-1">
            <a href="{{ route('contact') }}"
               class="bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-6 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
               Get In Touch
               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M17 7l-10 10" />
                  <path d="M8 7l9 0l0 9" />
               </svg>
            </a>
            <div class="flex items-center gap-3">
               <div
                  class="w-12 h-12 rounded-full bg-[#f1f3f4] flex items-center justify-center shrink-0 border border-[#e5e7eb]">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                     <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                     <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                     <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                     <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                  </svg>
               </div>
               <div class="flex flex-col">
                  <p class="paragraph text-black font-bold leading-tight">4.8/5.0</p>
                  <p class="smallParagraph text-[#666666] font-medium leading-tight">Google Ratings</p>
               </div>
            </div>
         </div>
      </div>
      <div class="w-2/6 shrink-0">
         <div class="overflow-hidden w-full">
            <img src="{{ asset('assets/whychooseusimg.jpg') }}" alt="Senior Care"
               class="w-full h-full object-cover rounded-3xl rounded-bl-[50%] min-h-[700px]">
         </div>
      </div>
   </div>
</div>
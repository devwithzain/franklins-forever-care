<section class="w-full">
   <div class="bg-[#7E80B0] relative overflow-hidden">
      <div class="absolute inset-0 opacity-10">
         <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
               <pattern id="grid" width="80" height="80" patternUnits="userSpaceOnUse">
                  <path d="M 80 0 Q 40 40 0 80" fill="none" stroke="white" stroke-width="1" />
               </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
         </svg>
      </div>
      <div class="padding-x py-14 relative z-10">
         <div class="grid grid-cols-2 gap-10 items-center">
            <div class="space-y-2">
               <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
                  <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
                     Newsletter
                  </p>
               </div>
               <h2 class="heading text-white font-bold leading-tight dmserif">
                  Subscribe To Our <br>
                  <span class="relative inline-block">
                     Newsletter
                     <svg class="absolute -bottom-4 left-0 w-full" viewBox="0 0 120 20" fill="none">
                        <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
                     </svg>
                  </span>
               </h2>
            </div>
            <div>
               <form class="space-y-3">
                  <div class="flex bg-white rounded-lg overflow-hidden">
                     <input type="email" placeholder="Enter Your Email"
                        class="flex-1 px-5 outline-none border-none text-black focus:border-none focus:outline-none focus:ring-0">
                     <button
                        class="bg-[#F0BB4C] hover:bg-[#7E80B0] transition px-8 text-black hover:text-white font-medium flex items-center justify-center gap-2 h-14 m-1 rounded-lg cursor-pointer">
                        Subscribe
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 17L17 7M7 7h10v10" />
                        </svg>
                     </button>
                  </div>
                  <label class="flex items-center gap-3 text-white text-sm">
                     <input type="checkbox" class="rounded border-white cursor-pointer">
                     <span>
                        I understand and agree to the
                        <a href="#" class="underline">
                           Terms & Conditions
                        </a>
                     </span>
                  </label>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
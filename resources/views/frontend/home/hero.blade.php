<div class="w-full h-screen relative padding-x">
   <div class="absolute inset-0 z-0">
      <img src="{{ asset('assets/her-banner-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover">
   </div>
   <div class="w-[90%] mx-auto h-full flex items-center justify-center relative z-10">
      <div class="w-1/2 flex flex-col gap-5">
         <div class="flex items-center gap-2">
            <span class="smallParagraph bg-[#7E80B0] w-2 h-2 rounded-full"></span>
            <p class="paragraph text-[#7E80B0] font-medium leading-tight capitalize">Welcome to Franklin's Forever
               Home Care
            </p>
         </div>
         <h1 class="heading text-black font-semibold dmserif leading-tight max-w-xl tracking-wide">We Provide
            Quality
            Home Care For
            Your Loved
            Ones
         </h1>
         <p class="paragraph text-[#666666] font-medium leading-normal max-w-2xl">Elderly Home and Senior Care services
            provide a safe, comfortable, and compassionate environment for seniors who need assistance with daily living
            care.
         </p>
         <div class="flex items-center gap-5">
            <a href="{{ route('contact') }}"
               class="bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
               Get In Touch
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M17 7l-10 10" />
                  <path d="M8 7l9 0l0 9" />
               </svg>
            </a>
            <div class="flex items-center gap-5">
               <button
                  class="bg-[#7E80B0] text-white subparagraph flex items-center gap-2 font-medium px-4 py-4 rounded-full hover:bg-[#F0BB4C] hover:text-black transition-all duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-phone-call">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                     <path
                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                     <path d="M15 7a2 2 0 0 1 2 2" />
                     <path d="M15 3a6 6 0 0 1 6 6" />
                  </svg>
               </button>
               <div class="flex flex-col items-start gap-2">
                  <p class="paragraph text-[#666666] font-medium leading-tight">Need Help</p>
                  <p class="paragraph text-black font-semibold leading-tight">+1 (444) 507 8494
                  </p>
               </div>
            </div>
         </div>
      </div>
      <div class="w-1/2 h-full flex flex-col items-center gap-4 relative">
         <div class="w-full absolute bottom-0 z-0">
            <img src="{{ asset('assets/home-hero-img01.png') }}" alt="Hero Image"
               class="w-full h-[700px] object-contain">
            <span class="dmserif"
               style="width: 100%; font-size: 100px; font-style: normal; font-weight: 400; line-height: 100px; text-transform: uppercase; background: transparent; color: transparent; -webkit-text-stroke: 1px rgba(255, 255, 255, 1); user-select: none; position: absolute; top: -7%; left: 50%; transform: translate(-50%, 0);z-index: -1; text-align: center;">senior
               care</span>
            <div class="absolute bottom-1/2 right-0 translate-y-1/2 space-y-2">
               <div class="flex items-center">
                  <img src="{{ asset('assets/user01.jpg') }}"
                     class="w-14 h-14 rounded-full border-2 border-white object-cover -ml-0">
                  <img src="{{ asset('assets/user02.jpg') }}"
                     class="w-14 h-14 rounded-full border-2 border-white object-cover -ml-4">
                  <img src="{{ asset('assets/user03.jpg') }}"
                     class="w-14 h-14 rounded-full border-2 border-white object-cover -ml-4">
               </div>
               <h2 class="subHeading text-black font-semibold leading-normal dmserif">
                  300K+ People
               </h2>
               <p class="smallParagraph text-[#666666] font-medium leading-normal">
                  Individuals who have trusted <br> Franklin's services
               </p>
            </div>
         </div>
         <div
            class="max-w-sm absolute bottom-20 bg-[#00000088] border border-[#ffffff80] rounded-lg -left-20 space-y-2">
            <div class="flex items-center p-4 gap-4">
               <div class="shrink-0">
                  <img src="{{ asset('assets/home-hero-img02.jpg') }}" alt="banner-img" class="rounded-lg">
               </div>
               <div class="space-y-2">
                  <p class="smallParagraph text-white font-medium leading-normal">“We are committed to delivering
                     high-quality services.”</p>
                  <p class="smallParagraph text-white font-medium leading-normal">Travis Morrison
                     <span class="smallParagraph text-white font-medium leading-normal">- Founder</span>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
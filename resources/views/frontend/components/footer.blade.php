<footer class="w-[98%] relative padding-x rounded-2xl overflow-hidden mx-auto mb-5">
   <div class="absolute inset-0 z-0">
      <img src="{{ asset('assets/footer-bg.jpg') }}" alt="footer-bg" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-black/90"></div>
   </div>
   <div class="relative w-full max-w-screen-2xl mx-auto">
      <div class="grid grid-cols-4 gap-10 py-24 border-b border-white/10">
         <div class="flex flex-col gap-6">
            <a href="#" class="block">
               <img src="{{ asset('assets/logo.png') }}" alt="Logo"
                  class="w-36 object-contain filter brightness-0 invert">
            </a>
            <p class="smallParagraph text-gray-300 leading-normal">
               Stay connected with the latest news, helpful tips, and heartwarming stories from our blog
            </p>
            <form action="#" class="flex flex-col gap-3 w-full">
               <div class="relative w-full">
                  <input type="email" placeholder="Enter Your Email"
                     class="w-full bg-white text-black smallParagraph px-4 py-3.5 rounded-md pr-12 focus:outline-none focus:ring-2 focus:ring-[#F0BB4C]">
                  <button type="submit"
                     class="absolute right-1.5 top-1.5 bottom-1.5 bg-[#7E80B0] hover:bg-[#F0BB4C] hover:text-black transition-colors duration-300 text-white rounded px-3 flex items-center justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 14l11 -11" />
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                     </svg>
                  </button>
               </div>
               <label class="flex items-start gap-2 cursor-pointer mt-2">
                  <input type="checkbox"
                     class="mt-1 w-4 h-4 rounded border-gray-500 text-[#7E80B0] focus:ring-[#7E80B0] bg-transparent">
                  <span class="smallParagraph text-gray-300">I understand and agree to the <a
                        href="{{ route('terms-conditions') }}"
                        class="text-white underline hover:text-[#F0BB4C] transition-colors">Terms &
                        Conditions</a></span>
               </label>
            </form>
         </div>
         <div class="flex flex-col gap-6">
            <div class="relative">
               <h3 class="dmserif text-white subHeading font-medium tracking-wide">Useful Link</h3>
               <div class="w-12 h-0.5 bg-[#7E80B0] mt-3 relative overflow-hidden">
                  <div class="absolute w-4 h-full bg-[#F0BB4C] left-0"></div>
               </div>
            </div>
            <div class="flex flex-col gap-4">
               <a href="{{ route('about') }}"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Learn
                  About us</a>
               <a href="{{ route('packages') }}"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Pricing
                  Plans</a>
               <a href="{{ route('career.index') }}"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Join Our
                  Care
                  Team</a>
               <a href="{{ route('blogs') }}"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">News &
                  Blog</a>
               <a href="{{ route('contact') }}"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Contact
                  Us</a>
            </div>
         </div>
         <div class="flex flex-col gap-6">
            <div class="relative">
               <h3 class="dmserif text-white subHeading font-medium tracking-wide">Our Services</h3>
               <div class="w-12 h-0.5 bg-[#7E80B0] mt-3 relative overflow-hidden">
                  <div class="absolute w-4 h-full bg-[#F0BB4C] left-0"></div>
               </div>
            </div>
            <div class="flex flex-col gap-4">
               <a href="/service/rehabilitation-services"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Rehabilitation
                  Services
               </a>
               <a href="/service/home-safety-assessments"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Home
                  Safety Assessments
               </a>
               <a href="/service/personalized-care-plans"
                  class="smallParagraph font-medium text-gray-300 hover:text-[#F0BB4C] transition-colors w-fit">Personalized
                  Care Plans
               </a>
            </div>
         </div>
         <div class="flex flex-col gap-6">
            <div class="relative">
               <h3 class="dmserif text-white subHeading font-medium tracking-wide">Get In Touch</h3>
               <div class="w-12 h-0.5 bg-[#7E80B0] mt-3 relative overflow-hidden">
                  <div class="absolute w-4 h-full bg-[#F0BB4C] left-0"></div>
               </div>
            </div>
            <div class="flex flex-col gap-6">
               <div class="flex items-start gap-3">
                  <div class="mt-1 text-[#F0BB4C]">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin">
                        <path
                           d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" />
                     </svg>
                  </div>
                  <div class="flex flex-col gap-1.5">
                     <h4 class="text-white font-bold smallParagraph">Location</h4>
                     <p class="smallParagraph text-gray-300">1901 Thorndike Cir. Shiloh, Hawaii 81063</p>
                  </div>
               </div>
               <div class="flex items-start gap-3">
                  <div class="mt-1 text-[#F0BB4C]">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-mail">
                        <path
                           d="M22 7.535v9.465a3 3 0 0 1 -2.824 2.995l-.176 .005h-14a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-9.465l9.445 6.297l.116 .066a1 1 0 0 0 .878 0l.116 -.066l9.445 -6.297z" />
                        <path
                           d="M19 4c1.08 0 2.027 .57 2.555 1.427l-9.555 6.37l-9.555 -6.37a2.999 2.999 0 0 1 2.354 -1.42l.201 -.007h14z" />
                     </svg>
                  </div>
                  <div class="flex flex-col gap-1.5">
                     <h4 class="text-white font-bold smallParagraph">Email</h4>
                     <a href="mailto:help@franklinscare.com"
                        class="smallParagraph text-gray-300 hover:text-[#F0BB4C] transition-colors">help@franklinscare.com</a>
                  </div>
               </div>
               <div class="flex items-start gap-3">
                  <div class="mt-1 text-[#F0BB4C]">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-phone">
                        <path
                           d="M9 3a1 1 0 0 1 .877 .519l.051 .11l2 5a1 1 0 0 1 -.313 1.16l-.1 .068l-1.674 1.004l.063 .103a10 10 0 0 0 3.132 3.132l.102 .062l1.005 -1.672a1 1 0 0 1 1.113 -.453l.115 .039l5 2a1 1 0 0 1 .622 .807l.007 .121v4c0 1.657 -1.343 3 -3 3a17 17 0 0 1 -16.996 -16.266l-.004 -.234a3 3 0 0 1 2.824 -2.995l.176 -.005h4z" />
                     </svg>
                  </div>
                  <div class="flex flex-col gap-1.5">
                     <h4 class="text-white font-bold smallParagraph">Phone</h4>
                     <a href="tel:+14445078494"
                        class="smallParagraph text-gray-300 hover:text-[#F0BB4C] transition-colors">+1
                        (444) 507 8494</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="flex items-center justify-between gap-4 py-7">
         <p class="smallParagraph text-gray-300">
            &copy; <span class="text-white font-bold">Franklin's Home Care</span> All Rights Reserved.
         </p>
         <div class="flex items-center gap-4">
            <a href="{{ route('privacy-policy') }}"
               class="smallParagraph text-white font-medium hover:text-[#F0BB4C] transition-colors">Privacy
               Policy</a>
            <span class="w-1.5 h-1.5 rounded-full bg-[#7E80B0]"></span>
            <a href="{{ route('terms-conditions') }}"
               class="smallParagraph text-white font-medium hover:text-[#F0BB4C] transition-colors">Terms &
               Conditions</a>
         </div>
      </div>
   </div>
   <button id="scrollToTop"
      class="absolute bottom-6 right-6 lg:right-10 bg-[#7E80B0] hover:bg-[#F0BB4C] text-white hover:text-black transition-all duration-300 w-10 h-10 flex items-center justify-center rounded z-20 shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up">
         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
         <path d="M12 5l0 14" />
         <path d="M18 11l-6 -6" />
         <path d="M6 11l6 -6" />
      </svg>
   </button>
</footer>

<script>
document.getElementById('scrollToTop').addEventListener('click', function() {
   window.scrollTo({
      top: 0,
      behavior: 'smooth'
   });
});
</script>
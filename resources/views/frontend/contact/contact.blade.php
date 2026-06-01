<div class="w-full padding-x padding-y bg-white">
   <div class="w-full grid grid-cols-2 gap-10 items-center">
      <div class="bg-gradient-to-br from-[#DDEEE7] to-[#F6ECD9] rounded-3xl px-10 py-20">
         <h2 class="subHeading font-semibold text-black mb-3 leading-tight dmserif">
            Take A Scheduled Appointment
         </h2>
         <p class="text-[#666666] mb-8">
            Our booking process is simple confidential and flexible to fit your schedule
         </p>
         <form class="space-y-5" action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-5">
               <input type="text" name="name" placeholder="Full Name" required
                  class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#DFA15B]">
               <input type="email" name="email" placeholder="Email" required
                  class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#DFA15B]">
               <input type="text" name="phone" placeholder="Phone"
                  class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#DFA15B]">
               <input type="text" name="subject" placeholder="Subject" required
                  class="w-full h-14 rounded-xl border-0 bg-white px-5 outline-none focus:ring-2 focus:ring-[#DFA15B]">
            </div>
            <textarea rows="5" name="message" placeholder="Write Your Message" required
               class="w-full rounded-xl border-0 bg-white p-5 outline-none resize-none focus:ring-2 focus:ring-[#DFA15B]"></textarea>
            <button type="submit"
               class="bg-[#E8B06B] hover:bg-[#d89a50] transition text-black font-medium px-8 h-14 rounded-xl flex items-center gap-2">
               Send Message
               <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10" />
               </svg>
            </button>
         </form>
      </div>
      <div class="relative space-y-5">
         <div class="w-fit bg-[#F0BB4C] rounded-full px-5 py-2.5">
            <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
               Contact Us
            </p>
         </div>
         <h2 class="heading font-semibold leading-tight text-black dmserif">
            Please Don't Hesitate To<br>
            <span class="relative inline-block">
               Contact Us
               <svg class="absolute -bottom-4 left-0 w-full" viewBox="0 0 120 20" fill="none">
                  <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
            For Your Healthy Life
         </h2>
         <p class="text-[#666666] font-medium paragraph leading-normal">
            Whether provided at home in assisted living facilities or nursing homes
            senior care aims to promote independence while offering safety and comfort.
            Compassionate and personalized care helps seniors maintain their physical
            health mental well being and social connections
         </p>
         <div class="space-y-5">
            <h3 class="subHeading font-semibold text-black leading-tight dmserif">
               Opening Hours
            </h3>
            <div class="space-y-2 text-[#666666] font-medium paragraph leading-normal">
               <p>Monday - Friday, 8 AM - 6 PM</p>
               <p>Saturday - Sunday, 10 AM - 9 PM</p>
            </div>
         </div>
         <div class="space-y-5">
            <h3 class="subHeading font-semibold text-black leading-tight dmserif">
               Social Media
            </h3>
            <div class="flex items-center gap-4">
               <div class="flex items-center gap-2">
                  <a class="smallParagraph text-black font-medium leading-tight rounded-full p-1.5 border border-black hover:bg-[#7E80B0] hover:border-[#7E80B0] hover:text-white transition-all duration-300"
                     href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                     </svg>
                  </a>
                  <a class="smallParagraph text-black font-medium leading-tight rounded-full p-1.5 border border-black hover:bg-[#7E80B0] hover:border-[#7E80B0] hover:text-white transition-all duration-300"
                     href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 4l11.733 16h4.267l-11.733 -16l-4.267 0" />
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                     </svg>
                  </a>
                  <a class="smallParagraph text-black font-medium leading-tight rounded-full p-1.5 border border-black hover:bg-[#7E80B0] hover:border-[#7E80B0] hover:text-white transition-all duration-300"
                     href="#">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4l0 -8" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M16.5 7.5v.01" />
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="absolute right-0 bottom-0">
            <img src="{{ asset('assets/star.png') }}" alt="Star Image" class="w-40 h-40 object-cover">
         </div>
      </div>
   </div>
   <div class="w-full pt-20">
      <iframe
         src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52805896.53512097!2d-161.45637340731136!3d36.11746438821319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2s!4v1778534414521!5m2!1sen!2s"
         width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
         referrerpolicy="no-referrer-when-downgrade"></iframe>
   </div>
</div>
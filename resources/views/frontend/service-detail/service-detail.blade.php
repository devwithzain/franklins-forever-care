<section class="w-full padding-x padding-y bg-white overflow-hidden">
   <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-3 gap-10 lg:gap-8 md:grid-cols-1 sm:grid-cols-1 xm:grid-cols-1">
         <div class="space-y-6">
            <div class="bg-white rounded-[18px] p-6">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-5">
                  Our Services
               </h3>
               <div class="space-y-3">
                  @foreach ($allServices as $s)
                                 <a href="{{ route('service-detail', $s->slug) }}"
                                    class="w-full h-[52px] rounded-lg px-4 flex items-center justify-between text-base transition duration-300 text-black
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   {{ request()->route('slug') == $s->slug
                     ? 'bg-[#F0BB4C]'
                     : 'bg-[#f5f5f5] hover:bg-[#F0BB4C]'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  }}">

                                    <span>{{ $s->title }}</span>

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                       stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                 </a>
                  @endforeach
               </div>
            </div>
            <div class="bg-white rounded-[18px] p-6">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-5">
                  Get In Touch
               </h3>
               <form class="space-y-4">
                  <input type="text" placeholder="Name"
                     class="w-full h-[54px] bg-[#f5f5f5] rounded-lg px-5 outline-none border-none focus:border-none focus:outline-none text-sm">
                  <input type="email" placeholder="Email"
                     class="w-full h-[54px] bg-[#f5f5f5] rounded-lg px-5 outline-none border-none focus:border-none focus:outline-none text-sm">
                  <textarea placeholder="Your message"
                     class="w-full h-[140px] bg-[#f5f5f5] rounded-lg p-5 outline-none border-none focus:border-none focus:outline-none text-sm resize-none"></textarea>
                  <button
                     class="bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
                     Contact Now
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 7l-10 10" />
                        <path d="M8 7l9 0l0 9" />
                     </svg>
                  </button>
               </form>
            </div>
         </div>
         <div class="col-span-2 md:col-span-1 sm:col-span-1 xm:col-span-1">
            <div class="overflow-hidden rounded-[20px] mb-8">
               <img src="{{ $service->image ? asset($service->image) : asset('assets/service-detail.jpg') }}"
                  alt="{{ $service->title }}"
                  class="w-full h-[450px] lg:h-[400px] md:h-[380px] sm:h-[320px] xm:h-[250px] object-cover">
            </div>
            <div class="flex items-center justify-between gap-6 mb-6 flex-wrap">
               <h2
                  class="text-[48px] lg:text-[42px] md:text-[38px] sm:text-[32px] xm:text-[28px] leading-tight font-semibold text-[#111]">
                  {{ $service->title }}
               </h2>
            </div>
            <div class="prose max-w-none text-[#666666] text-[16px] leading-8 mb-5 service-content">
               {!! $service->description !!}
            </div>
            <a href="{{ route('packages') }}"
               class="w-fit bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
               Book Now
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

<style>
   .service-content h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #111;
   }

   .service-content h2 {
      font-size: 2rem;
      font-weight: 600;
      color: #111;
   }

   .service-content h3 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
   }

   .service-content ul,
   .service-content ol {
      padding-left: 1.5rem;
   }

   .service-content ul {
      list-style: disc;
   }

   .service-content ol {
      list-style: decimal;
   }

   .service-content blockquote {
      border-left: 4px solid #F0BB4C;
      padding: 0.75rem 1.25rem;
      background: #f8f9fa;
      margin: 1.5rem 0;
      border-radius: 0 8px 8px 0;
      color: #555;
      font-style: italic;
   }

   .service-content a {
      color: #7E80B0;
      text-decoration: underline;
      font-weight: 600;
   }

   .service-content img {
      max-width: 100%;
      border-radius: 20px;
      margin: 2rem 0;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
   }

   .service-content code {
      background: #f4f4f4;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 0.875rem;
   }

   .service-content pre {
      background: #1e293b;
      color: #f8fafc;
      padding: 1.5rem;
      border-radius: 12px;
      overflow-x: auto;
      margin: 2rem 0;
      font-size: 0.875rem;
   }

   .service-content strong {
      font-weight: 700;
      color: #111;
   }
</style>
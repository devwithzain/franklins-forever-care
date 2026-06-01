<section class="bg-white padding-x padding-y overflow-hidden">
   <div class="w-full flex flex-col gap-5 items-center mb-14">
      <div class="bg-[#F0BB4C] rounded-full px-5 py-2.5">
         <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
            Latest News
         </p>
      </div>
      <div>
         <h2 class="heading font-semibold leading-tight text-black dmserif max-w-4xl text-center">
            Check Out Everything Interesting And Useful
            From The Latest
            <span class="relative inline-block">
               News
               <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 120 20" fill="none">
                  <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
               </svg>
            </span>
         </h2>
      </div>
   </div>

   @if($blogs->isNotEmpty())
      <div class="swiper blogSwiper">
         <div class="swiper-wrapper">
            @foreach ($blogs as $blog)
               @php
                  $date = $blog->published_at ?? $blog->created_at;
               @endphp
               <div class="swiper-slide h-auto">
                  <a href="{{ route('blog-detail', $blog->slug) }}" class="block h-full">
                     <div class="bg-[#FAFAFA] rounded-md p-5 h-full flex flex-col group">
                        <div class="overflow-hidden rounded-md">
                           <img src="{{ $blog->image ? asset($blog->image) : asset('assets/blog01.jpg') }}"
                              alt="{{ $blog->title }}"
                              class="w-full h-[320px] object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="flex items-center gap-4 text-gray-500 text-sm mt-6">
                           <div class="flex items-center gap-2">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                              </svg>
                              {{ $date->format('M d, Y') }}
                           </div>
                           <span>/</span>
                           <div class="flex items-center gap-2">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z" />
                              </svg>
                              {{ $blog->category->name ?? 'General' }}
                           </div>
                        </div>
                        <h3
                           class="text-3xl font-semibold leading-snug mt-5 mb-4 text-black group-hover:text-[#F0BB4C] transition duration-300">
                           {{ $blog->title }}
                        </h3>
                        <p class="text-[#666666] leading-relaxed text-lg flex-1">
                           {{ Str::limit(strip_tags($blog->content), 110) }}
                        </p>
                        <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#F0BB4C]">
                           Read More
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M14 5l7 7m0 0l-7 7m7-7H3" />
                           </svg>
                        </div>
                     </div>
                  </a>
               </div>
            @endforeach
         </div>
         <div class="swiper-pagination mt-14 !relative"></div>
      </div>
   @else
      <div class="text-center py-16 text-gray-400">
         <p class="text-lg">No blog posts published yet.</p>
         <a href="{{ route('blogs') }}" class="mt-4 inline-block text-[#F0BB4C] font-semibold hover:underline">View All
            Posts</a>
      </div>
   @endif
</section>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      new Swiper(".blogSwiper", {
         slidesPerView: 1,
         spaceBetween: 30,
         loop: true,

         pagination: {
            el: ".blogSwiper .swiper-pagination",
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
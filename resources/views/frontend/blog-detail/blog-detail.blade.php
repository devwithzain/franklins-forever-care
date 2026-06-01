<section class="w-full bg-white padding-x padding-y overflow-hidden">
   <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-3 gap-8 lg:gap-6 md:grid-cols-1 sm:grid-cols-1 xm:grid-cols-1">
         <div class="col-span-2 md:col-span-1 sm:col-span-1 xm:col-span-1">
            <div class="overflow-hidden rounded-[18px] mb-6">
               <img src="{{ $blog->image ? asset($blog->image) : asset('assets/blog01.jpg') }}" alt="{{ $blog->title }}"
                  class="w-full h-[420px] lg:h-[380px] md:h-[360px] sm:h-[300px] xm:h-[240px] object-cover">
            </div>
            <div class="flex items-center gap-5 text-gray-400 text-xs mb-4 flex-wrap">
               <span class="inline-flex items-center gap-1.5">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  By {{ $blog->user->name ?? 'Admin' }}
               </span>
               <span class="inline-flex items-center gap-1.5">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  {{ ($blog->published_at ?? $blog->created_at)->format('M d, Y') }}
               </span>
               @if($blog->category)
                  <a href="{{ route('blogs', ['category' => $blog->category_id]) }}"
                     class="inline-flex items-center gap-1.5 hover:text-[#F0BB4C] transition">
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z" />
                     </svg>
                     {{ $blog->category->name }}
                  </a>
               @endif
            </div>

            <!-- Title -->
            <h1
               class="text-[42px] lg:text-[36px] md:text-[32px] sm:text-[28px] xm:text-[24px] leading-tight font-semibold text-[#111] mb-6">
               {{ $blog->title }}
            </h1>

            <!-- Content from Quill -->
            <div class="prose prose-lg max-w-none text-[#666666] leading-8 blog-content">
               {!! $blog->content !!}
            </div>
         </div>

         <!-- SIDEBAR -->
         <div class="space-y-6">
            <!-- Search -->
            <div class="bg-[#EBF0DF] rounded-[18px] p-6 sm:p-5 xm:p-4">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-5">Search Here</h3>
               <form action="{{ route('blogs') }}" method="GET" class="relative">
                  <input type="text" name="search" placeholder="Search..."
                     class="w-full h-[54px] bg-[#f5f5f5] rounded-lg border border-transparent px-5 pr-14 outline-none focus:border-[#F0BB4C] text-sm">
                  <button type="submit"
                     class="absolute top-1/2 right-2 -translate-y-1/2 w-10 h-10 rounded-md bg-[#F0BB4C] text-white flex items-center justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                     </svg>
                  </button>
               </form>
            </div>

            <!-- Popular Posts -->
            @if($popularPosts->isNotEmpty())
               <div class="bg-[#EBF0DF] rounded-md p-6 sm:p-5 xm:p-4">
                  <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">Popular Posts</h3>
                  <div class="space-y-5">
                     @foreach ($popularPosts as $post)
                        <a href="{{ route('blog-detail', $post->slug) }}" class="flex gap-4 group">
                           <img src="{{ $post->image ? asset($post->image) : asset('assets/blog01.jpg') }}" alt=""
                              class="w-[85px] h-[85px] rounded-xl object-cover flex-shrink-0 group-hover:opacity-80 transition">
                           <div>
                              <span class="text-xs text-gray-400">
                                 {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
                              </span>
                              <h4 class="text-[15px] leading-6 font-medium mt-1 group-hover:text-[#F0BB4C] transition">
                                 {{ Str::limit($post->title, 55) }}
                              </h4>
                           </div>
                        </a>
                     @endforeach
                  </div>
               </div>
            @endif

            <!-- Categories -->
            @if($categories->isNotEmpty())
               <div class="bg-[#EBF0DF] rounded-[18px] p-6 sm:p-5 xm:p-4">
                  <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">Blogs Category</h3>
                  <div class="space-y-3">
                     @foreach ($categories as $category)
                        <a href="{{ route('blogs', ['category' => $category->id]) }}"
                           class="w-full h-[52px] bg-[#f5f5f5] rounded-lg px-4 flex items-center justify-between text-sm hover:bg-[#F0BB4C] hover:text-white transition duration-300">
                           <span>{{ $category->name }}</span>
                           <span>({{ $category->blogs_count }})</span>
                        </a>
                     @endforeach
                  </div>
               </div>
            @endif

            <!-- Tags -->
            @if($tags->isNotEmpty())
               <div class="bg-[#EBF0DF] rounded-[18px] p-6 sm:p-5 xm:p-4">
                  <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">Popular Tags</h3>
                  <div class="flex flex-wrap gap-3">
                     @foreach ($tags as $tag)
                        <a href="{{ route('blogs', ['tag' => $tag->id]) }}"
                           class="px-4 py-2 rounded-md text-sm transition duration-300 {{ $blog->tags->contains($tag->id) ? 'bg-[#F0BB4C]' : 'bg-[#f5f5f5] hover:bg-[#F0BB4C]' }}">
                           {{ $tag->name }}
                        </a>
                     @endforeach
                  </div>
               </div>
            @endif
         </div>

      </div>
   </div>
</section>

<style>
   /* Style Quill-rendered HTML content */
   .blog-content h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #111;
   }

   .blog-content h2 {
      font-size: 1.6rem;
      font-weight: 600;
      color: #111;
   }

   .blog-content h3 {
      font-size: 1.3rem;
      font-weight: 600;
      color: #333;
   }

   .blog-content ul,
   .blog-content ol {
      padding-left: 1.5rem;
   }

   .blog-content ul {
      list-style: disc;
   }

   .blog-content ol {
      list-style: decimal;
   }

   .blog-content blockquote {
      border-left: 4px solid #F0BB4C;
      padding: 0.75rem 1.25rem;
      background: #fffbf0;
      margin: 1.5rem 0;
      border-radius: 0 8px 8px 0;
      color: #555;
      font-style: italic;
   }

   .blog-content a {
      color: #7E80B0;
      text-decoration: underline;
   }

   .blog-content img {
      max-width: 100%;
      border-radius: 12px;
      margin: 1rem 0;
   }

   .blog-content code {
      background: #f4f4f4;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 0.875rem;
   }

   .blog-content pre {
      background: #1e293b;
      color: #f8fafc;
      padding: 1rem 1.25rem;
      border-radius: 10px;
      overflow-x: auto;
      margin: 1.5rem 0;
      font-size: 0.875rem;
   }

   .blog-content strong {
      font-weight: 700;
      color: #111;
   }
</style>
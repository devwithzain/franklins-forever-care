<section class="w-full padding-x padding-y bg-white overflow-hidden">
   <div class="max-w-7xl mx-auto px-4 sm:px-5 xm:px-4">
      <div class="grid grid-cols-3 gap-8 lg:gap-6 md:grid-cols-1 sm:grid-cols-1 xm:grid-cols-1">
         <div class="space-y-6">
            <div class="bg-white rounded-[18px] p-6 sm:p-5 xm:p-4">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-5">
                  Search Here
               </h3>
               <form action="{{ route('blogs') }}" method="GET" class="relative">
                  <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search..."
                     class="w-full h-[54px] bg-[#f5f5f5] rounded-lg border border-transparent px-5 pr-14 outline-none focus:border-[#F0BB4C] text-sm">
                  <button type="submit"
                     class="absolute top-1/2 right-2 -translate-y-1/2 w-10 h-10 rounded-md bg-[#F0BB4C] text-white flex items-center justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                     </svg>
                  </button>
               </form>
            </div>
            <div class="bg-white rounded-md p-6 sm:p-5 xm:p-4">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">
                  Popular Post
               </h3>
               <div class="space-y-5">
                  @foreach ($popularPosts as $post)
                     <div class="flex gap-4">
                        <img src="{{ $post->image ? asset($post->image) : asset('assets/blog01.jpg') }}" alt=""
                           class="w-[85px] h-[85px] rounded-xl object-cover flex-shrink-0">
                        <div>
                           <span class="text-xs text-gray-400">
                              {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                           </span>
                           <h4 class="text-[15px] leading-6 font-medium mt-1 hover:text-[#F0BB4C] transition">
                              <a href="{{ route('blog-detail', $post->slug) }}">
                                 {{ $post->title }}
                              </a>
                           </h4>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
            <div class="bg-white rounded-[18px] p-6 sm:p-5 xm:p-4">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">
                  Blogs Category
               </h3>
               <div class="space-y-3">
                  @foreach ($categories as $category)
                     <a href="{{ route('blogs', ['category' => $category->id]) }}"
                        class="w-full h-[52px] rounded-lg px-4 flex items-center justify-between text-sm transition duration-300 {{ request('category') == $category->id ? 'bg-[#F0BB4C]' : 'bg-[#f5f5f5] hover:bg-[#F0BB4C] text-black' }}">
                        <span>{{ $category->name }}</span>
                        <span>({{ $category->blogs_count }})</span>
                     </a>
                  @endforeach
               </div>
            </div>
            <div class="bg-white rounded-[18px] p-6 sm:p-5 xm:p-4">
               <h3 class="text-[22px] sm:text-[20px] xm:text-[18px] font-semibold mb-6">
                  Popular Tags
               </h3>
               <div class="flex flex-wrap gap-3">
                  @foreach ($tags as $tag)
                     <a href="{{ route('blogs', ['tag' => $tag->id]) }}"
                        class="px-4 py-2 rounded-md text-sm transition duration-300 {{ request('tag') == $tag->id ? 'bg-[#F0BB4C]' : 'bg-[#f5f5f5] hover:bg-[#F0BB4C] text-black' }}">
                        {{ $tag->name }}
                     </a>
                  @endforeach
               </div>
            </div>
         </div>
         <div class="col-span-2 md:col-span-1 sm:col-span-1 xm:col-span-1">
            <div class="grid grid-cols-2 gap-8 lg:gap-6 sm:grid-cols-1 xm:grid-cols-1">
               @forelse ($blogs as $blog)
                  @php
                     $date = $blog->published_at ?? $blog->created_at;
                  @endphp
                  <div class="group">
                     <div class="relative overflow-hidden rounded-[18px]">
                        <img src="{{ $blog->image ? asset($blog->image) : asset('assets/blog01.jpg') }}" alt=""
                           class="w-full h-[260px] lg:h-[240px] md:h-[250px] sm:h-[240px] xm:h-[220px] object-cover transition duration-700 group-hover:scale-110">
                        <div
                           class="absolute bottom-3 right-3 bg-[#F0BB4C] w-[58px] h-[62px] rounded-md flex flex-col items-center justify-center">
                           <h4 class="text-black text-[20px] font-bold leading-none">
                              {{ $date->format('d') }}
                           </h4>
                           <span class="text-[11px] uppercase mt-1 font-medium leading-none">
                              {{ $date->format('M') }}
                           </span>
                        </div>
                     </div>
                     <div class="pt-5">
                        <div class="flex items-center gap-5 text-gray-400 text-xs mb-3">
                           <div class="flex items-center gap-1">
                              <span>By {{ $blog->user->name ?? 'Admin' }}</span>
                           </div>
                           <div class="flex items-center gap-1">
                              <span>{{ $blog->category->name ?? 'News' }}</span>
                           </div>
                        </div>
                        <h2
                           class="text-[25px] lg:text-[22px] md:text-[24px] sm:text-[20px] xm:text-[18px] leading-[36px] lg:leading-[32px] sm:leading-[30px] xm:leading-[28px] font-semibold text-[#111] mb-4 transition duration-300 hover:text-[#F0BB4C]">
                           <a href="{{ route('blog-detail', $blog->slug) }}">
                              {{ $blog->title }}
                           </a>
                        </h2>
                        <p class="text-gray-500 text-[15px] leading-7 mb-5 line-clamp-3">
                           {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>
                        <a href="{{ route('blog-detail', $blog->slug) }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold hover:text-[#F0BB4C] transition">
                           Learn More
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M14 5l7 7m0 0l-7 7m7-7H3" />
                           </svg>
                        </a>
                     </div>
                  </div>
               @empty
                  <div class="col-span-2 text-center py-20 text-gray-400">
                     No blog posts found matching your criteria.
                  </div>
               @endforelse
            </div>
            <div class="mt-12">
               {{ $blogs->appends(request()->query())->links() }}
            </div>
         </div>
      </div>
   </div>
</section>
<div id="navbar" class="w-full padding-x py-3 transition-all duration-300 border-b border-black/5">
   <div class="w-full flex items-center justify-between">
      <a href="#" class="block">
         <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-28 object-cover">
      </a>
      <nav class="flex items-center gap-7">
         <a href="{{ route('home') }}"
            class="paragraph text-black font-medium leading-tight transition-colors capitalize duration-300 hover:text-[#C67C48]">Home</a>
         <a href="{{ route('about') }}"
            class="paragraph text-black font-medium leading-tight transition-colors capitalize duration-300 hover:text-[#C67C48]">About
            Us</a>
         <a href="{{ route('services') }}"
            class="paragraph text-black font-medium leading-tight transition-colors capitalize duration-300 hover:text-[#C67C48]">Services</a>
         <a href="{{ route('blogs') }}"
            class="paragraph text-black font-medium leading-tight transition-colors capitalize duration-300 hover:text-[#C67C48]">Blog</a>
         <a href="{{ route('contact') }}"
            class="paragraph text-black font-medium leading-tight transition-colors capitalize duration-300 hover:text-[#C67C48]">Contact
            Us</a>
      </nav>
      <div class="flex items-center gap-6">
         @auth
            <div class="relative group">
               <button class="flex items-center gap-2 outline-none cursor-pointer">
                  <div
                     class="w-14 h-14 rounded-full bg-[#DDEEE7] border border-[#4A9D7A] text-[#4A9D7A] flex items-center justify-center font-bold text-lg">
                     <img
                        src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/placeholder.png') }}"
                        alt="" class="w-full h-full rounded-full">
                  </div>
               </button>
               <div
                  class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.08)] py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100">
                  <div class="px-5 py-3 border-b border-gray-100">
                     <p class="text-[14px] font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                     <p class="text-[12px] text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                  </div>
                  <div class="py-1">
                     @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="block px-5 py-2.5 text-[13.5px] font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#C67C48] transition-colors">Dashboard</a>
                     @elseif(Auth::user()->role === 'employee')
                        <a href="{{ route('employee.dashboard') }}"
                           class="block px-5 py-2.5 text-[13.5px] font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#C67C48] transition-colors">Dashboard</a>
                     @else
                        <a href="{{ route('client.dashboard') }}"
                           class="block px-5 py-2.5 text-[13.5px] font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#C67C48] transition-colors">Dashboard</a>
                     @endif
                  </div>
                  <div class="py-1 border-t border-gray-100">
                     <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                           class="w-full text-left px-5 py-2.5 text-[13.5px] font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer">Log
                           Out</button>
                     </form>
                  </div>
               </div>
            </div>
         @else
            <div class="flex items-center gap-2">
               <a href="{{ route('login') }}"
                  class="bg-[#F0BB4C] text-black subparagraph flex items-center gap-2 font-medium px-5 py-3 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
                  LogIn
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                     <path d="M17 7l-10 10" />
                     <path d="M8 7l9 0l0 9" />
                  </svg>
               </a>
               <a href="{{ route('packages') }}"
                  class="bg-[#7E80B0] text-white subparagraph flex items-center gap-2 font-medium px-5 py-3 rounded-md hover:bg-[#F0BB4C] hover:text-black transition-all duration-300">
                  Get Started
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                     <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                     <path d="M17 7l-10 10" />
                     <path d="M8 7l9 0l0 9" />
                  </svg>
               </a>
            </div>
         @endauth
      </div>
   </div>
</div>

<script>
   window.addEventListener("scroll", function () {
      const navbar = document.getElementById("navbar");

      if (window.scrollY > 80) {
         navbar.classList.add("bg-white", "shadow-sm", "fixed", "top-0", "z-50");
      } else {
         navbar.classList.remove("bg-white", "shadow-sm", "fixed", "top-0", "z-50");
      }
   });
</script>
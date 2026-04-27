<nav
    class="flex items-center justify-between bg-white px-7 border-b border-slate-200 z-[90] flex-shrink-0 h-[64px] fixed top-0 right-0 left-64">
    <div class="hidden md:flex items-center bg-[#f0f2f8] border border-slate-200 rounded-md px-4 w-80 gap-2">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#94a3b8" stroke-width="2">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <input type="text" placeholder="Search clients, agents, requests..."
            class="border-none bg-transparent outline-none focus:ring-0 text-sm text-slate-700 w-full" />
    </div>
    <div class="flex items-center gap-3.5">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative w-[38px] h-[38px] rounded-full border border-slate-200 bg-white cursor-pointer flex items-center justify-center hover:bg-[#f0f2f8] transition-colors">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <span class="absolute top-[7px] right-2 w-2 h-2 bg-[#e63b3b] rounded-full border-2 border-white"></span>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[54px] right-0 w-[340px] bg-white rounded-[14px] border border-slate-200 shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500]">
                <div class="flex items-center justify-between px-[18px] py-4 border-b border-slate-200">
                    <h4 class="text-[14px] font-extrabold flex items-center gap-2">
                        Notifications
                        <span class="bg-[#fee2e2] text-[#e63b3b] px-[7px] py-0.5 rounded-full text-[11px]">5 New</span>
                    </h4>
                </div>
                <div class="max-h-[340px] overflow-y-auto">
                    <div
                        class="flex gap-[11px] px-[18px] py-[13px] border-b border-slate-200 cursor-pointer hover:bg-[#f0f2f8] transition-colors bg-[#fafbff]">
                        <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 bg-[#1a3cdc]"></div>
                        <div>
                            <div class="text-[12.5px] text-slate-800 leading-relaxed"><b>Arthur Morgan</b> has completed
                                therapy session today.</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">2 minutes ago</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.notifications') }}"
                    class="px-[18px] py-3 text-center text-[13px] text-[#1a3cdc] font-semibold cursor-pointer hover:bg-[#f0f2f8] rounded-b-[14px] block">See
                    All Notifications →
                </a>
            </div>
        </div>
        <div class="flex items-center gap-2.5 cursor-pointer" x-data="{ open: false }" @click="open = !open">
            <div class="text-right">
                <div class="text-[13px] font-bold text-slate-800">{{ auth()->user()->name }}</div>
                <div class="text-[10.5px] text-slate-500 uppercase tracking-wide">{{ auth()->user()->role }}</div>
            </div>
            <div
                class="w-[38px] h-[38px] rounded-full bg-[#1a3cdc] flex items-center justify-center text-white font-extrabold text-[13px]">
                <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/placeholder.png') }}"
                    alt="" class="w-full h-full rounded-full">
            </div>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[54px] right-0 w-48 bg-white rounded-lg border border-slate-200 shadow-lg z-[500] py-2">
                <a href="{{ route('admin.container.setting.index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
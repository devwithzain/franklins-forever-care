<nav :class="sidebarOpen ? 'left-64' : 'left-0'"
    class="flex items-center justify-between bg-theme-card px-7 border-b border-theme-border z-[90] flex-shrink-0 h-[64px] fixed top-0 right-0 transition-all duration-300">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen"
            class="text-theme-muted hover:text-theme-main focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
        <div
            class="hidden md:flex items-center bg-theme-bg border border-theme-border rounded-md px-4 w-80 gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#94a3b8" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" placeholder="Search clients, agents, requests..."
                class="border-none bg-transparent outline-none focus:ring-0 text-sm text-theme-main w-full placeholder-theme-muted" />
        </div>
    </div>
    <div class="flex items-center gap-3.5">
        @if(Auth::user()->role === 'admin')
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="px-4 py-2 bg-theme-primary text-white rounded-[8px] text-[12.5px] font-bold shadow-md hover:bg-theme-primary-hover transition-all flex items-center gap-2">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Quick Add
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[48px] right-0 w-56 bg-theme-card rounded-xl border border-theme-border shadow-xl z-[600] overflow-hidden">
                <a href="{{ route('admin.clients.create') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-theme-main hover:bg-theme-hover transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#1a3cdc] flex items-center justify-center">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <line x1="20" y1="8" x2="20" y2="14" />
                            <line x1="17" y1="11" x2="23" y2="11" />
                        </svg>
                    </div>
                    Add New Client
                </a>
                <a href="{{ route('admin.employees.create') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-theme-main hover:bg-theme-hover transition-colors border-t border-theme-border">
                    <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    Add New Agent
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-theme-main hover:bg-theme-hover transition-colors border-t border-theme-border">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="12" y1="18" x2="12" y2="12" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                        </svg>
                    </div>
                    Create Request
                </a>
            </div>
        </div>
        @endif
        <button @click="darkMode = !darkMode"
            class="relative w-[38px] h-[38px] rounded-full border border-theme-border bg-theme-card cursor-pointer flex items-center justify-center hover:bg-theme-hover transition-colors text-theme-muted hover:text-theme-main">
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <svg x-show="darkMode" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
        </button>
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative w-[38px] h-[38px] rounded-full border border-theme-border bg-theme-card cursor-pointer flex items-center justify-center hover:bg-theme-hover transition-colors text-theme-muted hover:text-theme-main">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <span class="absolute top-[7px] right-2 w-2 h-2 bg-[#e63b3b] rounded-full border-2 border-white"></span>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[54px] right-0 w-[340px] bg-theme-card rounded-[14px] border border-theme-border shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500] text-theme-main">
                <div class="flex items-center justify-between px-[18px] py-4 border-b border-theme-border">
                    <h4 class="text-[14px] font-extrabold flex items-center gap-2">
                        Notifications
                        <span class="bg-[#fee2e2] text-[#e63b3b] px-[7px] py-0.5 rounded-full text-[11px]">5 New</span>
                    </h4>
                </div>
                <div class="max-h-[340px] overflow-y-auto">
                    <div
                        class="flex gap-[11px] px-[18px] py-[13px] border-b border-theme-border cursor-pointer hover:bg-theme-hover transition-colors bg-theme-bg">
                        <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 bg-theme-primary"></div>
                        <div>
                            <div class="text-[12.5px] text-theme-main leading-relaxed"><b>Arthur
                                    Morgan</b>
                                has completed
                                therapy session today.</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">2 minutes ago</div>
                        </div>
                    </div>
                </div>
                <a href="{{ Auth::user()->role === 'employee' ? route('employee.notifications') : (Auth::user()->role === 'client' ? route('client.notifications') : route('admin.notifications')) }}"
                    class="px-[18px] py-3 text-center text-[13px] text-theme-primary font-semibold cursor-pointer hover:bg-theme-hover rounded-b-[14px] block">See
                    All Notifications →
                </a>
            </div>
        </div>
        <div class="flex items-center gap-2.5 cursor-pointer" x-data="{ open: false }" @click="open = !open">
            <div class="text-right">
                <div class="text-[13px] font-bold text-theme-main">{{ auth()->user()->name }}</div>
                <div class="text-[10.5px] text-theme-muted uppercase tracking-wide">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <div
                class="w-[38px] h-[38px] rounded-full bg-theme-primary flex items-center justify-center text-white font-extrabold text-[13px]">
                <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/placeholder.png') }}"
                    alt="" class="w-full h-full rounded-full">
            </div>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[54px] right-0 w-48 bg-theme-card rounded-lg border border-theme-border shadow-lg z-[500]">
                <a href="{{ Auth::user()->role === 'employee' ? route('employee.container.setting.index') : (Auth::user()->role === 'client' ? route('client.container.setting.index') : route('admin.container.setting.index')) }}"
                    class="block px-4 py-2 text-sm text-theme-main hover:bg-theme-hover">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-theme-hover">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
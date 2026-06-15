<nav :class="sidebarOpen ? 'left-64' : 'left-0'"
    class="flex items-center justify-between bg-theme-card px-7 border-b border-theme-border z-[90] flex-shrink-0 h-[64px] fixed top-0 right-0 transition-all duration-300">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-theme-muted hover:text-theme-main focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
        <div class="hidden md:flex items-center bg-theme-bg border border-theme-border rounded-md px-4 w-80 gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#94a3b8" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" placeholder="Search clients, agents, requests..."
                class="border-none bg-transparent outline-none focus:ring-0 text-sm text-theme-main w-full placeholder-theme-muted" />
        </div>
    </div>
    <div class="flex items-center gap-3.5">
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
        @php
            $unreadCount = auth()->user()->unreadNotifications()->count();
            $recentNotifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
        @endphp
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="relative w-[38px] h-[38px] rounded-full border border-theme-border bg-theme-card cursor-pointer flex items-center justify-center hover:bg-theme-hover transition-colors text-theme-muted hover:text-theme-main">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                @if($unreadCount > 0)
                    <span class="absolute top-[7px] right-2 w-2 h-2 bg-[#e63b3b] rounded-full border-2 border-white"></span>
                @endif
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute top-[54px] right-0 w-[340px] bg-theme-card rounded-[14px] border border-theme-border shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500] text-theme-main">
                <div class="flex items-center justify-between px-[18px] py-4 border-b border-theme-border">
                    <h4 class="text-[14px] font-extrabold flex items-center gap-2">
                        Notifications
                        @if($unreadCount > 0)
                            <span class="bg-[#fee2e2] text-[#e63b3b] px-[7px] py-0.5 rounded-full text-[11px]">{{ $unreadCount }} New</span>
                        @endif
                    </h4>
                </div>
                <div class="max-h-[340px] overflow-y-auto">
                    @forelse($recentNotifications as $notification)
                        <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left flex gap-[11px] px-[18px] py-[13px] border-b border-theme-border cursor-pointer hover:bg-theme-hover transition-colors bg-theme-bg">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 bg-theme-primary"></div>
                                <div>
                                    <div class="text-[12.5px] text-theme-main leading-relaxed"><b>{{ $notification->data['title'] ?? 'Notification' }}</b><br>
                                        {{ $notification->data['message'] ?? 'You have a new notification.' }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </button>
                        </form>
                    @empty
                        <div class="px-[18px] py-[13px] text-center text-[12.5px] text-theme-muted">
                            No new notifications.
                        </div>
                    @endforelse
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
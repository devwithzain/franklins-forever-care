@extends('layouts.admin')
@section('title', 'Dashboard')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Welcome back, {{ Auth::user()->name }}! 👋</div>
            <div class="text-[13px] text-theme-text-muted mt-1">
                Here's what's happening at Franklin's Forever Care today.
            </div>
        </div>
        <div class="flex gap-3">
            <button
                class="px-5 py-2.5 bg-theme-card border border-theme-primary text-theme-primary rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">+
                Add Reminder</button>
            <a href="{{ route('admin.clients.create') }}"
                class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">+
                New Client</a>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
        <a href="{{ route('admin.clients.index') }}"
            class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-theme-primary-light flex items-center justify-center text-theme-primary mb-5 group-hover:bg-theme-primary group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Total Clients</div>
            <div class="text-2xl font-extrabold text-theme-text-main mt-1">{{ $stats['total_clients'] }}</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 text-[10.5px] font-bold">↑ {{ $stats['client_growth'] }}% total growth</span>
            </div>
        </a>
        <a href="{{ route('admin.employees.index') }}"
            class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-[#e63b3b] dark:text-red-400 mb-5 group-hover:bg-[#e63b3b] group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Specialists (PCA)</div>
            <div class="text-2xl font-extrabold text-theme-text-main mt-1">{{ $stats['specialists'] }}</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10.5px] font-bold">{{ $stats['active_duty'] }} Active Duty</span>
            </div>
        </a>
        <a href="{{ route('admin.employees.index') }}"
            class="bg-theme-primary rounded-[14px] p-5 shadow-lg relative overflow-hidden text-white hover:bg-theme-primary-hover transition-colors group">
            <div
                class="w-10 h-10 rounded-[10px] bg-white/20 flex items-center justify-center text-white mb-5 group-hover:bg-white group-hover:text-[#1a3cdc] transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4m0 4h.01" />
                </svg>
            </div>
            <div class="text-white/70 text-[12.5px] font-medium uppercase tracking-wide">Pending Apps & Bookings</div>
            <div class="text-2xl font-extrabold text-white mt-1">{{ $stats['pending_requests'] + $stats['pending_applications'] }}</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10.5px] font-bold">{{ $stats['pending_applications'] }} New Career Submissions</span>
            </div>
            <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-white/10 rounded-full"></div>
        </a>
        <a href="{{ route('admin.payments') }}"
            class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-5 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Monthly Revenue</div>
            <div class="text-2xl font-extrabold text-theme-text-main mt-1">${{ number_format($stats['monthly_revenue'] / 1000, 1) }}K</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 text-[10.5px] font-bold">This month</span>
            </div>
        </a>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-5">
        <div class="col-span-2">
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm mb-5">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Client Activities</h3>
                    <a href="{{ route('admin.clients.index') }}" class="text-[12px] font-bold text-theme-primary hover:underline">View All →</a>
                </div>
                <div class="divide-y divide-theme-border">
                    @forelse($recentActivities as $activity)
                    <div class="px-6 py-4 flex items-start gap-4">
                        <div
                            class="w-9 h-9 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-bold text-[12px]">
                            {{ strtoupper(substr($activity->patient_name, 0, 2)) }}</div>
                        <div>
                            <div class="text-[13.5px] text-theme-text-main"><b>{{ $activity->patient_name }}</b> <span class="text-theme-text-muted">booked {{ $activity->service->title }} ({{ $activity->plan_type }})</span></div>
                            <div class="text-[11.5px] text-theme-text-muted mt-1">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-10 text-center text-theme-text-muted text-sm italic">No recent activity</div>
                    @endforelse
                </div>
            </div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Upcoming Activities</h3>
                    <a href="#" class="text-[12px] font-bold text-theme-primary hover:underline">Full Schedule →</a>
                </div>
                <div class="divide-y divide-theme-border">
                    <div class="px-6 py-4 flex items-start gap-4">
                        <div
                            class="bg-theme-hover border-l-4 border-theme-primary rounded-r-lg px-4 py-2 text-center min-w-[60px]">
                            <div class="text-[10px] font-bold text-theme-primary uppercase">OCT</div>
                            <div class="text-[20px] font-extrabold text-theme-text-main">24</div>
                        </div>
                        <div>
                            <div class="text-[14px] font-bold text-theme-text-main">Staff General Briefing</div>
                            <div class="text-[12px] text-theme-text-muted mt-1">🕘 09:00 AM &nbsp;&nbsp; 📍 Main Hall</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-5">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-[14.5px] font-bold text-theme-text-main">October 2023</h3>
                    <div class="flex gap-2">
                        <button
                            class="w-7 h-7 rounded-full border border-theme-border flex items-center justify-center text-theme-text-muted hover:bg-theme-hover">‹</button>
                        <button
                            class="w-7 h-7 rounded-full border border-theme-border flex items-center justify-center text-theme-text-muted hover:bg-theme-hover">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center">
                    @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                        <div class="text-[11px] font-bold text-theme-text-muted py-2">{{ $day }}</div>
                    @endforeach
                    {{-- Dummy Days --}}
                    @for($i = 1; $i <= 31; $i++)
                        <div
                            class="py-2 text-[12.5px] text-theme-text-main hover:bg-theme-hover hover:text-theme-primary rounded-full cursor-pointer {{ $i == 23 ? 'bg-theme-primary text-white font-bold' : '' }}">
                            {{ $i }}</div>
                    @endfor
                </div>
            </div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-sm font-bold text-theme-text-main">Reminders</h3>
                    <button
                        class="w-8 h-8 rounded-full bg-theme-primary text-white flex items-center justify-center text-lg shadow-sm hover:bg-theme-primary-hover">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-theme-border bg-theme-hover">
                        <div
                            class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-theme-text-main">Health appointment</div>
                            <div class="text-[11.5px] text-theme-text-muted mt-0.5">Specialist Dr. Vance</div>
                            <div class="text-[11px] font-bold text-red-600 dark:text-red-400 mt-1 uppercase tracking-wider">Today, 2:30 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
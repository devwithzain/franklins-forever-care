@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-slate-800">Welcome back, {{ Auth::user()->name }}! 👋</div>
            <div class="text-[13px] text-slate-500 mt-1">
                Here's what's happening at Franklin's Forever Care today.
            </div>
        </div>
        <div class="flex gap-3">
            <button
                class="px-5 py-2.5 bg-white border border-[#1a3cdc] text-[#1a3cdc] rounded-[10px] text-[13px] font-bold hover:bg-[#eef2ff] transition-all">+
                Add Reminder</button>
            <a href="{{ route('admin.clients') }}"
                class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">+
                New Client</a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 my-5">
        <a href="{{ route('admin.clients') }}"
            class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-[#eef2ff] flex items-center justify-center text-[#1a3cdc] mb-5 group-hover:bg-[#1a3cdc] group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="text-slate-400 text-[12.5px] font-medium uppercase tracking-wide">Total Clients</div>
            <div class="text-2xl font-extrabold text-slate-800 mt-1">125</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">↑ 12% this
                    month</span>
            </div>
        </a>
        <a href="{{ route('admin.employees') }}"
            class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-red-50 flex items-center justify-center text-[#e63b3b] mb-5 group-hover:bg-[#e63b3b] group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div class="text-slate-400 text-[12.5px] font-medium uppercase tracking-wide">Specialists (PCA)</div>
            <div class="text-2xl font-extrabold text-slate-800 mt-1">38</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">10 Active
                    Duty</span>
            </div>
        </a>
        <a href="{{ route('admin.requests') }}"
            class="bg-[#1a3cdc] rounded-[14px] p-5 shadow-lg relative overflow-hidden text-white hover:bg-[#1230b0] transition-colors group">
            <div
                class="w-10 h-10 rounded-[10px] bg-white/20 flex items-center justify-center text-white mb-5 group-hover:bg-white group-hover:text-[#1a3cdc] transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4m0 4h.01" />
                </svg>
            </div>
            <div class="text-white/70 text-[12.5px] font-medium uppercase tracking-wide">Pending Requests</div>
            <div class="text-2xl font-extrabold text-white mt-1">12</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10.5px] font-bold">Urgent
                    attention</span>
            </div>
            <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-white/10 rounded-full"></div>
        </a>
        <a href="{{ route('admin.payments') }}"
            class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div
                class="w-10 h-10 rounded-[10px] bg-green-50 flex items-center justify-center text-green-600 mb-5 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            <div class="text-slate-400 text-[12.5px] font-medium uppercase tracking-wide">Monthly Revenue</div>
            <div class="text-2xl font-extrabold text-slate-800 mt-1">$48K</div>
            <div class="mt-3 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">↑ 8% vs last
                    month</span>
            </div>
        </a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm mb-5">
                <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-slate-800">Recent Client Activities</h3>
                    <a href="{{ route('admin.clients') }}" class="text-[12px] font-bold text-[#1a3cdc] hover:underline">View
                        All →</a>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="px-6 py-4 flex items-start gap-4">
                        <div
                            class="w-9 h-9 rounded-full bg-[#dde3f8] text-[#1a3cdc] flex items-center justify-center font-bold text-[12px]">
                            AM</div>
                        <div>
                            <div class="text-[13.5px] text-slate-700"><b>Arthur Morgan</b> <span
                                    class="text-slate-500">completed therapy session</span></div>
                            <div class="text-[11.5px] text-slate-400 mt-1">2 hours ago</div>
                        </div>
                    </div>
                    <div class="px-6 py-4 flex items-start gap-4">
                        <div
                            class="w-9 h-9 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-[12px]">
                            SJ</div>
                        <div>
                            <div class="text-[13.5px] text-slate-700"><b>Sarah Jenkins</b> <span
                                    class="text-slate-500">registered as a new client</span></div>
                            <div class="text-[11.5px] text-slate-400 mt-1">4 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-slate-800">Upcoming Activities</h3>
                    <a href="#" class="text-[12px] font-bold text-[#1a3cdc] hover:underline">Full Schedule →</a>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="px-6 py-4 flex items-start gap-4">
                        <div
                            class="bg-slate-50 border-l-4 border-[#1a3cdc] rounded-r-lg px-4 py-2 text-center min-w-[60px]">
                            <div class="text-[10px] font-bold text-[#1a3cdc] uppercase">OCT</div>
                            <div class="text-[20px] font-extrabold text-slate-800">24</div>
                        </div>
                        <div>
                            <div class="text-[14px] font-bold text-slate-800">Staff General Briefing</div>
                            <div class="text-[12px] text-slate-500 mt-1">🕘 09:00 AM &nbsp;&nbsp; 📍 Main Hall</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-5">
            <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-[14.5px] font-bold text-slate-800">October 2023</h3>
                    <div class="flex gap-2">
                        <button
                            class="w-7 h-7 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50">‹</button>
                        <button
                            class="w-7 h-7 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50">›</button>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center">
                    @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                        <div class="text-[11px] font-bold text-slate-400 py-2">{{ $day }}</div>
                    @endforeach
                    {{-- Dummy Days --}}
                    @for($i = 1; $i <= 31; $i++)
                        <div
                            class="py-2 text-[12.5px] text-slate-600 hover:bg-[#eef2ff] hover:text-[#1a3cdc] rounded-full cursor-pointer {{ $i == 23 ? 'bg-[#1a3cdc] text-white font-bold' : '' }}">
                            {{ $i }}</div>
                    @endfor
                </div>
            </div>
            <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-sm font-bold text-slate-800">Reminders</h3>
                    <button
                        class="w-8 h-8 rounded-full bg-[#1a3cdc] text-white flex items-center justify-center text-lg shadow-sm hover:bg-[#1230b0]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50/50">
                        <div
                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-[13px] font-bold text-slate-800">Health appointment</div>
                            <div class="text-[11.5px] text-slate-500 mt-0.5">Specialist Dr. Vance</div>
                            <div class="text-[11px] font-bold text-red-600 mt-1 uppercase tracking-wider">Today, 2:30 PM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
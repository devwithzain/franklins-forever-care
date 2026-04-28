@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Outdoor Activities</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Monitor active outdoor sessions, tracking locations and duration.
            </div>
        </div>
        <button
            class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all flex items-center gap-2">
            + New Session
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Now</div>
            <div class="text-2xl font-extrabold text-theme-text-main">8</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">In Progress</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">24</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Avg Duration</div>
            <div class="text-2xl font-extrabold text-theme-text-main">45m</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Reports Filed</div>
            <div class="text-2xl font-extrabold text-theme-text-main">18</div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Session Log</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-theme-bg border-b border-theme-border">
                            <tr>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Client</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent
                                </th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Activity</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Duration</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-border">
                            <tr class="hover:bg-theme-bg transition-colors">
                                <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main">Arthur Morgan</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">James Wilson</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">Morning Park Walk</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">45 mins</td>
                                <td class="px-6 py-4"><span
                                        class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Active</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-slate-900 rounded-[14px] p-6 text-white shadow-xl relative overflow-hidden">
                <h3 class="text-[14.5px] font-bold mb-4">Live Activity Timer</h3>
                <div class="text-4xl font-mono font-extrabold text-[#1a3cdc] mb-2">00:42:15</div>
                <p class="text-[12px] text-white/60 mb-6 uppercase tracking-widest font-bold">Session: Walking (A. Morgan)
                </p>
                <div class="flex gap-2">
                    <button class="flex-1 py-2.5 bg-[#1a3cdc] rounded-lg text-[12px] font-bold">Stop Session</button>
                    <button class="px-4 py-2.5 bg-white/10 rounded-lg text-[12px] font-bold">Reset</button>
                </div>
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
            </div>
        </div>
    </div>
@endsection
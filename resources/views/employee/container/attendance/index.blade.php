@extends('layouts.employee')

@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Attendance Management</div>
            <div class="text-[13px] text-theme-text-muted mt-1">
                Track daily check-ins, check-outs, and monthly reports for all agents.
            </div>
        </div>
        <div class="flex gap-3">
            <button
                class="px-5 py-2.5 bg-theme-card border border-[#1a3cdc] text-[#1a3cdc] rounded-[10px] text-[13px] font-bold hover:bg-[#eef2ff] transition-all">Late/Off
                Alert</button>
            <button
                class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Monthly
                Report</button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Present Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">28</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">On Duty</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Late Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">4</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Late</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Absent Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">6</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">Absent</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">On Leave</div>
            <div class="text-2xl font-extrabold text-theme-text-main">2</div>
            <div class="mt-2 flex items-center">
                <span
                    class="px-2 py-0.5 rounded-full bg-theme-hover text-theme-text-muted text-[10.5px] font-bold">Approved</span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Today's Attendance — Oct 23, 2023</h3>
                    <select
                        class="bg-theme-bg border border-theme-border rounded-[8px] px-3 py-1.5 text-[12px] font-bold outline-none">
                        <option>All Agents</option>
                        <option>Present</option>
                        <option>Late</option>
                        <option>Absent</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-theme-bg border-b border-theme-border">
                            <tr>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Agent
                                </th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Check-In</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Check-Out</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Hours
                                </th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-border">
                            <tr class="hover:bg-theme-bg transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-[#dde3f8] text-[#1a3cdc] flex items-center justify-center font-bold text-[11px]">
                                            JW</div>
                                        <div class="text-[13px] font-bold text-theme-text-main">James Wilson</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">08:02 AM</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">05:00 PM</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main font-bold">8.9 hrs</td>
                                <td class="px-6 py-4"><span
                                        class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Present</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-theme-bg transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-[11px]">
                                            LB</div>
                                        <div class="text-[13px] font-bold text-theme-text-main">Lisa Brown</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-main">08:31 AM</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-muted">—</td>
                                <td class="px-6 py-4 text-[13px] text-theme-text-muted">—</td>
                                <td class="px-6 py-4"><span
                                        class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Late</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-[14.5px] font-bold text-theme-text-main mb-6">October 2023 — Monthly Overview</h3>
                <div class="grid grid-cols-7 gap-2">
                    @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $d)
                        <div class="text-center text-[10px] font-bold text-theme-text-muted mb-1">{{ $d }}</div>
                    @endforeach
                    @for($i = 1; $i <= 21; $i++)
                        <div
                            class="aspect-square rounded-lg flex flex-col items-center justify-center gap-0.5 {{ $i % 7 == 0 || ($i + 1) % 7 == 0 ? 'bg-theme-bg text-theme-text-muted' : ($i == 10 ? 'bg-red-50 text-red-600' : ($i == 4 ? 'bg-amber-50 text-amber-600' : 'bg-green-50 text-green-600')) }}">
                            <div class="text-[10px] font-bold">{{ $i }}</div>
                            <div class="text-[8px] font-extrabold uppercase">
                                {{ $i % 7 == 0 || ($i + 1) % 7 == 0 ? 'Off' : ($i == 10 ? 'A' : ($i == 4 ? 'L' : 'P')) }}
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="mt-6 space-y-2">
                    <div class="flex items-center gap-2 text-[11px] font-bold text-theme-text-muted">
                        <div class="w-2.5 h-2.5 rounded bg-green-500"></div> Present (P)
                    </div>
                    <div class="flex items-center gap-2 text-[11px] font-bold text-theme-text-muted">
                        <div class="w-2.5 h-2.5 rounded bg-red-500"></div> Absent (A)
                    </div>
                    <div class="flex items-center gap-2 text-[11px] font-bold text-theme-text-muted">
                        <div class="w-2.5 h-2.5 rounded bg-amber-500"></div> Late (L)
                    </div>
                    <div class="flex items-center gap-2 text-[11px] font-bold text-theme-text-muted">
                        <div class="w-2.5 h-2.5 rounded bg-slate-300"></div> Day Off
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
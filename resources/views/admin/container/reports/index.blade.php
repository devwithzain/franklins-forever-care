@extends('layouts.admin')
@section('title', 'Reports')
@section('admin-content')
        <div class="w-full flex items-center justify-between gap-5">
    <div>
        <div class="text-2xl font-extrabold text-theme-text-main">Reports & Analytics</div>
        <div class="text-[13px] text-theme-text-muted mt-1">Detailed performance metrics, growth charts, and collection
            summaries.</div>
    </div>
    <div class="flex gap-3">
        <button
            class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-bg transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="7 10 12 15 17 10" />
                <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Export PDF
        </button>
        <button
            class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Generate
            Report</button>
    </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-6">Key Performance Indicators</h3>
            <div class="space-y-6">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[13px] font-bold text-theme-text-main">Client Growth Rate</span>
                        <span class="text-[13px] font-extrabold text-[#1a3cdc]">+12.4%</span>
                    </div>
                    <div class="w-full h-2 bg-theme-hover rounded-full overflow-hidden">
                        <div class="h-full bg-[#1a3cdc] rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[13px] font-bold text-theme-text-main">Attendance Reliability</span>
                        <span class="text-[13px] font-extrabold text-green-600">94.8%</span>
                    </div>
                    <div class="w-full h-2 bg-theme-hover rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 94%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[13px] font-bold text-theme-text-main">Revenue Collection</span>
                        <span class="text-[13px] font-extrabold text-amber-600">86.2%</span>
                    </div>
                    <div class="w-full h-2 bg-theme-hover rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 86%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[14.5px] font-bold text-theme-text-main mb-6">Top Performing Agents (Oct)</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-50 text-[#1a3cdc] flex items-center justify-center font-bold text-[11px]">
                            01</div>
                        <span class="text-[13.5px] font-bold text-theme-text-main">James Wilson</span>
                    </div>
                    <span class="text-[12px] font-bold text-green-600">98% Rating</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-theme-bg text-theme-text-muted flex items-center justify-center font-bold text-[11px]">
                            02</div>
                        <span class="text-[13.5px] font-bold text-theme-text-main">Lisa Brown</span>
                    </div>
                    <span class="text-[12px] font-bold text-green-600">96% Rating</span>
                </div>
            </div>
        </div>
    </div>
@endsection
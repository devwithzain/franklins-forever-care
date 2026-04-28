@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Complaints & Feedback</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Monitor service issues and track resolution status.</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Open Issues</div>
            <div class="text-2xl font-extrabold text-theme-text-main">5</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">Needs Attention</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">In Progress</div>
            <div class="text-2xl font-extrabold text-theme-text-main">3</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Resolved (30d)</div>
            <div class="text-2xl font-extrabold text-theme-text-main">18</div>
        </div>
    </div>
    <div class="space-y-5">
        <div
            class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm flex gap-4 hover:border-[#1a3cdc] transition-colors cursor-pointer group">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[14px] font-bold text-theme-text-main">Delayed Medication Support</span>
                    <span class="text-[11px] text-theme-text-muted font-bold uppercase tracking-widest">Urgent</span>
                </div>
                <p class="text-[13px] text-theme-text-muted mb-3">Client (Arthur Morgan) reported that the agent arrived 15 minutes
                    late for morning medication.</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-6 h-6 rounded-full bg-theme-hover flex items-center justify-center text-[9px] font-bold text-theme-text-muted">
                            AM</div>
                        <span class="text-[11.5px] font-bold text-theme-text-muted">Arthur Morgan</span>
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="px-3 py-1 bg-slate-800 text-white rounded-lg text-[11px] font-bold">Investigate</button>
                        <button
                            class="px-3 py-1 bg-theme-card border border-theme-border text-theme-text-main rounded-lg text-[11px] font-bold">Dismiss</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
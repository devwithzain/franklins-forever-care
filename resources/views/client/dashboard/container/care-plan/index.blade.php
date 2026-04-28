@extends('layouts.user')

@section('client-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-theme-main">My Care Plan</h1>
        <p class="text-theme-muted text-[13.5px] mt-1">Review the details and schedule of your active care plan.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-theme-card border border-theme-border rounded-[14px] p-8 flex items-center justify-between shadow-sm">
        <div>
            <h2 class="text-[12px] font-bold uppercase tracking-widest text-theme-muted mb-1">Current Plan</h2>
            <p class="text-2xl font-extrabold text-theme-main">{{ $clientRecord->care_plan ?? 'Standard Care' }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-theme-primary/10 flex items-center justify-center text-theme-primary">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />
            </svg>
        </div>
    </div>
    
    <div class="bg-theme-card border border-theme-border rounded-[14px] p-8 flex items-center justify-between shadow-sm">
        <div>
            <h2 class="text-[12px] font-bold uppercase tracking-widest text-theme-muted mb-1">Status</h2>
            <p class="text-2xl font-extrabold text-theme-main">{{ $clientRecord->status ?? 'Active' }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
</div>

<div class="bg-theme-card border border-theme-border rounded-[14px] shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-theme-border">
        <h3 class="text-[15px] font-extrabold text-theme-main">Plan Details</h3>
    </div>
    <div class="p-6 text-theme-muted text-[13.5px] leading-relaxed">
        <p>This section will outline the specific services included in your care plan, including frequency of visits, scheduled times, and specific care instructions.</p>
        <p class="mt-4">If you need to make adjustments to your current care plan or request additional services, please submit a <a href="{{ route('client.requests.index') }}" class="text-theme-primary font-bold hover:underline">New Request</a> or contact your assigned agent directly.</p>
    </div>
</div>
@endsection

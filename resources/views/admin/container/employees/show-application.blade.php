@extends('layouts.admin')
@section('title', 'View Application')
@section('admin-content')

<div class="mb-6">
    <a href="{{ route('admin.employees.index', ['tab' => 'applications']) }}"
        class="text-[13px] text-theme-primary font-bold flex items-center gap-2">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6" />
        </svg>
        Back to Applications
    </a>
</div>

<div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-extrabold text-theme-text-main">Application Details</h3>
            <p class="text-[13px] text-theme-text-muted mt-1">Submitted by: {{ $application->full_name }}</p>
        </div>
        <span
            class="px-4 py-2 rounded-full {{ $application->status === 'approved' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }} text-[11px] font-bold">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div class="bg-theme-bg rounded-lg p-4 border border-theme-border">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Personal
                Information</div>
            <div class="space-y-3">
                <div>
                    <span class="text-[11px] text-theme-text-muted">Full Name</span>
                    <div class="text-[13px] font-bold text-theme-text-main">{{ $application->full_name }}</div>
                </div>
                <div>
                    <span class="text-[11px] text-theme-text-muted">Email</span>
                    <div class="text-[13px] font-bold text-theme-text-main">{{ $application->email }}</div>
                </div>
                <div>
                    <span class="text-[11px] text-theme-text-muted">Phone</span>
                    <div class="text-[13px] font-bold text-theme-text-main">{{ $application->phone }}</div>
                </div>
                <div>
                    <span class="text-[11px] text-theme-text-muted">Application Date</span>
                    <div class="text-[13px] font-bold text-theme-text-main">
                        {{ $application->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-theme-bg rounded-lg p-4 border border-theme-border">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Address</div>
            <div class="space-y-3">
                <div>
                    <span class="text-[11px] text-theme-text-muted">Street Address</span>
                    <div class="text-[13px] font-bold text-theme-text-main">{{ $application->address }}</div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <span class="text-[11px] text-theme-text-muted">City</span>
                        <div class="text-[13px] font-bold text-theme-text-main">{{ $application->city }}</div>
                    </div>
                    <div>
                        <span class="text-[11px] text-theme-text-muted">State</span>
                        <div class="text-[13px] font-bold text-theme-text-main">{{ $application->state }}</div>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] text-theme-text-muted">ZIP Code</span>
                    <div class="text-[13px] font-bold text-theme-text-main">{{ $application->zip_code }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-theme-bg rounded-lg p-4 border border-theme-border mb-6">
        <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Message</div>
        <p class="text-[13px] text-theme-text-main leading-relaxed">{{ $application->message ?? 'No message provided.' }}
        </p>
    </div>

    @if($application->status === 'pending')
    <div class="flex items-center gap-3">
        <form action="{{ route('admin.employees.approve', $application->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="px-5 py-2.5 bg-green-600 text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-green-700 transition-all flex items-center gap-2">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                Approve Application
            </button>
        </form>
        <a href="{{ route('admin.employees.index', ['tab' => 'applications']) }}"
            class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">
            Cancel
        </a>
    </div>
    @endif
</div>

@endsection
@extends('layouts.user')
@section('title', 'My Care Plan')
@section('client-content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-theme-main">My Care Plan</h1>
            <p class="text-theme-muted text-[13.5px] mt-1">Review the details and schedule of your active care plan.</p>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($activeBookings as $booking)
            <div class="bg-theme-card border border-theme-border rounded-[14px] shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between bg-theme-hover/50">
                    @php
                        $serviceTitle = $booking->service->title ?? $booking->service->name ?? 'Care Service';
                    @endphp
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-theme-primary text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr($serviceTitle, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-[15px] font-extrabold text-theme-main">{{ $serviceTitle }}</h3>
                            <p class="text-[11px] text-theme-muted uppercase tracking-widest font-bold">
                                {{ $booking->plan_type }} Plan</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span
                            class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-black uppercase">Active</span>
                    </div>
                </div>
                <div class="p-6 grid sm:grid-cols-1 grid-cols-4 gap-8">
                    <div>
                        <h4 class="text-[11px] font-bold text-theme-muted uppercase mb-2">Patient Details</h4>
                        <p class="text-[14px] font-bold text-theme-main">{{ $booking->patient_name }}</p>
                        <p class="text-[12px] text-theme-muted mt-1">{{ $booking->patient_age }} years ·
                            {{ $booking->relationship }}</p>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-theme-muted uppercase mb-2">Location & Schedule</h4>
                        <p class="text-[14px] font-bold text-theme-main">{{ $booking->city }}, {{ $booking->state }}</p>
                        <p class="text-[12px] text-theme-muted mt-1">Starts:
                            {{ $booking->preferred_date ? \Carbon\Carbon::parse($booking->preferred_date)->format('d M Y') : 'Immediate' }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-theme-muted uppercase mb-2">Subscription Period</h4>
                        <p class="text-[13.5px] font-bold text-theme-main flex justify-between gap-2">Start: <span class="text-theme-muted font-normal">{{ $booking->created_at->format('d M Y') }}</span></p>
                        <p class="text-[13.5px] font-bold text-theme-main mt-1 flex justify-between gap-2">
                            End/Renewal: 
                            <span class="text-theme-muted font-normal">
                                {{ $booking->subscription_ends_at ? $booking->subscription_ends_at->format('d M Y') : 'Auto-renews' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-theme-muted uppercase mb-2">Payment Info</h4>
                        <p class="text-[14px] font-bold text-theme-primary">${{ number_format($booking->amount, 2) }}</p>
                        <p class="text-[12px] text-theme-muted mt-1">Status: Paid</p>
                    </div>
                </div>
                @if($booking->notes)
                    <div class="px-6 pb-6 pt-0">
                        <div
                            class="p-4 bg-theme-bg rounded-[10px] border border-theme-border italic text-[12.5px] text-theme-muted">
                            "{{ $booking->notes }}"
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-theme-card border border-theme-border rounded-[14px] p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-theme-bg rounded-full flex items-center justify-center mx-auto mb-6 text-theme-muted">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-theme-main mb-2">No Active Care Plans</h3>
                <p class="text-theme-muted text-[14px] max-w-md mx-auto mb-8">You haven't booked any care services yet. Explore
                    our packages to get started with professional home care.</p>
                <a href="{{ route('packages') }}"
                    class="px-8 py-3 bg-theme-primary text-white rounded-[12px] font-bold shadow-lg hover:bg-theme-primary-hover transition-all">Browse
                    Packages</a>
            </div>
        @endforelse
    </div>
@endsection
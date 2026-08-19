@extends('layouts.user')
@section('title', 'Dashboard')
@section('client-content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-theme-main">Welcome, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-theme-muted text-[13.5px] mt-1">Manage your care plan and requests with Franklin's Forever Care.
            </p>
        </div>
        <div class="flex gap-3">
            @if(Auth::user()->stripe_customer_id)
                <a href="{{ route('stripe.portal') }}"
                    class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-main rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-hover transition-all flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-theme-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Manage Billing
                </a>
            @endif
            <a href="{{ route('client.requests.index') }}"
                class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">+ New Request</a>
        </div>
    </div>
    <div
        class="bg-theme-card border border-theme-border rounded-[14px] p-8 flex items-center justify-between mb-8 shadow-sm">
        <div class="flex items-center gap-6">
            <div
                class="w-20 h-20 rounded-full bg-theme-bg border-4 border-theme-border flex items-center justify-center text-3xl font-extrabold text-theme-primary">
                <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/placeholder.png') }}"
                    alt="" class="w-full h-full rounded-full">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-theme-main">{{ Auth::user()->name }}</h2>
                <p class="text-theme-muted text-[14px] mt-1">Client Portal · {{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="text-[12px] font-bold uppercase tracking-widest text-theme-muted mb-1 text-right">Account Status
            </div>
            <div class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-extrabold uppercase">
                {{ $clientRecord->status ?? 'Active' }}</div>
        </div>
    </div>

    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-6 mb-8">
        <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
            <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Assigned Agent</div>
            <div class="text-2xl font-extrabold text-theme-main">{{ $clientRecord->agent->name ?? 'Pending Assignment' }}
            </div>
            <div class="mt-4 text-theme-muted text-[11.5px] font-medium">Your primary point of contact</div>
        </div>

        <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
            <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Plan</div>
            <div class="text-2xl font-extrabold text-theme-main">
                {{ $stats['active_plan']->service->title ?? 'None Active' }}
            </div>
            <div class="mt-4 text-theme-primary text-[11.5px] font-bold">
                {{ $stats['active_plan'] ? ucfirst($stats['active_plan']->plan_type) . ' Plan' : 'Choose a package' }}
            </div>
        </div>

        <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
            <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Requests</div>
            <div class="text-3xl font-extrabold text-theme-main">{{ $stats['total_requests']}}</div>
            <div class="mt-4 text-theme-muted text-[11.5px] font-medium">Services & queries</div>
        </div>
    </div>

    <div class="space-y-8">
        {{-- Bookings Table --}}
        <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
            <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                <h3 class="text-[15px] font-extrabold text-theme-main">Recent Care Bookings</h3>
                <a href="{{ route('client.requests.index', ['tab' => 'bookings']) }}"
                    class="text-[12px] font-bold text-theme-primary hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[13.5px]">
                    <thead class="bg-theme-bg border-b border-theme-border">
                        <tr>
                            <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Service</th>
                            <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Plan</th>
                            <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Amount</th>
                            <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-theme-border text-theme-main">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-theme-hover transition-colors">
                                <td class="px-6 py-4 font-semibold">{{ $booking->service->title ?? $booking->service->name ?? 'Service Booking' }}</td>
                                <td class="px-6 py-4 text-theme-muted capitalize">{{ $booking->plan_type }}</td>
                                <td class="px-6 py-4 font-bold text-theme-primary">${{ number_format($booking->amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-theme-muted">No care bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
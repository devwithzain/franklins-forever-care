@extends('layouts.admin')
@section('title', 'Payments')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Payments & Billing</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage invoices, monthly billing cycles, and payment receipts.</div>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Billed</div>
            <div class="text-2xl font-extrabold text-theme-text-main">${{ number_format($stats['total_billed'], 2) }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Collected</div>
            <div class="text-2xl font-extrabold text-theme-text-main text-green-600">${{ number_format($stats['collected'], 2) }}</div>
        </div>
        <div class="bg-[#1a3cdc] rounded-[14px] p-5 shadow-lg text-white">
            <div class="text-white/70 text-[12px] font-bold uppercase tracking-widest mb-1">Outstanding</div>
            <div class="text-2xl font-extrabold text-white">${{ number_format($stats['outstanding'], 2) }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Overdue</div>
            <div class="text-2xl font-extrabold text-theme-text-main text-red-500">${{ number_format($stats['overdue'], 2) }}</div>
        </div>
    </div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between flex-wrap gap-4">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Billing Records</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Booking ID</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Service</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Amount</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-theme-bg transition-colors">
                            <td class="px-6 py-4"><span class="px-2 py-0.5 rounded bg-blue-50 text-[#1a3cdc] text-[11px] font-extrabold">#{{ $booking->booking_custom_id }}</span></td>
                            <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $booking->service->title }}</td>
                            <td class="px-6 py-4 text-[13.5px] font-extrabold text-theme-text-main">${{ number_format($booking->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} text-[10.5px] font-bold">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-muted">{{ $booking->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">No billing records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
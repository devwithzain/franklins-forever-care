@extends('layouts.admin')
@section('title', 'Bookings')
@section('admin-content')
    <div class="text-2xl font-extrabold text-theme-text-main mb-4">Bookings</div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-4">All Bookings</h3>

            <div class="mb-4">
                <form action="{{ route('admin.bookings.bulk-auto-assign') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-[#1a3cdc] text-white rounded text-sm font-bold">Auto-Assign All Pending Bookings</button>
                </form>
            </div>

            <table class="w-full text-left text-[13px] text-theme-text-main">
                <thead>
                    <tr class="border-b border-theme-border text-theme-text-muted bg-theme-bg">
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Booking ID</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Client</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Patient</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Service</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Date</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Agent</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px]">Status</th>
                        <th class="px-4 py-3 font-bold uppercase tracking-widest text-[11px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-theme-hover">
                            <td class="px-4 py-3 font-bold text-[#1a3cdc]">#{{ $booking->id }}</td>
                            <td class="px-4 py-3">{{ $booking->user?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $booking->patient_name }}</td>
                            <td class="px-4 py-3">{{ $booking->service?->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $booking->preferred_date?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                @if($booking->agent)
                                    <span class="text-green-600 font-bold">{{ $booking->agent->name }}</span>
                                @else
                                    <span class="text-red-500 font-bold">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10.5px] font-bold
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.bookings.assign', $booking->id) }}" class="text-[#1a3cdc] font-bold text-xs hover:underline mr-2">Assign</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
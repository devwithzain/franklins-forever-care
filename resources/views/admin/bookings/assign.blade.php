@extends('layouts.admin')
@section('title', 'Assign Booking')
@section('admin-content')
    <div class="text-2xl font-extrabold text-theme-text-main mb-4">Assign Booking #{{ $booking->id }}</div>

    <div class="grid grid-cols-2 gap-4">
        <!-- Booking Info -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4">Booking Details</h3>
            <p><strong>Patient:</strong> {{ $booking->patient_name }}</p>
            <p><strong>Client:</strong> {{ $booking->user?->name }}</p>
            <p><strong>Service:</strong> {{ $booking->service?->name }}</p>
            <p><strong>Date:</strong> {{ $booking->preferred_date?->format('M d, Y') ?? 'N/A' }}</p>
        </div>

        <!-- Assignment Form -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4">Assign Agent</h3>

            @if($recommendedEmployee)
            <div class="bg-blue-50 border border-blue-200 p-4 rounded mb-4">
                <p class="text-blue-800 text-sm"><strong>Recommended Match:</strong> {{ $recommendedEmployee->name }} (Available Workload)</p>
                <form action="{{ route('admin.bookings.auto-assign', $booking->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-xs font-bold hover:bg-blue-700">Auto Assign to {{ $recommendedEmployee->name }}</button>
                </form>
            </div>
            @endif

            <form action="{{ route('admin.bookings.assign.store', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Select Agent manually</label>
                    <select name="agent_id" class="w-full border rounded p-2 text-sm" required>
                        <option value="">-- Choose Agent --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp['id'] }}" {{ !$emp['is_available'] ? 'disabled' : '' }}>
                                {{ $emp['name'] }} - Capacity: {{ $emp['active_bookings'] }}/{{ $emp['max_capacity'] }}
                                {{ !$emp['is_available'] ? '(Full)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded font-bold hover:bg-green-700">Assign Selected Agent</button>
            </form>
        </div>
    </div>
@endsection
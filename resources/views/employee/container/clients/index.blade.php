@extends('layouts.employee')
@section('title', 'My Clients')
@section('employee-content')
<div class="w-full flex items-center justify-between gap-5 mb-5">
    <div>
        <div class="text-2xl font-extrabold text-theme-text-main">Assigned Clients</div>
        <div class="text-[13px] text-theme-text-muted mt-1">Manage profiles and active assignments for clients under
            your care.</div>
    </div>
</div>

@if (session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] mb-5 text-sm font-bold">
    {{ session('success') }}
</div>
@endif

<div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-5 mb-5">
    <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
        <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Assigned</div>
        <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
        <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Plans</div>
        <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['active_plans'] }}</div>
    </div>
    <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
        <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Critical Cases</div>
        <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['critical_cases'] }}</div>
    </div>
</div>

<div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
    <div class="px-6 py-5 border-b border-theme-border">
        <h3 class="text-[15px] font-extrabold text-theme-text-main">Client Records</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-theme-bg border-b border-theme-border text-theme-text-main">
                <tr>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">ID
                    </th>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client
                        Name</th>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Region
                    </th>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Care
                        Plan</th>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                        Subscription Plan & Status</th>
                    <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-theme-border">
                @forelse ($clients as $client)
                <tr class="hover:bg-theme-hover transition-colors">
                    <td class="px-6 py-4 text-[13px] text-theme-text-muted">{{ $client->client_custom_id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-full overflow-hidden bg-theme-primary-light flex items-center justify-center">
                                <img src="{{ $client->user->image ? asset('storage/' . $client->user->image) : asset('assets/placeholder.png') }}"
                                    alt="" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $client->user->name }}
                                </div>
                                <div class="text-[11px] text-theme-text-muted">Contact: {{ $client->phone ??
                                    $client->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $client->region ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span
                            class="px-2 py-0.5 rounded bg-theme-primary-light text-theme-primary text-[11px] font-bold">{{
                            $client->care_plan ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $latestBooking = $client->user->serviceBookings->first();
                        @endphp
                        @if($latestBooking)
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1">
                                <span class="text-[12.5px] font-bold text-theme-text-main">${{
                                    number_format($latestBooking->amount, 2) }}</span>
                                <span class="text-[10px] text-theme-text-muted font-medium">/mo</span>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                @php
                                $subStatusClasses = [
                                'active' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                'past_due' => 'bg-amber-100 text-amber-700',
                                'inactive' => 'bg-slate-100 text-slate-700',
                                ];
                                $subClass = $subStatusClasses[strtolower($latestBooking->subscription_status)] ??
                                'bg-slate-100 text-slate-700';
                                @endphp
                                <span
                                    class="px-1.5 py-0.5 rounded text-[9.5px] font-bold uppercase tracking-wider {{ $subClass }}">
                                    {{ $latestBooking->subscription_status ?? 'Inactive' }}
                                </span>
                                @if($latestBooking->subscription_ends_at)
                                <span class="text-[9.5px] text-theme-text-muted font-semibold">Renewal: {{
                                    $latestBooking->subscription_ends_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                        </div>
                        @else
                        <span class="text-[11.5px] text-theme-text-muted italic">No active subscription</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $statusClasses = [
                        'Active' => 'bg-green-100 text-green-600',
                        'Pending' => 'bg-amber-100 text-amber-600',
                        'Critical' => 'bg-red-100 text-red-600',
                        'Inactive' => 'bg-theme-hover text-theme-text-main',
                        ];
                        $statusClass = $statusClasses[$client->status] ?? 'bg-theme-hover text-theme-text-main';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[10.5px] font-bold">
                            {{ $client->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">
                        No clients currently assigned to you.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($clients->hasPages())
    <div class="px-6 py-4 border-t border-theme-border">
        {{ $clients->links() }}
    </div>
    @endif
</div>
@endsection
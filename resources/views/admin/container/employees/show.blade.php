@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Agent Profile: {{ $employee->user->name }}</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Detailed performance and assignment overview for {{ $employee->agent_custom_id }}.</div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                class="px-5 py-2.5 bg-amber-50 text-amber-600 rounded-[10px] text-[13px] font-bold hover:bg-amber-100 transition-all flex items-center gap-2">
                Edit Profile
            </a>
            <a href="{{ route('admin.employees.index') }}"
                class="px-5 py-2.5 bg-theme-hover text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-[#dde3f8] text-[#1a3cdc] flex items-center justify-center font-extrabold text-2xl mx-auto mb-4">
                    {{ strtoupper(substr($employee->user->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-extrabold text-theme-text-main">{{ $employee->user->name }}</h3>
                <p class="text-sm text-theme-text-muted">{{ $employee->agent_custom_id }}</p>
                <div class="mt-4">
                    @php
                        $statusClasses = [
                            'Active' => 'bg-green-100 text-green-600',
                            'On Leave' => 'bg-amber-100 text-amber-600',
                            'Inactive' => 'bg-red-100 text-red-600',
                        ];
                        $statusClass = $statusClasses[$employee->status] ?? 'bg-theme-hover text-theme-text-main';
                    @endphp
                    <span class="px-3 py-1 rounded-full {{ $statusClass }} text-[12px] font-bold">
                        {{ $employee->status }}
                    </span>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
                <h4 class="text-[14px] font-bold text-theme-text-main mb-4 border-b border-theme-border pb-3">Quick Stats</h4>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-3 bg-theme-bg rounded-xl">
                        <div class="text-xl font-extrabold text-theme-text-main">{{ $employee->clients->count() }}</div>
                        <div class="text-[10px] font-bold text-theme-text-muted uppercase">Clients</div>
                    </div>
                    <div class="p-3 bg-theme-bg rounded-xl">
                        <div class="text-xl font-extrabold text-amber-500">⭐ {{ number_format($employee->rating, 1) }}</div>
                        <div class="text-[10px] font-bold text-theme-text-muted uppercase">Rating</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Professional Details -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
                <h4 class="text-[14px] font-bold text-theme-text-main mb-4 border-b border-theme-border pb-3">Professional Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Email Address</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $employee->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Phone Number</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $employee->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Assigned Region</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $employee->region ?? 'Not assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Employment Type</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $employee->type }}</p>
                    </div>
                </div>
            </div>

            <!-- Assigned Clients -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-theme-border">
                    <h4 class="text-[14px] font-bold text-theme-text-main">Assigned Clients</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-theme-bg border-b border-theme-border">
                            <tr>
                                <th class="px-6 py-3 text-[10px] font-bold text-theme-text-muted uppercase tracking-widest">Client Name</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-theme-text-muted uppercase tracking-widest">Region</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-theme-text-muted uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($employee->clients as $client)
                                <tr class="hover:bg-theme-bg transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-[13px] font-bold text-theme-text-main">{{ $client->user->name }}</div>
                                        <div class="text-[11px] text-theme-text-muted">{{ $client->client_custom_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $client->region }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.clients.show', $client->id) }}" class="text-[#1a3cdc] text-xs font-bold hover:underline">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-theme-text-muted text-sm">No clients assigned yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

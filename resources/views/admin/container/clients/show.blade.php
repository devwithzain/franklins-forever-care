@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Client Details</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Viewing profile information for {{ $client->user->name }}.</div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.clients.edit', $client->id) }}"
                class="px-5 py-2.5 bg-amber-50 text-amber-600 rounded-[10px] text-[13px] font-bold hover:bg-amber-100 transition-all flex items-center gap-2">
                Edit Profile
            </a>
            <a href="{{ route('admin.clients.index') }}"
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
                    {{ strtoupper(substr($client->user->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-extrabold text-theme-text-main">{{ $client->user->name }}</h3>
                <p class="text-sm text-theme-text-muted">{{ $client->client_custom_id }}</p>
                <div class="mt-4">
                    @php
                        $statusClasses = [
                            'Active' => 'bg-green-100 text-green-600',
                            'Pending' => 'bg-amber-100 text-amber-600',
                            'Critical' => 'bg-red-100 text-red-600',
                            'Inactive' => 'bg-theme-hover text-theme-text-main',
                        ];
                        $statusClass = $statusClasses[$client->status] ?? 'bg-theme-hover text-theme-text-main';
                    @endphp
                    <span class="px-3 py-1 rounded-full {{ $statusClass }} text-[12px] font-bold">
                        {{ $client->status }}
                    </span>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
                <h4 class="text-[14px] font-bold text-theme-text-main mb-4 border-b border-theme-border pb-3">Contact Information</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Email</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold">{{ $client->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Phone</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold">{{ $client->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Region</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold">{{ $client->region ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <!-- Service Details -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
                <h4 class="text-[14px] font-bold text-theme-text-main mb-4 border-b border-theme-border pb-3">Care & Assignment</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Assigned Agent</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-8 h-8 rounded-full bg-theme-hover flex items-center justify-center text-theme-text-main text-xs font-bold">
                                {{ $client->agent ? strtoupper(substr($client->agent->name, 0, 2)) : '?' }}
                            </div>
                            <p class="text-[13.5px] text-theme-text-main font-bold">{{ $client->agent->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Care Plan</p>
                        <p class="mt-1"><span class="px-3 py-1 rounded bg-blue-50 text-[#1a3cdc] text-[12px] font-bold">{{ $client->care_plan ?? 'Standard' }}</span></p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Date of Birth</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $client->dob?->format('F d, Y') ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-theme-text-muted uppercase tracking-wider">Registration Date</p>
                        <p class="text-[13.5px] text-theme-text-main font-bold mt-1">{{ $client->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes Placeholder -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm p-6">
                <h4 class="text-[14px] font-bold text-theme-text-main mb-4 border-b border-theme-border pb-3">Recent Activity & Notes</h4>
                <div class="py-10 text-center text-theme-text-muted">
                    <p class="text-sm">No recent activity or notes for this client.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

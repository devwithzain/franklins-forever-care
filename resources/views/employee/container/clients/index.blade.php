@extends('layouts.employee')

@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Client Management</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage client profiles, service plans, and active
                assignments.</div>
        </div>
        <a href="{{ route('admin.clients.create') }}"
            class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Client
        </a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] mb-5 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
        <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Clients</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['total'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Registered</span>
            </div>
        </div>
        <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Plans</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['active_plans'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-theme-primary-light text-theme-primary text-[10.5px] font-bold">Receiving
                    Care</span></div>
        </div>
        <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Pending Assignment</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['pending_assignment'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Needs Agent</span>
            </div>
        </div>
        <div class="bg-theme-card text-theme-text-main rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Critical Cases</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['critical_cases'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">High Priority</span>
            </div>
        </div>
    </div>
    <div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">All Client Records</h3>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search clients..."
                    class="w-60 bg-theme-bg border border-theme-border rounded-[8px] px-4 py-2 text-[12.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary">
                <select
                    class="w-40 bg-theme-card border border-theme-primary text-theme-primary rounded-[8px] px-3 py-2 text-[12px] font-medium outline-none cursor-pointer">
                    <option>All Regions</option>
                    <option>Austin</option>
                    <option>Houston</option>
                    <option>Dallas</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border text-theme-text-main">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            ID</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Client Name
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Contact Info
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Region</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Care Plan
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Agent</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Status</th>
                        <th
                            class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($clients as $client)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4 text-[13px] text-theme-text-muted">{{ $client->client_custom_id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-extrabold text-[12px]">
                                        {{ strtoupper(substr($client->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-[13.5px] font-bold text-theme-text-main">
                                            {{ $client->user->name }}
                                        </div>
                                        <div class="text-[11px] text-theme-text-muted">
                                            DOB: {{ $client->dob?->format('m/d/Y') ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] font-bold text-theme-text-main">{{ $client->phone ?? 'N/A' }}
                                </div>
                                <div class="text-[11px] text-theme-text-muted">{{ $client->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $client->region ?? 'N/A' }}</td>
                            <td class="px-6 py-4"><span
                                    class="px-2 py-0.5 rounded bg-theme-primary-light text-theme-primary text-[11px] font-bold">{{ $client->care_plan ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main font-bold">
                                {{ $client->agent->name ?? 'Unassigned' }}
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
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.clients.show', $client->id) }}"
                                        class="w-8 h-8 rounded-lg bg-theme-primary-light text-theme-primary flex items-center justify-center hover:bg-theme-primary hover:text-white transition-all"><svg
                                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg></a>
                                    <a href="{{ route('admin.clients.edit', $client->id) }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><svg
                                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg></a>
                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this client?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><svg
                                                class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-theme-text-muted">
                                No client records found.
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
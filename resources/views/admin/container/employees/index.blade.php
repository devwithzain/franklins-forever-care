@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Employees / PCA Management</div>
            <div class="text-[13px] text-theme-text-muted mt-1">
                Personal Care Agents — profiles, assignments, and performance.
            </div>
        </div>
        <a href="{{ route('admin.employees.create') }}"
            class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Agent
        </a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Agents</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['total'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Registered</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">On Active Duty</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['active'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Working</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Available</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['available'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-blue-100 text-[#1a3cdc] text-[10.5px] font-bold">Ready</span></div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">On Leave</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['on_leave'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Absent</span></div>
        </div>
    </div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">All Personal Care Agents</h3>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search agents..."
                    class="bg-theme-bg border border-theme-border rounded-[8px] px-4 py-2 text-[12.5px] outline-none focus:border-[#1a3cdc]">
                <select
                    class="bg-theme-card border border-[#1a3cdc] text-[#1a3cdc] rounded-[8px] px-3 py-2 text-[12px] font-bold outline-none cursor-pointer">
                    <option>All Types</option>
                    <option>24/7</option>
                    <option>Part-time</option>
                    <option>Hourly</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">#</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent Name
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Contact</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Area</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Type</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Clients</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Rating</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($employees as $employee)
                        <tr class="hover:bg-theme-bg transition-colors">
                            <td class="px-6 py-4 text-[13px] text-theme-text-muted">{{ $employee->agent_custom_id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-[#dde3f8] text-[#1a3cdc] flex items-center justify-center font-extrabold text-[12px]">
                                        {{ strtoupper(substr($employee->user->name, 0, 2)) }}</div>
                                    <div>
                                        <div class="text-[13.5px] font-bold text-theme-text-main">{{ $employee->user->name }}</div>
                                        <div class="text-[11px] text-theme-text-muted">SSN: ***-**-{{ substr($employee->ssn, -4) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] font-bold text-theme-text-main">{{ $employee->phone ?? 'N/A' }}</div>
                                <div class="text-[11px] text-theme-text-muted">{{ $employee->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $employee->region ?? 'N/A' }}</td>
                            <td class="px-6 py-4"><span
                                    class="px-2 py-0.5 rounded bg-blue-50 text-[#1a3cdc] text-[11px] font-bold">{{ $employee->type }}</span></td>
                            <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main text-center">{{ $employee->clients->count() }}</td>
                            <td class="px-6 py-4 text-[13px] text-amber-500 font-bold">⭐ {{ number_format($employee->rating, 1) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'Active' => 'bg-green-100 text-green-600',
                                        'On Leave' => 'bg-amber-100 text-amber-600',
                                        'Inactive' => 'bg-red-100 text-red-600',
                                    ];
                                    $statusClass = $statusClasses[$employee->status] ?? 'bg-theme-hover text-theme-text-main';
                                @endphp
                                <span class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[10.5px] font-bold">{{ $employee->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.employees.show', $employee->id) }}"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><svg
                                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg></a>
                                    <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><svg
                                            class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg></a>
                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
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
                            <td colspan="9" class="px-6 py-10 text-center text-theme-text-muted">
                                No agents found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($employees->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection
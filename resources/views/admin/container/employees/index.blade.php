@extends('layouts.admin')
@section('title', 'Employees')
@section('admin-content')
        <div class="w-full flex items-center justify-between gap-5 mb-5">
            <div>
                <div class="text-2xl font-extrabold text-theme-text-main">Employees / PCA Management</div>
                <div class="text-[13px] text-theme-text-muted mt-1">
                    Personal Care Agents — profiles, assignments, and performance.
                </div>
            </div>

        </div>
        <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
            <a href="{{ route('admin.employees.index', ['tab' => 'active']) }}"
                class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ ($activeTab ?? 'active') === 'active' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
                Active Agents ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.employees.index', ['tab' => 'applications']) }}"
                class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ ($activeTab ?? 'active') === 'applications' ? 'bg-theme-primary text-white shadow-md' : 'text-theme-text-muted hover:bg-theme-hover border border-theme-border' }}">
                Job Applications ({{ $stats['pending_apps'] ?? 0 }})
            </a>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif
        <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
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
                <h3 class="text-[15px] font-extrabold text-theme-text-main">
                    {{ $activeTab === 'applications' ? 'Pending Job Applications' : 'All Personal Care Agents' }}
                </h3>
                <div class="flex items-center gap-3">
                    <input type="text" placeholder="Search clients..."
                        class="w-60 bg-theme-bg border border-theme-border rounded-[8px] px-4 py-2 text-[12.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary">
                </div>
            </div>
            <div class="overflow-x-auto">
                @if($activeTab === 'applications')
                    <table class="w-full text-left">
                        <thead class="bg-theme-bg border-b border-theme-border">
                            <tr>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Applicant</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Contact</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Experience</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Applied Date</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status
                                </th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-border">
                            @forelse ($applications as $app)
                                <tr class="hover:bg-theme-bg transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-[13.5px] font-bold text-theme-text-main">{{ $app->full_name }}</div>
                                        <div class="text-[11px] text-theme-text-muted">{{ $app->address }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[13px] font-bold text-theme-text-main">{{ $app->phone }}</div>
                                        <div class="text-[11px] text-theme-text-muted">{{ $app->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $app->experience_years }} Years</td>
                                    <td class="px-6 py-4 text-[13px] text-theme-text-muted">{{ $app->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">{{ ucfirst($app->status) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($app->status === 'pending')
                                            <form action="{{ route('admin.employees.approve', $app->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-[11px] font-bold hover:bg-green-600 transition-all">Approve</button>
                                            </form>
                                        @else
                                            <span class="text-green-600 font-bold text-[11px]">Approved</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">No applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <table class="w-full text-left">
                        <thead class="bg-theme-bg border-b border-theme-border">
                            <tr>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">#</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent
                                    Name</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                                    Contact</th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Area
                                </th>
                                <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Type
                                </th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-center">
                                    Clients</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-center">
                                    Rating</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
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
                                                class="w-9 h-9 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-extrabold text-[12px]">
                                                {{ strtoupper(substr($employee->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $employee->user->name }}
                                                </div>
                                                <div class="text-[11px] text-theme-text-muted">SSN:
                                                    ***-**-{{ substr($employee->ssn, -4) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[13px] font-bold text-theme-text-main">{{ $employee->phone ?? 'N/A' }}</div>
                                        <div class="text-[11px] text-theme-text-muted">{{ $employee->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $employee->region ?? 'N/A' }}</td>
                                    <td class="px-6 py-4"><span
                                            class="px-2 py-0.5 rounded bg-blue-50 text-theme-primary text-[11px] font-bold">{{ $employee->type }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main text-center">
                                        {{ $employee->clients->count() }}</td>
                                    <td class="px-6 py-4 text-[13px] text-amber-500 font-bold text-center">⭐
                                        {{ number_format($employee->rating, 1) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-2 py-0.5 rounded-full {{ $employee->status === 'Active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }} text-[10.5px] font-bold">{{ $employee->status }}</span>
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
                                            <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" class="inline">
                                                @csrf @method('DELETE')
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
                                    <td colspan="9" class="px-6 py-10 text-center text-theme-text-muted">No agents found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
            @php
    $paginationItems = $activeTab === 'applications' ? $applications : $employees;
            @endphp
            @if ($paginationItems->hasPages())
                <div class="px-6 py-4 border-t border-theme-border">
                    {{ $paginationItems->links() }}
                </div>
            @endif
        </div>
@endsection
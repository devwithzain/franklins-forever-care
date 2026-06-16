@extends('layouts.admin')
@section('title', 'Inquiries')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Inquiries (Contact Submissions)</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage and respond to message inquiries received from the contact form.</div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
        <a href="{{ route('admin.contact-submissions.index') }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ !request()->filled('status') ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            All Inquiries ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.contact-submissions.index', ['status' => 'new']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'new' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            New ({{ $stats['new'] }})
        </a>
        <a href="{{ route('admin.contact-submissions.index', ['status' => 'in_progress']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'in_progress' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            In Progress ({{ $stats['in_progress'] }})
        </a>
        <a href="{{ route('admin.contact-submissions.index', ['status' => 'resolved']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'resolved' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Resolved ({{ $stats['resolved'] }})
        </a>
    </div>

    <!-- Search and Filters Form -->
    <div class="bg-theme-card rounded-[14px] border border-theme-border p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @if(request()->filled('status'))
                <input type="hidden" name="status" value="{{ request()->status }}">
            @endif
            <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Search Inquiries</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email or subject..." 
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div class="md:col-span-4 flex justify-end gap-2">
                <a href="{{ route('admin.contact-submissions.index', request()->only('status')) }}" class="px-4 py-2 rounded-xl border border-theme-border bg-theme-hover text-theme-text-main text-[11.5px] font-bold">Clear Filters</a>
                <button type="submit" class="px-4 py-2 rounded-xl bg-theme-primary text-white text-[11.5px] font-bold hover:bg-theme-primary-hover shadow-sm transition-all">Apply Filter</button>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-hover border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Name & Email</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Date Submitted</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Assigned Admin</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($submissions as $submission)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $submission->name }}</div>
                                <div class="text-[11px] text-theme-text-muted">{{ $submission->email }}</div>
                                @if($submission->phone)
                                    <div class="text-[11px] text-theme-text-muted">{{ $submission->phone }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] font-bold text-theme-text-main max-w-xs truncate">{{ $submission->subject }}</div>
                                <div class="text-[11.5px] text-theme-text-muted max-w-xs truncate mt-0.5">{{ $submission->message }}</div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main font-semibold">
                                {{ $submission->created_at->format('M d, Y') }}
                                <div class="text-[11px] text-theme-text-muted mt-0.5 font-normal">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'new' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                                        'in_progress' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                                        'resolved' => 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                        'spam' => 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                    $statusClass = $statusClasses[$submission->status] ?? 'bg-theme-bg text-theme-text-muted';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full {{ $statusClass }} text-[10.5px] font-bold uppercase tracking-wider">{{ str_replace('_', ' ', $submission->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">
                                @if($submission->assignedAdmin)
                                    <span class="font-bold">{{ $submission->assignedAdmin->name }}</span>
                                @else
                                    <span class="text-theme-text-muted italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.contact-submissions.show', $submission->id) }}" 
                                   class="px-3.5 py-2 bg-theme-primary-light text-theme-primary rounded-xl text-[11.5px] font-bold hover:bg-theme-primary hover:text-white transition-all shadow-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted italic">
                                No inquiries found matching the criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($submissions->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
@endsection

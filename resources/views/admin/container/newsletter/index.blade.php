@extends('layouts.admin')
@section('title', 'Newsletter Subscribers')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Newsletter Subscribers</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage, confirm, and export your email newsletter audience list.</div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.newsletter.export', request()->only('status')) }}"
                class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all flex items-center gap-2 shadow-sm">
                📥 Export CSV
            </a>
            <a href="{{ route('admin.newsletter.create') }}"
                class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold hover:bg-theme-primary-hover shadow-md transition-all flex items-center gap-2">
                + Add Subscriber
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
        <a href="{{ route('admin.newsletter.index') }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ !request()->filled('status') ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            All Subscribers ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.newsletter.index', ['status' => 'active']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'active' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Active ({{ $stats['active'] }})
        </a>
        <a href="{{ route('admin.newsletter.index', ['status' => 'pending']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'pending' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Pending ({{ $stats['pending'] }})
        </a>
        <a href="{{ route('admin.newsletter.index', ['status' => 'unsubscribed']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ request()->status === 'unsubscribed' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Unsubscribed ({{ $stats['unsubscribed'] }})
        </a>
    </div>

    <!-- Filter form -->
    <div class="bg-theme-card rounded-[14px] border border-theme-border p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.newsletter.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @if(request()->filled('status'))
                <input type="hidden" name="status" value="{{ request()->status }}">
            @endif
            <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Search Subscribers</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by email or name..." 
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Joined From</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Joined To</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
            </div>
            <div class="md:col-span-4 flex justify-end gap-2">
                <a href="{{ route('admin.newsletter.index', request()->only('status')) }}" class="px-4 py-2 rounded-xl border border-theme-border bg-theme-hover text-theme-text-main text-[11.5px] font-bold">Clear Filters</a>
                <button type="submit" class="px-4 py-2 rounded-xl bg-theme-primary text-white text-[11.5px] font-bold hover:bg-theme-primary-hover shadow-sm transition-all">Apply Filter</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-hover border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Email & Name</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Joined Date</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Campaign Stats</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($subscribers as $subscriber)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $subscriber->email }}</div>
                                <div class="text-[11px] text-theme-text-muted">{{ $subscriber->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main font-semibold">
                                {{ $subscriber->created_at->format('M d, Y') }}
                                <div class="text-[11px] text-theme-text-muted mt-0.5 font-normal">{{ $subscriber->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                        'pending' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                                        'unsubscribed' => 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                        'bounced' => 'bg-slate-100 text-slate-600',
                                    ];
                                    $statusClass = $statusClasses[$subscriber->status] ?? 'bg-theme-bg text-theme-text-muted';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full {{ $statusClass }} text-[10.5px] font-bold uppercase tracking-wider">{{ $subscriber->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-[12.5px] text-theme-text-muted leading-relaxed font-semibold">
                                Sent: <span class="text-theme-text-main">{{ $subscriber->emails_sent }}</span> | 
                                Opened: <span class="text-theme-text-main">{{ $subscriber->emails_opened }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.newsletter.show', $subscriber->id) }}" 
                                       class="px-3 py-1.5 bg-theme-primary-light text-theme-primary rounded-lg text-[11px] font-bold transition-all shadow-sm hover:bg-theme-primary hover:text-white">
                                        View
                                    </a>
                                    
                                    @if ($subscriber->status === 'pending')
                                        <form action="{{ route('admin.newsletter.confirm', $subscriber->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-[11px] font-bold hover:bg-green-600 shadow-sm transition-all">Confirm</button>
                                        </form>
                                    @endif
                                    
                                    @if ($subscriber->status === 'active')
                                        <form action="{{ route('admin.newsletter.unsubscribe', $subscriber->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to unsubscribe this email?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-[11px] font-bold hover:bg-red-100 transition-all">Unsubscribe</button>
                                        </form>
                                    @elseif($subscriber->status === 'unsubscribed')
                                        <form action="{{ route('admin.newsletter.reactivate', $subscriber->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-[11px] font-bold hover:bg-green-100 transition-all">Reactivate</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-theme-text-muted italic">
                                No newsletter subscribers found matching the criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($subscribers->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>
@endsection

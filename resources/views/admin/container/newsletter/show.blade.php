@extends('layouts.admin')
@section('title', 'Subscriber Details')
@section('admin-content')
    <div class="mb-5">
        <a href="{{ route('admin.newsletter.index') }}" class="text-[12.5px] font-bold text-theme-primary hover:underline flex items-center gap-1.5 mb-3">
            ← Back to Subscribers
        </a>
        <div class="w-full flex items-center justify-between gap-5">
            <div>
                <div class="text-2xl font-extrabold text-theme-text-main">Subscriber Details</div>
                <div class="text-[13px] text-theme-text-muted mt-1">Review subscriber status, email delivery stats, and details.</div>
            </div>
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

    <div class="grid sm:grid-cols-1 grid-cols-2 gap-6">
        <!-- Details Column -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-sm font-bold text-theme-text-main mb-4">Subscriber Info</h3>
                <div class="grid sm:grid-cols-1 grid-cols-2 gap-6">
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Email Address</span>
                        <div class="text-[14px] font-bold text-theme-text-main break-all">{{ $subscriber->email }}</div>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Name</span>
                        <div class="text-[14px] font-bold text-theme-text-main">{{ $subscriber->name ?? 'Not provided' }}</div>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Status</span>
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-50 text-green-600',
                                'pending' => 'bg-amber-50 text-amber-600',
                                'unsubscribed' => 'bg-red-50 text-red-600',
                                'bounced' => 'bg-slate-100 text-slate-600',
                            ];
                            $statusClass = $statusClasses[$subscriber->status] ?? 'bg-theme-bg text-theme-text-muted';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full {{ $statusClass }} text-[10.5px] font-bold uppercase tracking-wider inline-block">{{ $subscriber->status }}</span>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Date Joined</span>
                        <div class="text-[13px] font-bold text-theme-text-main">
                            {{ optional($subscriber->created_at)->format('M d, Y h:i A') }}
                            <span class="text-[11.5px] text-theme-text-muted ml-1 font-medium">({{ optional($subscriber->created_at)->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Stats -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-sm font-bold text-theme-text-main mb-4">Email Campaign Statistics</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-theme-hover border border-theme-border rounded-xl text-center">
                        <div class="text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Emails Sent</div>
                        <div class="text-xl font-extrabold text-theme-text-main">{{ $subscriber->emails_sent }}</div>
                    </div>
                    <div class="p-4 bg-theme-hover border border-theme-border rounded-xl text-center">
                        <div class="text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Emails Opened</div>
                        <div class="text-xl font-extrabold text-theme-text-main">{{ $subscriber->emails_opened }}</div>
                    </div>
                    <div class="p-4 bg-theme-hover border border-theme-border rounded-xl text-center col-span-2 font-semibold">
                        <div class="text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Open Rate</div>
                        <div class="text-xl font-extrabold text-theme-text-main">
                            {{ $subscriber->emails_sent > 0 ? round(($subscriber->emails_opened / $subscriber->emails_sent) * 100) : 0 }}%
                        </div>
                    </div>
                </div>
            </div>
            
            @if($subscriber->status === 'unsubscribed')
                <div class="bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900 rounded-[14px] p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-red-800 dark:text-red-400 mb-2">Unsubscription Details</h3>
                    <div class="text-[13px] text-red-700 dark:text-red-500 font-medium">
                        <strong>Date:</strong> {{ optional($subscriber->unsubscribed_at)->format('M d, Y h:i A') }}
                    </div>
                    @if($subscriber->unsubscribe_reason)
                        <div class="text-[13px] text-red-700 dark:text-red-500 mt-2 font-medium">
                            <strong>Reason:</strong> {{ $subscriber->unsubscribe_reason }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Meta info sidebar column -->
        <div class="space-y-6">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-theme-text-main mb-2">Actions</h3>
                
                @if ($subscriber->status === 'pending')
                    <form action="{{ route('admin.newsletter.confirm', $subscriber->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 bg-green-500 text-white rounded-xl text-xs font-bold hover:bg-green-600 shadow-sm transition-all text-center">
                            Confirm Subscription
                        </button>
                    </form>
                @endif
                
                @if ($subscriber->status === 'active')
                    <form action="{{ route('admin.newsletter.unsubscribe', $subscriber->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Unsubscribe Reason (Optional)</label>
                            <input type="text" name="reason" placeholder="e.g. Requested via phone"
                                   class="w-full px-3 py-1.5 rounded-lg border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-xs">
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition-all text-center">
                            Unsubscribe Email
                        </button>
                    </form>
                @elseif($subscriber->status === 'unsubscribed')
                    <form action="{{ route('admin.newsletter.reactivate', $subscriber->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 bg-green-50 text-green-600 rounded-xl text-xs font-bold hover:bg-green-100 transition-all text-center">
                            Reactivate Subscriber
                        </button>
                    </form>
                @endif

                <div class="border-t border-theme-border pt-4">
                    <form action="{{ route('admin.newsletter.destroy', $subscriber->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to permanently delete this subscriber? This action is irreversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-xl text-xs font-bold hover:bg-red-600 transition-all text-center">
                            Delete Subscriber
                        </button>
                    </form>
                </div>
            </div>

            <!-- Meta details card -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-sm font-bold text-theme-text-main mb-3">Subscription Source Info</h3>
                <div class="space-y-3 text-[11.5px] text-theme-text-muted leading-relaxed font-semibold">
                    <div><strong>IP Address:</strong> <span class="text-theme-text-main">{{ $subscriber->ip_address ?? 'N/A' }}</span></div>
                    <div class="break-words"><strong>User Agent:</strong> <span class="text-theme-text-main">{{ $subscriber->user_agent ?? 'N/A' }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection

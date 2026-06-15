@extends('layouts.employee')
@section('title', 'Notifications')
@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Notifications Center</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage system-wide broadcasts and personalized alerts.</div>
        </div>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 gap-5 my-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Notifications</h3>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[12px] font-bold text-[#1a3cdc] hover:underline">Mark all as read</button>
                    </form>
                    @endif
                </div>
                <div class="divide-y divide-theme-border">
                    @forelse ($notifications as $notification)
                        <div class="p-6 flex gap-4 hover:bg-theme-bg transition-colors {{ is_null($notification->read_at) ? 'bg-blue-50/20' : '' }}">
                            <div class="w-10 h-10 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center flex-shrink-0">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[14px] font-bold text-theme-text-main {{ is_null($notification->read_at) ? 'text-theme-primary' : '' }}">{{ $notification->data['title'] ?? 'Notification' }}</span>
                                    <span class="text-[11px] text-theme-text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-theme-text-muted leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>
                                @if(is_null($notification->read_at))
                                <div class="mt-3 flex gap-2">
                                    <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-[#1a3cdc] text-white rounded-[6px] text-[11px] font-bold">Mark as Read</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-theme-text-muted italic">No notifications found.</div>
                    @endforelse
                </div>
                @if($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-theme-border">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

            <!-- Broadcasts section -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm mt-8">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Broadcasts</h3>
                </div>
                <div class="divide-y divide-theme-border">
                    @forelse ($broadcasts as $broadcast)
                        <div class="p-6 flex gap-4 hover:bg-theme-bg transition-colors">
                            <div class="w-10 h-10 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center flex-shrink-0">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[14px] font-bold text-theme-text-main">Broadcast</span>
                                    <span class="text-[11px] text-theme-text-muted">{{ $broadcast->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-theme-text-muted leading-relaxed">{{ $broadcast->message }}</p>
                                <div class="mt-2 text-[11px] text-theme-text-muted font-bold">Sent by: {{ $broadcast->sender?->name ?? 'Admin' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-theme-text-muted italic">No broadcasts sent yet.</div>
                    @endforelse
                </div>
                @if($broadcasts->hasPages())
                    <div class="px-6 py-4 border-t border-theme-border">
                        {{ $broadcasts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
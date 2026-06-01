@extends('layouts.user')
@section('title', 'Notification')
@section('client-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Notifications Center</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage system-wide broadcasts and personalized alerts.</div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-5 my-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Notifications</h3>
                    <button class="text-[12px] font-bold text-[#1a3cdc] hover:underline">Mark all as read</button>
                </div>
                <div class="divide-y divide-theme-border">
                    @forelse($broadcasts ?? [] as $broadcast)
                        <div class="p-6 flex gap-4 hover:bg-theme-bg transition-colors">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[14px] font-bold text-theme-text-main">{{ ucfirst($broadcast->audience) }} Notification</span>
                                    <span class="text-[11px] text-theme-text-muted">{{ $broadcast->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-theme-text-muted leading-relaxed">{{ $broadcast->message }}</p>
                                <div class="mt-3 flex gap-2">
                                    <span class="text-[10px] text-theme-text-muted">From: {{ $broadcast->sender?->name ?? 'Admin' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-theme-text-muted">
                            <p>No notifications at this time.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
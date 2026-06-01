@extends('layouts.admin')
@section('title', 'Notifications')
@section('admin-content')
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
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-5 my-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
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
                                    <span class="text-[14px] font-bold text-theme-text-main">Broadcast to {{ $broadcast->audience }}</span>
                                    <span class="text-[11px] text-theme-text-muted">{{ $broadcast->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-theme-text-muted leading-relaxed">{{ $broadcast->message }}</p>
                                <div class="mt-2 text-[11px] text-theme-text-muted font-bold">Sent by: {{ $broadcast->sender->name }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-theme-text-muted italic">No broadcasts sent yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-[14.5px] font-bold text-theme-text-main mb-6">Send Quick Broadcast</h3>
                <form action="{{ route('admin.notifications.broadcast') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest block mb-2">Audience</label>
                        <select name="audience" class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2 text-[13px] font-medium outline-none">
                            <option value="All Users">All Users</option>
                            <option value="Clients Only">Clients Only</option>
                            <option value="Agents Only">Agents Only</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest block mb-2">Message</label>
                        <textarea name="message" required class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-3 text-[13px] h-32 outline-none focus:border-theme-primary" placeholder="Type your broadcast message..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-theme-primary text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">Send Notification</button>
                </form>
            </div>
        </div>
    </div>
@endsection
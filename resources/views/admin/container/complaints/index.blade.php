@extends('layouts.admin')
@section('title', 'Complaints')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Complaints & Feedback</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Monitor service issues and track resolution status.</div>
        </div>
    </div>
    <div class="grid xm:grid-cols-1 sm:grid-cols-1 grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Issues</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Pending</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['pending'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">Needs Attention</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Resolved</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['resolved'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">High Priority</div>
            <div class="text-2xl font-extrabold text-theme-text-main text-red-500">{{ $stats['high_priority'] }}</div>
        </div>
    </div>
    <div class="space-y-5">
        @forelse ($complaints as $complaint)
            <div
                class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm flex gap-4 hover:border-theme-primary transition-colors group">
                <div
                    class="w-12 h-12 rounded-full {{ $complaint->priority === 'High' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center flex-shrink-0">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[14px] font-bold text-theme-text-main">{{ $complaint->subject }}</span>
                        <span
                            class="text-[11px] {{ $complaint->priority === 'High' ? 'text-red-500' : 'text-amber-500' }} font-bold uppercase tracking-widest">{{ $complaint->priority }}</span>
                    </div>
                    <p class="text-[13px] text-theme-text-muted mb-3">{{ $complaint->description }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center text-[9px] font-bold">
                                {{ strtoupper(substr($complaint->client->user->name, 0, 2)) }}
                            </div>
                            <span
                                class="text-[11.5px] font-bold text-theme-text-muted">{{ $complaint->client->user->name }}</span>
                            <span
                                class="text-[10px] text-theme-text-muted ml-2">{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-2">
                            @if ($complaint->status === 'Pending')
                                <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Resolved">
                                    <button type="submit"
                                        class="px-4 py-1.5 bg-green-500 text-white rounded-lg text-[11px] font-bold hover:bg-green-600 transition-all">Mark
                                        as Resolved</button>
                                </form>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-lg text-[11px] font-bold">Resolved</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-10 text-center text-theme-text-muted">
                No complaints found.
            </div>
        @endforelse
    </div>
    @if ($complaints->hasPages())
        <div class="mt-5">
            {{ $complaints->links() }}
        </div>
    @endif
@endsection
@extends('layouts.admin')
@section('title', 'Outdoor Activities')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Outdoor Activities</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Monitor active outdoor sessions, tracking locations and
                duration.</div>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Now</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['active'] }}</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">In Progress</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['total_today'] }}</div>
        </div>
    </div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">Session Log</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Activity</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Start
                            Time</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($sessions as $session)
                        <tr class="hover:bg-theme-bg transition-colors">
                            <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main">
                                {{ $session->client->user->name }}
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $session->employee->user->name }}</td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $session->activity_name }}</td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $session->start_time->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-0.5 rounded-full {{ $session->status === 'Active' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }} text-[10.5px] font-bold">{{ $session->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-theme-text-muted">No outdoor activity sessions
                                found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($sessions->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
@endsection
@extends('layouts.admin')
@section('title', 'Attendance')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Attendance Management</div>
            <div class="text-[13px] text-theme-text-muted mt-1">
                Track daily check-ins, check-outs, and monthly reports for all agents.
            </div>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Present Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['present'] }}</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">On Duty</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Late Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['late'] }}</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Late</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Absent Today</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['absent'] }}</div>
            <div class="mt-2 flex items-center">
                <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">Absent</span>
            </div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">On Leave</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $stats['on_leave'] }}</div>
            <div class="mt-2 flex items-center">
                <span
                    class="px-2 py-0.5 rounded-full bg-theme-hover text-theme-text-muted text-[10.5px] font-bold">Approved</span>
            </div>
        </div>
    </div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Attendance Log</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Check-In</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                            Check-Out</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Note
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($attendances as $attendance)
                        <tr class="hover:bg-theme-bg transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-bold text-[11px]">
                                        {{ strtoupper(substr($attendance->employee->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div class="text-[13px] font-bold text-theme-text-main">
                                        {{ $attendance->employee->user->name ?? 'Unknown' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] font-bold text-theme-text-main">
                                    {{ $attendance->client->user->name ?? 'N/A' }}
                                </div>
                                <div class="text-[11px] text-theme-text-muted">
                                    {{ $attendance->check_in->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] text-theme-text-main">{{ $attendance->check_in->format('h:i A') }}</div>
                                @if($attendance->check_in_latitude)
                                <div class="text-[10px] text-[#1a3cdc] mt-1"><a href="https://maps.google.com/?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}" target="_blank" class="hover:underline">View Map</a></div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13px] text-theme-text-main">
                                    {{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '—' }}
                                </div>
                                @if($attendance->check_out_latitude)
                                <div class="text-[10px] text-[#1a3cdc] mt-1"><a href="https://maps.google.com/?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}" target="_blank" class="hover:underline">View Map</a></div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'Present' => 'bg-green-100 text-green-600',
                                        'Pending Review' => 'bg-yellow-100 text-yellow-600',
                                        'Absent' => 'bg-red-100 text-red-600',
                                        'On Leave' => 'bg-theme-hover text-theme-text-muted',
                                    ];
                                    $statusClass = $statusClasses[$attendance->status] ?? 'bg-theme-hover text-theme-text-muted';
                                @endphp
                                <span
                                    class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[10.5px] font-bold">{{ $attendance->status }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[12px] text-theme-text-muted max-w-[200px] truncate" title="{{ $attendance->note }}">
                                    {{ $attendance->note ?? '—' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-theme-text-muted">No attendance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($attendances->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>
@endsection
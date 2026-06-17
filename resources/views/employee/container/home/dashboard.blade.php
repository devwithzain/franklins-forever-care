@extends('layouts.employee')
@section('title', 'Dashboard')
@section('employee-content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-800">Welcome, {{ Auth::user()->name }}! 👋</h1>
    <p class="text-slate-500 text-[13.5px] mt-1">Here's your work overview for today - <span class="font-semibold">{{
            $currentDateTime->format('l, F j, Y') }} | {{ $currentDateTime->format('h:i:s A') }}</span></p>
</div>

@if(!$employeeRecord && $application)
{{-- Application Status for Candidates --}}
<div class="bg-white rounded-[14px] border-2 border-dashed border-theme-primary/20 p-8 text-center mb-8 shadow-sm">
    <div class="w-20 h-20 bg-theme-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-theme-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="1.5">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    <h2 class="text-xl font-bold text-slate-800 mb-2">Application Under Review</h2>
    <p class="text-slate-500 text-[14px] max-w-md mx-auto mb-6">
        Thank you for applying to Franklin's Forever Care! Your application is currently in the
        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-bold uppercase text-[10px]">{{
            $application->status }}</span>
        phase. Our HR team will notify you via email once a decision is made.
    </p>
    <div
        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-lg text-[12px] font-bold text-slate-600 border border-slate-100">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 8v4l3 3" />
        </svg>
        Submitted: {{ $application->created_at->diffForHumans() }}
    </div>
</div>
@endif

@if($employeeRecord)
{{-- Active Employee Dashboard --}}
<div
    class="bg-[#7c3aed] rounded-[14px] p-8 text-white flex items-center justify-between mb-8 shadow-lg shadow-purple-200">
    <div class="flex items-center gap-6">
        <div
            class="w-20 h-20 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center text-3xl font-extrabold">
            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/placeholder.png') }}"
                alt="" class="w-full h-full rounded-full">
        </div>
        <div>
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
            <p class="text-purple-100 text-[14px] mt-1">
                {{ $employeeRecord->type }} · ID: {{ $employeeRecord->agent_custom_id }}
            </p>
        </div>
    </div>
    <div class="flex gap-3">
        @if($todayAttendance)
        <div class="text-right">
            <p class="text-purple-100 text-[12px] mb-2">Checked in at:</p>
            <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') }}</p>
        </div>
        @else
        <div class="text-right">
            <p class="text-purple-100 text-[12px] mb-2">No check-in recorded today</p>
        </div>
        @endif
    </div>
</div>

<div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
        <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Assigned Clients</div>
        <div class="text-3xl font-extrabold text-slate-800">{{ $stats['total_clients'] }}</div>
        <div class="mt-4 flex items-center gap-2 text-green-600 text-[12px] font-bold">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> {{ $stats['active_cases'] }} Active
            Duty
        </div>
    </div>


    <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
        <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Attendance Rating</div>
        <div class="text-3xl font-extrabold text-slate-800">{{ $employeeRecord->rating }}/5.0</div>
        <div class="mt-4 text-slate-400 text-[12px] font-medium">Based on 30 day history</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Weekly Attendance Log --}}
    <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm overflow-x-auto">
        <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">Weekly Attendance Log</h3>
        <div class="grid grid-cols-7 gap-2">
            @foreach($weeklyAttendance as $day)
            <div class="text-center">
                <div class="text-[10px] font-bold text-slate-400 uppercase mb-2">{{ $day['day'] }}</div>
                <div class="w-full rounded-lg p-2 text-center text-[10px] border
                                @if($day['status'] === 'Present')
                                    bg-green-50 border-green-200 text-green-700 font-bold
                                @elseif($day['status'] === 'Absent')
                                    bg-red-50 border-red-200 text-red-700 font-bold
                                @elseif($day['status'] === 'Late')
                                    bg-amber-50 border-amber-200 text-amber-700 font-bold
                                @else
                                    bg-slate-50 border-slate-200 text-slate-500
                                @endif
                            ">
                    @if($day['status'] === 'Present')
                    <svg class="w-4 h-4 mx-auto mb-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    <div>{{ $day['check_in_time'] }}</div>
                    @elseif($day['status'] === 'Absent')
                    <svg class="w-4 h-4 mx-auto mb-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                    <div>Absent</div>
                    @else
                    <span>OFF</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if(!empty(collect($weeklyAttendance)->where('status', 'Present')->first()))
        <div class="mt-6 pt-4 border-t border-slate-200 text-[12px] text-slate-600">
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <span class="font-bold">Present Days:</span>
                    <span class="ml-2">{{ collect($weeklyAttendance)->where('status', 'Present')->count() }}</span>
                </div>
                <div>
                    <span class="font-bold">Absent Days:</span>
                    <span class="ml-2">{{ collect($weeklyAttendance)->where('status', 'Absent')->count() }}</span>
                </div>
                <div>
                    <span class="font-bold">Off Days:</span>
                    <span class="ml-2">{{ collect($weeklyAttendance)->where('status', 'OFF')->count() }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
        <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">Recent Activity</h3>
        @if($recentActivity->count() > 0)
        <div class="space-y-4">
            @foreach($recentActivity as $activity)
            <div class="flex items-start gap-3 pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-theme-primary to-purple-600 text-white flex items-center justify-center flex-shrink-0 text-[12px] font-bold">
                    <img src="{{ $activity['image'] ? asset('storage/' . $activity['image']) : asset('assets/placeholder.png') }}"
                        alt="" class="w-full h-full rounded-full">
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-[13px] font-bold text-slate-800 truncate">{{ $activity['client_name'] }}</h4>
                    <p class="text-[12px] text-slate-500 mt-1">
                        <span class="font-semibold text-slate-700">{{ $activity['request_type'] }}</span>
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">{{ Str::limit($activity['description'], 50) }}</p>
                    <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-400">
                        <span>{{ $activity['created_date'] }} {{ $activity['created_time'] }}</span>
                        <span class="px-2 py-0.5 rounded-full 
                                            @if($activity['status'] === 'Pending')
                                                bg-amber-100 text-amber-700
                                            @elseif($activity['status'] === 'Approved')
                                                bg-green-100 text-green-700
                                            @else
                                                bg-red-100 text-red-700
                                            @endif
                                            font-bold uppercase text-[10px]">{{ $activity['status'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-slate-400 text-[13.5px]">
            <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p>No recent updates from your assigned clients.</p>
        </div>
        @endif
    </div>
</div>

<!-- Live Clock and System Time (Optional) -->
<div
    class="mt-8 bg-gradient-to-r from-slate-50 to-slate-100 rounded-[14px] border border-slate-200 p-4 text-center text-slate-600 text-[12px]">
    <p>System Time: <span id="system-time" class="font-bold text-slate-800">{{ $currentDateTime->format('h:i:s A')
            }}</span></p>
</div>

<script>
    // Live clock update
            function updateClock() {
                const now = new Date();
                document.getElementById('system-time').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
            }
            updateClock();
            setInterval(updateClock, 1000);
</script>
@elseif(!$application)
{{-- No application and not an employee --}}
<div class="bg-white rounded-[14px] border border-slate-200 p-12 text-center shadow-sm">
    <h2 class="text-xl font-bold text-slate-800 mb-2">Become a PCA Specialist</h2>
    <p class="text-slate-500 mb-8 max-w-md mx-auto">Join our team of professional care providers. Fill out our career
        application form to get started.</p>
    <a href="{{ route('career.index') }}"
        class="px-8 py-3 bg-theme-primary text-white rounded-lg font-bold shadow-lg">Apply Now</a>
</div>
@endif
@endsection
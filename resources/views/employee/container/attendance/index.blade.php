@extends('layouts.employee')
@section('title', 'My Attendance')
@section('employee-content')
<div class="mb-8">
   <h1 class="text-2xl font-extrabold text-slate-800">My Attendance</h1>
   <p class="text-slate-500 text-[13.5px] mt-1">Track your daily check-ins, check-outs, and monthly attendance records.
   </p>
</div>

{{-- FIX 1: Flash messages were missing entirely --}}
@if(session('success'))
<div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-[13px] font-medium">
   {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-[13px] font-medium">
   {{ session('error') }}
</div>
@endif

@if($employeeRecord)
<div class="grid sm:rid-cols-1 xm:grid-cols-1 grid-cols-2 gap-8">
   {{-- Today's Status --}}
   <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
         <h3 class="text-[15px] font-extrabold text-slate-800">Today's Status</h3>
         <div class="flex gap-3">
            @if(!$attendanceToday || !$attendanceToday->check_in)
            <form method="POST" action="{{ route('employee.attendance.check-in') }}">
               @csrf
               <button type="submit"
                  class="px-5 py-2.5 bg-green-600 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-green-700 transition-all">
                  Check In
               </button>
            </form>
            @endif
            @if($attendanceToday && $attendanceToday->check_in && !$attendanceToday->check_out)
            <form method="POST" action="{{ route('employee.attendance.check-out') }}">
               @csrf
               <button type="submit"
                  class="px-5 py-2.5 bg-red-600 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-red-700 transition-all">
                  Check Out
               </button>
            </form>
            @endif
         </div>
      </div>

      <div class="space-y-4">
         @if($attendanceToday)
         <div class="flex items-center justify-between">
            <span class="text-slate-500 text-[13px]">Check In</span>
            <span
               class="text-slate-800 font-bold">{{ \Carbon\Carbon::parse($attendanceToday->check_in)->format('h:i A') }}</span>
         </div>
         <div class="flex items-center justify-between">
            <span class="text-slate-500 text-[13px]">Check Out</span>
            <span
               class="text-slate-800 font-bold">{{ $attendanceToday->check_out ? \Carbon\Carbon::parse($attendanceToday->check_out)->format('h:i A') : '—' }}</span>
         </div>
         <div class="flex items-center justify-between">
            <span class="text-slate-500 text-[13px]">Status</span>
            <span class="px-2 py-0.5 rounded-full 
                        @if($attendanceToday->status === 'Present')
                            bg-green-100 text-green-700
                        @elseif($attendanceToday->status === 'Late')
                            bg-amber-100 text-amber-700
                        @elseif($attendanceToday->status === 'On Leave')
                            bg-slate-100 text-slate-700
                        @else
                            bg-red-100 text-red-700
                        @endif
                        text-[11px] font-bold">
               {{ $attendanceToday->status }}
            </span>
         </div>
         @if($attendanceToday->check_out)
         {{-- FIX 2: Duration was "1.5 hrs" — now shows "1h 30m" --}}
         <div class="flex items-center justify-between">
            <span class="text-slate-500 text-[13px]">Hours Worked</span>
            @php
            $todayMins =
            \Carbon\Carbon::parse($attendanceToday->check_out)->diffInMinutes(\Carbon\Carbon::parse($attendanceToday->check_in));
            @endphp
            <span class="text-slate-800 font-bold">{{ floor($todayMins / 60) }}h {{ $todayMins % 60 }}m</span>
         </div>
         @endif
         @else
         <div class="text-center py-8 text-slate-400">
            <p>No check-in recorded yet for today.</p>
         </div>
         @endif
      </div>
   </div>

   {{-- Monthly Statistics --}}
   <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
      <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">Monthly Statistics</h3>
      <div class="grid grid-cols-2 gap-4">
         <div class="bg-green-50 rounded-lg p-4 border border-green-100">
            <div class="text-green-600 text-[12px] font-bold uppercase tracking-widest">Present</div>
            <div class="text-2xl font-extrabold text-green-700">
               {{ collect($monthlyAttendance)->where('status', 'Present')->count() }}</div>
         </div>
         <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
            <div class="text-amber-600 text-[12px] font-bold uppercase tracking-widest">Late</div>
            <div class="text-2xl font-extrabold text-amber-700">
               {{ collect($monthlyAttendance)->where('status', 'Late')->count() }}</div>
         </div>
         <div class="bg-red-50 rounded-lg p-4 border border-red-100">
            <div class="text-red-600 text-[12px] font-bold uppercase tracking-widest">Absent</div>
            <div class="text-2xl font-extrabold text-red-700">
               {{ collect($monthlyAttendance)->where('status', 'Absent')->count() }}</div>
         </div>
         <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
            <div class="text-slate-600 text-[12px] font-bold uppercase tracking-widest">Off Days</div>
            <div class="text-2xl font-extrabold text-slate-700">
               {{ collect($monthlyAttendance)->where('status', 'OFF')->count() }}</div>
         </div>
      </div>
   </div>
</div>

{{-- Monthly Calendar --}}
<div class="mt-8 bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
   <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">{{ $currentMonth->format('F Y') }} — Monthly Overview</h3>

   <div class="grid grid-cols-7 gap-2">
      @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
      <div class="text-center text-[10px] font-bold text-slate-400 uppercase mb-2">{{ $day }}</div>
      @endforeach

      {{-- FIX 3: Calendar had no offset — first day always started on Monday column regardless of actual weekday --}}
      @php $startOffset = $currentMonth->copy()->startOfMonth()->dayOfWeekIso - 1; @endphp
      @for($i = 0; $i < $startOffset; $i++) <div>
   </div>
   @endfor

   @foreach($monthlyAttendance as $day)
   <div class="text-center">
      <div class="w-full rounded-lg p-2 text-center text-[10px] border
                @if($day['isToday'])
                    ring-2 ring-purple-500 ring-offset-1
                @endif
                @if($day['status'] === 'Present')
                    bg-green-50 border-green-200 text-green-700 font-bold
                @elseif($day['status'] === 'Late')
                    bg-amber-50 border-amber-200 text-amber-700 font-bold
                @elseif($day['status'] === 'Absent')
                    bg-red-50 border-red-200 text-red-700 font-bold
                @elseif($day['status'] === 'On Leave')
                    bg-slate-50 border-slate-200 text-slate-600 font-bold
                @elseif($day['status'] === 'Upcoming')
                    bg-white border-slate-100 text-slate-300
                @else
                    bg-slate-50 border-slate-200 text-slate-400
                @endif
            ">
         <div class="font-bold text-[11px]">{{ $day['day'] }}</div>
         <div class="text-[8px] mt-1 uppercase">
            @if($day['status'] === 'Present')
            P
            @elseif($day['status'] === 'Late')
            L
            @elseif($day['status'] === 'Absent')
            A
            @elseif($day['status'] === 'On Leave')
            Lv
            @elseif($day['status'] === 'Upcoming')
            {{-- future days: show nothing --}}
            @else
            OFF
            @endif
         </div>
      </div>
   </div>
   @endforeach
</div>

<div class="mt-6 flex flex-wrap gap-4 justify-center">
   <div class="flex items-center gap-2 text-[12px] font-bold text-slate-600">
      <div class="w-3 h-3 rounded bg-green-500"></div> Present
   </div>
   <div class="flex items-center gap-2 text-[12px] font-bold text-slate-600">
      <div class="w-3 h-3 rounded bg-amber-500"></div> Late
   </div>
   <div class="flex items-center gap-2 text-[12px] font-bold text-slate-600">
      <div class="w-3 h-3 rounded bg-red-500"></div> Absent
   </div>
   <div class="flex items-center gap-2 text-[12px] font-bold text-slate-600">
      <div class="w-3 h-3 rounded bg-slate-300"></div> Off Day
   </div>
</div>
</div>

{{-- Attendance Log --}}
<div class="mt-8 bg-white rounded-[14px] border border-slate-200 shadow-sm overflow-hidden">
   <div class="px-6 py-5 border-b border-slate-200">
      <h3 class="text-[15px] font-extrabold text-slate-800">Attendance History</h3>
   </div>
   <div class="overflow-x-auto">
      <table class="w-full text-left">
         <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
               <th class="px-6 py-3 text-[10.5px] font-bold text-slate-500 uppercase tracking-widest">Date</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-slate-500 uppercase tracking-widest">Check In</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-slate-500 uppercase tracking-widest">Check Out</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-slate-500 uppercase tracking-widest">Hours</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-slate-500 uppercase tracking-widest">Status</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-slate-200">
            @forelse($attendances as $a)
            <tr class="hover:bg-slate-50 transition-colors">
               <td class="px-6 py-4 text-[13px] text-slate-800">
                  {{ \Carbon\Carbon::parse($a->check_in)->format('M d, Y') }}</td>
               <td class="px-6 py-4 text-[13px] text-slate-800">
                  {{ \Carbon\Carbon::parse($a->check_in)->format('h:i A') }}</td>
               <td class="px-6 py-4 text-[13px] text-slate-800">
                  {{ $a->check_out ? \Carbon\Carbon::parse($a->check_out)->format('h:i A') : '—' }}</td>
               {{-- FIX 4: Was showing "— hrs" when no checkout. Also duration now "Xh Ym" --}}
               <td class="px-6 py-4 text-[13px] text-slate-800 font-bold">
                  @if($a->check_out)
                  @php $mins = \Carbon\Carbon::parse($a->check_out)->diffInMinutes(\Carbon\Carbon::parse($a->check_in));
                  @endphp
                  {{ floor($mins / 60) }}h {{ $mins % 60 }}m
                  @else
                  —
                  @endif
               </td>
               <td class="px-6 py-4">
                  <span class="px-2 py-0.5 rounded-full 
                            @if($a->status === 'Present')
                                bg-green-100 text-green-700
                            @elseif($a->status === 'Late')
                                bg-amber-100 text-amber-700
                            @elseif($a->status === 'On Leave')
                                bg-slate-100 text-slate-700
                            @else
                                bg-red-100 text-red-700
                            @endif
                            text-[10.5px] font-bold">
                     {{ $a->status }}
                  </span>
               </td>
            </tr>
            @empty
            <tr>
               <td colspan="5" class="px-6 py-10 text-center text-slate-400">No attendance records found for this month.
               </td>
            </tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>
@else
<div class="bg-white rounded-[14px] border border-slate-200 p-12 text-center shadow-sm">
   <h2 class="text-xl font-bold text-slate-800 mb-2">Employee Record Not Found</h2>
   <p class="text-slate-500">Your attendance can only be tracked if you have an active employee record.</p>
</div>
@endif
@endsection
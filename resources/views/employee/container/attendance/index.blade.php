@extends('layouts.employee')
@section('title', 'My Attendance')
@section('employee-content')
<div class="mb-8 flex items-center justify-between gap-5">
   <div>
      <h1 class="text-2xl font-extrabold text-slate-800">My Attendance & Visits</h1>
      <p class="text-slate-500 text-[13.5px] mt-1">Track your check-ins and timesheets per client visit.</p>
   </div>
</div>

@if(session('success'))
<div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-[13px] font-medium">
   {{ session('success') }}
</div>
@endif
@if(session('error') || isset($error))
<div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-[13px] font-medium">
   {{ session('error') ?? $error }}
</div>
@endif

@if(!isset($error))
<div class="grid lg:grid-cols-3 gap-8">
   <!-- Left Column: Today's Schedule & Missed Punches -->
   <div class="lg:col-span-2 space-y-8">

      <!-- Missed Punches -->
      @if(count($missedPunches) > 0)
      <div class="bg-red-50 rounded-[14px] border border-red-200 p-6 shadow-sm">
         <div class="flex items-center gap-2 mb-4 text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <h3 class="text-[15px] font-extrabold">Incomplete Attendance (Missed Checkout)</h3>
         </div>
         <div class="space-y-4">
            @foreach($missedPunches as $missed)
            <div class="bg-white p-4 rounded-lg border border-red-100 flex items-center justify-between">
               <div>
                  <div class="text-[13px] font-bold text-slate-800">{{ $missed->serviceBooking->client->user->name ?? 'Unknown Client' }}</div>
                  <div class="text-[12px] text-slate-500">
                     Check-in: {{ $missed->check_in->format('M d, Y h:i A') }}
                  </div>
               </div>
               <button onclick="openMissedPunchModal({{ $missed->id }})" class="px-4 py-2 bg-red-600 text-white rounded-lg text-[12px] font-bold hover:bg-red-700">Fix Punch</button>
            </div>
            @endforeach
         </div>
      </div>
      @endif

      <!-- Today's Visits -->
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm overflow-hidden">
         <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-slate-800">Today's Scheduled Visits</h3>
         </div>
         <div class="divide-y divide-slate-100">
            @forelse($todaysBookings as $booking)
               @php
                  $attendance = $todaysAttendances->get($booking->id);
               @endphp
               <div class="p-6">
                  <div class="flex items-center justify-between mb-4">
                     <div>
                        <div class="text-[15px] font-bold text-slate-800">{{ $booking->client->user->name ?? $booking->patient_name }}</div>
                        <div class="text-[13px] text-slate-500 mt-0.5">{{ $booking->service->name ?? 'Service' }} | {{ $booking->address }}, {{ $booking->city }}</div>
                     </div>
                     <div>
                        @if(!$attendance)
                           <button onclick="checkIn({{ $booking->id }})" class="px-5 py-2.5 bg-green-600 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-green-700 transition-all flex items-center gap-2">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                              Check In
                           </button>
                        @elseif($attendance && !$attendance->check_out)
                           <button onclick="openCheckOutModal({{ $attendance->id }})" class="px-5 py-2.5 bg-red-600 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                              Check Out
                           </button>
                        @else
                           <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-[12px] font-bold">Completed</span>
                        @endif
                     </div>
                  </div>

                  @if($attendance)
                  <div class="bg-slate-50 rounded-lg p-4 grid grid-cols-2 gap-4">
                     <div>
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Check In</div>
                        <div class="text-[13px] font-bold text-slate-800">{{ $attendance->check_in->format('h:i A') }}</div>
                     </div>
                     <div>
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Check Out</div>
                        <div class="text-[13px] font-bold text-slate-800">{{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '--:--' }}</div>
                     </div>
                  </div>
                  @endif
               </div>
            @empty
               <div class="p-6 text-center text-slate-500 text-[13.5px]">No visits scheduled for today.</div>
            @endforelse
         </div>
      </div>
   </div>

   <!-- Right Column: Timesheet Summary -->
   <div class="space-y-8">
      <div class="bg-slate-900 rounded-[14px] p-6 text-white shadow-xl">
         <h3 class="text-[15px] font-extrabold mb-6">Weekly Timesheet</h3>

         <div class="space-y-4 mb-8">
            <div>
               <div class="text-white/60 text-[12px] font-bold uppercase tracking-widest mb-1">Total Hours</div>
               <div class="text-4xl font-extrabold text-[#1a3cdc]">{{ $totalHoursThisWeek }}<span class="text-xl text-white/50">h</span></div>
            </div>
            <div>
               <div class="text-white/60 text-[12px] font-bold uppercase tracking-widest mb-1">Visits Completed</div>
               <div class="text-2xl font-extrabold">{{ $completedVisitsThisWeek }}</div>
            </div>
         </div>
      </div>

      <!-- Weekly Log Detail -->
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm overflow-hidden">
         <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-[14px] font-extrabold text-slate-800">Recent Logs</h3>
         </div>
         <div class="divide-y divide-slate-100">
            @forelse($weeklyAttendances as $log)
            <div class="p-4">
               <div class="flex items-center justify-between mb-1">
                  <div class="text-[13px] font-bold text-slate-800">{{ $log->check_in->format('D, M d') }}</div>
                  <div class="text-[12px] font-bold text-slate-500">
                     @if($log->check_out)
                        {{ round($log->check_in->diffInMinutes($log->check_out) / 60, 1) }} hrs
                     @else
                        In Progress
                     @endif
                  </div>
               </div>
               <div class="text-[12px] text-slate-500">{{ $log->serviceBooking->client->user->name ?? 'Client' }}</div>
            </div>
            @empty
            <div class="p-4 text-center text-slate-500 text-[13px]">No logs this week.</div>
            @endforelse
         </div>
      </div>
   </div>
</div>

<!-- Check Out Modal -->
<div id="checkOutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div class="bg-white w-full max-w-md rounded-[14px] shadow-2xl overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
         <h3 class="text-[16px] font-extrabold text-slate-800">Check Out</h3>
         <button onclick="document.getElementById('checkOutModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
         </button>
      </div>
      <div class="p-6">
         <form id="checkOutForm">
            @csrf
            <input type="hidden" id="co_attendance_id">
            <input type="hidden" id="co_lat" name="latitude">
            <input type="hidden" id="co_lng" name="longitude">
            <div class="space-y-4">
               <div>
                  <label class="block text-[13px] font-bold text-slate-700 mb-2">Shift Notes (Optional)</label>
                  <textarea name="note" rows="3" placeholder="Any issues or notes during this visit?" class="w-full border border-slate-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:border-[#1a3cdc] focus:ring-1 focus:ring-[#1a3cdc]"></textarea>
               </div>
            </div>
            <div class="mt-6 flex gap-3 justify-end">
               <button type="button" onclick="document.getElementById('checkOutModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-slate-600 hover:bg-slate-50 border border-slate-200">Cancel</button>
               <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-red-700">Submit Check Out</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Missed Punch Modal -->
<div id="missedPunchModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div class="bg-white w-full max-w-md rounded-[14px] shadow-2xl overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
         <h3 class="text-[16px] font-extrabold text-slate-800">Fix Missed Punch</h3>
         <button onclick="document.getElementById('missedPunchModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
         </button>
      </div>
      <div class="p-6">
         <form method="POST" id="missedPunchForm">
            @csrf
            <div class="space-y-4">
               <p class="text-[13px] text-slate-600">Submit a correction request for this visit. Admin will review and adjust your timesheet.</p>
               <div>
                  <label class="block text-[13px] font-bold text-slate-700 mb-2">Explanation / Correct Time</label>
                  <textarea name="note" required rows="3" placeholder="e.g. I left at 4:30 PM but forgot to check out." class="w-full border border-slate-200 rounded-lg px-4 py-2 text-[13px] focus:outline-none focus:border-[#1a3cdc] focus:ring-1 focus:ring-[#1a3cdc]"></textarea>
               </div>
            </div>
            <div class="mt-6 flex gap-3 justify-end">
               <button type="button" onclick="document.getElementById('missedPunchModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-slate-600 hover:bg-slate-50 border border-slate-200">Cancel</button>
               <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-slate-800">Submit Request</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
function getCoordinates() {
   return new Promise((resolve, reject) => {
      if (!navigator.geolocation) {
         resolve({lat: null, lng: null});
      } else {
         navigator.geolocation.getCurrentPosition(
            (position) => {
               resolve({
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
               });
            },
            (error) => {
               console.warn("Geolocation denied or error:", error);
               resolve({lat: null, lng: null}); // Proceed even if denied as per requirements
            },
            { timeout: 5000 }
         );
      }
   });
}

async function checkIn(bookingId) {
   // Optional: Show a spinner or disabled state here
   const coords = await getCoordinates();

   const formData = new FormData();
   formData.append('_token', '{{ csrf_token() }}');
   if(coords.lat) formData.append('latitude', coords.lat);
   if(coords.lng) formData.append('longitude', coords.lng);

   fetch(`/employee-dashboard/attendance/${bookingId}/check-in`, {
      method: 'POST',
      body: formData,
      headers: {
         'Accept': 'application/json'
      }
   })
   .then(res => res.json())
   .then(data => {
      if(data.error) alert(data.error);
      else window.location.reload();
   })
   .catch(err => {
      console.error(err);
      alert('An error occurred during check in.');
   });
}

async function openCheckOutModal(attendanceId) {
   document.getElementById('co_attendance_id').value = attendanceId;
   const coords = await getCoordinates();
   if(coords.lat) {
      document.getElementById('co_lat').value = coords.lat;
      document.getElementById('co_lng').value = coords.lng;
   }
   document.getElementById('checkOutModal').classList.remove('hidden');
}

document.getElementById('checkOutForm').addEventListener('submit', function(e) {
   e.preventDefault();
   const attendanceId = document.getElementById('co_attendance_id').value;
   const formData = new FormData(this);

   fetch(`/employee-dashboard/attendance/${attendanceId}/check-out`, {
      method: 'POST',
      body: formData,
      headers: {
         'Accept': 'application/json'
      }
   })
   .then(res => res.json())
   .then(data => {
      if(data.error) alert(data.error);
      else window.location.reload();
   })
   .catch(err => {
      console.error(err);
      alert('An error occurred during check out.');
   });
});

function openMissedPunchModal(attendanceId) {
   const form = document.getElementById('missedPunchForm');
   form.action = `/employee-dashboard/attendance/${attendanceId}/missed-punch`;
   document.getElementById('missedPunchModal').classList.remove('hidden');
}
</script>
@endif
@endsection

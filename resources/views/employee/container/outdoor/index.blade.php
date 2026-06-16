@extends('layouts.employee')
@section('title', 'Outdoor')
@section('employee-content')

<div class="w-full flex items-center justify-between gap-5">
   <div>
      <div class="text-2xl font-extrabold text-theme-text-main">Outdoor Activities</div>
      <div class="text-[13px] text-theme-text-muted mt-1">Monitor active outdoor sessions, tracking locations and
         duration.
      </div>
   </div>
   <button onclick="document.getElementById('newSessionModal').classList.remove('hidden')"
      class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all flex items-center gap-2">
      + New Session
   </button>
</div>

<div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
   <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
      <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Active Now</div>
      <div class="text-2xl font-extrabold text-theme-text-main">{{ $activeNow }}</div>
      @if($activeNow > 0)
      <div class="mt-2 flex items-center"><span
            class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">In Progress</span>
      </div>
      @endif
   </div>
   <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
      <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Today</div>
      <div class="text-2xl font-extrabold text-theme-text-main">{{ $totalToday }}</div>
   </div>
   <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
      <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Avg Duration</div>
      <div class="text-2xl font-extrabold text-theme-text-main">{{ $avgDuration }}m</div>
   </div>
   <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
      <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Reports Filed</div>
      <div class="text-2xl font-extrabold text-theme-text-main">{{ $reportsFiled }}</div>
   </div>
</div>

<div class="grid grid-cols-1 gap-5">
   <div class="{{ $activeSession ? 'lg:col-span-2' : 'lg:col-span-3' }}">
      <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
         <div class="px-6 py-5 border-b border-theme-border">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">Session Log</h3>
         </div>
         <div class="overflow-x-auto">
            <table class="w-full text-left">
               <thead class="bg-theme-bg border-b border-theme-border">
                  <tr>
                     <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                        Client</th>
                     <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Agent
                     </th>
                     <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                        Activity</th>
                     <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                        Duration</th>
                     <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">
                        Status</th>
                  </tr>
               </thead>
               <tbody class="divide-y divide-theme-border">
                  @forelse($history as $session)
                  <tr class="hover:bg-theme-bg transition-colors">
                     <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main">
                        {{ $session->client->user->name ?? 'Unknown' }}</td>
                     <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ Auth::user()->name }}</td>
                     <td class="px-6 py-4 text-[13px] text-theme-text-main">
                        {{ $session->activity_name }} <br>
                        <span class="text-[11px] text-theme-text-muted">{{ $session->activity_type }}</span>
                     </td>
                     <td class="px-6 py-4 text-[13px] text-theme-text-main">
                        @if($session->status === 'Completed' && $session->end_time)
                        {{ $session->start_time->diffInMinutes($session->end_time) }} mins
                        @else
                        -
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        @if($session->status === 'Active')
                        <span
                           class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Active</span>
                        @else
                        <span
                           class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10.5px] font-bold">Completed</span>
                        @if($session->report_summary)
                        <div class="mt-1">
                           <button data-title="{{ $session->activity_name }}"
                              data-summary="{{ $session->report_summary }}"
                              data-participation="{{ $session->report_participation_level }}"
                              data-outcome="{{ $session->report_outcome_notes }}"
                              data-recommendations="{{ $session->report_follow_up_recommendations }}"
                              onclick="viewReport(this)"
                              class="text-[#1a3cdc] text-[11px] font-bold hover:underline cursor-pointer">View
                              Report</button>
                        </div>
                        @endif
                        @endif
                     </td>
                  </tr>
                  @empty
                  <tr>
                     <td colspan="5" class="px-6 py-4 text-center text-[13px] text-theme-text-muted">No sessions found.
                     </td>
                  </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>

   @if($activeSession)
   <div>
      <div class="bg-slate-900 rounded-[14px] p-6 text-white shadow-xl relative overflow-hidden">
         <h3 class="text-[14.5px] font-bold mb-4">Live Activity Timer</h3>
         <div id="liveTimer" class="text-4xl font-mono font-extrabold text-[#1a3cdc] mb-2">00:00:00</div>
         <p class="text-[12px] text-white/60 mb-6 uppercase tracking-widest font-bold">
            Session: {{ $activeSession->activity_name }} ({{ $activeSession->client->user->name ?? 'Unknown' }})
         </p>
         <div class="flex gap-2">
            <button onclick="openStopSessionModal({{ $activeSession->id }})"
               class="flex-1 py-2.5 bg-[#1a3cdc] rounded-lg text-[12px] font-bold hover:bg-[#1230b0]">Stop Session &
               File Report</button>
         </div>
         <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
      </div>
   </div>
   @endif
</div>

<!-- Report Modal -->
<div id="reportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div
      class="bg-theme-card w-full max-w-lg rounded-[14px] shadow-2xl border border-theme-border overflow-hidden max-h-[90vh] overflow-y-auto">
      <div class="px-6 py-4 border-b border-theme-border flex items-center justify-between">
         <h3 id="reportTitle" class="text-[16px] font-extrabold text-theme-text-main">Activity Report</h3>
         <button onclick="document.getElementById('reportModal').classList.add('hidden')"
            class="text-theme-text-muted hover:text-theme-text-main transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
         </button>
      </div>
      <div class="p-6">
         <div class="space-y-4">
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Summary</label>
               <p id="viewReportSummary"
                  class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap">
               </p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Participation Level</label>
               <p id="viewReportParticipation"
                  class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap">
               </p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Outcome / Progress Notes</label>
               <p id="viewReportOutcome"
                  class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap">
               </p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Follow-up Recommendations</label>
               <p id="viewReportRecommendations"
                  class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap">
               </p>
            </div>
         </div>
         <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')"
               class="px-4 py-2 bg-theme-bg text-theme-text-main border border-theme-border rounded-[8px] text-[13px] font-bold hover:bg-theme-border transition-colors">Close</button>
         </div>
      </div>
   </div>
</div>

<!-- Stop Session & File Report Modal -->
<div id="stopSessionModal"
   class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div
      class="bg-theme-card w-full max-w-lg rounded-[14px] shadow-2xl border border-theme-border overflow-hidden max-h-[90vh] overflow-y-auto">
      <div class="px-6 py-4 border-b border-theme-border flex items-center justify-between">
         <h3 class="text-[16px] font-extrabold text-theme-text-main">File Activity Report & Stop Session</h3>
         <button onclick="document.getElementById('stopSessionModal').classList.add('hidden')"
            class="text-theme-text-muted hover:text-theme-text-main transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
         </button>
      </div>
      <div class="p-6">
         <form id="stopSessionForm">
            @csrf
            <input type="hidden" id="stopSessionId" name="session_id" value="">
            <div class="space-y-4">
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Summary</label>
                  <textarea name="report_summary" required rows="3" placeholder="Brief summary of the activity..."
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]"></textarea>
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Participation Level</label>
                  <select name="report_participation_level" required
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]">
                     <option value="High">High</option>
                     <option value="Medium">Medium</option>
                     <option value="Low">Low</option>
                     <option value="Refused">Refused</option>
                  </select>
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Outcome / Progress Notes</label>
                  <textarea name="report_outcome_notes" required rows="3"
                     placeholder="Notes on client progress or outcomes..."
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]"></textarea>
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Follow-up Recommendations</label>
                  <textarea name="report_follow_up_recommendations" rows="3" placeholder="Any follow-ups required?"
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]"></textarea>
               </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
               <button type="button" onclick="document.getElementById('stopSessionModal').classList.add('hidden')"
                  class="px-4 py-2 bg-theme-bg text-theme-text-main border border-theme-border rounded-[8px] text-[13px] font-bold hover:bg-theme-border transition-colors">Cancel</button>
               <button type="submit"
                  class="px-4 py-2 bg-[#1a3cdc] text-white rounded-[8px] text-[13px] font-bold hover:bg-[#1230b0] transition-colors">Submit
                  Report & Stop</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- New Session Modal -->
<div id="newSessionModal"
   class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div class="bg-theme-card w-full max-w-lg rounded-[14px] shadow-2xl border border-theme-border overflow-hidden">
      <div class="px-6 py-4 border-b border-theme-border flex items-center justify-between">
         <h3 class="text-[16px] font-extrabold text-theme-text-main">New Outdoor Session</h3>
         <button onclick="document.getElementById('newSessionModal').classList.add('hidden')"
            class="text-theme-text-muted hover:text-theme-text-main transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
         </button>
      </div>
      <div class="p-6">
         <form id="newSessionForm">
            @csrf
            <div class="space-y-4">
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Client</label>
                  <select name="client_id" required
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]">
                     <option value="" disabled selected>Select a client...</option>
                     @foreach($clients as $client)
                     <option value="{{ $client->id }}">{{ $client->user->name ?? 'Unknown' }}</option>
                     @endforeach
                  </select>
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Activity Name</label>
                  <input type="text" name="activity_name" required placeholder="e.g. Morning Walk"
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]">
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Activity Type</label>
                  <select name="activity_type" required
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]">
                     <option value="Walking">Walking</option>
                     <option value="Exercise">Exercise</option>
                     <option value="Park Visit">Park Visit</option>
                     <option value="Shopping Assistance">Shopping Assistance</option>
                     <option value="Community Activity">Community Activity</option>
                     <option value="Other">Other</option>
                  </select>
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Location</label>
                  <input type="text" name="location" placeholder="e.g. Central Park"
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]">
               </div>
               <div>
                  <label class="block text-[12px] font-bold text-theme-text-main mb-1">Notes/Goals</label>
                  <textarea name="notes" rows="3" placeholder="Any specific goals for this session?"
                     class="w-full bg-theme-bg border border-theme-border rounded-[8px] px-3 py-2 text-[13px] text-theme-text-main focus:outline-none focus:border-[#1a3cdc]"></textarea>
               </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
               <button type="button" onclick="document.getElementById('newSessionModal').classList.add('hidden')"
                  class="px-4 py-2 bg-theme-bg text-theme-text-main border border-theme-border rounded-[8px] text-[13px] font-bold hover:bg-theme-border transition-colors">Cancel</button>
               <button type="submit"
                  class="px-4 py-2 bg-[#1a3cdc] text-white rounded-[8px] text-[13px] font-bold hover:bg-[#1230b0] transition-colors">Start
                  Session</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
@if($activeSession)
// Live Timer Logic
const startTime = new Date("{{ $activeSession->start_time->toISOString() }}").getTime();

function updateTimer() {
   const now = new Date().getTime();
   const difference = now - startTime;

   const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
   const seconds = Math.floor((difference % (1000 * 60)) / 1000);

   const formattedHours = String(hours).padStart(2, '0');
   const formattedMinutes = String(minutes).padStart(2, '0');
   const formattedSeconds = String(seconds).padStart(2, '0');

   const timerElement = document.getElementById('liveTimer');
   if (timerElement) {
      timerElement.innerText = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
   }
}

setInterval(updateTimer, 1000);
updateTimer(); // Initial call
@endif

// Handle New Session Submission
document.getElementById('newSessionForm').addEventListener('submit', function(e) {
   e.preventDefault();
   const formData = new FormData(this);

   fetch("{{ route('employee.outdoor.start') }}", {
         method: "POST",
         body: formData,
         headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json"
         }
      })
      .then(response => response.json())
      .then(data => {
         if (data.error) {
            alert(data.error);
         } else {
            window.location.reload();
         }
      })
      .catch(err => {
         console.error(err);
         alert('An error occurred while starting the session.');
      });
});

// Handle View Report
function viewReport(buttonElement) {
   document.getElementById('reportTitle').innerText = buttonElement.getAttribute('data-title') + ' Report';
   document.getElementById('viewReportSummary').innerText = buttonElement.getAttribute('data-summary') || 'N/A';
   document.getElementById('viewReportParticipation').innerText = buttonElement.getAttribute('data-participation') ||
      'N/A';
   document.getElementById('viewReportOutcome').innerText = buttonElement.getAttribute('data-outcome') || 'N/A';
   document.getElementById('viewReportRecommendations').innerText = buttonElement.getAttribute(
      'data-recommendations') || 'N/A';
   document.getElementById('reportModal').classList.remove('hidden');
}

// Handle Stop Session & Report
function openStopSessionModal(id) {
   document.getElementById('stopSessionId').value = id;
   document.getElementById('stopSessionModal').classList.remove('hidden');
}

document.getElementById('stopSessionForm').addEventListener('submit', function(e) {
   e.preventDefault();
   const formData = new FormData(this);
   const sessionId = document.getElementById('stopSessionId').value;

   fetch(`/employee-dashboard/outdoor/${sessionId}/stop`, {
         method: "POST",
         body: formData,
         headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json"
         }
      })
      .then(response => response.json())
      .then(data => {
         if (data.error) {
            alert(data.error);
         } else {
            window.location.reload();
         }
      })
      .catch(err => {
         console.error(err);
         alert('An error occurred while filing the report and stopping the session.');
      });
});
</script>

@endsection
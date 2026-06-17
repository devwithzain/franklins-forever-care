@extends('layouts.client')
@section('title', 'Service History & Visit Logs')
@section('client-content')
<div class="mb-8">
   <h1 class="text-2xl font-extrabold text-theme-text-main">Service History</h1>
   <p class="text-theme-text-muted text-[13.5px] mt-1">Review completed visits, PCA check-ins, and activity reports.</p>
</div>

<div class="bg-theme-card border border-theme-border rounded-[14px] shadow-sm overflow-hidden">
   <div class="overflow-x-auto">
      <table class="w-full text-left">
         <thead class="bg-theme-bg border-b border-theme-border">
            <tr>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Date</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">PCA Agent</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Service</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Check-In / Out</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Duration</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Activity Report</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-theme-border">
            @forelse($visits as $visit)
               @php
                  // Try to find a matching outdoor activity report for this visit date/agent
                  $dateKey = $visit->check_in->format('Y-m-d') . '_' . $visit->employee_id;
                  $reportArray = isset($reports) ? $reports->get($dateKey) : null;
                  $report = $reportArray ? $reportArray->first() : null;
               @endphp
               <tr class="hover:bg-theme-bg transition-colors">
                  <td class="px-6 py-4 text-[13px] font-bold text-theme-text-main">
                     {{ $visit->check_in->format('M d, Y') }}
                  </td>
                  <td class="px-6 py-4">
                     <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-bold text-[11px]">
                           {{ substr($visit->employee->user->name ?? 'U', 0, 2) }}
                        </div>
                        <div class="text-[13px] font-bold text-theme-text-main">{{ $visit->employee->user->name ?? 'Unknown' }}</div>
                     </div>
                  </td>
                  <td class="px-6 py-4 text-[13px] text-theme-text-main">
                     {{ $visit->serviceBooking->service->name ?? 'Service Booking' }}
                  </td>
                  <td class="px-6 py-4">
                     <div class="text-[12px] text-theme-text-main"><span class="font-bold">In:</span> {{ $visit->check_in->format('h:i A') }}</div>
                     <div class="text-[12px] text-theme-text-muted"><span class="font-bold">Out:</span> {{ $visit->check_out->format('h:i A') }}</div>
                  </td>
                  <td class="px-6 py-4 text-[13px] text-theme-text-main">
                     {{ round($visit->check_in->diffInMinutes($visit->check_out) / 60, 1) }} hrs
                  </td>
                  <td class="px-6 py-4">
                     @if($report)
                        <button
                           data-summary="{{ $report->report_summary }}"
                           data-participation="{{ $report->report_participation_level }}"
                           data-outcome="{{ $report->report_outcome_notes }}"
                           data-recommendations="{{ $report->report_follow_up_recommendations }}"
                           onclick="viewReport(this)"
                           class="text-[#1a3cdc] text-[12px] font-bold hover:underline cursor-pointer flex items-center gap-1">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                           View Report
                        </button>
                     @else
                        <span class="text-[12px] text-theme-text-muted italic">No formal report</span>
                     @endif
                  </td>
               </tr>
            @empty
               <tr>
                  <td colspan="6" class="px-6 py-10 text-center text-[13.5px] text-theme-text-muted">No completed visits found.</td>
               </tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>

<!-- Report Modal -->
<div id="reportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
   <div class="bg-theme-card w-full max-w-lg rounded-[14px] shadow-2xl border border-theme-border overflow-hidden max-h-[90vh] overflow-y-auto">
      <div class="px-6 py-4 border-b border-theme-border flex items-center justify-between">
         <h3 class="text-[16px] font-extrabold text-theme-text-main">Visit Activity Report</h3>
         <button onclick="document.getElementById('reportModal').classList.add('hidden')" class="text-theme-text-muted hover:text-theme-text-main transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
         </button>
      </div>
      <div class="p-6">
         <div class="space-y-4">
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Summary</label>
               <p id="viewReportSummary" class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap"></p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Participation Level</label>
               <p id="viewReportParticipation" class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap"></p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Outcome / Progress Notes</label>
               <p id="viewReportOutcome" class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap"></p>
            </div>
            <div>
               <label class="block text-[12px] font-bold text-theme-text-main mb-1">Follow-up Recommendations</label>
               <p id="viewReportRecommendations" class="text-[13px] text-theme-text-main bg-theme-bg p-3 rounded-[8px] border border-theme-border whitespace-pre-wrap"></p>
            </div>
         </div>
         <div class="mt-6 flex justify-end">
            <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')" class="px-4 py-2 bg-theme-bg text-theme-text-main border border-theme-border rounded-[8px] text-[13px] font-bold hover:bg-theme-border transition-colors">Close</button>
         </div>
      </div>
   </div>
</div>

<script>
function viewReport(buttonElement) {
   document.getElementById('viewReportSummary').innerText = buttonElement.getAttribute('data-summary') || 'N/A';
   document.getElementById('viewReportParticipation').innerText = buttonElement.getAttribute('data-participation') || 'N/A';
   document.getElementById('viewReportOutcome').innerText = buttonElement.getAttribute('data-outcome') || 'N/A';
   document.getElementById('viewReportRecommendations').innerText = buttonElement.getAttribute('data-recommendations') || 'N/A';
   document.getElementById('reportModal').classList.remove('hidden');
}
</script>
@endsection

@extends('layouts.client')
@section('title', 'Upcoming Schedule')
@section('client-content')
<div class="mb-8">
   <h1 class="text-2xl font-extrabold text-theme-text-main">Upcoming Schedule</h1>
   <p class="text-theme-text-muted text-[13.5px] mt-1">View your scheduled visits and assigned PCA agents.</p>
</div>

<div class="bg-theme-card border border-theme-border rounded-[14px] shadow-sm overflow-hidden">
   <div class="overflow-x-auto">
      <table class="w-full text-left">
         <thead class="bg-theme-bg border-b border-theme-border">
            <tr>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Date</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Service</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">PCA Agent</th>
               <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-theme-border">
            @forelse($upcomingBookings as $booking)
               <tr class="hover:bg-theme-bg transition-colors">
                  <td class="px-6 py-4">
                     <div class="text-[13px] font-bold text-theme-text-main">{{ $booking->booking_date->format('l, M d, Y') }}</div>
                     @if($booking->preferred_date && $booking->preferred_date->format('H:i') !== '00:00')
                        <div class="text-[11px] text-theme-text-muted">Prefers around {{ $booking->preferred_date->format('h:i A') }}</div>
                     @endif
                  </td>
                  <td class="px-6 py-4 text-[13px] text-theme-text-main">
                     {{ $booking->service->name ?? 'Home Care Service' }}
                  </td>
                  <td class="px-6 py-4">
                     @if($booking->agent)
                        <div class="flex items-center gap-3">
                           <div class="w-8 h-8 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-bold text-[11px]">
                              {{ substr($booking->agent->name, 0, 2) }}
                           </div>
                           <div class="text-[13px] font-bold text-theme-text-main">{{ $booking->agent->name }}</div>
                        </div>
                     @else
                        <span class="text-[12px] text-amber-600 font-bold bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">Pending Assignment</span>
                     @endif
                  </td>
                  <td class="px-6 py-4">
                     <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-[10.5px] font-bold border border-blue-200 uppercase tracking-wide">
                        {{ $booking->status }}
                     </span>
                  </td>
               </tr>
            @empty
               <tr>
                  <td colspan="4" class="px-6 py-10 text-center">
                     <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                     <div class="text-[14px] font-bold text-theme-text-main">No Upcoming Visits</div>
                     <div class="text-[13px] text-theme-text-muted mt-1">You have no visits scheduled at this time.</div>
                  </td>
               </tr>
            @endforelse
         </tbody>
      </table>
   </div>
</div>
@endsection

@extends('layouts.employee')
@section('title', 'Notifications')
@section('employee-content')
<div class="mb-8">
   <h1 class="text-2xl font-extrabold text-slate-800">Notifications</h1>
   <p class="text-slate-500 text-[13.5px] mt-1">Stay updated with important announcements and alerts</p>
</div>

<div class="bg-white rounded-[14px] border border-slate-200 shadow-sm">
   <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
      <h3 class="text-[15px] font-extrabold text-slate-800">All Notifications</h3>
      @if($notificationCounts['total'] > 0)
      <form method="POST" action="{{ route('employee.notifications.mark-all-read') }}" class="inline">
         @csrf
         <button type="submit" class="text-[12px] font-bold text-[#1a3cdc] hover:underline">
            Mark all as read
         </button>
      </form>
      @endif
   </div>
   <div class="divide-y divide-slate-200">
      @forelse($notifications as $notification)
      <div
         class="p-6 flex gap-4 hover:bg-slate-50 transition-colors {{ !$notification->is_read ? 'bg-slate-50' : '' }}">
         <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                @if($notification->type === 'broadcast') bg-purple-100 text-purple-600
                @elseif($notification->type === 'agent_assigned') bg-green-100 text-green-600
                @elseif($notification->type === 'pending_request') bg-amber-100 text-amber-600
                @else bg-blue-100 text-blue-600
                @endif">
            @if($notification->type === 'broadcast')
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path
                  d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 00-1.564.317z" />
            </svg>
            @elseif($notification->type === 'agent_assigned')
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            @else
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @endif
         </div>
         <div class="flex-1">
            <div class="flex items-start justify-between gap-4 mb-1">
               <h4 class="text-[14px] font-bold text-slate-800">{{ $notification->title }}</h4>
               <span
                  class="text-[11px] text-slate-400 flex-shrink-0">{{ $notification->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-[13px] text-slate-500 leading-relaxed">{{ $notification->message }}</p>
            @if(!$notification->is_read)
            <div class="mt-3 flex gap-2">
               <form method="POST" action="{{ route('employee.notifications.mark-read', $notification->id) }}"
                  class="inline">
                  @csrf
                  <button type="submit"
                     class="px-3 py-1 bg-[#1a3cdc] text-white rounded-[6px] text-[11px] font-bold hover:bg-[#1230b0] transition-all">
                     Mark as read
                  </button>
               </form>
            </div>
            @endif
         </div>
         @if(!$notification->is_read)
         <div class="w-2 h-2 rounded-full bg-[#1a3cdc] flex-shrink-0 mt-2"></div>
         @endif
      </div>
      @empty
      <div class="px-6 py-12 text-center text-slate-400">
         <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
               d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
         </svg>
         <p>No notifications yet</p>
      </div>
      @endforelse
   </div>
   @if($notifications->hasPages())
   <div class="px-6 py-4 border-t border-slate-200">
      {{ $notifications->links() }}
   </div>
   @endif
</div>
@endsection
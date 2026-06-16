@extends('layouts.admin')
@section('title', 'Notifications')

@section('admin-content')
<div class="mb-8">
   <h1 class="text-2xl font-extrabold text-slate-800">Notifications</h1>
   <p class="text-slate-500 text-[13.5px] mt-1">Manage system-wide broadcasts and personalized alerts.</p>
</div>

@if (session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
   {{ session('success') }}
</div>
@endif

<div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-2 gap-5">
   <div class="lg:col-span-2 space-y-4">
      <!-- System Notifications -->
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm">
         <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-slate-800">System Notifications</h3>
            @if(isset($notificationCounts) && $notificationCounts['total'] > 0)
            <form method="POST" action="{{ route('admin.notifications.mark-all-read') }}" class="inline">
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
                     <form method="POST" action="{{ route('admin.notifications.mark-read', $notification->id) }}"
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

      <!-- Recent Broadcasts -->
      <div class="bg-white rounded-[14px] border border-slate-200 shadow-sm">
         <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-[15px] font-extrabold text-slate-800">Recent Broadcasts</h3>
         </div>
         <div class="divide-y divide-slate-200">
            @forelse ($broadcasts as $broadcast)
            <div class="p-6 flex gap-4 hover:bg-slate-50 transition-colors">
               <div
                  class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                     <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                  </svg>
               </div>
               <div class="flex-1">
                  <div class="flex items-center justify-between mb-1">
                     <span class="text-[14px] font-bold text-slate-800">Broadcast to {{ $broadcast->audience }}</span>
                     <span class="text-[11px] text-slate-400">{{ $broadcast->created_at->diffForHumans() }}</span>
                  </div>
                  <p class="text-[13px] text-slate-500 leading-relaxed">{{ $broadcast->message }}</p>
                  <div class="mt-2 text-[11px] text-slate-400 font-bold">Sent by: {{ $broadcast->sender->name }}</div>
               </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-slate-400 italic">No broadcasts sent yet.</div>
            @endforelse
         </div>
         @if($broadcasts->hasPages())
         <div class="px-6 py-4 border-t border-slate-200">
            {{ $broadcasts->links() }}
         </div>
         @endif
      </div>
   </div>

   <!-- Send Broadcast -->
   <div>
      <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
         <h3 class="text-[14.5px] font-bold text-slate-800 mb-6">Send Quick Broadcast</h3>
         <form action="{{ route('admin.notifications.broadcast') }}" method="POST" class="space-y-4">
            @csrf
            <div>
               <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Audience</label>
               <select name="audience"
                  class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-[13px] font-medium outline-none">
                  <option value="all">All Users</option>
                  <option value="client">Clients Only</option>
                  <option value="employee">Agents Only</option>
                  <option value="admin">Admins Only</option>
               </select>
            </div>
            <div>
               <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Message</label>
               <textarea name="message" required
                  class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-[13px] h-32 outline-none focus:border-[#1a3cdc]"
                  placeholder="Type your broadcast message..."></textarea>
            </div>
            <button type="submit"
               class="w-full py-2.5 bg-[#1a3cdc] text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Send
               Notification</button>
         </form>
      </div>
   </div>
</div>
@endsection
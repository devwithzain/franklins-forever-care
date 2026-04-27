<aside class="w-64 bg-white border-r border-slate-200 flex flex-col h-screen flex-shrink-0 z-[100] fixed top-0 left-0">
   <div class="p-6 pb-2">
      <div class="flex items-center gap-3">
         <div
            class="w-9 h-9 bg-[#1a3cdc] rounded-[10px] flex items-center justify-center text-white shadow-lg shadow-blue-200">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round" stroke-linejoin="round">
               <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
               <polyline points="9,22 9,12 15,12 15,22" />
            </svg>
         </div>
         <div class="leading-tight">
            <div class="text-[15px] font-extrabold text-slate-800 tracking-tight">Franklin's</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Forever Care</div>
         </div>
      </div>
   </div>
   <div class="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar">
      @if(Auth::user()->role === 'admin')
         <div class="mb-8">
            <div class="px-3 mb-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em]">Main</div>
            <div class="space-y-1">
               <a href="{{ route('admin.dashboard') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.dashboard') ? 'bg-[#1a3cdc] text-white shadow-md shadow-blue-100' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Dashboard</span>
                  </div>
               </a>
            </div>
         </div>
         <div class="mb-8">
            <div class="px-3 mb-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em]">Operations</div>
            <div class="space-y-1">
               <a href="{{ route('admin.clients') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.clients') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.clients') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Clients</span>
                  </div>
               </a>
               <a href="{{ route('admin.employees') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.employees') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.employees') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                     </svg>
                     <span class="text-[13.5px] font-bold">PCA Tracking</span>
                  </div>
               </a>
               <a href="{{ route('admin.attendance') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.attendance') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.attendance') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Attendance Log</span>
                  </div>
               </a>
               <a href="{{ route('admin.payments') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.payments') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.payments') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Payments & Billing</span>
                  </div>
               </a>
               <a href="{{ route('admin.outdoor') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.outdoor') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.outdoor') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Outdoor Activities</span>
                  </div>
               </a>
            </div>
         </div>
         <div class="mb-8">
            <div class="px-3 mb-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em]">Support</div>
            <div class="space-y-1">
               <a href="{{ route('admin.requests') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.requests') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.requests') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Client Requests</span>
                  </div>
                  <span class="px-1.5 py-0.5 rounded-full bg-red-100 text-red-600 text-[9px] font-extrabold">12</span>
               </a>
               <a href="{{ route('admin.complaints') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.complaints') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.complaints') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path
                           d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Complaints</span>
                  </div>
                  <span class="px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[9px] font-extrabold">5</span>
               </a>
            </div>
         </div>
         <div>
            <div class="px-3 mb-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em]">System</div>
            <div class="space-y-1">
               <a href="{{ route('admin.notifications') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.notifications') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.notifications') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Notifications</span>
                  </div>
               </a>
               <a href="{{ route('admin.reports') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.reports') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.reports') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                        <path d="M22 12A10 10 0 0 0 12 2v10z" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Reports</span>
                  </div>
               </a>
               <a href="{{ route('admin.container.setting.index') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('admin.container.setting.index') ? 'bg-[#1a3cdc] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('admin.container.setting.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3" />
                        <path
                           d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                     </svg>
                     <span class="text-[13.5px] font-bold">Settings</span>
                  </div>
               </a>
            </div>
         </div>
      @elseif(Auth::user()->role === 'employee')
         <div class="mb-8">
            <div class="px-3 mb-3 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em]">Menu</div>
            <div class="space-y-1">
               <a href="{{ route('employee.dashboard') }}"
                  class="flex items-center justify-between px-3 py-2.5 rounded-[10px] {{ Request::routeIs('employee.dashboard') ? 'bg-[#7c3aed] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }} transition-all group">
                  <div class="flex items-center gap-3">
                     <svg
                        class="w-[18px] h-[18px] {{ Request::routeIs('employee.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                     </svg>
                     <span class="text-[13.5px] font-bold">My Dashboard</span>
                  </div>
               </a>
            </div>
         </div>
      @endif
   </div>
   <div class="p-4 border-t border-slate-100">
      <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button type="submit"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-red-500 hover:bg-red-50 transition-all font-bold text-[13.5px]">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
               <polyline points="16 17 21 12 16 7" />
               <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Logout
         </button>
      </form>
   </div>
</aside>
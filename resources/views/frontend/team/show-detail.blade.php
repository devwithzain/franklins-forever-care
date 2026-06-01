<section class="w-full bg-white padding-x padding-y">
   <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

         {{-- LEFT: Profile Card --}}
         <div class="lg:col-span-1 flex flex-col gap-6">
            {{-- Photo card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-[#f0f0f0]">
               @if($employee->user->image)
                  <img src="{{ asset('storage/' . $employee->user->image) }}"
                     alt="{{ $employee->user->name }}"
                     class="w-full h-80 object-cover">
               @else
                  <div class="w-full h-80 bg-gradient-to-br from-[#7E80B0]/10 to-[#F0BB4C]/10 flex items-center justify-center">
                     <div class="w-36 h-36 rounded-full bg-[#7E80B0]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#7E80B0]" viewBox="0 0 24 24" fill="currentColor">
                           <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                     </div>
                  </div>
               @endif
               <div class="p-6 flex flex-col gap-3">
                  <h2 class="text-2xl font-bold text-black dmserif leading-snug">
                     {{ $employee->user->name }}
                  </h2>
                  <p class="text-[#7E80B0] font-medium capitalize text-sm">
                     {{ $employee->type }} Care Specialist
                  </p>
                  {{-- Rating --}}
                  <div class="flex items-center gap-1.5">
                     @for($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                           fill="{{ $i <= round($employee->rating) ? '#F0BB4C' : '#e5e7eb' }}"
                           stroke="{{ $i <= round($employee->rating) ? '#F0BB4C' : '#d1d5db' }}"
                           stroke-width="1.5">
                           <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                     @endfor
                     <span class="text-sm font-semibold text-[#F0BB4C] ml-1">{{ number_format($employee->rating, 1) }}</span>
                     <span class="text-xs text-[#999]">/ 5.0</span>
                  </div>
               </div>
            </div>

            {{-- Quick Info Card --}}
            <div class="bg-[#F8F9FF] rounded-2xl p-6 flex flex-col gap-4 border border-[#e8eaf0]">
               <h3 class="text-lg font-semibold text-black dmserif">Quick Info</h3>
               <div class="flex flex-col gap-3">
                  {{-- Agent ID --}}
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-[#7E80B0]/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7E80B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Agent ID</p>
                        <p class="text-sm text-black font-semibold">{{ $employee->agent_custom_id }}</p>
                     </div>
                  </div>
                  {{-- Type --}}
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-[#F0BB4C]/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F0BB4C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Employment Type</p>
                        <p class="text-sm text-black font-semibold">{{ $employee->type }}</p>
                     </div>
                  </div>
                  {{-- Region --}}
                  @if($employee->region)
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-[#7E80B0]/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7E80B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Service Region</p>
                        <p class="text-sm text-black font-semibold">{{ $employee->region }}</p>
                     </div>
                  </div>
                  @endif
                  {{-- Phone --}}
                  @if($employee->phone)
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-[#F0BB4C]/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F0BB4C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.45 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.88a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Phone</p>
                        <p class="text-sm text-black font-semibold">{{ $employee->phone }}</p>
                     </div>
                  </div>
                  @endif
                  {{-- Email --}}
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-[#7E80B0]/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7E80B0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Email</p>
                        <p class="text-sm text-black font-semibold break-all">{{ $employee->user->email }}</p>
                     </div>
                  </div>
                  {{-- Status --}}
                  <div class="flex items-center gap-3">
                     <div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                     </div>
                     <div>
                        <p class="text-xs text-[#999] font-medium">Status</p>
                        <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-green-100 text-green-700">
                           {{ $employee->status }}
                        </span>
                     </div>
                  </div>
               </div>
            </div>

            {{-- Back button --}}
            <a href="{{ route('team.index') }}"
               class="flex items-center justify-center gap-2 bg-[#7E80B0] text-white font-semibold px-6 py-4 rounded-xl hover:bg-[#F0BB4C] hover:text-black transition-all duration-300 text-sm">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 12H5M12 19l-7-7 7-7"/>
               </svg>
               Back to Team
            </a>
         </div>

         {{-- RIGHT: Detail Content --}}
         <div class="lg:col-span-2 flex flex-col gap-8">

            {{-- About Section --}}
            <div class="bg-white rounded-2xl p-8 border border-[#f0f0f0] shadow-sm">
               <div class="flex items-center gap-3 mb-6">
                  <div class="w-1 h-8 bg-[#F0BB4C] rounded-full"></div>
                  <h3 class="text-2xl font-bold text-black dmserif">About {{ explode(' ', $employee->user->name)[0] }}</h3>
               </div>
               <p class="text-[#666666] leading-relaxed paragraph">
                  {{ $employee->user->name }} is a dedicated {{ $employee->type === 'Full-time' ? 'full-time' : 'part-time' }}
                  care specialist at Franklin's Forever Care
                  @if($employee->region)
                     , serving the <strong>{{ $employee->region }}</strong> region
                  @endif
                  . With a professional rating of <strong>{{ number_format($employee->rating, 1) }}/5.0</strong>,
                  they consistently deliver compassionate, personalised care that makes a meaningful difference
                  in the lives of seniors and their families.
               </p>
               <p class="text-[#666666] leading-relaxed paragraph mt-4">
                  Our team of caregiving professionals uphold the highest standards of senior care — from medication
                  reminders and daily assistance to companionship and medical support. {{ explode(' ', $employee->user->name)[0] }}
                  exemplifies these values every single day.
               </p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
               <div class="bg-gradient-to-br from-[#7E80B0] to-[#6062a0] rounded-2xl p-6 text-white flex flex-col gap-1">
                  <span class="text-4xl font-bold dmserif">{{ number_format($employee->rating, 1) }}</span>
                  <span class="text-sm text-white/80 font-medium">Performance Rating</span>
               </div>
               <div class="bg-gradient-to-br from-[#F0BB4C] to-[#e0a832] rounded-2xl p-6 text-black flex flex-col gap-1">
                  <span class="text-4xl font-bold dmserif">
                     {{ $employee->clients->count() }}
                  </span>
                  <span class="text-sm text-black/70 font-medium">Clients Served</span>
               </div>
               <div class="col-span-2 sm:col-span-1 bg-gradient-to-br from-[#F8F9FF] to-[#eef0ff] rounded-2xl p-6 text-black flex flex-col gap-1 border border-[#e8eaf0]">
                  <span class="text-4xl font-bold dmserif text-[#7E80B0]">{{ $employee->type === 'Full-time' ? '40h' : '20h' }}</span>
                  <span class="text-sm text-[#666666] font-medium">Weekly Hours</span>
               </div>
            </div>

            {{-- Specialties --}}
            <div class="bg-white rounded-2xl p-8 border border-[#f0f0f0] shadow-sm">
               <div class="flex items-center gap-3 mb-6">
                  <div class="w-1 h-8 bg-[#7E80B0] rounded-full"></div>
                  <h3 class="text-2xl font-bold text-black dmserif">Areas of Care</h3>
               </div>
               <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  @foreach(['Personal Care & Hygiene', 'Medication Reminders', 'Companionship & Emotional Support', 'Meal Preparation', 'Mobility Assistance', 'Health Monitoring'] as $specialty)
                     <div class="flex items-center gap-3 p-3 rounded-xl bg-[#F8F9FF] border border-[#e8eaf0]">
                        <span class="w-7 h-7 rounded-full bg-[#F0BB4C] flex items-center justify-center shrink-0">
                           <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M5 12l5 5l10 -10"/>
                           </svg>
                        </span>
                        <span class="text-sm text-black font-medium">{{ $specialty }}</span>
                     </div>
                  @endforeach
               </div>
            </div>

            {{-- CTA --}}
            <div class="bg-gradient-to-r from-[#7E80B0] to-[#6062a0] rounded-2xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
               <div>
                  <h4 class="text-xl font-bold text-white dmserif mb-1">Ready to work with {{ explode(' ', $employee->user->name)[0] }}?</h4>
                  <p class="text-white/70 text-sm">Book a care consultation and get matched with the right plan.</p>
               </div>
               <a href="{{ route('contact') }}"
                  class="shrink-0 bg-[#F0BB4C] text-black font-semibold px-7 py-3.5 rounded-xl hover:bg-white transition-all duration-300 text-sm whitespace-nowrap">
                  Book a Consultation
               </a>
            </div>
         </div>
      </div>
   </div>
</section>

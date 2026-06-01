<section class="w-full bg-white padding-x padding-y">
   {{-- Section Header --}}
   <div class="w-full flex flex-col gap-5 items-center mb-14">
      <div class="bg-[#F0BB4C] rounded-full px-5 py-2.5">
         <p class="smallParagraph text-black capitalize font-semibold leading-tight tracking-wide">
            Our Team
         </p>
      </div>
      <h2 class="heading font-semibold leading-tight text-black dmserif max-w-3xl text-center">
         Meet Our
         <span class="relative inline-block">
            Dedicated
            <svg class="absolute -bottom-4 left-0 w-full" viewBox="0 0 120 20" fill="none">
               <path d="M5 15C30 5 90 5 115 15" stroke="#E7B36A" stroke-width="2" stroke-linecap="round" />
            </svg>
         </span>
         Care Professionals
      </h2>
      <p class="paragraph text-[#666666] text-center max-w-2xl">
         Our team of experienced caregivers and healthcare professionals are committed to delivering compassionate, personalised senior care every single day.
      </p>
   </div>

   @if($employees->count() > 0)
      {{-- Stats Bar --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-14 bg-[#F8F9FF] rounded-2xl p-8">
         <div class="flex flex-col items-center gap-1 text-center">
            <span class="text-4xl font-bold text-[#7E80B0] dmserif">{{ $employees->count() }}+</span>
            <span class="text-sm text-[#666666] font-medium">Team Members</span>
         </div>
         <div class="flex flex-col items-center gap-1 text-center">
            <span class="text-4xl font-bold text-[#F0BB4C] dmserif">{{ $employees->where('type', 'Full-time')->count() }}</span>
            <span class="text-sm text-[#666666] font-medium">Full-time Staff</span>
         </div>
         <div class="flex flex-col items-center gap-1 text-center">
            <span class="text-4xl font-bold text-[#7E80B0] dmserif">{{ $employees->where('type', 'Part-time')->count() }}</span>
            <span class="text-sm text-[#666666] font-medium">Part-time Staff</span>
         </div>
         <div class="flex flex-col items-center gap-1 text-center">
            <span class="text-4xl font-bold text-[#F0BB4C] dmserif">{{ number_format($employees->avg('rating'), 1) }}</span>
            <span class="text-sm text-[#666666] font-medium">Avg. Rating</span>
         </div>
      </div>

      {{-- Team Grid --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
         @foreach ($employees as $employee)
            <a href="{{ route('team.show', $employee->id) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-[#f0f0f0] hover:border-[#7E80B0]/30 hover:-translate-y-1">

               {{-- Photo --}}
               <div class="relative overflow-hidden h-72">
                  @if($employee->user->image)
                     <img src="{{ asset('storage/' . $employee->user->image) }}"
                        alt="{{ $employee->user->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                  @else
                     <div class="w-full h-full bg-gradient-to-br from-[#7E80B0]/10 to-[#F0BB4C]/10 flex items-center justify-center">
                        <div class="w-28 h-28 rounded-full bg-[#7E80B0]/20 flex items-center justify-center">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-[#7E80B0]" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                           </svg>
                        </div>
                     </div>
                  @endif

                  {{-- Type badge --}}
                  <div class="absolute top-3 right-3">
                     <span class="text-xs font-semibold px-3 py-1 rounded-full
                        {{ $employee->type === 'Full-time' ? 'bg-[#7E80B0] text-white' : 'bg-[#F0BB4C] text-black' }}">
                        {{ $employee->type }}
                     </span>
                  </div>

                  {{-- Hover overlay --}}
                  <div class="absolute inset-0 bg-[#7E80B0]/80 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                     <span class="text-white font-semibold text-sm tracking-wide flex items-center gap-2 border border-white/40 rounded-full px-5 py-2.5">
                        View Profile
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M17 7l-10 10"/><path d="M8 7l9 0l0 9"/>
                        </svg>
                     </span>
                  </div>
               </div>

               {{-- Info --}}
               <div class="p-5 flex flex-col gap-2">
                  <h3 class="text-xl font-semibold text-black dmserif leading-snug group-hover:text-[#7E80B0] transition-colors duration-300">
                     {{ $employee->user->name }}
                  </h3>
                  <p class="text-sm text-[#666666] capitalize">{{ $employee->type }} Care Specialist</p>
                  @if($employee->region)
                     <p class="text-xs text-[#999] flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                           <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $employee->region }}
                     </p>
                  @endif

                  {{-- Rating --}}
                  <div class="flex items-center gap-1 mt-1">
                     @for($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                           fill="{{ $i <= round($employee->rating) ? '#F0BB4C' : 'none' }}"
                           stroke="#F0BB4C" stroke-width="2">
                           <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                     @endfor
                     <span class="text-xs text-[#999] ml-1">{{ number_format($employee->rating, 1) }}</span>
                  </div>
               </div>
            </a>
         @endforeach
      </div>
   @else
      {{-- Empty State --}}
      <div class="flex flex-col items-center justify-center py-24 gap-6">
         <div class="w-24 h-24 rounded-full bg-[#F0BB4C]/15 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#F0BB4C]" viewBox="0 0 24 24" fill="currentColor">
               <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
         </div>
         <div class="text-center">
            <h3 class="text-2xl font-semibold text-black dmserif mb-2">No Team Members Yet</h3>
            <p class="text-[#666666]">Our team profiles will be available soon. Check back later!</p>
         </div>
         <a href="{{ route('about') }}"
            class="bg-[#F0BB4C] text-black font-semibold px-8 py-4 rounded-md hover:bg-[#7E80B0] hover:text-white transition-all duration-300">
            Back to About
         </a>
      </div>
   @endif
</section>

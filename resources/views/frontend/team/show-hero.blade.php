<div class="w-full relative">
   <img src="{{ asset('assets/inner-page-banner.jpg') }}" alt="{{ $employee->user->name }}" class="w-full object-cover h-[500px]">
   <div class="absolute inset-0 bg-black/75 z-0"></div>
   <div class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-4 text-center px-6">
      {{-- Profile Avatar --}}
      <div class="w-24 h-24 rounded-full border-4 border-[#F0BB4C] overflow-hidden shadow-2xl">
         @if($employee->user->image)
            <img src="{{ asset('storage/' . $employee->user->image) }}"
               alt="{{ $employee->user->name }}"
               class="w-full h-full object-cover">
         @else
            <div class="w-full h-full bg-[#7E80B0]/40 flex items-center justify-center">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
               </svg>
            </div>
         @endif
      </div>
      <div class="dmserif">
         <span class="heading uppercase text-white font-semibold leading-tight block">
            {{ $employee->user->name }}
         </span>
         <p class="text-[#F0BB4C] text-base font-medium capitalize mt-1">
            {{ $employee->type }} Care Specialist
         </p>
      </div>
      {{-- Rating stars --}}
      <div class="flex items-center gap-1">
         @for($i = 1; $i <= 5; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
               fill="{{ $i <= round($employee->rating) ? '#F0BB4C' : 'none' }}"
               stroke="#F0BB4C" stroke-width="2">
               <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
         @endfor
         <span class="text-white/70 text-sm ml-1">{{ number_format($employee->rating, 1) }} / 5.0</span>
      </div>
   </div>
   {{-- Breadcrumb --}}
   <div class="w-fit bg-white rounded-t-xl px-8 py-4 flex items-center gap-3 absolute bottom-0 left-20">
      <svg class="absolute bottom-0 -right-2.5 rotate-0" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
         <path fillRule="evenodd" clipRule="evenodd" d="M0 0V10H10C4.47715 10 0 5.52285 0 0Z" fill="white" />
      </svg>
      <svg class="absolute bottom-0 -left-2.5 -rotate-90" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
         <path fillRule="evenodd" clipRule="evenodd" d="M0 0V10H10C4.47715 10 0 5.52285 0 0Z" fill="white" />
      </svg>
      <a href="/" class="text-black text-xs font-semibold uppercase hover:opacity-60 transition-opacity">Home</a>
      <svg xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="#01090A">
         <path d="M10.372 4.68477L6.43453 8.62227C6.35244 8.70437 6.2411 8.75049 6.125 8.75049C6.0089 8.75049 5.89756 8.70437 5.81547 8.62227C5.73338 8.54018 5.68726 8.42884 5.68726 8.31274C5.68726 8.19665 5.73338 8.0853 5.81547 8.00321L9.00648 4.81274H0.4375C0.321468 4.81274 0.210188 4.76665 0.128141 4.6846C0.0460937 4.60256 0 4.49127 0 4.37524C0 4.25921 0.0460937 4.14793 0.128141 4.06588C0.210188 3.98384 0.321468 3.93774 0.4375 3.93774H9.00648L5.81547 0.747274C5.73338 0.665182 5.68726 0.55384 5.68726 0.437743C5.68726 0.321646 5.73338 0.210305 5.81547 0.128212C5.89756 0.0461192 6.0089 0 6.125 0C6.2411 0 6.35244 0.0461192 6.43453 0.128212L10.372 4.06571C10.4127 4.10634 10.445 4.15459 10.467 4.20771C10.489 4.26082 10.5003 4.31775 10.5003 4.37524C10.5003 4.43274 10.489 4.48967 10.467 4.54278C10.445 4.59589 10.4127 4.64414 10.372 4.68477Z" fill="#01090A" />
      </svg>
      <a href="{{ route('team.index') }}" class="text-black text-xs font-semibold uppercase hover:opacity-60 transition-opacity">Our Team</a>
      <svg xmlns="http://www.w3.org/2000/svg" width="11" height="9" viewBox="0 0 11 9" fill="#01090A">
         <path d="M10.372 4.68477L6.43453 8.62227C6.35244 8.70437 6.2411 8.75049 6.125 8.75049C6.0089 8.75049 5.89756 8.70437 5.81547 8.62227C5.73338 8.54018 5.68726 8.42884 5.68726 8.31274C5.68726 8.19665 5.73338 8.0853 5.81547 8.00321L9.00648 4.81274H0.4375C0.321468 4.81274 0.210188 4.76665 0.128141 4.6846C0.0460937 4.60256 0 4.49127 0 4.37524C0 4.25921 0.0460937 4.14793 0.128141 4.06588C0.210188 3.98384 0.321468 3.93774 0.4375 3.93774H9.00648L5.81547 0.747274C5.73338 0.665182 5.68726 0.55384 5.68726 0.437743C5.68726 0.321646 5.73338 0.210305 5.81547 0.128212C5.89756 0.0461192 6.0089 0 6.125 0C6.2411 0 6.35244 0.0461192 6.43453 0.128212L10.372 4.06571C10.4127 4.10634 10.445 4.15459 10.467 4.20771C10.489 4.26082 10.5003 4.31775 10.5003 4.37524C10.5003 4.43274 10.489 4.48967 10.467 4.54278C10.445 4.59589 10.4127 4.64414 10.372 4.68477Z" fill="#01090A" />
      </svg>
      <span class="text-[#01090A] text-xs font-semibold uppercase">{{ $employee->user->name }}</span>
   </div>
</div>

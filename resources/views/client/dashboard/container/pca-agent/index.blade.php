@extends('layouts.user')
@section('title', 'My PCA Agent')
@section('client-content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-theme-main">My PCA Agent</h1>
    <p class="text-theme-muted text-[13.5px] mt-1">Details and contact information of your assigned Personal Care Agent.</p>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    @if($clientRecord && $clientRecord->agent)
        @php
            $agent = $clientRecord->agent;
            $employee = $agent->employee;
        @endphp
        <div class="bg-theme-card border border-theme-border rounded-[14px] shadow-sm overflow-hidden">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8 border-b border-theme-border bg-gradient-to-r from-theme-primary/5 via-transparent to-transparent">
                <div class="w-24 h-24 rounded-full bg-theme-primary text-white flex items-center justify-center text-3xl font-extrabold shadow-md border-4 border-theme-card">
                    @if($agent->image)
                        <img src="{{ asset('storage/' . $agent->image) }}" class="w-full h-full rounded-full object-cover" alt="{{ $agent->name }}">
                    @else
                        {{ strtoupper(substr($agent->name, 0, 2)) }}
                    @endif
                </div>
                <div class="text-center md:text-left flex-1">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <h2 class="text-2xl font-black text-theme-main">{{ $agent->name }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-wider">Assigned Agent</span>
                    </div>
                    <p class="text-theme-muted text-[13.5px] mt-1.5 flex items-center justify-center md:justify-start gap-1">
                        <svg class="w-4 h-4 text-theme-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $employee->type ?? 'Personal Care Assistant' }}
                    </p>
                    
                    <div class="mt-4 flex items-center justify-center md:justify-start gap-1">
                        @php
                            $rating = $employee->rating ?? 5.0;
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - ($fullStars + $halfStar);
                        @endphp
                        <div class="flex text-amber-400">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                            @if ($halfStar)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[12px] text-theme-muted font-bold ml-1.5">({{ number_format($rating, 1) }} Rating)</span>
                    </div>
                </div>
            </div>
            
            <div class="p-8 grid sm:grid-cols-1 grid-cols-2 gap-8 bg-theme-hover/20">
                <div>
                    <h3 class="text-[11.5px] font-bold text-theme-muted uppercase tracking-wider mb-4">Agent Profile</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-theme-border/60 pb-2">
                            <span class="text-[13px] text-theme-muted">Agent ID</span>
                            <span class="text-[13px] font-extrabold text-theme-main">{{ $employee->agent_custom_id ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-theme-border/60 pb-2">
                            <span class="text-[13px] text-theme-muted">Assigned Region</span>
                            <span class="text-[13px] font-extrabold text-theme-main">{{ $employee->region ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] text-theme-muted">Current Status</span>
                            <span class="px-2 py-0.5 rounded bg-green-50 text-green-600 text-[10.5px] font-extrabold border border-green-100">
                                {{ $employee->status ?? 'Active' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-[11.5px] font-bold text-theme-muted uppercase tracking-wider mb-4">Direct Contact</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-theme-border/60 pb-2">
                            <span class="text-[13px] text-theme-muted">Email Address</span>
                            <a href="mailto:{{ $agent->email }}" class="text-[13px] font-extrabold text-theme-primary hover:underline">{{ $agent->email }}</a>
                        </div>
                        <div class="flex items-center justify-between border-b border-theme-border/60 pb-2">
                            <span class="text-[13px] text-theme-muted">Phone Number</span>
                            <a href="tel:{{ $employee->phone ?? '' }}" class="text-[13px] font-extrabold text-theme-main hover:text-theme-primary">{{ $employee->phone ?? 'N/A' }}</a>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] text-theme-muted">Support Center</span>
                            <span class="text-[13px] font-bold text-theme-muted">Franklin's Care Support</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-5 bg-theme-bg border-t border-theme-border flex items-center justify-between flex-wrap gap-4">
                <span class="text-[12.5px] text-theme-muted">Need to request a change or report an issue?</span>
                <a href="{{ route('client.requests.index') }}" class="px-4 py-2 bg-theme-card border border-theme-border text-theme-main rounded-[10px] text-[12.5px] font-bold hover:bg-theme-hover transition-colors">
                    Submit Request
                </a>
            </div>
        </div>
        <div class="bg-theme-card border border-theme-border rounded-[14px] p-8 shadow-sm mt-6">
            <h3 class="text-[15px] font-extrabold text-theme-main mb-2">Rate Your Personal Care Agent</h3>
            <p class="text-theme-muted text-[13px] mb-6">Your feedback helps us maintain high quality standards. Please submit your experience rating below.</p>
            
            <form action="{{ route('client.pca-agent.rate', $employee) }}" method="POST" x-data="{ currentRating: {{ floor($employee->rating ?? 5) }}, hoverRating: 0 }">
                @csrf
                <div class="flex items-center gap-3">
                    <!-- Dynamic Star Selectors -->
                    <div class="flex items-center gap-1 text-slate-300">
                        <template x-for="i in 5">
                            <button type="button" 
                                @click="currentRating = i"
                                @mouseover="hoverRating = i"
                                @mouseleave="hoverRating = 0"
                                class="w-10 h-10 transition-transform active:scale-95 focus:outline-none"
                                :class="{'text-amber-400': (hoverRating ? hoverRating >= i : currentRating >= i), 'text-slate-300': (hoverRating ? hoverRating < i : currentRating < i)}">
                                <svg class="w-full h-full fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        </template>
                    </div>
                    <span class="text-sm font-extrabold text-theme-muted ml-2" x-text="currentRating + ' / 5 stars'"></span>
                    
                    <input type="hidden" name="rating" :value="currentRating">
                </div>
                
                <div class="mt-6 flex justify-start">
                    <button type="submit" class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-colors">
                        Submit Experience Rating
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-theme-card border border-theme-border rounded-[14px] p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-theme-bg rounded-full flex items-center justify-center mx-auto mb-6 text-theme-muted">
                <svg class="w-10 h-10 animate-pulse text-theme-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V7a4 4 0 00-8 0v4c0 2.017.391 3.924 1.1 5.657l.06.113m11.114.113c.709-1.733 1.1-3.64 1.1-5.657V7a4 4 0 00-8 0v4c0 2.017.391 3.924 1.1 5.657l.06.113M12 18a3.75 3.75 0 00.495-7.467M12 18.25a.25.25 0 100-.5M12 18.25a.25.25 0 110-.5M12 18.75a.75.75 0 100-1.5M12 18.75a.75.75 0 110-1.5"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-theme-main mb-2">PCA Assignment Pending</h3>
            <p class="text-theme-muted text-[14px] max-w-md mx-auto mb-8">We are currently assigning the best Personal Care Agent tailored to your region and booking requirements. Once assigned, their details and contact info will appear here.</p>
            <a href="{{ route('client.requests.index') }}" class="px-6 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-colors">
                Contact Care Support
            </a>
        </div>
    @endif
</div>
@endsection

@extends('layouts.employee')

@section('employee-content')
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Welcome, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 text-[13.5px] mt-1">Here's your work overview for today.</p>
    </div>

    <div class="bg-[#7c3aed] rounded-[14px] p-8 text-white flex items-center gap-6 mb-8 shadow-lg shadow-purple-200">
        <div
            class="w-20 h-20 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center text-3xl font-extrabold">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
            <p class="text-purple-100 text-[14px] mt-1">Personal Care Attendant (PCA) · Franklin's Forever Care</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Assigned Clients</div>
            <div class="text-3xl font-extrabold text-slate-800">{{ $clients }}</div>
            <div class="mt-4 flex items-center gap-2 text-green-600 text-[12px] font-bold">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Active Duty
            </div>
        </div>

        <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Pending Requests</div>
            <div class="mt-4 text-amber-500 text-[12px] font-bold uppercase tracking-wide">Action Required</div>
        </div>

        <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Total Service Requests</div>
            <div class="mt-4 text-slate-400 text-[12px] font-medium">All time performance</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Attendance --}}
        <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">Weekly Attendance</h3>
            <div class="grid grid-cols-7 gap-3">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <div class="text-center">
                        <div class="text-[10px] font-bold text-slate-400 uppercase mb-2">{{ $day }}</div>
                        <div
                            class="w-full h-12 rounded-lg bg-slate-50 flex items-center justify-center border border-slate-100 {{ in_array($day, ['Mon', 'Tue', 'Wed', 'Thu']) ? 'bg-green-50 border-green-100 text-green-600' : '' }}">
                            @if(in_array($day, ['Mon', 'Tue', 'Wed', 'Thu']))
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            @else
                                <span class="text-[10px] font-bold text-slate-300">OFF</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Activity Feed --}}
        <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-slate-800 mb-6">Recent Client Activity</h3>
            <div class="space-y-6">
                @forelse([
                        [
                            'name' => 'John Doe',
                            'action' => 'submitted a new service request',
                            'time' => '2 hours ago',
                            'status' => 'pending',
                            'created_at' => now(),
                        ],
                        [
                            'name' => 'Jane Doe',
                            'action' => 'submitted a new service request',
                            'time' => '2 hours ago',
                            'status' => 'pending',
                            'created_at' => now(),

                        ]
                    ] as $act)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 font-bold text-sm">
                                {{ strtoupper(substr($act['name'] ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[13.5px] text-slate-700 leading-snug"><b>{{ $act['name'] ?? 'Client' }}</b> submitted a new service request.</p>
                                <p class="text-[11.5px] text-slate-400 mt-1">{{ $act['time'] }}</p>
                            </div>
                        </div>
                @empty
                        <div class="text-center py-4 text-slate-400 text-[13.5px]">No recent activity.</div>
                    @endforelse
                        </div>
                    </div>
                </div>
@endsection
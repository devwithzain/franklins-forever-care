@extends('layouts.user')

@section('client-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-theme-main">Welcome, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-theme-muted text-[13.5px] mt-1">Manage your care plan and requests with Franklin's Forever Care.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('client.requests.index') }}" class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">+ New Request</a>
    </div>
</div>

<div class="bg-theme-card border border-theme-border rounded-[14px] p-8 flex items-center justify-between mb-8 shadow-sm">
    <div class="flex items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-theme-bg border-4 border-theme-border flex items-center justify-center text-3xl font-extrabold text-theme-primary">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <h2 class="text-2xl font-bold text-theme-main">{{ Auth::user()->name }}</h2>
            <p class="text-theme-muted text-[14px] mt-1">Client Portal · {{ Auth::user()->email }}</p>
        </div>
    </div>
    <div class="hidden md:block">
        <div class="text-[12px] font-bold uppercase tracking-widest text-theme-muted mb-1 text-right">Account Status</div>
        <div class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-extrabold uppercase">{{ $clientRecord->status ?? 'Active' }}</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
        <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Assigned Agent</div>
        <div class="text-2xl font-extrabold text-theme-main">{{ $clientRecord->agent->name ?? 'Pending Assignment' }}</div>
        <div class="mt-4 text-theme-muted text-[11.5px] font-medium">Your primary point of contact</div>
    </div>
    
    <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
        <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Care Plan</div>
        <div class="text-2xl font-extrabold text-theme-main">{{ $clientRecord->care_plan ?? 'Standard Care' }}</div>
        <div class="mt-4 text-theme-primary text-[11.5px] font-bold">Currently Active</div>
    </div>

    <div class="bg-theme-card rounded-[14px] p-6 border border-theme-border shadow-sm">
        <div class="text-theme-muted text-[12px] font-bold uppercase tracking-widest mb-1">Recent Requests</div>
        <div class="text-3xl font-extrabold text-theme-main">{{ collect($requests)->count() }}</div>
        <div class="mt-4 text-theme-muted text-[11.5px] font-medium">Submitted this period</div>
    </div>
</div>

<div class="space-y-8">
    {{-- Requests Table --}}
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-theme-main">My Recent Requests</h3>
            <a href="{{ route('client.requests.index') }}" class="text-[12px] font-bold text-theme-primary hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[13.5px]">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Request Type</th>
                        <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Submitted On</th>
                        <th class="px-6 py-3 font-bold text-theme-muted uppercase tracking-widest text-[10px]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border text-theme-main">
                    @forelse($requests as $request)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4 font-semibold">{{ $request->type }}</td>
                            <td class="px-6 py-4 text-theme-muted">{{ $request->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($request->status === 'Pending')
                                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10px] font-bold uppercase">Pending</span>
                                @elseif($request->status === 'Approved')
                                    <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10px] font-bold uppercase">Approved</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase">{{ $request->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-theme-muted">No requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
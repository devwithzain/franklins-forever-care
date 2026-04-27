@extends('layouts.user')

@section('client-content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Welcome, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 text-[13.5px] mt-1">Manage your services and applications with Franklin's Forever Care.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('client.dashboard.container.loan.pre-loan') }}" class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">+ New Loan Application</a>
    </div>
</div>

<div class="bg-gradient-to-r from-green-600 to-green-400 rounded-[14px] p-8 text-white flex items-center justify-between mb-8 shadow-lg shadow-green-100">
    <div class="flex items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center text-3xl font-extrabold">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
            <p class="text-green-50 text-[14px] mt-1">Client Portal · {{ Auth::user()->email }}</p>
        </div>
    </div>
    <div class="hidden md:block">
        <div class="text-[12px] font-bold uppercase tracking-widest text-green-100 mb-1 text-right">Account Status</div>
        <div class="px-3 py-1 bg-white/20 rounded-full text-[11px] font-extrabold uppercase">Premium Member</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
        <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">My Applications</div>
        <div class="text-3xl font-extrabold text-slate-800">{{ $loan_applications->count() }}</div>
        <div class="mt-4 text-slate-400 text-[11.5px] font-medium">Tracking {{ $loan_applications->count() }} submissions</div>
    </div>
    
    <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
        <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Active Inquiries</div>
        <div class="text-3xl font-extrabold text-slate-800">{{ $bookings->count() }}</div>
        <div class="mt-4 text-blue-600 text-[11.5px] font-bold">Responses pending</div>
    </div>

    <div class="bg-white rounded-[14px] p-6 border border-slate-200 shadow-sm">
        <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Approved Credits</div>
        <div class="text-3xl font-extrabold text-green-600">0</div>
        <div class="mt-4 text-slate-400 text-[11.5px] font-medium">Ready for disbursement</div>
    </div>
</div>

<div class="space-y-8">
    {{-- Inquiries Table --}}
    <div class="bg-white rounded-[14px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-slate-800">My Service Inquiries</h3>
            <a href="{{ route('client.dashboard.container.inquries.listings') }}" class="text-[12px] font-bold text-green-600 hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[13.5px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px]">Service</th>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px]">Submitted On</th>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings->take(5) as $booking)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">{{ $booking->service->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $booking->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10px] font-bold uppercase">Pending Review</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Loan Applications --}}
    <div class="bg-white rounded-[14px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-slate-800">Loan Applications</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[13.5px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px]">Company</th>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px]">Broker</th>
                        <th class="px-6 py-3 font-bold text-slate-400 uppercase tracking-widest text-[10px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($loan_applications as $application)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">{{ $application->company_name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $application->broker_name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('client.dashboard.container.my-loan.submission', $application->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
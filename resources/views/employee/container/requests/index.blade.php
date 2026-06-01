@extends('layouts.employee')
@section('title', 'Client Requests')
@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Client Requests</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Review requests from your assigned clients.</div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
        <a href="{{ route('employee.requests.index', ['tab' => 'all']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'all' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            All Requests ({{ $stats['total'] }})
        </a>
        <a href="{{ route('employee.requests.index', ['tab' => 'Change Agent']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'Change Agent' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Change Agent ({{ $stats['change_agent'] }})
        </a>
    </div>

    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-hover border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Type</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Date Submitted</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Priority</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($requests as $requestData)
                        <tr class="hover:bg-theme-hover transition-colors" x-data="{ showModal: false }">
                            <td class="px-6 py-4">
                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $requestData->client->user->name }}</div>
                                <div class="text-[11px] text-theme-text-muted">{{ $requestData->request_custom_id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-600 text-[11px] font-bold">{{ $requestData->type }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $requestData->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[11px] font-bold">{{ $requestData->priority }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusBadgeClasses = [
                                        'Approved' => 'bg-green-100 text-green-700',
                                        'Rejected' => 'bg-red-100 text-red-700',
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                    ];
                                    $badgeClass = $statusBadgeClasses[$requestData->status] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10.5px] font-bold {{ $badgeClass }}">
                                    {{ $requestData->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="showModal = true" class="px-3 py-1.5 bg-theme-primary-light text-theme-primary rounded-lg text-[11px] font-bold transition-all">View Details</button>
                            </td>

                            <!-- Request Details Modal -->
                            <template x-teleport="body">
                                <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
                                    <div x-show="showModal" @click.outside="showModal = false" x-transition.opacity.duration.300ms
                                        class="bg-theme-card rounded-[20px] shadow-2xl w-full max-w-lg overflow-hidden border border-theme-border">
                                        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between bg-theme-hover">
                                            <div>
                                                <h3 class="text-[16px] font-extrabold text-theme-text-main">Request Details</h3>
                                                <p class="text-[12px] text-theme-text-muted">{{ $requestData->request_custom_id }}</p>
                                            </div>
                                            <button @click="showModal = false" class="w-8 h-8 rounded-full bg-theme-border text-theme-text-muted flex items-center justify-center hover:bg-theme-hover transition-colors">
                                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 space-y-5">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Request Type</div>
                                                    <div class="text-[13px] font-bold text-theme-text-main">{{ $requestData->type }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Priority</div>
                                                    <div class="text-[13px] font-bold text-theme-text-main">{{ $requestData->priority }}</div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Description / Reason</div>
                                                <div class="p-4 bg-theme-hover border border-theme-border rounded-[12px] text-[13px] text-theme-text-main leading-relaxed">
                                                    {{ $requestData->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-6 py-4 border-t border-theme-border bg-theme-hover flex flex-wrap items-center justify-between gap-4">
                                            <div>
                                                @if($requestData->status !== 'Pending')
                                                    <span class="text-[12.5px] font-bold text-theme-text-muted">Processed: <span class="text-theme-primary">{{ $requestData->status }}</span></span>
                                                @elseif(!in_array($requestData->type, ['General Support', 'Outdoor Access']))
                                                    <span class="text-[11.5px] text-amber-600 font-bold flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                        Admin clearance required
                                                    </span>
                                                @else
                                                    <span class="text-[11.5px] text-green-600 font-bold">Open for your action</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                @if($requestData->status === 'Pending' && in_array($requestData->type, ['General Support', 'Outdoor Access']))
                                                    <form action="{{ route('employee.requests.update-status', $requestData) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="status" value="Rejected" class="px-4 py-2 bg-red-50 text-red-600 border border-red-100 rounded-[10px] text-[12.5px] font-bold hover:bg-red-100 transition-colors">
                                                            Decline
                                                        </button>
                                                        <button type="submit" name="status" value="Approved" class="px-4 py-2 bg-green-600 text-white rounded-[10px] text-[12.5px] font-bold hover:bg-green-700 transition-colors ml-1.5">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                                <button @click="showModal = false" class="px-4 py-2 bg-theme-border text-theme-text-muted rounded-[10px] text-[12.5px] font-bold hover:bg-theme-hover transition-colors">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">
                                No client requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($requests->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
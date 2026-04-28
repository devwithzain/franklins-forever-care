@extends('layouts.employee')

@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Client Requests</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Review and approve service changes, outdoor requests, and cancellations.</div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
        <a href="{{ route('admin.requests.index', ['tab' => 'all']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'all' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            All Requests ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.requests.index', ['tab' => 'Change Agent']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'Change Agent' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Change Agent ({{ $stats['change_agent'] }})
        </a>
        <a href="{{ route('admin.requests.index', ['tab' => 'Outdoor Access']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'Outdoor Access' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Outdoor Access ({{ $stats['outdoor'] }})
        </a>
        <a href="{{ route('admin.requests.index', ['tab' => 'Cancellations']) }}" 
            class="px-5 py-2.5 rounded-[10px] text-[13px] font-bold whitespace-nowrap transition-all {{ $activeTab === 'Cancellations' ? 'bg-theme-primary text-white shadow-md' : 'bg-theme-card border border-theme-border text-theme-text-muted hover:bg-theme-hover' }}">
            Cancellations ({{ $stats['cancellations'] }})
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
                                @php
                                    $typeClasses = [
                                        'Change Agent' => 'bg-amber-50 text-amber-600',
                                        'Outdoor Access' => 'bg-green-50 text-green-600',
                                        'Cancellations' => 'bg-red-50 text-red-600',
                                    ];
                                    $typeClass = $typeClasses[$requestData->type] ?? 'bg-blue-50 text-blue-600';
                                @endphp
                                <span class="px-2 py-0.5 rounded {{ $typeClass }} text-[11px] font-bold">{{ $requestData->type }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main">{{ $requestData->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $priorityClasses = [
                                        'High' => 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                        'Medium' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                                        'Low' => 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                    ];
                                    $priorityClass = $priorityClasses[$requestData->priority] ?? 'bg-theme-bg text-theme-text-muted';
                                @endphp
                                <span class="px-2 py-0.5 rounded {{ $priorityClass }} text-[11px] font-bold">{{ $requestData->priority }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'Pending' => 'bg-theme-hover text-theme-text-muted',
                                        'Approved' => 'bg-green-100 text-green-600',
                                        'Rejected' => 'bg-red-100 text-red-600',
                                    ];
                                    $statusClass = $statusClasses[$requestData->status] ?? 'bg-theme-hover text-theme-text-muted';
                                @endphp
                                <span class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[10.5px] font-bold">{{ $requestData->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="showModal = true" class="px-3 py-1.5 bg-theme-primary-light text-theme-primary rounded-lg text-[11px] font-bold transition-all">View</button>
                                    
                                    @if ($requestData->status === 'Pending')
                                        <form action="{{ route('admin.requests.updateStatus', $requestData->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Approved">
                                            <button type="submit" class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-[11px] font-bold hover:bg-green-600 shadow-sm transition-all">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.requests.updateStatus', $requestData->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" class="px-3 py-1.5 bg-theme-card border border-theme-border text-theme-text-main rounded-lg text-[11px] font-bold hover:bg-theme-hover shadow-sm transition-all">Reject</button>
                                        </form>
                                    @endif
                                </div>
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
                                            <div class="flex items-center gap-4 p-4 bg-theme-hover rounded-[12px] border border-theme-border">
                                                <div class="w-12 h-12 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-extrabold text-[14px]">
                                                    {{ strtoupper(substr($requestData->client->user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="text-[14px] font-bold text-theme-text-main">{{ $requestData->client->user->name }}</div>
                                                    <div class="text-[12px] text-theme-text-muted">{{ $requestData->client->user->email }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Request Type</div>
                                                    <span class="px-2 py-0.5 rounded {{ $typeClass }} text-[12px] font-bold">{{ $requestData->type }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Priority</div>
                                                    <span class="px-2 py-0.5 rounded {{ $priorityClass }} text-[12px] font-bold">{{ $requestData->priority }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Date Submitted</div>
                                                    <div class="text-[13px] font-bold text-theme-text-main">{{ $requestData->created_at->format('M d, Y h:i A') }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-1">Current Status</div>
                                                    <span class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[12px] font-bold">{{ $requestData->status }}</span>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Description / Reason</div>
                                                <div class="p-4 bg-theme-hover border border-theme-border rounded-[12px] text-[13px] text-theme-text-main leading-relaxed">
                                                    {{ $requestData->description ?? 'No description provided by the client.' }}
                                                </div>
                                            </div>
                                        </div>
                                        @if ($requestData->status === 'Pending')
                                            <div class="px-6 py-4 border-t border-theme-border bg-theme-hover flex items-center justify-end gap-3">
                                                <form action="{{ route('admin.requests.updateStatus', $requestData->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all shadow-sm">Reject Request</button>
                                                </form>
                                                <form action="{{ route('admin.requests.updateStatus', $requestData->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Approved">
                                                    <button type="submit" class="px-5 py-2.5 bg-green-500 text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-green-600 transition-all">Approve Request</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </template>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">
                                No requests found.
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
@extends('layouts.user')
@section('title', 'Complaints')
@section('client-content')
<div x-data="{ showComplaintModal: false }">
    <div class="w-full flex items-center justify-between gap-5 mb-8">
        <div>
            <div class="text-2xl font-extrabold text-theme-main">My Complaints</div>
            <div class="text-[13px] text-theme-muted mt-1">Register new complaints and track their resolution status.</div>
        </div>
        <button @click="showComplaintModal = true" 
            class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Register Complaint
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold shadow-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-muted uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-muted uppercase tracking-widest">Priority</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-muted uppercase tracking-widest text-left">Description</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-muted uppercase tracking-widest">Submitted On</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-muted uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border text-theme-main">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4 font-bold text-[13.5px]">{{ $complaint->subject }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $complaint->priority === 'High' ? 'bg-red-50 text-red-600 border border-red-100' : ($complaint->priority === 'Medium' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-green-50 text-green-600 border border-green-100') }}">
                                    {{ $complaint->priority }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[13px] max-w-[280px] truncate" title="{{ $complaint->description }}">{{ $complaint->description }}</td>
                            <td class="px-6 py-4 text-[13px] text-theme-muted">{{ $complaint->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $complaint->status === 'Resolved' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-theme-muted">No complaints filed yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($complaints->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>

    <!-- Modal backdrop -->
    <div x-show="showComplaintModal" 
        class="fixed inset-0 bg-black/50 z-[999] flex items-center justify-center p-4 transition-opacity"
        x-cloak style="display: none;">
        
        <!-- Modal content -->
        <div @click.away="showComplaintModal = false" 
            class="bg-theme-card border border-theme-border w-full max-w-lg rounded-[18px] shadow-2xl overflow-hidden transform transition-all duration-300">
            
            <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                <h3 class="text-[17px] font-extrabold text-theme-main">Register New Complaint</h3>
                <button @click="showComplaintModal = false" class="text-theme-muted hover:text-theme-main transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('client.complaints.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label for="subject" class="block text-[12.5px] font-bold text-theme-muted uppercase tracking-wider mb-2">Subject / Title</label>
                    <input type="text" name="subject" id="subject" required max="255" placeholder="e.g. Caregiver was late, medication issue..."
                        class="w-full bg-theme-bg border border-theme-border text-theme-main px-4 py-3 rounded-[10px] text-[13.5px] font-bold focus:outline-none focus:border-theme-primary transition-all placeholder-slate-400">
                </div>
                
                <div>
                    <label for="priority" class="block text-[12.5px] font-bold text-theme-muted uppercase tracking-wider mb-2">Priority Level</label>
                    <select name="priority" id="priority" required
                        class="w-full bg-theme-bg border border-theme-border text-theme-main px-4 py-3 rounded-[10px] text-[13.5px] font-bold focus:outline-none focus:border-theme-primary transition-all">
                        <option value="Low">Low (No Immediate Risk)</option>
                        <option value="Medium" selected>Medium (Standard Complaint)</option>
                        <option value="High">High (Immediate Care Intervention Required)</option>
                    </select>
                </div>
                
                <div>
                    <label for="description" class="block text-[12.5px] font-bold text-theme-muted uppercase tracking-wider mb-2">Detailed Description</label>
                    <textarea name="description" id="description" rows="5" required minlength="10"
                        placeholder="Please describe the incident or issue in detail including dates and times..."
                        class="w-full bg-theme-bg border border-theme-border text-theme-main px-4 py-3 rounded-[10px] text-[13.5px] focus:outline-none focus:border-theme-primary transition-all placeholder-slate-400"></textarea>
                </div>
                
                <div class="flex items-center gap-3 pt-3">
                    <button type="button" @click="showComplaintModal = false"
                        class="flex-1 py-3 bg-theme-bg border border-theme-border text-theme-main rounded-[10px] text-[13.5px] font-bold hover:bg-theme-hover transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-theme-primary text-white rounded-[10px] text-[13.5px] font-bold shadow-md hover:bg-theme-primary-hover transition-colors">
                        Submit Complaint
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Inquiry Details')
@section('admin-content')
    <div class="mb-5">
        <a href="{{ route('admin.contact-submissions.index') }}" class="text-[12.5px] font-bold text-theme-primary hover:underline flex items-center gap-1.5 mb-3">
            ← Back to Inquiries
        </a>
        <div class="w-full flex items-center justify-between gap-5">
            <div>
                <div class="text-2xl font-extrabold text-theme-text-main">Inquiry Details</div>
                <div class="text-[13px] text-theme-text-muted mt-1">Review inquirer information, assign tasks, and record admin updates.</div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid sm:grid-cols-1 grid-cols-2 gap-6">
        <!-- Inquiry Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <div class="border-b border-theme-border pb-4 mb-4">
                    <span class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest">Subject</span>
                    <h2 class="text-lg font-extrabold text-theme-text-main mt-1">{{ $submission->subject }}</h2>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest">Message</span>
                    <div class="p-4 bg-theme-hover border border-theme-border rounded-[12px] text-[13.5px] text-theme-text-main leading-relaxed mt-2 whitespace-pre-wrap font-medium">
                        {{ $submission->message }}
                    </div>
                </div>
            </div>

            <!-- Response / Administrative Action Card -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-sm font-bold text-theme-text-main mb-4">Administrative Action</h3>
                
                @if($submission->status !== 'resolved')
                    <form action="{{ route('admin.contact-submissions.update-status', $submission->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[11.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-2">Update Status</label>
                            <select name="status" class="w-full px-4 py-2 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm font-medium">
                                <option value="new" {{ $submission->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="in_progress" {{ $submission->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $submission->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="spam" {{ $submission->status === 'spam' ? 'selected' : '' }}>Spam</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-[11.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-2">Admin Notes (Resolution Details)</label>
                            <textarea name="admin_notes" rows="4" placeholder="Record any response or action taken for this inquiry..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm resize-none font-medium">{{ $submission->admin_notes }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-theme-primary text-white text-[13px] font-bold hover:bg-theme-primary-hover shadow-md transition-colors">
                                Update Inquiry
                            </button>
                        </div>
                    </form>
                @else
                    <div class="space-y-4">
                        <div class="p-4 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900 rounded-[12px]">
                            <div class="text-[13px] font-bold text-green-700 dark:text-green-400">This inquiry is resolved.</div>
                            @if($submission->admin_notes)
                                <div class="text-[12.5px] text-green-600 dark:text-green-500 mt-2 font-medium">
                                    <strong>Resolution Notes:</strong><br>
                                    {{ $submission->admin_notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Inquirer / Meta Info Sidebar Column -->
        <div class="space-y-6">
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-sm font-bold text-theme-text-main mb-4">Inquirer Details</h3>
                <div class="space-y-4">
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Name</span>
                        <div class="text-[13.5px] font-bold text-theme-text-main">{{ $submission->name }}</div>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Email</span>
                        <a href="mailto:{{ $submission->email }}" class="text-[13px] font-bold text-theme-primary hover:underline break-all">{{ $submission->email }}</a>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Phone</span>
                        <div class="text-[13px] font-bold text-theme-text-main">{{ $submission->phone ?? 'Not provided' }}</div>
                    </div>
                    <div>
                        <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Date Submitted</span>
                        <div class="text-[13px] font-bold text-theme-text-main">
                            {{ $submission->created_at->format('M d, Y h:i A') }}
                            <div class="text-[11.5px] text-theme-text-muted mt-0.5 font-medium">{{ $submission->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Administration Meta -->
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-theme-text-main mb-2">Inquiry Info</h3>
                <div>
                    <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Assigned Admin</span>
                    @if($submission->assignedAdmin)
                        <div class="text-[13px] font-bold text-theme-text-main">{{ $submission->assignedAdmin->name }}</div>
                    @else
                        <div class="text-[13px] text-theme-text-muted italic mb-2">Unassigned</div>
                        @if($submission->status !== 'resolved')
                            <form action="{{ route('admin.contact-submissions.assign', $submission->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-theme-primary text-white rounded-xl text-xs font-bold hover:bg-theme-primary-hover shadow-sm transition-all text-center">
                                    Assign to Myself
                                </button>
                            </form>
                        @endif
                    @endif
                </div>

                <div>
                    <span class="block text-[10.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1">Meta Details</span>
                    <div class="space-y-1 mt-1 text-[11px] text-theme-text-muted leading-relaxed font-medium">
                        <div><strong>IP Address:</strong> {{ $submission->ip_address }}</div>
                        <div class="break-words"><strong>User Agent:</strong> {{ $submission->user_agent }}</div>
                    </div>
                </div>

                <div class="border-t border-theme-border pt-4">
                    <form action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to permanently delete this inquiry?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-100 transition-all text-center">
                            Delete Inquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

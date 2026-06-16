@extends('layouts.admin')
@section('title', 'Add Newsletter Subscriber')
@section('admin-content')
    <div class="mb-5">
        <a href="{{ route('admin.newsletter.index') }}" class="text-[12.5px] font-bold text-theme-primary hover:underline flex items-center gap-1.5 mb-3">
            ← Back to Subscribers
        </a>
        <div class="w-full flex items-center justify-between gap-5">
            <div>
                <div class="text-2xl font-extrabold text-theme-text-main">Add Subscriber</div>
                <div class="text-[13px] text-theme-text-muted mt-1">Manually subscribe an email address to the newsletter.</div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-[10px] my-4 text-sm font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 max-w-lg shadow-sm">
        <form method="POST" action="{{ route('admin.newsletter.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-wider mb-2">Email Address *</label>
                <input type="email" name="email" required placeholder="e.g. user@example.com" value="{{ old('email') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm font-medium">
                @error('email')
                    <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-wider mb-2">Name (Optional)</label>
                <input type="text" name="name" placeholder="e.g. John Doe" value="{{ old('name') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm font-medium">
                @error('name')
                    <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.newsletter.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-theme-border bg-theme-hover text-theme-text-main text-[13px] font-bold hover:bg-theme-border transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-theme-primary text-white text-[13px] font-bold hover:bg-theme-primary-hover shadow-md transition-colors">
                    Add Subscriber
                </button>
            </div>
        </form>
    </div>
@endsection

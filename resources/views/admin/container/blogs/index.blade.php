@extends('layouts.admin')
@section('title', 'Blogs')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Blog Management</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Write and manage news, updates, and articles.</div>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
            class="px-5 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Post
        </a>
    </div>

    <div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">All Blog Posts</h3>
            <form action="{{ route('admin.blogs.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search posts..."
                    class="w-60 bg-theme-bg border border-theme-border rounded-[8px] px-4 py-2 text-[12.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary">
                <button type="submit" class="px-4 py-2 bg-theme-primary text-white rounded-[8px] text-[12px] font-bold">Search</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border text-theme-text-main">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Image</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Title</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Category</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Published At</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    @forelse ($blogs as $blog)
                        <tr class="hover:bg-theme-hover transition-colors">
                            <td class="px-6 py-4">
                                <img src="{{ $blog->image ? asset($blog->image) : asset('assets/blog01.jpg') }}" 
                                     alt="{{ $blog->title }}" class="w-12 h-12 rounded-lg object-cover">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[13.5px] font-bold text-theme-text-main">{{ $blog->title }}</div>
                                <div class="text-[11px] text-theme-text-muted">By {{ $blog->user->name ?? 'Admin' }}</div>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-theme-text-main font-medium">
                                {{ $blog->category->name ?? 'Uncategorized' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'published' => 'bg-green-100 text-green-600',
                                        'draft' => 'bg-amber-100 text-amber-600',
                                        'archived' => 'bg-theme-hover text-theme-text-main',
                                    ];
                                    $statusClass = $statusClasses[$blog->status] ?? 'bg-theme-hover text-theme-text-main';
                                @endphp
                                <span class="px-2 py-0.5 rounded-full {{ $statusClass }} text-[10.5px] font-bold">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[12px] text-theme-text-muted">
                                {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Not Published' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-theme-text-muted">No blog posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($blogs->hasPages())
            <div class="px-6 py-4 border-t border-theme-border">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
@endsection

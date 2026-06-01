@extends('layouts.admin')
@section('title', 'Edit Category')
@section('admin-content')
    <div class="w-full mb-5">
        <div class="text-2xl font-extrabold text-theme-text-main">Edit Category</div>
        <div class="text-[13px] text-theme-text-muted mt-1">Update category details.</div>
    </div>

    <div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border shadow-sm max-w-2xl">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            <div class="space-y-6 mb-6">
                <div>
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Type</label>
                    <select name="type" required class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                        <option value="blog" {{ old('type', $category->type) == 'blog' ? 'selected' : '' }}>Blog</option>
                        <option value="service" {{ old('type', $category->type) == 'service' ? 'selected' : '' }}>Service</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-8 py-3 bg-theme-primary text-white rounded-[10px] text-[14px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-8 py-3 bg-theme-bg text-theme-text-muted rounded-[10px] text-[14px] font-bold border border-theme-border hover:bg-theme-hover transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

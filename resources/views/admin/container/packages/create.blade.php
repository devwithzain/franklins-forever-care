@extends('layouts.admin')
@section('title', 'Create Package')
@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Create New Package</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Fill in the details to create a new pricing package.</div>
        </div>
        <a href="{{ route('admin.packages.index') }}"
            class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-[10px] text-[13px] font-bold shadow-sm hover:bg-gray-200 transition-all flex items-center gap-2">
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-3 gap-5">
            <div class="col-span-2 space-y-5">
                <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm space-y-5">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase">Package Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Basic Care"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                            @error('name') <p class="text-red-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase">Price</label>
                            <input type="text" name="price" value="{{ old('price') }}" required placeholder="e.g. $250"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                            @error('price') <p class="text-red-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase">Duration</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" required placeholder="e.g. / week"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                            @error('duration') <p class="text-red-500 text-[11px]">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase">Linked Service (Optional)</label>
                            <select name="service_id" class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                                <option value="">Global Package</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[12px] font-bold text-theme-text-muted uppercase block">Features / What's Included</label>
                        <div id="features-container" class="space-y-3">
                            <div class="flex gap-3">
                                <input type="text" name="features[]" placeholder="Enter feature..." required
                                    class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                                <button type="button" class="add-feature px-4 bg-theme-primary text-white rounded-lg">+</button>
                            </div>
                        </div>
                        <p class="text-[11px] text-theme-text-muted mt-2 italic">Add at least one feature for the package.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm space-y-6">
                    <div class="space-y-2">
                        <label class="text-[12px] font-bold text-theme-text-muted uppercase">Status</label>
                        <select name="status" required class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="popular" id="popular" value="1" {{ old('popular') ? 'checked' : '' }} class="w-4 h-4 rounded border-theme-border text-theme-primary focus:ring-theme-primary">
                        <label for="popular" class="text-[13px] font-bold text-theme-text-main">Mark as Most Popular</label>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-theme-border">
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-theme-text-muted uppercase">Bg Color</label>
                            <input type="color" name="color" value="#DDEEE7" class="w-full h-10 p-1 bg-theme-bg border border-theme-border rounded">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-theme-text-muted uppercase">Text Color</label>
                            <input type="color" name="text_color" value="#2E6A51" class="w-full h-10 p-1 bg-theme-bg border border-theme-border rounded">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-theme-primary text-white rounded-[10px] text-[14px] font-extrabold shadow-md hover:bg-theme-primary-hover transition-all">
                        Save Package
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('features-container');
            
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-feature')) {
                    const div = document.createElement('div');
                    div.className = 'flex gap-3';
                    div.innerHTML = `
                        <input type="text" name="features[]" placeholder="Enter feature..." required
                            class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-theme-primary">
                        <button type="button" class="remove-feature px-4 bg-red-50 text-red-500 border border-red-100 rounded-lg">-</button>
                    `;
                    container.appendChild(div);
                }
                
                if (e.target.classList.contains('remove-feature')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
@endsection

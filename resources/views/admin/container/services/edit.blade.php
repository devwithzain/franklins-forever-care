@extends('layouts.admin')
@section('title', 'Edit Service')
@section('admin-content')
    <div class="w-full mb-5">
        <div class="text-2xl font-extrabold text-theme-text-main">Edit Service</div>
        <div class="text-[13px] text-theme-text-muted mt-1">Update service details and content.</div>
    </div>

    <div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border shadow-sm max-w-4xl">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="p-8" id="service-form">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Service Title</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Short Description</label>
                    <textarea name="short_description" rows="2"
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">{{ old('short_description', $service->short_description) }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Full Description <span class="text-red-400">*</span></label>
                    <input type="hidden" name="description" id="description-input">
                    <div id="description-editor" class="bg-theme-bg border border-theme-border rounded-[10px]" style="font-size: 14px; min-height: 320px;">{!! old('description', $service->description) !!}</div>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Featured Image</label>
                    @if($service->image)
                        <div class="mb-3">
                            <img src="{{ asset($service->image) }}" alt="{{ $service->title }}" class="w-32 h-24 rounded-lg object-cover border border-theme-border">
                            <p class="text-[11px] text-theme-text-muted mt-1">Current image. Upload new to replace.</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image-input" accept="image/*"
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-2 text-[13.5px] outline-none focus:border-theme-primary">
                    <div id="image-preview" class="mt-3 hidden">
                        <img id="preview-img" src="" alt="Preview" class="w-32 h-24 rounded-lg object-cover border border-theme-border">
                    </div>
                    @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Status</label>
                    <select name="status" class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                        <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Service Inclusions</label>
                    <p class="text-[11px] text-theme-text-muted mb-3">Add each item that's included in this service. Press Enter or click + to add.</p>
                    <div class="flex gap-2 mb-3">
                        <input type="text" id="includes-input" placeholder="e.g. Mobility Assistance"
                            class="flex-1 bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                        <button type="button" onclick="addIncludesItem()"
                            class="px-4 py-3 bg-theme-primary text-white rounded-[10px] font-bold hover:bg-theme-primary-hover transition-all">+</button>
                    </div>
                    <div id="includes-tags" class="flex flex-wrap gap-2 min-h-[40px]"></div>
                    <input type="hidden" name="includes" id="includes-hidden">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="px-8 py-3 bg-theme-primary text-white rounded-[10px] text-[14px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">
                    Update Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="px-8 py-3 bg-theme-bg text-theme-text-muted rounded-[10px] text-[14px] font-bold border border-theme-border hover:bg-theme-hover transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Quill.js CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <style>
        #description-editor {
            border-radius: 10px;
            position: relative;
        }

        #description-editor .ql-editor {
            min-height: 260px;
            font-size: 14px;
            line-height: 1.7;
        }

        #description-editor .ql-toolbar { border-radius: 10px 10px 0 0; }
        #description-editor .ql-container { border-radius: 0 0 10px 10px; }

        .ql-toolbar .ql-picker-options { z-index: 9999 !important; }
        .ql-snow .ql-tooltip { z-index: 9999 !important; }
        .dark #description-editor .ql-toolbar { border-color: #334155; }
        .dark #description-editor .ql-toolbar .ql-stroke { stroke: #94a3b8; }
        .dark #description-editor .ql-toolbar .ql-fill { fill: #94a3b8; }
        .dark #description-editor .ql-toolbar .ql-picker { color: #94a3b8; }
        .dark #description-editor .ql-editor { color: #f8fafc; }
        .includes-tag { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: var(--theme-primary-light, #eef2ff); color: var(--theme-primary, #1a3cdc); border-radius: 999px; font-size: 12px; font-weight: 600; }
        .includes-tag button { background: none; border: none; cursor: pointer; color: inherit; padding: 0; font-size: 14px; line-height: 1; opacity: 0.7; }
        .includes-tag button:hover { opacity: 1; }
    </style>

    <script>
        const quill = new Quill('#description-editor', {
            theme: 'snow',
            placeholder: 'Write a detailed description of this service...',
            modules: {
                clipboard: { matchVisual: false },
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'blockquote'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean']
                ]
            }
        });

        // Strip background-color from pasted content
        quill.clipboard.addMatcher(Node.ELEMENT_NODE, function (node, delta) {
            delta.ops = delta.ops.map(function (op) {
                if (op.attributes) {
                    delete op.attributes.background;
                    delete op.attributes['background-color'];
                }
                return op;
            });
            return delta;
        });

        document.getElementById('service-form').addEventListener('submit', function() {
            document.getElementById('description-input').value = quill.root.innerHTML;
        });


        // Load existing includes
        let includesItems = @json($service->includes ?? []);
        renderTags();

        function addIncludesItem() {
            const input = document.getElementById('includes-input');
            const val = input.value.trim();
            if (val && !includesItems.includes(val)) {
                includesItems.push(val);
                renderTags();
                input.value = '';
            }
        }

        function removeTag(val) {
            includesItems = includesItems.filter(i => i !== val);
            renderTags();
        }

        function renderTags() {
            const container = document.getElementById('includes-tags');
            container.innerHTML = includesItems.map(item =>
                `<span class="includes-tag">${item} <button type="button" onclick="removeTag('${item.replace(/'/g, "\\'")}')">&times;</button></span>`
            ).join('');
            document.getElementById('includes-hidden').value = JSON.stringify(includesItems);
        }

        document.getElementById('includes-input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); addIncludesItem(); }
        });

        // Image preview
        document.getElementById('image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('preview-img').src = ev.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection

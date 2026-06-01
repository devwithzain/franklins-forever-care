@extends('layouts.admin')
@section('title', 'Create Blog Post')
@section('admin-content')
    <div class="w-full mb-5">
        <div class="text-2xl font-extrabold text-theme-text-main">Create New Blog Post</div>
        <div class="text-[13px] text-theme-text-muted mt-1">Publish a new article to the website.</div>
    </div>

    <div class="bg-theme-card text-theme-text-main rounded-[14px] border border-theme-border shadow-sm max-w-5xl">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="p-8" id="blog-form">
            @csrf
            <div class="grid grid-cols-3 gap-6 mb-6">

                <!-- ROW 1: Title + Category -->
                <div class="col-span-2">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Post Title <span class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Category <span class="text-red-400">*</span></label>
                    <select name="category_id" required class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- ROW 2: Quill Content -->
                <div class="col-span-3">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Content <span class="text-red-400">*</span></label>
                    <input type="hidden" name="content" id="content-input" value="{{ old('content') }}">
                    <div id="content-editor" class="bg-theme-bg border border-theme-border" style="font-size: 14px; min-height: 420px;">{{ old('content') }}</div>
                    @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- ROW 3: Image + Status -->
                <div class="col-span-2 mt-20">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Featured Image</label>
                    <input type="file" name="image" id="image-input" accept="image/*"
                        class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-2 text-[13.5px] outline-none focus:border-theme-primary">
                    <div id="image-preview" class="mt-3 hidden">
                        <img id="preview-img" src="" alt="Preview" class="w-48 h-32 rounded-lg object-cover border border-theme-border">
                    </div>
                    @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mt-20">
                    <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Status</label>
                    <select name="status" class="w-full bg-theme-bg border border-theme-border rounded-[10px] px-4 py-3 text-[13.5px] outline-none focus:border-theme-primary">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- ROW 4: Tags with inline creator -->
                <div class="col-span-3">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-[12px] font-bold text-theme-text-muted uppercase tracking-widest">Tags</label>
                        <span class="text-[11px] text-theme-text-muted">Select existing or create new</span>
                    </div>

                    <!-- Existing Tags Checkboxes -->
                    <div id="tags-container" class="flex flex-wrap gap-2 mb-4 min-h-[36px]">
                        @foreach($tags as $tag)
                            <label class="tag-label inline-flex items-center gap-2 px-3 py-1.5 bg-theme-bg border border-theme-border rounded-full cursor-pointer hover:border-theme-primary hover:bg-theme-primary-light transition-all has-[:checked]:bg-theme-primary-light has-[:checked]:border-theme-primary">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                    class="w-3.5 h-3.5 accent-[var(--theme-primary)]">
                                <span class="text-[12px] font-semibold text-theme-text-main">{{ $tag->name }}</span>
                            </label>
                        @endforeach

                        @if($tags->isEmpty())
                            <span id="no-tags-msg" class="text-[12px] text-theme-text-muted italic">No tags yet — create one below.</span>
                        @endif
                    </div>

                    <!-- Inline Tag Creator -->
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-theme-bg border border-dashed border-theme-border rounded-[10px]">
                        <svg class="w-4 h-4 text-theme-text-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z" />
                        </svg>
                        <input type="text" id="new-tag-input" placeholder="Type a new tag name and press Enter..."
                            class="flex-1 bg-transparent text-[13px] outline-none text-theme-text-main placeholder:text-theme-text-muted border-none">
                        <button type="button" id="create-tag-btn"
                            class="px-4 py-1.5 bg-theme-primary text-white rounded-[8px] text-[12px] font-bold hover:bg-theme-primary-hover transition-all shrink-0">
                            + Create Tag
                        </button>
                        <span id="tag-create-msg" class="text-[11px] hidden"></span>
                    </div>
                </div>

            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="px-8 py-3 bg-theme-primary text-white rounded-[10px] text-[14px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">
                    Publish Post
                </button>
                <a href="{{ route('admin.blogs.index') }}" class="px-8 py-3 bg-theme-bg text-theme-text-muted rounded-[10px] text-[14px] font-bold border border-theme-border hover:bg-theme-hover transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Quill.js CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <style>
        #content-editor {
            position: relative;
        }

        #content-editor .ql-editor {
            min-height: 360px;
            font-size: 14px;
            line-height: 1.8;
        }

        #content-editor .ql-toolbar { border-radius: 10px 10px 0 0; }
        #content-editor .ql-container { border-radius: 0 0 10px 10px; }
        #content-editor .ql-editor h1 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        #content-editor .ql-editor h2 { font-size: 22px; font-weight: 600; margin-bottom: 10px; }
        #content-editor .ql-editor h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        #content-editor .ql-editor blockquote { border-left: 4px solid var(--theme-primary, #1a3cdc); padding-left: 16px; color: #64748b; font-style: italic; }

        /* Fix Quill dropdown z-index */
        .ql-toolbar .ql-picker-options { z-index: 9999 !important; }
        .ql-snow .ql-tooltip { z-index: 9999 !important; }
        .dark #content-editor .ql-toolbar { border-color: #334155; }
        .dark #content-editor .ql-toolbar .ql-stroke { stroke: #94a3b8; }
        .dark #content-editor .ql-toolbar .ql-fill { fill: #94a3b8; }
        .dark #content-editor .ql-toolbar .ql-picker { color: #94a3b8; }
        .dark #content-editor .ql-editor { color: #f8fafc; }
    </style>

    <script>
        // ─── Quill Editor ──────────────────────────────────────────────
        const quill = new Quill('#content-editor', {
            theme: 'snow',
            placeholder: 'Start writing your blog post here...',
            modules: {
                // matchVisual:false prevents Quill from copying extra formatting
                clipboard: { matchVisual: false },
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    ['link', 'image', 'blockquote', 'code-block'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        // Strip background-color from any pasted content
        quill.clipboard.addMatcher(Node.ELEMENT_NODE, function (node, delta) {
            delta.ops = delta.ops.map(function (op) {
                if (op.attributes) {
                    delete op.attributes.background;
                    delete op.attributes['background-color'];
                    // Uncomment below to also strip text color on paste:
                    // delete op.attributes.color;
                }
                return op;
            });
            return delta;
        });

        document.getElementById('blog-form').addEventListener('submit', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });

        // ─── Image preview ─────────────────────────────────────────────
        document.getElementById('image-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    document.getElementById('preview-img').src = ev.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // ─── Inline Tag Creator ────────────────────────────────────────
        const tagInput    = document.getElementById('new-tag-input');
        const createBtn   = document.getElementById('create-tag-btn');
        const tagMsg      = document.getElementById('tag-create-msg');
        const tagsContainer = document.getElementById('tags-container');
        const TAGS_STORE_URL = "{{ route('admin.tags.store') }}";
        const CSRF_TOKEN     = document.querySelector('meta[name="csrf-token"]')
                               ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                               : "{{ csrf_token() }}";

        async function createTag() {
            const name = tagInput.value.trim();
            if (!name) return;

            createBtn.disabled = true;
            createBtn.textContent = 'Creating...';

            try {
                const res = await fetch(TAGS_STORE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name }),
                });

                const data = await res.json();

                if (!res.ok) {
                    // Show validation error
                    const errorMsg = data.errors?.name?.[0] ?? 'Tag already exists.';
                    showMsg(errorMsg, 'error');
                } else {
                    // Append new checkbox tag
                    appendTagCheckbox(data.id, data.name, true);
                    tagInput.value = '';
                    // Remove "no tags" message if it exists
                    const noTagsMsg = document.getElementById('no-tags-msg');
                    if (noTagsMsg) noTagsMsg.remove();
                    showMsg('Tag "' + data.name + '" created!', 'success');
                }
            } catch (err) {
                showMsg('Something went wrong.', 'error');
            } finally {
                createBtn.disabled = false;
                createBtn.textContent = '+ Create Tag';
            }
        }

        function appendTagCheckbox(id, name, checked = false) {
            const label = document.createElement('label');
            label.className = 'tag-label inline-flex items-center gap-2 px-3 py-1.5 bg-theme-primary-light border border-theme-primary rounded-full cursor-pointer transition-all has-[:checked]:bg-theme-primary-light has-[:checked]:border-theme-primary';
            label.innerHTML = `
                <input type="checkbox" name="tags[]" value="${id}" ${checked ? 'checked' : ''}
                    class="w-3.5 h-3.5 accent-[var(--theme-primary)]">
                <span class="text-[12px] font-semibold text-theme-text-main">${name}</span>
            `;
            tagsContainer.appendChild(label);
        }

        function showMsg(text, type) {
            tagMsg.textContent = text;
            tagMsg.className = 'text-[11px] font-medium ' + (type === 'error' ? 'text-red-500' : 'text-green-600');
            tagMsg.classList.remove('hidden');
            setTimeout(() => tagMsg.classList.add('hidden'), 3000);
        }

        createBtn.addEventListener('click', createTag);
        tagInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); createTag(); }
        });
    </script>
@endsection
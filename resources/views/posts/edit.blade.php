@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-inner">
        <div>
            <div class="flex gap-sm mb-md" style="align-items:center;">
                @if(Route::has('posts.index'))
                <a href="{{ route('posts.index') }}" class="btn btn-ghost btn-sm" style="padding-left:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    Posts
                </a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--clr-text-3)" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                @endif
                <span class="text-sm text-muted">Edit Post</span>
            </div>
            <h1 class="page-title">Edit Post</h1>
            <p class="page-subtitle">Update your post content and settings.</p>
        </div>
        <div class="flex gap-md">
            <span class="badge badge-{{ isset($post) && $post->status === 'published' ? 'success' : (isset($post) && $post->status === 'pending' ? 'warning' : 'gray') }}" style="font-size:0.8125rem; padding:0.5rem 0.875rem;">
                {{ ucfirst(isset($post) ? $post->status : 'draft') }}
            </span>
            @isset($post)
            @if(Route::has('posts.show'))
            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary btn-sm" target="_blank">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Preview
            </a>
            @endif
            @endisset
        </div>
    </div>
</div>

<form method="POST" action="{{ isset($post) ? route('posts.update', $post) : '#' }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <div class="grid gap-lg" style="grid-template-columns: 1fr 320px; align-items: start;">

        {{-- ─── Main Content ─── --}}
        <div style="display:flex; flex-direction:column; gap:var(--sp-5);">

            {{-- Title --}}
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="title" class="text-sm">Post Title <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            id="title" name="title"
                            value="{{ old('title', isset($post) ? $post->title : '') }}"
                            placeholder="Write an engaging post title..."
                            style="font-size:1.125rem; font-weight:600; border-color:transparent; padding:var(--sp-3) 0; border-radius:0; border-bottom:2px solid var(--clr-border); background:transparent;"
                            required>
                        @error('title')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Excerpt --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Post Excerpt</h5></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="excerpt">Short Summary <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}"
                            id="excerpt" name="excerpt" rows="2"
                            placeholder="A brief description shown in post listings...">{{ old('excerpt', isset($post) ? $post->excerpt : '') }}</textarea>
                        <span class="form-hint">Recommended: 120–160 characters</span>
                        @error('excerpt') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Content <span style="color:var(--clr-danger);">*</span></h5></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                            id="content" name="content" rows="18"
                            placeholder="Write your post content here...">{{ old('content', isset($post) ? $post->content : '') }}</textarea>
                        @error('content') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="card" style="border-color:var(--clr-danger-bg);">
                <div class="card-header" style="background:var(--clr-danger-bg);">
                    <h5 class="mb-0" style="color:var(--clr-danger);">Danger Zone</h5>
                </div>
                <div class="card-body flex-between">
                    <div>
                        <p class="fw-semibold mb-xs" style="color:var(--clr-text);">Delete this post</p>
                        <p class="text-sm text-muted mb-0">This action is permanent and cannot be undone.</p>
                    </div>
                    @isset($post)
                    <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('deleteModal').classList.add('active')">
                        Delete Post
                    </button>
                    @endisset
                </div>
            </div>
        </div>

        {{-- ─── Sidebar Panel ─── --}}
        <div style="display:flex; flex-direction:column; gap:var(--sp-5); position:sticky; top:calc(var(--navbar-h) + var(--sp-8));">

            {{-- Update Actions --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Update Post</h5></div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft"     {{ old('status', isset($post) ? $post->status : 'draft') == 'draft'     ? 'selected' : '' }}>📝 Draft</option>
                            <option value="pending"   {{ old('status', isset($post) ? $post->status : '') == 'pending'   ? 'selected' : '' }}>⏳ Pending Review</option>
                            <option value="published" {{ old('status', isset($post) ? $post->status : '') == 'published' ? 'selected' : '' }}>🌐 Published</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer" style="flex-direction:column;">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Save Changes
                    </button>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Organization</h5></div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:var(--sp-4);">
                    <div class="form-group mb-0">
                        <label for="category_id">Category</label>
                        <select class="form-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category_id" name="category_id">
                            <option value="">— Select category —</option>
                            @isset($categories)
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', isset($post) ? $post->category_id : '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="tags">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                            value="{{ old('tags', isset($post) ? $post->tags : '') }}"
                            placeholder="e.g. design, css, tutorial">
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Featured Image</h5></div>
                <div class="card-body">
                    @isset($post)
                        @if($post->featured_image)
                        <div style="margin-bottom:var(--sp-4);">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured"
                                 style="width:100%;border-radius:var(--r-lg);object-fit:cover;max-height:160px;">
                        </div>
                        @endif
                    @endisset
                    <div id="featuredPreview" style="display:none; margin-bottom:var(--sp-4);">
                        <img id="featuredImg" src="" alt="Preview" style="width:100%;border-radius:var(--r-lg);object-fit:cover;max-height:160px;">
                    </div>
                    <div class="form-group mb-0">
                        <input type="file" class="form-control" id="featured_image" name="featured_image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            onchange="previewFeatured(this)">
                        <span class="form-hint">Leave empty to keep current image</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Delete Confirmation Modal --}}
@isset($post)
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="mb-0">Delete Post?</h4>
            <button class="modal-close" onclick="document.getElementById('deleteModal').classList.remove('active')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong>"{{ $post->title }}"</strong>? This action cannot be undone and all associated data will be permanently removed.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('deleteModal').classList.remove('active')">Cancel</button>
            <form method="POST" action="{{ Route::has('posts.destroy') ? route('posts.destroy', $post) : '#' }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Forever</button>
            </form>
        </div>
    </div>
</div>
@endisset
@endsection

@push('scripts')
<script>
    function previewFeatured(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('featuredImg').src = e.target.result;
                document.getElementById('featuredPreview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

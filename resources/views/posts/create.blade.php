@extends('layouts.app')

@section('title', 'Create New Post')

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
                <span class="text-sm text-muted">New Post</span>
            </div>
            <h1 class="page-title">Create New Post</h1>
            <p class="page-subtitle">Write and publish your content to the world.</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" novalidate id="create-post-form">
    @csrf

    <div class="grid gap-lg" style="grid-template-columns: 1fr 320px; align-items: start;">

        {{-- ─── Main Content ─── --}}
        <div style="display:flex; flex-direction:column; gap:var(--sp-5);">

            {{-- Title --}}
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="title" class="text-sm">Post Title <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            id="title" name="title" value="{{ old('title') }}"
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
                <div class="card-header">
                    <h5 class="mb-0">Post Excerpt</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="excerpt">Short Summary <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}"
                            id="excerpt" name="excerpt" rows="2"
                            placeholder="A brief description shown in post lists and SEO...">{{ old('excerpt') }}</textarea>
                        <span class="form-hint">Recommended: 120–160 characters for good SEO</span>
                        @error('excerpt')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Content <span style="color:var(--clr-danger);">*</span></h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                            id="content" name="content"
                            rows="18"
                            placeholder="Start writing your post content here...&#10;&#10;You can use Markdown or plain text.">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="form-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Sidebar Panel ─── --}}
        <div style="display:flex; flex-direction:column; gap:var(--sp-5); position: sticky; top: calc(var(--navbar-h) + var(--sp-8));">

            {{-- Publish Actions --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Publish</h5>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:var(--sp-3);">
                    <div class="form-group mb-0">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" {{ old('status','draft') == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ Submit for Review</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>🌐 Publish Now</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label for="scheduled_at">Schedule Date <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}">
                    </div>
                </div>
                <div class="card-footer" style="flex-direction:column;">
                    <button type="submit" name="action" value="publish" class="btn btn-primary btn-block">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Publish Post
                    </button>
                    <button type="submit" name="action" value="draft" class="btn btn-secondary btn-block">
                        Save as Draft
                    </button>
                </div>
            </div>

            {{-- Category & Tags --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Organization</h5></div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:var(--sp-4);">
                    <div class="form-group mb-0">
                        <label for="category_id">Category</label>
                        <select class="form-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category_id" name="category_id">
                            <option value="">— Select category —</option>
                            @isset($categories)
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            @endisset
                            {{-- Sample options for preview --}}
                            @empty($categories)
                            <option value="1">Technology</option>
                            <option value="2">Lifestyle</option>
                            <option value="3">Business</option>
                            @endempty
                        </select>
                        @error('category_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label for="tags">Tags <span class="text-muted fw-normal">(comma-separated)</span></label>
                        <input type="text" class="form-control" id="tags" name="tags"
                            value="{{ old('tags') }}" placeholder="e.g. design, css, tutorial">
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Featured Image</h5></div>
                <div class="card-body">
                    <div id="featuredPreview" style="display:none; margin-bottom:var(--sp-4);">
                        <img id="featuredImg" src="" alt="Preview" style="width:100%;border-radius:var(--r-lg);object-fit:cover;max-height:160px;">
                    </div>
                    <div class="form-group mb-0">
                        <input type="file" class="form-control" id="featured_image" name="featured_image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            onchange="previewFeatured(this)">
                        <span class="form-hint">JPG, PNG, or WebP — Max 2MB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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

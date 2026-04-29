@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Post</h2>
        <a href="{{ route('author.posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('author.posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="content_type" class="form-label">Post Type <span class="text-danger">*</span></label>
                    <select name="content_type" id="content_type" class="form-select @error('content_type') is-invalid @enderror" required>
                        <option value="post" {{ old('content_type', $post->content_type) == 'post' ? 'selected' : '' }}>Standard Post</option>
                        <option value="image" {{ old('content_type', $post->content_type) == 'image' ? 'selected' : '' }}>Image Post</option>
                        <option value="video" {{ old('content_type', $post->content_type) == 'video' ? 'selected' : '' }}>Video Post</option>
                        <option value="audio" {{ old('content_type', $post->content_type) == 'audio' ? 'selected' : '' }}>Resource/Document Post</option>
                    </select>
                    @error('content_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Media Library Selection -->
                <div class="mb-3">
                    <label class="form-label">Select from Media Library</label>
                    <div class="d-flex gap-2">
                        <select name="media_id" id="media_selector" class="form-select @error('media_id') is-invalid @enderror">
                            <option value="">-- Choose from Library --</option>
                            @if(auth()->check())
                                @php
                                    $availableMedia = \App\Models\Content::where('user_id', auth()->id())
                                        ->whereNotNull('file_path')
                                        ->where('content_type', '!=', 'video')
                                        ->where('id', '!=', $post->id)
                                        ->latest()
                                        ->get();
                                @endphp
                                @foreach($availableMedia as $media)
                                    <option value="{{ $media->id }}" {{ old('media_id', $post->media_id) == $media->id ? 'selected' : '' }}>
                                        {{ $media->title }} ({{ Str::limit($media->description, 30) }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <button type="button" class="btn btn-outline-primary" onclick="window.open('/author/media', '_blank')">
                            <i class="fas fa-folder-open"></i> Open Library
                        </button>
                    </div>
                    <small class="form-text text-muted">Select an existing file from your media library or upload new files below</small>
                    @error('media_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Dynamic fields based on post type -->
                <div class="mb-3" id="image-field" style="display: none;">
                    <label for="media_file" class="form-label">Upload Image</label>
                    <input type="file" name="media_file" id="media_file" class="form-control @error('media_file') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                    @if($post->file_path)
                        <small class="form-text text-muted">Current file: {{ basename($post->file_path) }}. Upload new file to replace.</small>
                    @else
                        <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG (Max 10MB)</small>
                    @endif
                    @error('media_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="video-field" style="display: none;">
                    <label for="external_url" class="form-label">Video URL</label>
                    <input type="url" name="external_url" id="external_url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url', $post->external_url) }}" placeholder="https://youtube.com/watch?v=...">
                    <small class="form-text text-muted">Enter YouTube, Vimeo, or other video URL</small>
                    @error('external_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="resource-field" style="display: none;">
                    <label for="external_url" class="form-label">Resource Link</label>
                    <input type="url" name="external_url" id="resource_url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url', $post->external_url) }}" placeholder="https://example.com/resource">
                    <small class="form-text text-muted">Enter external resource URL</small>
                    @error('external_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="document-field" style="display: none;">
                    <label for="media_file" class="form-label">Upload Document</label>
                    <input type="file" name="media_file" id="document_file" class="form-control @error('media_file') is-invalid @enderror" accept=".pdf,.docx,.doc">
                    @if($post->file_path)
                        <small class="form-text text-muted">Current file: {{ basename($post->file_path) }}. Upload new file to replace.</small>
                    @else
                        <small class="form-text text-muted">Allowed formats: PDF, DOCX, DOC (Max 10MB)</small>
                    @endif
                    @error('media_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->description) }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags') }}" placeholder="Enter tags separated by commas">
                    @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Categories</label>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-3 col-sm-4 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category_{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label">Schedule Publishing (Optional)</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                    <small class="form-text text-muted">Leave empty to publish immediately, or select a future date/time to schedule</small>
                    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publish</option>
                        <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                                                                                        
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">Update Post</button>
                    <a href="{{ route('author.posts.revisions', $post->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-history me-1"></i> View History
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Revisions History -->
    @if($post->revisions->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Revision History ({{ $post->revisions->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Content Preview</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($post->revisions as $revision)
                                <tr>
                                    <td>{{ $revision->formatted_created_at }}</td>
                                    <td>{{ $revision->title }}</td>
                                    <td>{{ Str::limit(strip_tags($revision->content), 50) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewRevision({{ $revision->id }})">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeSelect = document.getElementById('content_type');
    const imageField = document.getElementById('image-field');
    const videoField = document.getElementById('video-field');
    const resourceField = document.getElementById('resource-field');
    const documentField = document.getElementById('document-field');

    function toggleFields() {
        const selectedType = contentTypeSelect.value;
        
        // Hide all fields first
        imageField.style.display = 'none';
        videoField.style.display = 'none';
        resourceField.style.display = 'none';
        documentField.style.display = 'none';
        
        // Show relevant field based on selection
        switch(selectedType) {
            case 'image':
                imageField.style.display = 'block';
                break;
            case 'video':
                videoField.style.display = 'block';
                break;
            case 'audio':
                resourceField.style.display = 'block';
                documentField.style.display = 'block';
                break;
            case 'post':
            default:
                // Only show content field for standard posts
                break;
        }
    }

    // Initial call
    toggleFields();
    
    // Listen for changes
    contentTypeSelect.addEventListener('change', toggleFields);
    
    }

// Function to view revision details
function viewRevision(revisionId) {
    // You can implement this to show a modal with full revision details
    // For now, we'll just show an alert with basic info
    fetch(`/author/revisions/${revisionId}`)
        .then(response => response.json())
        .then(data => {
            alert(`Revision from ${data.created_at}:\n\nTitle: ${data.title}\n\nContent:\n${data.content}`);
        })
        .catch(error => {
            console.error('Error fetching revision:', error);
            alert('Error loading revision details');
        });
}
</script>
@endsection

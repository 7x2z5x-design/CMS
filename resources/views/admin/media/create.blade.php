@extends('admin.layout')
@section('title', 'Upload Media')

@section('content')
<div class="content-header" style="margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin: 0; margin-bottom: 1rem;">Upload Media</h1>
    <a href="{{ route('admin.media.index') }}" class="btn btn-light" style="display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="ph ph-arrow-left"></i> Back to Library
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Media Upload</h3>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Media Type Selection -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Media Type *</label>
                <select name="media_type" id="media_type" class="form-control" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);">
                    <option value="">Select media type</option>
                    <option value="image">Image (JPG, PNG, GIF)</option>
                    <option value="video">Video File (MP4, AVI, MOV)</option>
                    <option value="video_link">Video Link (YouTube, Vimeo)</option>
                    <option value="document">Document (PDF, DOC, DOCX)</option>
                    <option value="resource_link">Resource Link (External URL)</option>
                </select>
                @error('media_type') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
            </div>

            <!-- Title -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Title *</label>
                <input type="text" name="title" class="form-control" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);" placeholder="Enter media title">
                @error('title') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Description</label>
                <textarea name="description" rows="3" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);" placeholder="Enter media description (optional)"></textarea>
                @error('description') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
            </div>

            <!-- File Upload Fields (shown for file-based media) -->
            <div id="file_fields" style="display: none;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Select File *</label>
                    <input type="file" name="file" id="file_input" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);">
                    <small id="file_help" style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">Max file size: 10MB</small>
                    @error('file') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- URL Fields (shown for link-based media) -->
            <div id="url_fields" style="display: none;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">URL *</label>
                    <input type="url" name="url" id="url_input" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);" placeholder="https://example.com/video">
                    <small id="url_help" style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">Enter the full URL</small>
                    @error('url') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>

                <!-- Thumbnail for video links -->
                <div id="thumbnail_fields" style="display: none;">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Thumbnail URL (optional)</label>
                        <input type="url" name="thumbnail" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);" placeholder="https://example.com/thumbnail.jpg">
                        <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">Thumbnail image URL for video</small>
                        @error('thumbnail') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Alt Text for images -->
            <div id="alt_text_fields" style="display: none;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Alt Text (for accessibility)</label>
                    <input type="text" name="alt_text" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-body);" placeholder="Describe the image for screen readers">
                    @error('alt_text') <span class="invalid-feedback" style="color:var(--danger); font-size:0.85rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="ph ph-upload-simple"></i> Upload Media
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaType = document.getElementById('media_type');
    const fileFields = document.getElementById('file_fields');
    const urlFields = document.getElementById('url_fields');
    const thumbnailFields = document.getElementById('thumbnail_fields');
    const altTextFields = document.getElementById('alt_text_fields');
    const fileInput = document.getElementById('file_input');
    const urlInput = document.getElementById('url_input');
    const fileHelp = document.getElementById('file_help');
    const urlHelp = document.getElementById('url_help');

    function toggleFields() {
        const type = mediaType.value;
        
        // Hide all fields first
        fileFields.style.display = 'none';
        urlFields.style.display = 'none';
        thumbnailFields.style.display = 'none';
        altTextFields.style.display = 'none';
        
        // Remove required attributes
        fileInput.removeAttribute('required');
        urlInput.removeAttribute('required');
        
        // Show relevant fields based on media type
        if (type === 'image') {
            fileFields.style.display = 'block';
            altTextFields.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            fileInput.accept = '.jpg,.jpeg,.png,gif';
            fileHelp.textContent = 'Accepted formats: JPG, JPEG, PNG, GIF. Max file size: 10MB';
        } else if (type === 'video') {
            fileFields.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            fileInput.accept = '.mp4,.avi,.mov';
            fileHelp.textContent = 'Accepted formats: MP4, AVI, MOV. Max file size: 10MB';
        } else if (type === 'video_link') {
            urlFields.style.display = 'block';
            thumbnailFields.style.display = 'block';
            urlInput.setAttribute('required', 'required');
            urlHelp.textContent = 'Enter YouTube, Vimeo, or other video URL';
        } else if (type === 'document') {
            fileFields.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            fileInput.accept = '.pdf,.doc,.docx';
            fileHelp.textContent = 'Accepted formats: PDF, DOC, DOCX. Max file size: 10MB';
        } else if (type === 'resource_link') {
            urlFields.style.display = 'block';
            urlInput.setAttribute('required', 'required');
            urlHelp.textContent = 'Enter any external resource URL';
        }
    }
    
    mediaType.addEventListener('change', toggleFields);
});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Media Library</h2>
        <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Upload New Media</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($mediaFiles->count() > 0)
                <div class="row">
                    @foreach($mediaFiles as $media)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    @if($media->content_type === 'image')
                                        <div class="text-center mb-3">
                                            @if($media->file_path)
                                                <img src="{{ asset($media->file_path) }}" alt="{{ $media->title }}" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($media->content_type === 'document')
                                        <div class="text-center mb-3">
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-file-pdf fa-3x text-muted"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center mb-3">
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-file fa-3x text-muted"></i>
                                            </div>
                                        </div>
                                    @endif

                                    <h6 class="card-title">{{ $media->title }}</h6>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($media->description, 100) }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            {{ $media->created_at->format('M d, Y') }}
                                        </small>
                                        <div>
                                            @if($media->file_path)
                                                <button type="button" class="btn btn-sm btn-info me-1" onclick="copyToClipboard('{{ asset($media->file_path) }}')">
                                                    <i class="fas fa-copy"></i> Copy Link
                                                </button>
                                            @endif
                                            <form action="{{ route('author.media.destroy', $media->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this media file?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $mediaFiles->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Your media library is empty</h4>
                    <p class="text-muted">Upload images and documents to see them here.</p>
                    <a href="{{ route('author.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload New Media
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message (optional)
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3 bg-success text-white';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="fas fa-check-circle me-2"></i> Link copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endsection

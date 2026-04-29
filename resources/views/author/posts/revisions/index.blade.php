@extends('layouts.app')

@section('title', 'Post Revision History')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-history me-2"></i>
            Revision History
        </h2>
        <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Edit Post
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                "{{ $post->title }}" - All Revisions ({{ $revisions->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($revisions->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Content Preview</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revisions as $revision)
                                <tr>
                                    <td>
                                        <small>{{ $revision->formatted_created_at }}</small>
                                    </td>
                                    <td>
                                        @if($revision->user)
                                            <span class="badge bg-secondary">{{ $revision->user->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $revision->title }}</strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit(strip_tags($revision->content), 100) }}</small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info me-1" onclick="viewRevision({{ $revision->id }})">
                                            <i class="fas fa-eye"></i> Preview
                                        </button>
                                        <a href="{{ route('posts.revisions.compare', [$post->id, $revision->id]) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-code-branch"></i> Compare
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="restoreRevision({{ $revision->id }})">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Revision History</h4>
                    <p class="text-muted">This post hasn't been edited yet.</p>
                    <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Post
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Revision Preview Modal -->
    <div class="modal fade" id="revisionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Revision Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="revisionContent">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="restoreFromModal">
                        <i class="fas fa-undo"></i> Restore This Version
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentRevisionId = null;
let postId = {{ $post->id }};

function viewRevision(revisionId) {
    currentRevisionId = revisionId;
    
    fetch(`/author/revisions/${revisionId}`)
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="mb-3">
                    <label class="form-label fw-bold">Title:</label>
                    <p class="form-control-plaintext">${data.title}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Content:</label>
                    <div class="border rounded p-3 bg-light">
                        ${data.content}
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Created:</label>
                    <p class="form-control-plaintext">${data.created_at} by ${data.user}</p>
                </div>
            `;
            
            document.getElementById('revisionContent').innerHTML = content;
            document.getElementById('restoreFromModal').onclick = () => restoreRevision(revisionId);
            
            const modal = new bootstrap.Modal(document.getElementById('revisionModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error fetching revision:', error);
            alert('Error loading revision details');
        });
}

function restoreRevision(revisionId) {
    if (confirm('Are you sure you want to restore this revision? This will replace the current post content.')) {
        fetch(`/author/posts/${postId}/restore/${revisionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Post restored successfully!');
                window.location.href = `/author/posts/${postId}/edit`;
            } else {
                alert('Error restoring post: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error restoring revision:', error);
            alert('Error restoring post');
        });
    }
}
</script>
@endsection

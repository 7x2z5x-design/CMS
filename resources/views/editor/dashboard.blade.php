@extends('layouts.app')

@section('title', 'Editor Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editor Dashboard</h2>
        <div class="text-muted">
            Welcome back, {{ auth()->user()->name }}
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Submitted Posts</h6>
                            <h3 class="mb-0">{{ $submittedCount }}</h3>
                        </div>
                        <div class="ms-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Approved Posts</h6>
                            <h3 class="mb-0">{{ $approvedCount }}</h3>
                        </div>
                        <div class="ms-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Rejected Posts</h6>
                            <h3 class="mb-0">{{ $rejectedCount }}</h3>
                        </div>
                        <div class="ms-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Scheduled Posts</h6>
                            <h3 class="mb-0">{{ $scheduledCount }}</h3>
                        </div>
                        <div class="ms-3">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-calendar-check text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <form method="GET" action="{{ route('editor.dashboard') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search posts..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="author_id" class="form-select">
                            <option value="">All Authors</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tag_id" class="form-select">
                            <option value="">All Tags</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                <div class="col-md-2">
                    <select class="form-select" disabled>
                        <option value="">All Statuses</option>
                        <option value="submitted" selected>Submitted</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </button>
                        @if(request('search') || request('tag_id') || request('category_id') || request('author_id'))
                            <a href="{{ route('editor.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Clear
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Submitted Posts Table -->
    <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">Submitted Posts</h5>
                    @if(request('search') || request('tag_id') || request('category_id') || request('author_id'))
                        <small class="text-muted">
                            <i class="bi bi-funnel me-1"></i>
                            @if(request('search') && (request('tag_id') || request('category_id') || request('author_id')))
                                @if(request('tag_id') && request('category_id') && request('author_id'))
                                    Search results for "{{ request('search') }}" with tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}", category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}", and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                                @elseif(request('tag_id') && request('category_id'))
                                    Search results for "{{ request('search') }}" with tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}" and category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}"
                                @elseif(request('tag_id') && request('author_id'))
                                    Search results for "{{ request('search') }}" with tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}" and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                                @elseif(request('category_id') && request('author_id'))
                                    Search results for "{{ request('search') }}" with category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}" and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                                @elseif(request('tag_id'))
                                    Search results for "{{ request('search') }}" with tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}"
                                @elseif(request('category_id'))
                                    Search results for "{{ request('search') }}" with category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}"
                                @else
                                    Search results for "{{ request('search') }}" with author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                                @endif
                            @elseif(request('search'))
                                Search results for "{{ request('search') }}"
                            @elseif(request('tag_id') && request('category_id') && request('author_id'))
                                Filtered by tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}", category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}", and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                            @elseif(request('tag_id') && request('category_id'))
                                Filtered by tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}" and category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}"
                            @elseif(request('tag_id') && request('author_id'))
                                Filtered by tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}" and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                            @elseif(request('category_id') && request('author_id'))
                                Filtered by category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}" and author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                            @elseif(request('tag_id'))
                                Filtered by tag "{{ $tags->find(request('tag_id'))->name ?? 'Unknown' }}"
                            @elseif(request('category_id'))
                                Filtered by category "{{ $categories->find(request('category_id'))->name ?? 'Unknown' }}"
                            @else
                                Filtered by author "{{ $authors->find(request('author_id'))->name ?? 'Unknown' }}"
                            @endif
                        </small>
                    @endif
                </div>
                <div class="text-muted">
                    Showing {{ $submittedPosts->firstItem() ?? 1 }} to {{ $submittedPosts->lastItem() ?? $submittedPosts->count() }} 
                    of {{ $submittedPosts->total() }} posts
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author Name</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submittedPosts as $post)
                            <tr>
                                <td>
                                    <a href="#" class="text-decoration-none fw-medium">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                </td>
                                <td>{{ $post->user->name ?? 'Unknown' }}</td>
                                <td>{{ $post->created_at->format('M j, Y') }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" title="View Post">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <form action="{{ route('editor.posts.approve', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Approve Post" onclick="return confirm('Are you sure you want to approve this post?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Reject Post" 
                                            data-action="reject" data-post-id="{{ $post->id }}" data-post-title="{{ $post->title }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                        <a href="{{ route('editor.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Post">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No submitted posts found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($submittedPosts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $submittedPosts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.3); border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="rejectModalLabel" style="color: #dc3545; font-weight: 600;">
                    <i class="bi bi-x-circle me-2"></i>Reject Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" name="content_id" id="rejectContentId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="feedback" class="form-label" style="font-weight: 500; color: #333;">Rejection Feedback</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="4" required
                                  placeholder="Please provide detailed feedback for the author about why this post is being rejected..."
                                  style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;"></textarea>
                        <div class="form-text">Minimum 10 characters, maximum 500 characters.</div>
                    </div>
                    <div class="alert alert-warning" style="background: rgba(255, 193, 7, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> This feedback will be sent to the author to help them improve their post.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            style="background: rgba(108, 117, 125, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 8px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger" 
                            style="background: rgba(220, 53, 69, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(220, 53, 69, 0.3); border-radius: 8px;">
                        <i class="bi bi-x-lg me-2"></i>Reject Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Rejection Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle reject button clicks
    document.querySelectorAll('[data-action="reject"]').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const postTitle = this.dataset.postTitle;
            
            // Set the content ID
            document.getElementById('rejectContentId').value = postId;
            
            // Update modal title with post title
            document.getElementById('rejectModalLabel').innerHTML = 
                '<i class="bi bi-x-circle me-2"></i>Reject Post: ' + postTitle;
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        });
    });
    
    // Handle form submission
    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const contentId = document.getElementById('rejectContentId').value;
        const feedback = document.getElementById('feedback').value;
        
        // Create form data
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('feedback', feedback);
        
        // Submit the form
        fetch(`/editor/posts/${contentId}/reject`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
                
                // Reset form
                document.getElementById('rejectForm').reset();
                
                // Reload page to show updated data
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while rejecting the post.');
        });
    });
});
</script>
@endpush

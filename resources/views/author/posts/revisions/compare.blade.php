@extends('layouts.app')

@section('title', 'Compare Revisions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-code-branch me-2"></i>
            Compare Revisions
        </h2>
        <div>
            <a href="{{ route('author.posts.revisions', $post->id) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to History
            </a>
            <button type="button" class="btn btn-success me-2" onclick="restoreRevision({{ $revision->id }})">
                <i class="fas fa-undo"></i> Restore This Version
            </button>
            <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Post
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                Comparing: "{{ $post->title }}"
                <small class="text-muted">- Revision from {{ $revision->formatted_created_at }}</small>
            </h5>
        </div>
        <div class="card-body">
            <!-- Title Comparison -->
            <div class="mb-4">
                <h6 class="text-muted mb-3">Title Comparison</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <small class="text-muted">Old Version ({{ $revision->formatted_created_at }})</small>
                            </div>
                            <div class="card-body">
                                @foreach($titleDiff as $diff)
                                    @if($diff['type'] === 'removed')
                                        <div class="diff-removed">{{ $diff['line'] }}</div>
                                    @elseif($diff['type'] === 'unchanged')
                                        <div class="diff-unchanged">{{ $diff['line'] }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <small class="text-muted">Current Version</small>
                            </div>
                            <div class="card-body">
                                @foreach($titleDiff as $diff)
                                    @if($diff['type'] === 'added')
                                        <div class="diff-added">{{ $diff['line'] }}</div>
                                    @elseif($diff['type'] === 'unchanged')
                                        <div class="diff-unchanged">{{ $diff['line'] }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Comparison -->
            <div>
                <h6 class="text-muted mb-3">Content Comparison</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <small class="text-muted">Old Version ({{ $revision->formatted_created_at }})</small>
                            </div>
                            <div class="card-body">
                                @foreach($contentDiff as $diff)
                                    @if($diff['type'] === 'removed')
                                        <div class="diff-removed">{{ $diff['line'] }}</div>
                                    @elseif($diff['type'] === 'unchanged')
                                        <div class="diff-unchanged">{{ $diff['line'] }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <small class="text-muted">Current Version</small>
                            </div>
                            <div class="card-body">
                                @foreach($contentDiff as $diff)
                                    @if($diff['type'] === 'added')
                                        <div class="diff-added">{{ $diff['line'] }}</div>
                                    @elseif($diff['type'] === 'unchanged')
                                        <div class="diff-unchanged">{{ $diff['line'] }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.diff-removed {
    background-color: #ffebee;
    color: #c62828;
    padding: 2px 4px;
    border-radius: 3px;
    margin: 2px 0;
    text-decoration: line-through;
}

.diff-added {
    background-color: #e8f5e8;
    color: #2e7d32;
    padding: 2px 4px;
    border-radius: 3px;
    margin: 2px 0;
}

.diff-unchanged {
    padding: 2px 4px;
    margin: 2px 0;
    color: #666;
}

.card-body {
    max-height: 400px;
    overflow-y: auto;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    line-height: 1.4;
}

.diff-removed:empty,
.diff-added:empty,
.diff-unchanged:empty {
    display: none;
}
</style>

<script>
function restoreRevision(revisionId) {
    if (confirm('Are you sure you want to restore this version? Your current content will be saved as a new revision.')) {
        fetch(`/author/posts/{{ $post->id }}/restore/${revisionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Post restored successfully!');
                window.location.href = data.redirect;
            } else {
                alert('Error restoring post: ' + (data.message || 'Unknown error'));
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

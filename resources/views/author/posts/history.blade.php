@extends('layouts.app')

@section('title', 'Revision History')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Revision History</h2>
        <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Edit
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($revisions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revisions as $revision)
                                <tr>
                                    <td>{{ $revision->title }}</td>
                                    <td>{{ $revision->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('author.posts.revisions.compare', [$post->id, $revision->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-code-compare me-1"></i> Compare
                                        </a>
                                        <a href="{{ route('author.posts.restore', [$post->id, $revision->id]) }}" class="btn btn-sm btn-success" onclick="return confirm('Restore this revision? Current changes will be lost.')">
                                            <i class="fas fa-undo me-1"></i> Restore
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No revisions found</h4>
                    <p class="text-muted">This post doesn't have any revision history yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

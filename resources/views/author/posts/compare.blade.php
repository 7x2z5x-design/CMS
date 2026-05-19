@extends('layouts.app')

@section('title', 'Compare Revisions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Compare Revisions</h2>
        <a href="{{ route('author.posts.revisions', $post->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to History
        </a>
        <a href="{{ route('author.posts.history', $post->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-history me-2"></i> View All Revisions
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Previous Revision</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                <strong>Date:</strong> {{ $previousRevision->created_at->format('M d, Y H:i') }}
                            </p>
                            <div class="mb-3">
                                <h6>{{ $previousRevision->title }}</h6>
                                <div class="border p-3 rounded" style="background-color: #f8f9fa; min-height: 200px;">
                                    {{ $previousRevision->content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Current Revision</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                <strong>Date:</strong> {{ $currentRevision->created_at->format('M d, Y H:i') }}
                            </p>
                            <div class="mb-3">
                                <h6>{{ $currentRevision->title }}</h6>
                                <div class="border p-3 rounded" style="background-color: #e8f5e8; min-height: 200px;">
                                    {{ $currentRevision->content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

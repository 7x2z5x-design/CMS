@extends('layouts.app')

@section('title', 'View Post')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>View Post</h2>
        <div>
            <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-{{ $post->status == 'approved' ? 'success' : ($post->status == 'draft' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($post->status) }}
                </span>
                <small class="text-muted">Created: {{ $post->created_at->format('M d, Y') }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Description:</h5>
                    <p>{!! nl2br(e($post->description)) !!}</p>
                </div>
            </div>

            @if($post->categories->count() > 0)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Categories:</h5>
                        <div>
                            @foreach($post->categories as $category)
                                <span class="badge bg-info me-1">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($post->tags->count() > 0)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Tags:</h5>
                        <div>
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <h5>Post Details:</h5>
                    <ul>
                        <li><strong>Slug:</strong> {{ $post->slug }}</li>
                        <li><strong>Status:</strong> {{ ucfirst($post->status) }}</li>
                        <li><strong>Created:</strong> {{ $post->created_at->format('F d, Y \a\t g:i A') }}</li>
                        <li><strong>Last Updated:</strong> {{ $post->updated_at->format('F d, Y \a\t g:i A') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                <div>
                    <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>
                    <form action="{{ route('author.posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

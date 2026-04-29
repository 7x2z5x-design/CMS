@extends('layouts.app')

@section('title', 'Author Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome to Author Dashboard, {{ auth()->user()->name }}!</h2>
        <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Posts</h5>
                    <h2>{{ $stats['total_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Draft Posts</h5>
                    <h2>{{ $stats['draft_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Approved Posts</h5>
                    <h2>{{ $stats['approved_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #1a9e7a 0%, #2eb88a 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-eye me-2"></i>Total Views
                    </h5>
                    <h2>{{ number_format($stats['total_views']) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Your Latest Posts</h4>
        </div>
        <div class="card-body">
            @if($latestPosts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestPosts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $post->status == 'approved' ? 'success' : ($post->status == 'draft' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('author.posts.show', $post->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('author.posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-end">
                    <a href="{{ route('author.posts.index') }}" class="btn btn-outline-primary">View All Posts</a>
                </div>
            @else
                <p>You haven't created any posts yet.</p>
                <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create Your First Post</a>
            @endif
        </div>
    </div>
</div>
@endsection
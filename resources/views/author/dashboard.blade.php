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
            <h4>Your Draft Posts</h4>
        </div>
        <div class="card-body">
            @if($drafts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Post Title</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drafts as $draft)
                                <tr>
                                    <td>{{ $draft->title }}</td>
                                    <td>{{ $draft->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge" style="background-color: #FFC107; color: #000;">
                                            {{ ucfirst($draft->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('author.posts.edit', $draft->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('author.posts.destroy', $draft->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this draft?')">Delete</button>
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
                <p>No drafts found.</p>
                <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create a New Post</a>
            @endif
        </div>
    </div>
</div>
@endsection
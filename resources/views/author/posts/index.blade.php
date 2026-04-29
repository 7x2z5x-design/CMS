@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Posts</h2>
        <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('author.posts.index') }}" method="GET" class="row gx-3 gy-2 align-items-center">
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-text" style="background: linear-gradient(135deg, #1a9e7a 0%, #2eb88a 100%); border: 1px solid rgba(255,255,255,0.1); color: white; backdrop-filter: blur(10px);">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search posts (title & content)..." value="{{ request('search') }}" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-left: none;">
                    </div>
                </div>
                <div class="col-sm-2">
                    <select name="status" class="form-select" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="category_id" class="form-select" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <option value="">All Categories</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="tag_id" class="form-select" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <option value="">All Tags</option>
                        @if(isset($tags))
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #1a9e7a 0%, #2eb88a 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('author.posts.index') }}" class="btn btn-outline-secondary" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Categories</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Scheduled For</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        @if($post->categories->count() > 0)
                                            @foreach($post->categories as $category)
                                                <span class="badge bg-info me-1">{{ $category->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->tags->count() > 0)
                                            @foreach($post->tags as $tag)
                                                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $post->status == 'published' ? 'success' : ($post->status == 'scheduled' ? 'info' : ($post->status == 'draft' ? 'warning' : 'secondary')) }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($post->published_at)
                                            {{ $post->published_at->format('M d, Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('author.posts.analytics', $post->id) }}" class="btn btn-sm btn-success" style="background: linear-gradient(135deg, #1a9e7a, #2eb88a); border: none;">
                                            <i class="fas fa-chart-bar me-1"></i>Stats
                                        </a>
                                        <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('author.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $posts->links() }}
            @else
                <p>No posts found.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Post Analytics - ' . $post->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Post Analytics</h2>
            <p class="text-muted">{{ $post->title }}</p>
        </div>
        <div>
            <a href="{{ route('author.posts.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Posts
            </a>
            <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Post
            </a>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="row mb-4">
        <!-- Total Views Card -->
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #1a9e7a 0%, #2eb88a 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-eye fa-2x me-3"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Total Views</h5>
                            <h3 class="mb-0">{{ number_format($metrics['total_views']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engagement Level Card -->
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, {{ $metrics['engagement_level']['color'] }} 0%, {{ $metrics['engagement_level']['color'] }}dd 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="{{ $metrics['engagement_level']['icon'] }} fa-2x me-3"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Engagement</h5>
                            <h3 class="mb-0">{{ $metrics['engagement_level']['level'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Views Per Day Card -->
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-day fa-2x me-3"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Views/Day</h5>
                            <h3 class="mb-0">{{ $metrics['views_per_day'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Score Card -->
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line fa-2x me-3"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Performance</h5>
                            <h3 class="mb-0">{{ $metrics['performance_score'] }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="row">
        <!-- Post Information -->
        <div class="col-md-6">
            <div class="card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2" style="color: #1a9e7a;"></i>
                        Post Information
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Title:</strong></td>
                            <td>{{ $post->title }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $post->status === 'approved' ? 'success' : ($post->status === 'draft' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Categories:</strong></td>
                            <td>
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories as $category)
                                        <span class="badge bg-info me-1">{{ $category->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No categories</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Engagement Insights -->
        <div class="col-md-6">
            <div class="card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2" style="color: #1a9e7a;"></i>
                        Engagement Insights
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Performance Analysis</h6>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $metrics['performance_score'] }}%; background: linear-gradient(90deg, #1a9e7a, #2eb88a);"
                                 aria-valuenow="{{ $metrics['performance_score'] }}" 
                                 aria-valuemin="0" aria-valuemax="100">
                                {{ $metrics['performance_score'] }}%
                            </div>
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 style="color: #1a9e7a;">{{ $metrics['total_views'] }}</h4>
                            <small class="text-muted">Total Views</small>
                        </div>
                        <div class="col-4">
                            <h4 style="color: {{ $metrics['engagement_level']['color'] }};">{{ $metrics['engagement_level']['level'] }}</h4>
                            <small class="text-muted">Engagement</small>
                        </div>
                        <div class="col-4">
                            <h4 style="color: #667eea;">{{ $metrics['views_per_day'] }}</h4>
                            <small class="text-muted">Daily Average</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body text-center">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('author.posts.edit', $post->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Post
                        </a>
                        <a href="{{ route('public.post.show', $post->slug) }}" target="_blank" class="btn btn-outline-success">
                            <i class="fas fa-external-link-alt me-2"></i>View Post
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="fas fa-print me-2"></i>Print Analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}
</style>
@endsection

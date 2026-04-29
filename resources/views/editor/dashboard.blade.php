@extends('editor.layout')

@section('title', 'Editor Dashboard')
@section('page-title', 'Editor Dashboard')
@section('page-subtitle', 'Welcome to your content management workspace')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Welcome to Editor Dashboard, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">Manage content, review submissions, and optimize editorial workflows.</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary">
                <i class="ph ph-plus me-2"></i>Create New Content
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #FF6B35, #F7931E); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <h5 class="card-title">Total Content</h5>
                    <h2>{{ \App\Models\Content::where('content_type', 'post')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #FF8C42, #FFA500); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <h5 class="card-title">Pending Review</h5>
                    <h2>{{ \App\Models\Content::where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #FFB347, #FFCC80); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <h5 class="card-title">Published</h5>
                    <h2>{{ \App\Models\Content::where('status', 'approved')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #FFD700, #FFEB3B); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body">
                    <h5 class="card-title">Total Views</h5>
                    <h2>{{ \App\Models\Content::sum('views_count') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.scheduled.index') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-calendar me-2"></i>Scheduled
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.drafts.index') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-file-dotted me-2"></i>Drafts
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.reviews.index') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-eye me-2"></i>Reviews
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.analytics') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-chart-line me-2"></i>Analytics
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.seo.index') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-magnifying-glass me-2"></i>SEO
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <a href="{{ route('editor.import.index') }}" class="btn btn-outline-primary w-100">
                                <i class="ph ph-download-simple me-2"></i>Import
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Content</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentContent = \App\Models\Content::latest()->take(5)->get();
                                @endphp
                                @forelse($recentContent)
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No content found. Start creating content to see it here.
                                        </td>
                                    </tr>
                                @empty
                                    @foreach($recentContent as $content)
                                        <tr>
                                            <td>
                                                <a href="#" class="text-decoration-none">
                                                    {{ Str::limit($content->title, 50) }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $content->content_type }}</span>
                                            </td>
                                            <td>
                                                @if($content->status === 'approved')
                                                    <span class="badge badge-success">Published</span>
                                                @elseif($content->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($content->status === 'draft')
                                                    <span class="badge badge-secondary">Draft</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $content->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $content->created_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger">
                                                        <i class="ph ph-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Editor Overview</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Content Categories</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" style="width: 75%; background: linear-gradient(90deg, #FF6B35, #F7931E);"></div>
                        </div>
                        <small class="text-muted">15 of 20 categories active</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Review Queue</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" style="width: 30%; background: linear-gradient(90deg, #FF8C42, #FFA500);"></div>
                        </div>
                        <small class="text-muted">3 items pending review</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">SEO Score</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" style="width: 85%; background: linear-gradient(90deg, #FFB347, #FFCC80);"></div>
                        </div>
                        <small class="text-muted">85% optimization score</small>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('editor.analytics') }}" class="btn btn-primary">
                            <i class="ph ph-chart-line me-2"></i>View Full Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-refresh recent content every 30 seconds
setInterval(function() {
    // Implement auto-refresh if needed
}, 30000);
</script>
@endpush

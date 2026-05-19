@extends('layouts.app')

@section('title', 'Compare Revisions')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Compare Revisions</h2>
            <div class="text-muted">Post: {{ $content->title }}</div>
        </div>
        <div>
            <a href="{{ route('editor.posts.revisions', $content->id) }}" class="btn btn-secondary" 
               style="background: rgba(108, 117, 125, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 8px;">
                <i class="bi bi-arrow-left me-2"></i>Back to Revisions
            </a>
        </div>
    </div>

    <!-- Revision Info Cards -->
    <div class="row mb-4">
        <!-- Revision 1 -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(13, 202, 240, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(13, 202, 240, 0.3); border-radius: 8px;">
                <div class="card-header" style="background: rgba(13, 202, 240, 0.2); border-bottom: 1px solid rgba(13, 202, 240, 0.3); padding: 1rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="color: var(--clr-text-primary);">
                            <i class="ph ph-file-text me-2"></i>Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision1->id; }) + 1 }}
                        </h6>
                        <span class="badge bg-primary" style="background: var(--clr-primary-bg); color: var(--clr-primary);">
                            {{ $revision1->formatted_created_at }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Revision Details -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle" style="width: 32px; height: 32px; border-radius: 50%; background: var(--clr-primary-bg); color: var(--clr-primary); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.75rem; margin-right: 0.5rem;">
                            {{ strtoupper(substr($revision1->user->name ?? 'Unknown', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--clr-text-primary);">
                                {{ $revision1->user->name ?? 'Unknown' }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--clr-text-muted);">
                                {{ $revision1->user->role ?? 'Editor' }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Title</label>
                        <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary);">
                            {{ $revision1->title }}
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="mb-3">
                        <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Content</label>
                        <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary); min-height: 300px; white-space: pre-wrap; font-family: monospace; font-size: 0.875rem;">
                            {{ $revision1->content }}
                        </div>
                    </div>
                </div>
            </div>

        <!-- Revision 2 -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: rgba(25, 135, 84, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(25, 135, 84, 0.3); border-radius: 8px;">
                <div class="card-header" style="background: rgba(25, 135, 84, 0.2); border-bottom: 1px solid rgba(25, 135, 84, 0.3); padding: 1rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0" style="color: var(--clr-text-primary);">
                            <i class="ph ph-file-text me-2"></i>Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision2->id; }) + 1 }}
                        </h6>
                        <span class="badge bg-success" style="background: var(--clr-success-bg); color: var(--clr-success);">
                            {{ $revision2->formatted_created_at }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Revision Details -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle" style="width: 32px; height: 32px; border-radius: 50%; background: var(--clr-success-bg); color: var(--clr-success); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.75rem; margin-right: 0.5rem;">
                            {{ strtoupper(substr($revision2->user->name ?? 'Unknown', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--clr-text-primary);">
                                {{ $revision2->user->name ?? 'Unknown' }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--clr-text-muted);">
                                {{ $revision2->user->role ?? 'Editor' }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Title</label>
                        <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary);">
                            {{ $revision2->title }}
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="mb-3">
                        <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Content</label>
                        <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary); min-height: 300px; white-space: pre-wrap; font-family: monospace; font-size: 0.875rem;">
                            {{ $revision2->content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diff Legend -->
    <div class="card border-0 shadow-sm mt-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px;">
        <div class="card-body">
            <h6 style="color: var(--clr-text-primary); margin-bottom: 1rem;">
                <i class="ph ph-info-circle me-2"></i>Legend
            </h6>
            <div class="row">
                <div class="col-md-4">
                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                        <div style="width: 16px; height: 16px; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 4px; margin-right: 0.5rem;"></div>
                        <span style="color: var(--clr-text-primary);">Unchanged</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                        <div style="width: 16px; height: 16px; background: rgba(255, 193, 7, 0.2); border: 2px solid rgba(255, 193, 7, 0.3); border-radius: 4px; margin-right: 0.5rem;"></div>
                        <span style="color: var(--clr-text-primary);">Added</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                        <div style="width: 16px; height: 16px; background: rgba(220, 53, 69, 0.2); border: 2px solid rgba(220, 53, 69, 0.3); border-radius: 4px; margin-right: 0.5rem;"></div>
                        <span style="color: var(--clr-text-primary);">Removed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Line-by-Line Diff -->
    <div class="card border-0 shadow-sm mt-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px;">
        <div class="card-body">
            <h6 style="color: var(--clr-text-primary); margin-bottom: 1rem;">
                <i class="ph ph-git-compare me-2"></i>Line-by-Line Comparison
            </h6>
            <div style="background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; padding: 1rem; font-family: monospace; font-size: 0.875rem; max-height: 400px; overflow-y: auto;">
                @foreach($diff as $index => $line)
                    <div style="display: flex; {{ $line['type'] === 'changed' ? 'background: rgba(255, 193, 7, 0.1);' : ($line['type'] === 'added' ? 'background: rgba(25, 135, 84, 0.1);' : '') }}; padding: 0.25rem 0; border-radius: 4px;">
                        <!-- Line Number -->
                        <div style="width: 50px; padding-right: 1rem; color: var(--clr-text-muted); text-align: right; border-right: 1px solid var(--clr-border); user-select: none;">
                            {{ $index + 1 }}
                        </div>
                        
                        <!-- Line Content -->
                        <div style="flex: 1; padding: 0.25rem;">
                            @if($line['type'] === 'removed')
                                <span style="color: var(--clr-danger); text-decoration: line-through;">
                                    {{ $line['old'] }}
                                </span>
                            @elseif($line['type'] === 'added')
                                <span style="color: var(--clr-success);">
                                    {{ $line['new'] }}
                                </span>
                            @else
                                <span style="color: var(--clr-text-primary);">
                                    {{ $line['old'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card border-0 shadow-sm mt-4" style="background: rgba(13, 110, 253, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(13, 110, 253, 0.3); border-radius: 8px;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 style="color: var(--clr-text-primary); margin-bottom: 0;">
                        <i class="ph ph-lightning me-2"></i>Quick Actions
                    </h6>
                </div>
                <div>
                    <form method="POST" action="{{ route('editor.posts.revisions.restore', [$content->id, $revision1->id]) }}" 
                          style="display: inline;" 
                          onsubmit="return confirm('Are you sure you want to restore Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision1->id; }) + 1 }}?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary" 
                                style="border: 1px solid var(--clr-primary); color: var(--clr-primary); border-radius: 0.25rem;">
                            <i class="ph ph-arrow-counter-clockwise me-1"></i>Restore Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision1->id; }) + 1 }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('editor.posts.revisions.restore', [$content->id, $revision2->id]) }}" 
                          style="display: inline; margin-left: 0.5rem;" 
                          onsubmit="return confirm('Are you sure you want to restore Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision2->id; }) + 1 }}?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-success" 
                                style="border: 1px solid var(--clr-success); color: var(--clr-success); border-radius: 0.25rem;">
                            <i class="ph ph-arrow-counter-clockwise me-1"></i>Restore Revision {{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision2->id; }) + 1 }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

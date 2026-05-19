@extends('layouts.app')

@section('title', 'Revision History')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Revision History</h2>
            <div class="text-muted">Post: {{ $content->title }}</div>
        </div>
        <div>
            <a href="{{ route('editor.posts.edit', $content->id) }}" class="btn btn-secondary" 
               style="background: rgba(108, 117, 125, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 8px;">
                <i class="bi bi-pencil me-2"></i>Back to Edit
            </a>
        </div>
    </div>

    <!-- Revisions Table -->
    <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">All Revisions</h5>
                <div class="text-muted">
                    {{ $revisions->count() }} total revisions
                </div>
            </div>

            @if($revisions->isEmpty())
                <!-- Empty State -->
                <div style="text-align:center; padding:4rem 2rem; color:var(--clr-text-muted);">
                    <i class="ph ph-clock-counter-clockwise" style="font-size:3.5rem; opacity:0.25;"></i>
                    <h3 style="margin:1rem 0 0.5rem; font-size:1rem; color:var(--clr-text-secondary);">No revisions found</h3>
                    <p style="font-size:0.875rem;">Revisions will appear here when this post is edited.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr>
                                <th style="border-bottom: 2px solid var(--clr-border); color: var(--clr-text-primary); font-weight: 600;">Version</th>
                                <th style="border-bottom: 2px solid var(--clr-border); color: var(--clr-text-primary); font-weight: 600;">Title</th>
                                <th style="border-bottom: 2px solid var(--clr-border); color: var(--clr-text-primary); font-weight: 600;">Editor</th>
                                <th style="border-bottom: 2px solid var(--clr-border); color: var(--clr-text-primary); font-weight: 600;">Date</th>
                                <th style="border-bottom: 2px solid var(--clr-border); color: var(--clr-text-primary); font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $versionNumber = $revisions->count();
                            @endphp
                            @foreach($revisions as $revision)
                                <tr style="border-bottom: 1px solid var(--clr-border);">
                                    <td>
                                        <span class="badge bg-primary" style="background: var(--clr-primary-bg); color: var(--clr-primary);">
                                            v{{ $versionNumber-- }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500; color: var(--clr-text-primary);">
                                            {{ Str::limit($revision->title, 50) }}
                                        </div>
                                        @if(strlen($revision->title) > 50)
                                            <div style="font-size: 0.75rem; color: var(--clr-text-muted);">
                                                {{ $revision->title }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle" style="width: 32px; height: 32px; border-radius: 50%; background: var(--clr-primary-bg); color: var(--clr-primary); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.75rem; margin-right: 0.5rem;">
                                                {{ strtoupper(substr($revision->user->name ?? 'Unknown', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 500; color: var(--clr-text-primary);">
                                                    {{ $revision->user->name ?? 'Unknown' }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: var(--clr-text-muted);">
                                                    {{ $revision->user->role ?? 'Editor' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="color: var(--clr-text-primary);">
                                            {{ $revision->formatted_created_at }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('editor.posts.revisions.view', [$content->id, $revision->id]) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               style="border: 1px solid var(--clr-primary); color: var(--clr-primary); border-radius: 0.25rem;"
                                               title="View Revision">
                                                <i class="ph ph-eye"></i>
                                            </a>
                                            
                                            @if(!$loop->last)
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        style="border: 1px solid var(--clr-info); color: var(--clr-info); border-radius: 0.25rem;"
                                                        title="Compare with previous revision"
                                                        onclick="window.location.href='{{ route('editor.posts.revisions.compare', [$content->id, $revision->id, $loop->next->id]) }}'">
                                                    <i class="ph ph-git-compare"></i>
                                                </button>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('editor.posts.revisions.restore', [$content->id, $revision->id]) }}" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to restore this revision? A backup of the current version will be saved.')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        style="border: 1px solid var(--clr-success); color: var(--clr-success); border-radius: 0.25rem;"
                                                        title="Restore Revision">
                                                    <i class="ph ph-arrow-counter-clockwise"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Current Version Info -->
    <div class="card border-0 shadow-sm mt-4" style="background: rgba(13, 202, 240, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(13, 202, 240, 0.3); border-radius: 8px;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ph ph-info-circle me-3" style="font-size: 1.25rem; color: var(--clr-info);"></i>
                <div>
                    <strong style="color: var(--clr-text-primary);">Current Version:</strong> 
                    <span style="color: var(--clr-text-secondary);">The table above shows all saved revisions. Click "View" to see the content of a revision or "Restore" to restore it as the current version.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

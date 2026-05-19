@extends('layouts.app')

@section('title', 'View Revision')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>View Revision</h2>
            <div class="text-muted">Post: {{ $content->title }} (v{{ $content->revisions()->count() - $content->revisions()->search(function($item) use ($revision) { return $item->id === $revision->id; }) }})</div>
        </div>
        <div>
            <a href="{{ route('editor.posts.revisions', $content->id) }}" class="btn btn-secondary" 
               style="background: rgba(108, 117, 125, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 8px;">
                <i class="bi bi-arrow-left me-2"></i>Back to Revisions
            </a>
        </div>
    </div>

    <!-- Revision Info -->
    <div class="card border-0 shadow-sm mb-4" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 style="color: var(--clr-text-secondary); font-weight: 600; margin-bottom: 0.5rem;">Revision Details</h6>
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: var(--clr-primary-bg); color: var(--clr-primary); display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 1rem;">
                            {{ strtoupper(substr($revision->user->name ?? 'Unknown', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--clr-text-primary);">
                                {{ $revision->user->name ?? 'Unknown' }}
                            </div>
                            <div style="font-size: 0.875rem; color: var(--clr-text-muted);">
                                {{ $revision->user->role ?? 'Editor' }} • {{ $revision->formatted_created_at }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <form method="POST" action="{{ route('editor.posts.revisions.restore', [$content->id, $revision->id]) }}" 
                          onsubmit="return confirm('Are you sure you want to restore this revision? A backup of the current version will be saved.')">
                        @csrf
                        <button type="submit" class="btn btn-success" 
                                style="background: var(--clr-success); border: 1px solid var(--clr-success); border-radius: 8px;">
                            <i class="ph ph-arrow-counter-clockwise me-2"></i>Restore This Revision
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Revision Content -->
    <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <h5 style="color: var(--clr-text-primary); margin-bottom: 1rem;">Revision Content</h5>
            
            <!-- Title -->
            <div class="mb-4">
                <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Title</label>
                <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary);">
                    {{ $revision->title }}
                </div>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Content</label>
                <div style="padding: 1rem; background: var(--clr-input-bg); border: 2px solid var(--clr-border); border-radius: 8px; color: var(--clr-text-primary); min-height: 200px; white-space: pre-wrap;">
                    {{ $revision->content }}
                </div>
            </div>

            <!-- Readability Analysis -->
            <div class="mt-4">
                <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="ph ph-chart-line me-2"></i>Readability Analysis
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="display-6 fw-bold" style="color: {{ $readability['difficulty_color'] }};">
                                        {{ $readability['score'] }}
                                    </div>
                                    <div class="small text-muted">Score</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="h5 fw-bold" style="color: {{ $readability['difficulty_color'] }};">
                                        {{ $readability['difficulty'] }}
                                    </div>
                                    <div class="small text-muted">Difficulty</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="h5">{{ $readability['word_count'] }}</div>
                                    <div class="small text-muted">Words</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="h5">{{ $readability['sentence_count'] }}</div>
                                    <div class="small text-muted">Sentences</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-muted small">
                            <i class="ph ph-info me-1"></i>
                            Average {{ $readability['avg_words_per_sentence'] }} words per sentence • {{ $readability['character_count'] }} characters
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Notice -->
    <div class="card border-0 shadow-sm mt-4" style="background: rgba(255, 193, 7, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px;">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ph ph-warning-circle me-3" style="font-size: 1.25rem; color: var(--clr-warning);"></i>
                <div>
                    <strong style="color: var(--clr-text-primary);">Note:</strong> 
                    <span style="color: var(--clr-text-secondary);">This is a read-only view of the revision. To make changes, restore this revision and then edit the post.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

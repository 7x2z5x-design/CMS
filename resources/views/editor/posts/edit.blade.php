@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Post</h2>
        <div class="text-muted">
            Editing: {{ $content->title }}
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
        <div class="card-body">
            <form method="POST" action="{{ route('editor.posts.update', $content->id) }}">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">Post Title</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $content->title) }}"
                           required
                           maxlength="200"
                           style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                    <div class="form-text">Maximum 200 characters</div>
                </div>

                <!-- Content Field -->
                <div class="mb-4">
                    <label for="content" class="form-label fw-semibold">Post Content</label>
                    <textarea class="form-control" 
                              id="content" 
                              name="content" 
                              rows="12"
                              required
                              style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">{{ old('content', $content->content) }}</textarea>
                    <div class="form-text">Minimum 10 characters</div>
                </div>

                <!-- Readability Score -->
                <div class="mb-4">
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

                <!-- SEO Compliance Checklist -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="card-title mb-0">
                                    <i class="ph ph-seo-ranking me-2"></i>SEO Compliance
                                </h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge me-2" style="background-color: {{ App\Services\SEOComplianceService::getComplianceColor($seoCompliance['compliance_level']) }}; color: white;">
                                        {{ $seoCompliance['overall_score'] }}% - {{ $seoCompliance['compliance_level'] }}
                                    </span>
                                    <small class="text-muted">{{ $seoCompliance['passed_checks'] }}/{{ $seoCompliance['total_checks'] }} passed</small>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                @foreach($seoCompliance['checks'] as $checkName => $check)
                                <div class="d-flex align-items-start p-2 rounded" style="background-color: {{ $check['status'] === 'success' ? 'rgba(40, 167, 69, 0.1)' : ($check['status'] === 'warning' ? 'rgba(255, 193, 7, 0.1)' : 'rgba(220, 53, 69, 0.1)) }};">
                                    <div class="me-2">
                                        @if($check['passed'])
                                            <i class="ph ph-check-circle" style="color: #28a745; font-size: 1.2rem;"></i>
                                        @else
                                            <i class="ph ph-x-circle" style="color: #dc3545; font-size: 1.2rem;"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="small fw-semibold">
                                            @switch($checkName)
                                                @case('title_length')
                                                    Title Length (50-60 chars)
                                                    @break
                                                @case('has_h2_tag')
                                                    H2 Tag Presence
                                                    @break
                                                @case('focus_keyword_in_title')
                                                    Focus Keyword in Title
                                                    @break
                                                @case('focus_keyword_in_first_paragraph')
                                                    Focus Keyword in First Paragraph
                                                    @break
                                                @case('word_count')
                                                    Word Count (300+ words)
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="small text-muted">{{ $check['message'] }}</div>
                                    </div>
                                    <div class="text-end">
                                        <small class="badge" style="background-color: {{ $check['status'] === 'success' ? '#28a745' : ($check['status'] === 'warning' ? '#ffc107' : '#dc3545') }}; color: white;">
                                            {{ $check['current_value'] }} / {{ $check['target_range'] }}
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Field -->
                <div class="mb-4">
                    <label for="categories" class="form-label fw-semibold">Categories</label>
                    <select class="form-select" 
                            id="categories" 
                            name="categories[]" 
                            multiple
                            style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(200, 200, 200, 0.3); border-radius: 8px; min-height: 120px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ in_array($category->id, $content->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple categories</div>
                </div>

                <!-- Tags Field -->
                <div class="mb-4">
                    <label for="tags" class="form-label" style="font-weight: 600; color: var(--clr-text-primary); margin-bottom: 0.75rem; display: block;">Tags</label>
                    <div class="tag-select-container" style="position: relative;">
                        <select class="form-control" 
                                id="tags" 
                                name="tags[]" 
                                multiple
                                style="width: 100%; min-height: 120px; padding: 0.75rem; border: 2px solid var(--clr-border); border-radius: 0.5rem; background: var(--clr-input-bg); color: var(--clr-text-primary); font-size: 0.875rem; transition: all 0.3s ease;">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" 
                                        {{ in_array($tag->id, $content->tags->pluck('id')->toArray()) ? 'selected' : '' }}
                                        style="padding: 0.5rem; background: var(--clr-input-bg); color: var(--clr-text-primary);">
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-help" style="font-size: 0.75rem; color: var(--clr-text-muted); margin-top: 0.5rem;">
                            <i class="ph ph-info" style="font-size: 0.875rem;"></i> Hold Ctrl/Cmd to select multiple tags
                        </div>
                    </div>
                </div>

                <!-- Scheduling Field -->
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <input type="checkbox" id="schedule_post" name="schedule_post" value="1" 
                               class="form-check-input me-2" 
                               style="width: 1.25rem; height: 1.25rem; border: 2px solid var(--clr-border);">
                        <label for="schedule_post" class="form-check-label fw-semibold" 
                               style="color: var(--clr-text-primary); cursor: pointer;">
                            <i class="ph ph-clock me-2"></i>Schedule Post Publishing
                        </label>
                    </div>
                    <div id="schedule_options" style="display: none;">
                        <label for="scheduled_at" class="form-label" style="font-weight: 500; color: var(--clr-text-primary); margin-bottom: 0.5rem; display: block;">Schedule Date & Time</label>
                        <input type="datetime-local" 
                               id="scheduled_at" 
                               name="scheduled_at" 
                               class="form-control"
                               value="{{ old('scheduled_at') }}"
                               style="width: 100%; padding: 0.75rem; border: 2px solid var(--clr-border); border-radius: 0.5rem; background: var(--clr-input-bg); color: var(--clr-text-primary); font-size: 0.875rem;">
                        <div class="form-help" style="font-size: 0.75rem; color: var(--clr-text-muted); margin-top: 0.5rem;">
                            <i class="ph ph-info" style="font-size: 0.875rem;"></i> Select when this post should be automatically published
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('editor.dashboard') }}" class="btn btn-secondary" 
                       style="background: rgba(108, 117, 125, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 8px;">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <div>
                        <button type="submit" class="btn btn-primary" 
                                style="background: rgba(13, 110, 253, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(13, 110, 253, 0.3); border-radius: 8px;">
                            <i class="bi bi-check-lg me-2"></i>Save Changes
                        </button>
                    </div>
                </div>

                <!-- Revision Notice -->
                <div class="alert alert-info mt-3" style="background: rgba(13, 202, 240, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(13, 202, 240, 0.3); border-radius: 8px;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> A revision will be automatically saved before applying your changes.
                    <div class="mt-2">
                        <a href="{{ route('editor.posts.revisions', $content->id) }}" class="btn btn-sm btn-outline-primary" 
                           style="border: 1px solid rgba(13, 202, 240, 0.5); color: rgba(13, 202, 240, 0.8); border-radius: 6px;">
                            <i class="ph ph-clock-counter-clockwise me-1"></i>View Revision History
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle schedule checkbox toggle
    const scheduleCheckbox = document.getElementById('schedule_post');
    const scheduleOptions = document.getElementById('schedule_options');
    
    if (scheduleCheckbox && scheduleOptions) {
        scheduleCheckbox.addEventListener('change', function() {
            if (this.checked) {
                scheduleOptions.style.display = 'block';
                // Set minimum date to current time
                const now = new Date();
                const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                    .toISOString()
                    .slice(0, 16);
                document.getElementById('scheduled_at').min = localDateTime;
            } else {
                scheduleOptions.style.display = 'none';
                document.getElementById('scheduled_at').value = '';
            }
        });
    }
});
</script>
@endpush

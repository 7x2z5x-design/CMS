@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Create New Post</h2>
        <a href="{{ route('author.posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('author.posts.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="content_type" class="form-label">Post Type <span class="text-danger">*</span></label>
                    <select name="content_type" id="content_type" class="form-select @error('content_type') is-invalid @enderror" required>
                        <option value="post" {{ old('content_type') == 'post' ? 'selected' : '' }}>Standard Post</option>
                        <option value="image" {{ old('content_type') == 'image' ? 'selected' : '' }}>Image Post</option>
                        <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video Post</option>
                        <option value="audio" {{ old('content_type') == 'audio' ? 'selected' : '' }}>Resource/Document Post</option>
                    </select>
                    @error('content_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Media Library Selection -->
                <div class="mb-3">
                    <label class="form-label">Select from Media Library</label>
                    <div class="d-flex gap-2">
                        <select name="media_id" id="media_selector" class="form-select @error('media_id') is-invalid @enderror">
                            <option value="">-- Choose from Library --</option>
                            @if(auth()->check())
                                @php
                                    $availableMedia = \App\Models\Content::where('user_id', auth()->id())
                                        ->whereNotNull('file_path')
                                        ->where('content_type', '!=', 'video')
                                        ->latest()
                                        ->get();
                                @endphp
                                @foreach($availableMedia as $media)
                                    <option value="{{ $media->id }}" {{ old('media_id') == $media->id ? 'selected' : '' }}>
                                        {{ $media->title }} ({{ Str::limit($media->description, 30) }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <button type="button" class="btn btn-outline-primary" onclick="window.open('/author/media', '_blank')">
                            <i class="fas fa-folder-open"></i> Open Library
                        </button>
                    </div>
                    <small class="form-text text-muted">Select an existing file from your media library or upload new files below</small>
                    @error('media_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Dynamic fields based on post type -->
                <div class="mb-3" id="image-field" style="display: none;">
                    <label for="media_file" class="form-label">Upload Image</label>
                    <input type="file" name="media_file" id="media_file" class="form-control @error('media_file') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                    <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG (Max 10MB)</small>
                    @error('media_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="video-field" style="display: none;">
                    <label for="external_url" class="form-label">Video URL</label>
                    <input type="url" name="external_url" id="external_url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url') }}" placeholder="https://youtube.com/watch?v=...">
                    <small class="form-text text-muted">Enter YouTube, Vimeo, or other video URL</small>
                    @error('external_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="resource-field" style="display: none;">
                    <label for="external_url" class="form-label">Resource Link</label>
                    <input type="url" name="external_url" id="resource_url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url') }}" placeholder="https://example.com/resource">
                    <small class="form-text text-muted">Enter external resource URL</small>
                    @error('external_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3" id="document-field" style="display: none;">
                    <label for="media_file" class="form-label">Upload Document</label>
                    <input type="file" name="media_file" id="document_file" class="form-control @error('media_file') is-invalid @enderror" accept=".pdf,.docx,.doc">
                    <small class="form-text text-muted">Allowed formats: PDF, DOCX, DOC (Max 10MB)</small>
                    @error('media_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags') }}" placeholder="Enter tags separated by commas">
                    @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Categories</label>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-3 col-sm-4 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category_{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="published_at" class="form-label">Schedule Publishing (Optional)</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}">
                    <small class="form-text text-muted">Leave empty to publish immediately, or select a future date/time to schedule</small>
                    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="focus_keyword" class="form-label">Focus Keyword</label>
                    <input type="text" name="focus_keyword" id="focus_keyword" class="form-control @error('focus_keyword') is-invalid" placeholder="Enter your main keyword..." value="{{ old('focus_keyword') }}">
                    @error('focus_keyword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- SEO Insights Panel -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-search me-2"></i>
                                SEO Insights
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Focus Keyword</label>
                                        <input type="text" name="focus_keyword" id="focus_keyword" class="form-control @error('focus_keyword') is-invalid" placeholder="Enter your main keyword..." value="{{ old('focus_keyword') }}">
                                        @error('focus_keyword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <small class="text-muted">Keyword Analysis</small>
                                    </div>
                                    <div id="keyword-analysis">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-secondary me-2">No keyword</span>
                                            <small class="text-muted">Enter a keyword to see analysis</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Heading Structure Panel -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-heading me-2"></i>
                                Heading Structure
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <small class="text-muted">Heading Analysis</small>
                                    </div>
                                    <div id="heading-analysis">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-secondary me-2">No content</span>
                                            <small class="text-muted">Start typing to see analysis</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <small class="text-muted">Hierarchy Status</small>
                                    </div>
                                    <div id="hierarchy-status">
                                        <span class="badge bg-secondary me-2">Not checked</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Readability Score Display -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Readability Score</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-secondary me-2" id="readability-score">
                                            0.0/100
                                        </span>
                                        <small class="text-muted" id="readability-level">Not calculated</small>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted" id="readability-stats">
                                        0 words • 0 sentences
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeSelect = document.getElementById('content_type');
    const imageField = document.getElementById('image-field');
    const videoField = document.getElementById('video-field');
    const resourceField = document.getElementById('resource-field');
    const documentField = document.getElementById('document-field');

    function toggleFields() {
        const selectedType = contentTypeSelect.value;
        
        // Hide all fields first
        imageField.style.display = 'none';
        videoField.style.display = 'none';
        resourceField.style.display = 'none';
        documentField.style.display = 'none';
        
        // Show relevant field based on selection
        switch(selectedType) {
            case 'image':
                imageField.style.display = 'block';
                break;
            case 'video':
                videoField.style.display = 'block';
                break;
            case 'audio':
                resourceField.style.display = 'block';
                documentField.style.display = 'block';
                break;
            case 'post':
            default:
                // Only show content field for standard posts
                break;
        }
    }

    // Initial call
    toggleFields();
    
    // Listen for changes
    contentTypeSelect.addEventListener('change', toggleFields);
    
    // Real-time readability scoring
    const contentTextarea = document.getElementById('content');
    const scoreElement = document.getElementById('readability-score');
    const levelElement = document.getElementById('readability-level');
    const statsElement = document.getElementById('readability-stats');
    
    function updateReadabilityScore() {
        const content = contentTextarea.value;
        
        if (content.trim() === '') {
            scoreElement.textContent = '0.0/100';
            scoreElement.className = 'badge bg-secondary me-2';
            levelElement.textContent = 'Not calculated';
            statsElement.textContent = '0 words • 0 sentences';
            return;
        }
        
        // Simple calculation (similar to PHP service)
        const words = content.trim().split(/\s+/).filter(word => word.length > 0);
        const sentences = content.split(/[.!?]+/).filter(s => s.trim().length > 0);
        const wordCount = words.length;
        const sentenceCount = sentences.length;
        
        if (wordCount === 0 || sentenceCount === 0) {
            scoreElement.textContent = '0.0/100';
            scoreElement.className = 'badge bg-secondary me-2';
            levelElement.textContent = 'Not calculated';
            statsElement.textContent = '0 words • 0 sentences';
            return;
        }
        
        // Calculate average words per sentence
        const avgWordsPerSentence = wordCount / sentenceCount;
        
        // Simple syllable estimation (basic approximation)
        const syllableCount = words.reduce((total, word) => {
            const cleanWord = word.toLowerCase().replace(/[^a-z]/g, '');
            const vowelGroups = cleanWord.match(/[aeiouy]+/g);
            const syllables = vowelGroups ? vowelGroups.length : 0;
            return total + Math.max(1, syllables);
        }, 0);
        
        const avgSyllablesPerWord = syllableCount / wordCount;
        
        // Flesch Reading Ease Score
        let score = 206.835 - (1.015 * avgWordsPerSentence) - (84.6 * avgSyllablesPerWord);
        score = Math.max(0, Math.min(100, score));
        
        // Update display
        scoreElement.textContent = score.toFixed(1) + '/100';
        
        // Update color based on score
        if (score >= 80) {
            scoreElement.className = 'badge text-success me-2';
            levelElement.textContent = 'Easy to Read';
        } else if (score >= 60) {
            scoreElement.className = 'badge text-warning me-2';
            levelElement.textContent = 'Fairly Easy';
        } else {
            scoreElement.className = 'badge text-danger me-2';
            levelElement.textContent = 'Difficult';
        }
        
        statsElement.textContent = `${wordCount} words • ${sentenceCount} sentences`;
    }
    
    // Update score on content change
    contentTextarea.addEventListener('input', updateReadabilityScore);
    
    // Initial calculation
    updateReadabilityScore();
    
    // Update keyword analysis
    const keywordInput = document.getElementById('focus_keyword');
    keywordInput.addEventListener('input', updateKeywordAnalysis);
    
    // Initial calculation
    updateReadabilityScore();
    updateKeywordAnalysis();
    updateHeadingAnalysis();
}

function updateKeywordAnalysis() {
    const keywordInput = document.getElementById('focus_keyword');
    const keyword = keywordInput.value.trim();
    
    if (keyword === '') {
        document.getElementById('keyword-analysis').innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary me-2">No keyword</span>
                    <small class="text-muted">Enter a keyword to see analysis</small>
                </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary me-2">No keyword</span>
                    <small class="text-muted">Enter a keyword to see analysis</small>
                </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary me-2">No keyword</span>
                    <small class="text-muted">Enter a keyword to see analysis</small>
                </div>
        `;
        return;
    }
    
    // Simple calculation (similar to PHP service)
    const contentTextarea = document.getElementById('content');
    const content = contentTextarea.value.trim();
    const words = content.split(/\s+/).filter(word => word.length > 0);
    const totalWords = words.length;
    const keywordCount = content.toLowerCase().split(keyword.toLowerCase()).length - 1;
    const density = totalWords > 0 ? round((keywordCount / totalWords) * 100, 2) : 0;
    
    const analysis = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-secondary me-2">${keyword}</span>
                <small class="text-muted">In Title: <i class="fas fa-times text-danger"></i></small>
                <span class="badge bg-secondary me-2">${keywordCount}</span>
                <small class="text-muted">times</small>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-secondary me-2">${keywordCount}</span>
                <small class="text-muted">times in Content</small>
                <span class="badge {{ \App\Services\KeywordAnalysisService::getDensityColor(density) }} me-2">${density}%</span>
                <small class="text-muted">Density</small>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-secondary me-2">${totalWords}</span>
                <small class="text-muted">Total Words</small>
        </div>
    `;
    
    document.getElementById('keyword-analysis').innerHTML = analysis;
}

function updateHeadingAnalysis() {
    const contentTextarea = document.getElementById('content');
    const content = contentTextarea.value.trim();
    
    if (content === '') {
        document.getElementById('heading-analysis').innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary me-2">No content</span>
                    <small class="text-muted">Start typing to see analysis</small>
                </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary me-2">Not checked</span>
                    <small class="text-muted">Enter content to see analysis</small>
                </div>
        `;
        return;
    }
    
    // Simple heading extraction (similar to PHP service)
    const headingRegex = /<h([1-6])[^>]*>(.*?)<\/h\1>/gi;
    const matches = content.match(headingRegex) || [];
    
    const counts = {h1: 0, h2: 0, h3: 0, h4: 0, h5: 0, h6: 0};
    const issues = [];
    let lastLevel = 0;
    
    matches.forEach(match => {
        const level = parseInt(match.match(/<h([1-6])/i)[1]);
        counts['h' + level]++;
        lastLevel = level;
    });
    
    // Check for multiple H1 tags
    if (counts.h1 > 1) {
        issues.push('Multiple H1 tags detected');
    }
    
    // Check heading hierarchy
    for (let i = 1; i < matches.length; i++) {
        if (matches[i] && matches[i-1]) {
            const currentLevel = parseInt(matches[i].match(/<h([1-6])/i)[1]);
            const prevLevel = parseInt(matches[i-1].match(/<h([1-6])/i)[1]);
            if (currentLevel > prevLevel) {
                issues.push(`H${currentLevel} used before H${prevLevel}`);
            }
        }
    }
    
    const hierarchy = issues.length === 0 ? 'valid' : 'invalid';
    const hierarchyColor = hierarchy === 'valid' ? 'text-success' : 'text-warning';
    
    // Build summary
    let summary = '';
    if (matches.length > 0) {
        summary = `H1: ${counts.h1}, H2: ${counts.h2}, H3: ${counts.h3}`;
        if (counts.h4 > 0 || counts.h5 > 0 || counts.h6 > 0) {
            summary += `, H4: ${counts.h4}, H5: ${counts.h5}, H6: ${counts.h6}`;
        }
    } else {
        summary = 'No headings found';
    }
    
    const analysis = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-secondary me-2">${summary}</span>
                <small class="text-muted">Heading summary</small>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge ${hierarchyColor} me-2">${hierarchy}</span>
                <small class="text-muted">Hierarchy status</small>
        </div>
    `;
    
    if (issues.length > 0) {
        const issuesHtml = issues.map(issue => `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge text-danger me-2">⚠️ ${issue}</span>
                    <small class="text-muted">Issue</small>
                </div>
        `).join('');
        
        document.getElementById('heading-analysis').innerHTML = analysis + issuesHtml;
    } else {
        document.getElementById('heading-analysis').innerHTML = analysis;
    }
}
</script>
@endsection

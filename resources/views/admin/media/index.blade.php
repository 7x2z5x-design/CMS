@extends('admin.layout')

@section('title', 'Media Management')

@section('content')
<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="2">
                    <path d="M23 19l-8-7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                    <polyline points="23 19 15 13 7 13 7 19"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Media</div>
                <div class="stat-number">{{ $totalMedia ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 0 20 20v-1a9 9 0 0 1 20 20z"></path>
                    <polyline points="22 4 12 4 2 4"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Images</div>
                <div class="stat-number">{{ $totalImages ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="14 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Videos</div>
                <div class="stat-number">{{ $totalVideos ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Documents</div>
                <div class="stat-number">{{ $totalDocuments ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Storage Used</div>
                <div class="stat-number">{{ $storageUsed ?? '0 MB' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;">
    <div style="display: flex; gap: 1rem; align-items: center; flex: 1;">
        <form method="GET" style="display: flex; gap: 1rem; align-items: center; flex: 1;">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search media files..." 
                style="padding: 0.75rem 1rem; border: 1px solid #E5E7EB; border-radius: 0.5rem; background: white; min-width: 250px;"
            >
            <button type="submit" style="padding: 0.75rem 1rem; background: #6B7B3A; color: white; border: none; border-radius: 0.5rem; cursor: pointer;">
                <i class="ph ph-magnifying-glass"></i> Filter
            </button>
        </form>
        
        <select 
            name="type" 
            onchange="this.form.submit()" 
            style="padding: 0.75rem 1rem; border: 1px solid #E5E7EB; border-radius: 0.5rem; background: white;"
        >
            <option value="">All Types</option>
            <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}">Images</option>
            <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}">Videos</option>
            <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}">Documents</option>
        </select>
    </div>
    
    <a href="{{ route('admin.media.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s;">
        <i class="ph ph-upload"></i> Upload Media
    </a>
</div>

<!-- Media Grid -->
<section class="table-section">
    <div class="table-container">
        @if(isset($mediaFiles) && $mediaFiles->count() > 0)
            <div class="media-grid">
                @foreach($mediaFiles as $media)
                    <div class="media-card">
                        <div class="media-preview">
                            @if($media->media_type === 'image' && $media->file_path)
                                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->alt_text ?? $media->title ?? basename($media->file_path) }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                            @elseif($media->media_type === 'video' && $media->file_path)
                                <div class="video-preview" style="width: 100%; height: 200px; background: #f0ede4; border-radius: 8px; display: flex; align-items: center; justify-content: center; position: relative;">
                                    <i class="ph ph-video-camera" style="font-size: 3rem; color: #6B7B3A;"></i>
                                    <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                        VIDEO
                                    </div>
                                </div>
                            @elseif($media->media_type === 'video_link' && $media->url)
                                <div class="video-link-preview" style="width: 100%; height: 200px; background: #f0ede4; border-radius: 8px; display: flex; align-items: center; justify-content: center; position: relative;">
                                    @if($media->thumbnail)
                                        <img src="{{ $media->thumbnail }}" alt="{{ $media->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <i class="ph ph-play-circle" style="font-size: 3rem; color: #6B7B3A;"></i>
                                    @endif
                                    <div style="position: absolute; top: 8px; left: 8px; background: rgba(107,123,58,0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                        VIDEO LINK
                                    </div>
                                </div>
                            @elseif($media->media_type === 'document')
                                <div class="document-preview" style="width: 100%; height: 200px; background: #f0ede4; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ph ph-file-text" style="font-size: 3rem; color: #6B7B3A;"></i>
                                    <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                        {{ strtoupper($media->extension ?? 'DOC') }}
                                    </div>
                                </div>
                            @elseif($media->media_type === 'resource_link' && $media->url)
                                <div class="resource-preview" style="width: 100%; height: 200px; background: #f0ede4; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ph ph-link" style="font-size: 3rem; color: #6B7B3A;"></i>
                                    <div style="position: absolute; top: 8px; left: 8px; background: rgba(107,123,58,0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                        RESOURCE
                                    </div>
                                </div>
                            @else
                                <div class="default-preview" style="width: 100%; height: 200px; background: #f0ede4; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ph ph-file" style="font-size: 3rem; color: #6B7B3A;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="media-info">
                            <div class="media-name">{{ $media->title ?: basename($media->file_path ?: $media->url) }}</div>
                            @if($media->description)
                                <div class="media-description" style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">{{ Str::limit($media->description, 50) }}</div>
                            @endif
                            <div class="media-meta">
                                <span class="meta-item">
                                    <i class="ph ph-folder"></i>
                                    {{ $media->folder ?? 'Media' }}
                                </span>
                                <span class="meta-item">
                                    <i class="ph ph-calendar"></i>
                                    {{ $media->created_at->format('M d, Y') }}
                                </span>
                                <span class="meta-item">
                                    <i class="ph ph-scales"></i>
                                    {{ number_format($media->size / 1024, 2) }} KB
                                </span>
                            </div>
                            <div class="media-actions">
                                <button class="action-btn edit" title="Edit Media">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                        <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn delete" title="Delete Media" onclick="confirmDelete({{ $media->id }}, '{{ basename($media->file_path) }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                {{ $mediaFiles->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 4rem 2rem;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="1" style="opacity: 0.3;">
                    <path d="M23 19l-8-7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                    <polyline points="23 19 15 13 7 13 7 19"></polyline>
                </svg>
                <h3 style="color: #6B7B3A; margin: 1rem 0; font-size: 1.25rem;">No media files yet</h3>
                <p style="color: #6B7280; margin: 0;">Upload your first media file to get started.</p>
                <a href="{{ route('admin.media.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s; margin-top: 1rem;">
                    <i class="ph ph-upload"></i> Upload First Media
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@extends('admin.layout')

@section('title', 'Content Management')

@section('content')
<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="14 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Posts</div>
                <div class="stat-number">{{ $totalPosts ?? 0 }}</div>
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
                <div class="stat-label">Published</div>
                <div class="stat-number">{{ $publishedPosts ?? 0 }}</div>
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
                <div class="stat-label">Drafts</div>
                <div class="stat-number">{{ $draftPosts ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Scheduled</div>
                <div class="stat-number">{{ $scheduledPosts ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2">
                    <path d="M13 2L3 14h9v11l9-11z"></path>
                    <polyline points="13 2 3 14 3 14"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Archived</div>
                <div class="stat-number">{{ $archivedPosts ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 0 20 20v-1a9 9 0 0 1 20 20z"></path>
                    <polyline points="22 4 12 4 2 4"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Views</div>
                <div class="stat-number">{{ number_format($totalViews ?? 0) }}</div>
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
                placeholder="Search content..." 
                style="padding: 0.75rem 1rem; border: 1px solid #E5E7EB; border-radius: 0.5rem; background: white; min-width: 250px;"
            >
            <button type="submit" style="padding: 0.75rem 1rem; background: #6B7B3A; color: white; border: none; border-radius: 0.5rem; cursor: pointer;">
                <i class="ph ph-magnifying-glass"></i> Filter
            </button>
        </form>
        
        <select 
            name="status" 
            onchange="this.form.submit()" 
            style="padding: 0.75rem 1rem; border: 1px solid #E5E7EB; border-radius: 0.5rem; background: white;"
        >
            <option value="">All Status</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}">Published</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}">Draft</option>
            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}">Scheduled</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}">Archived</option>
        </select>
        
        <select 
            name="category" 
            onchange="this.form.submit()" 
            style="padding: 0.75rem 1rem; border: 1px solid #E5E7EB; border-radius: 0.5rem; background: white;"
        >
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    
    <a href="{{ route('admin.content.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s;">
        <i class="ph ph-plus"></i> Create Content
    </a>
</div>

<!-- Content Table -->
<section class="table-section">
    <div class="table-container">
        @if(isset($contents) && $contents->count() > 0)
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Published Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                        <tr class="table-row">
                            <td>
                                <div class="user-name">{{ $content->title }}</div>
                                @if($content->excerpt)
                                    <div class="user-email">{{ \Illuminate\Support\Str::limit($content->excerpt, 80) }}</div>
                                @endif
                            </td>
                            <td>
                                @if($content->category)
                                    <span class="role-badge editor">{{ $content->category->name }}</span>
                                @else
                                    <span class="role-badge">Uncategorized</span>
                                @endif
                            </td>
                            <td>
                                <div class="user-name">{{ $content->author->name ?? 'Unknown' }}</div>
                                <div class="user-email">{{ $content->author->email ?? 'unknown@example.com' }}</div>
                            </td>
                            <td>
                                <button 
                                    class="status-toggle" 
                                    data-id="{{ $content->id }}" 
                                    data-status="{{ $content->status }}"
                                    style="background: {{ $content->status === 'published' ? '#10B981' : ($content->status === 'draft' ? '#F59E0B' : ($content->status === 'scheduled' ? '#8B5CF6' : '#6B7280')) }}; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 12px; cursor: pointer; font-size: 0.875rem; font-weight: 600; transition: all 0.3s;"
                                >
                                    {{ ucfirst($content->status) }}
                                </button>
                            </td>
                            <td>
                                <span class="role-badge">{{ number_format($content->views ?? 0) }}</span>
                            </td>
                            <td>
                                <div class="joined-date">{{ $content->published_at ? $content->published_at->format('M d, Y') : 'Not published' }}</div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.content.edit', $content) }}" class="action-btn edit" title="Edit Content">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                            <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                        </svg>
                                    </a>
                                    <button 
                                        class="action-btn delete" 
                                        title="Delete Content"
                                        onclick="confirmDelete({{ $content->id }}, '{{ $content->title }}')"
                                    >
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                {{ $contents->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 4rem 2rem;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="1" style="opacity: 0.3;">
                    <path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="14 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <h3 style="color: #6B7B3A; margin: 1rem 0; font-size: 1.25rem;">No content found</h3>
                <p style="color: #6B7280; margin: 0;">Create your first content to get started.</p>
                <a href="{{ route('admin.content.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s; margin-top: 1rem;">
                    <i class="ph ph-plus"></i> Create First Content
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
function confirmDelete(id, title) {
    if (confirm(`Are you sure you want to delete '${title}'? This cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/content/${id}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Status toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const statusBadges = document.querySelectorAll('.status-toggle');
    
    statusBadges.forEach(badge => {
        badge.addEventListener('click', function(e) {
            e.preventDefault();
            
            const postId = this.dataset.id;
            const currentStatus = this.dataset.status;
            
            fetch(`/admin/content/${postId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update badge appearance
                    this.dataset.status = data.status;
                    const colors = {
                        'published': '#10B981',
                        'draft': '#F59E0B',
                        'scheduled': '#8B5CF6',
                        'archived': '#6B7280'
                    };
                    this.style.background = colors[data.status] || '#6B7280';
                    this.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    
                    // Show success message
                    showToast(data.message, 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating status', 'error');
            });
        });
    });
});

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>
@endpush
@endsection

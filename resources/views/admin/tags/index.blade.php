@extends('admin.layout')

@section('title', 'Tag Management')

@section('content')
<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="2">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 2.83l-7.17 7.17a2 2 0 0 1-2.83 2.83z"></path>
                    <line x1="7" y1="7" x2="17" y2="7"></line>
                    <line x1="17" y1="11" x2="7" y2="11"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Tags</div>
                <div class="stat-number">{{ $totalTags ?? 0 }}</div>
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
                <div class="stat-label">Active Tags</div>
                <div class="stat-number">{{ $activeTags ?? 0 }}</div>
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
                <div class="stat-label">Inactive Tags</div>
                <div class="stat-number">{{ $inactiveTags ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                    <path d="M16 21H5a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="16 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Posts Tagged</div>
                <div class="stat-number">{{ $totalPostsTagged ?? 0 }}</div>
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
                placeholder="Search tags..." 
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
            <option value="">All</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}">Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}">Inactive</option>
        </select>
    </div>
    
    <a href="{{ route('admin.tags.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s;">
        <i class="ph ph-plus"></i> Add New Tag
    </a>
</div>

<!-- Tags Table -->
<section class="table-section">
    <div class="table-container">
        @if(isset($tags) && $tags->count() > 0)
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Tag Name</th>
                        <th>Slug</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr class="table-row">
                            <td>
                                <div class="user-name">{{ $tag->name }}</div>
                            </td>
                            <td>
                                <code style="background: #f0ede4; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">
                                    {{ $tag->slug }}
                                </code>
                            </td>
                            <td>
                                <div class="joined-date">{{ $tag->created_at ? $tag->created_at->format('M d, Y') : 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.tags.edit', $tag) }}" class="action-btn edit" title="Edit Tag">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                            <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                                        </svg>
                                    </a>
                                    <button 
                                        class="action-btn delete" 
                                        title="Delete Tag"
                                        onclick="confirmDelete({{ $tag->id }}, '{{ $tag->name }}')"
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
                {{ $tags->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 4rem 2rem;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="1" style="opacity: 0.3;">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 2.83l-7.17 7.17a2 2 0 0 1-2.83 2.83z"></path>
                    <line x1="7" y1="7" x2="17" y2="7"></line>
                    <line x1="17" y1="11" x2="7" y2="11"></line>
                </svg>
                <h3 style="color: #6B7B3A; margin: 1rem 0; font-size: 1.25rem;">No tags yet</h3>
                <p style="color: #6B7280; margin: 0;">Create your first tag to organize your content.</p>
                <a href="{{ route('admin.tags.create') }}" style="display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; background: #6B7B3A; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: all 0.3s; margin-top: 1rem;">
                    <i class="ph ph-plus"></i> Create First Tag
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@extends('admin.layout')

@section('title', 'Dashboard Overview')
@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening with your platform.')

@section('content')

{{-- ============================================================
     STAT CARDS
     ============================================================ --}}
<section class="stats-section fade-in">
    <div class="stats-grid">

        {{-- Total Users --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon purple">
                    <i class="ph-fill ph-users"></i>
                </div>
                <span class="stat-badge positive">+12%</span>
            </div>
            <div class="stat-label">Total Users</div>
            <div class="stat-number">{{ number_format($totalUsers ?? 0) }}</div>
        </div>

        {{-- Active Users --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon green">
                    <i class="ph-fill ph-user-check"></i>
                </div>
                <span class="stat-badge neutral">Stable</span>
            </div>
            <div class="stat-label">Active Now</div>
            <div class="stat-number">{{ number_format($activeUsers ?? 0) }}</div>
        </div>

        {{-- Inactive Users --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon red">
                    <i class="ph-fill ph-user-minus"></i>
                </div>
                <span class="stat-badge negative">-3%</span>
            </div>
            <div class="stat-label">Inactive</div>
            <div class="stat-number">{{ number_format($inactiveUsers ?? 0) }}</div>
        </div>

        {{-- Total Posts --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon blue">
                    <i class="ph-fill ph-article"></i>
                </div>
                <span class="stat-badge positive">+8%</span>
            </div>
            <div class="stat-label">Total Posts</div>
            <div class="stat-number">{{ number_format($totalPosts ?? 0) }}</div>
        </div>

        {{-- Categories --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon amber">
                    <i class="ph-fill ph-folder"></i>
                </div>
                <span class="stat-badge neutral">Stable</span>
            </div>
            <div class="stat-label">Categories</div>
            <div class="stat-number">{{ number_format($totalCategories ?? 0) }}</div>
        </div>

        {{-- Tags --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon teal">
                    <i class="ph-fill ph-tag"></i>
                </div>
                <span class="stat-badge positive">+5%</span>
            </div>
            <div class="stat-label">Tags</div>
            <div class="stat-number">{{ number_format($totalTags ?? 0) }}</div>
        </div>

    </div>
</section>

{{-- ============================================================
     RECENT REGISTRATIONS TABLE
     ============================================================ --}}
<section class="table-section fade-in">

    <div class="table-header">
        <div>
            <h2>Recent Registrations</h2>
            <p style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;">
                Manage your workspace members and their access levels.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="ph ph-plus"></i> Add New User
        </a>
    </div>

    @if(isset($recentUsers) && count($recentUsers) > 0)
        <table class="user-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $index => $user)
                    @php
                        $colorClass = 'color-' . (($index % 5) + 1);
                        $initials = strtoupper(substr($user->name, 0, 1))
                                  . strtoupper(substr(explode(' ', $user->name)[1] ?? 'A', 0, 1));
                    @endphp
                    <tr class="table-row">
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-initials {{ $colorClass }}">{{ $initials }}</div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'Admin')
                                <span class="role-badge admin">Admin</span>
                            @elseif($user->role == 'Editor')
                                <span class="role-badge editor">Editor</span>
                            @else
                                <span class="role-badge">Viewer</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'Active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <span class="joined-date">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="action-btn edit" title="Edit User">
                                    <i class="ph ph-pencil-simple"></i>
                                </a>
                                <button
                                    class="action-btn delete"
                                    title="Delete User"
                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Empty State --}}
        <div style="text-align:center; padding:4rem 2rem; color:var(--text-muted);">
            <i class="ph ph-users" style="font-size:3.5rem; opacity:0.25;"></i>
            <h3 style="margin:1rem 0 0.5rem; font-size:1rem; color:var(--text-secondary);">No recent registrations</h3>
            <p style="font-size:0.875rem;">New user registrations will appear here.</p>
        </div>
    @endif

    <div style="display:flex; justify-content:center; padding:1.25rem; border-top:1px solid var(--border);">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="ph ph-users"></i> View All Users
        </a>
    </div>

</section>

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Are you sure you want to delete '${name}'? This cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}`;
        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]').content;
        const method = document.createElement('input');
        method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@endsection
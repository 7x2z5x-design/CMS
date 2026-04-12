@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- ════════════════════════════════════════
     DASHBOARD
════════════════════════════════════════ --}}

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-inner">
        <div>
            <h1 class="page-title">Welcome back, {{ $user->FullName ?? $user->Username ?? 'Blogger' }}! 👋</h1>
            <p class="page-subtitle">Here's what's happening with your blog today.</p>
        </div>
        @if(Route::has('posts.create'))
        <a href="{{ route('posts.create') }}" class="btn btn-primary" style="flex-shrink:0;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Post
        </a>
        @endif
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="grid grid-cols-4 gap-md mb-2xl">
    {{-- Total Posts --}}
    <div class="stat-card">
        <div class="flex-between mb-md">
            <div class="stat-card-label">Total Posts</div>
            <div class="stat-card-icon" style="background:var(--clr-primary-bg);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--clr-primary)" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-value">42</div>
        <div class="stat-card-trend up">↑ 12% from last month</div>
    </div>

    {{-- Total Views --}}
    <div class="stat-card">
        <div class="flex-between mb-md">
            <div class="stat-card-label">Total Views</div>
            <div class="stat-card-icon" style="background:var(--clr-info-bg);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--clr-info)" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
        </div>
        <div class="stat-card-value" style="color:var(--clr-info);">8.5K</div>
        <div class="stat-card-trend up">↑ 8% from last month</div>
    </div>

    {{-- Active Readers --}}
    <div class="stat-card">
        <div class="flex-between mb-md">
            <div class="stat-card-label">Active Readers</div>
            <div class="stat-card-icon" style="background:var(--clr-warning-bg);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--clr-warning)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-card-value" style="color:var(--clr-warning);">342</div>
        <div class="stat-card-trend up">↑ 24% from last week</div>
    </div>

    {{-- Comments --}}
    <div class="stat-card">
        <div class="flex-between mb-md">
            <div class="stat-card-label">Comments</div>
            <div class="stat-card-icon" style="background:var(--clr-danger-bg);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--clr-danger)" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-value" style="color:var(--clr-danger);">156</div>
        <div class="stat-card-trend up">↑ 5 new today</div>
    </div>
</div>

{{-- ── Two-column section ── --}}
<div class="grid grid-cols-2 gap-lg mb-2xl">

    {{-- Recent Posts Card --}}
    <div class="card">
        <div class="card-header">
            <div class="flex-between">
                <h4 class="mb-0">Recent Posts</h4>
                @if(Route::has('posts.index'))
                <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm">View All</a>
                @endif
            </div>
        </div>
        {{-- Post list items --}}
        <div>
            <div style="padding: var(--sp-5) var(--sp-6); border-bottom: 1px solid var(--clr-border);">
                <div class="flex-between">
                    <div style="flex:1; min-width:0;">
                        <p class="fw-semibold mb-xs" style="color:var(--clr-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">How to Master Web Design in 2026</p>
                        <div class="flex gap-sm" style="align-items:center;">
                            <span class="badge badge-success">Published</span>
                            <span class="text-xs text-muted">2 days ago</span>
                        </div>
                    </div>
                    <div style="text-align:right; flex-shrink:0; margin-left:var(--sp-4);">
                        <p class="fw-bold mb-0" style="color:var(--clr-text);">2.4K</p>
                        <p class="text-xs text-muted" style="margin:0;">views</p>
                    </div>
                </div>
            </div>
            <div style="padding: var(--sp-5) var(--sp-6); border-bottom: 1px solid var(--clr-border);">
                <div class="flex-between">
                    <div style="flex:1; min-width:0;">
                        <p class="fw-semibold mb-xs" style="color:var(--clr-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">10 Tips for Better Content Writing</p>
                        <div class="flex gap-sm" style="align-items:center;">
                            <span class="badge badge-gray">Draft</span>
                            <span class="text-xs text-muted">5 days ago</span>
                        </div>
                    </div>
                    <div style="text-align:right; flex-shrink:0; margin-left:var(--sp-4);">
                        <p class="fw-bold mb-0" style="color:var(--clr-text);">1.8K</p>
                        <p class="text-xs text-muted" style="margin:0;">views</p>
                    </div>
                </div>
            </div>
            <div style="padding: var(--sp-5) var(--sp-6);">
                <div class="flex-between">
                    <div style="flex:1; min-width:0;">
                        <p class="fw-semibold mb-xs" style="color:var(--clr-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">Latest SEO Trends for Bloggers</p>
                        <div class="flex gap-sm" style="align-items:center;">
                            <span class="badge badge-warning">Pending</span>
                            <span class="text-xs text-muted">1 week ago</span>
                        </div>
                    </div>
                    <div style="text-align:right; flex-shrink:0; margin-left:var(--sp-4);">
                        <p class="fw-bold mb-0" style="color:var(--clr-text);">892</p>
                        <p class="text-xs text-muted" style="margin:0;">views</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Account Info Card --}}
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Account Information</h4>
        </div>
        <div class="card-body">
            {{-- Avatar --}}
            <div style="text-align:center; margin-bottom:var(--sp-6);">
                @if($user->ProfilePicture)
                    <img src="{{ str_contains($user->ProfilePicture, 'http') ? $user->ProfilePicture : asset('storage/' . $user->ProfilePicture) }}"
                         alt="Profile"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto var(--sp-3);box-shadow:var(--shadow-md);border:3px solid var(--clr-primary-bg);">
                @else
                    <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--clr-primary),var(--clr-primary-light));display:flex;align-items:center;justify-content:center;margin:0 auto var(--sp-3);font-size:2rem;color:white;font-weight:800;">
                        {{ strtoupper(substr($user->Username ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <h5 class="mb-0">{{ $user->FullName ?? $user->Username }}</h5>
                <span class="badge badge-primary" style="margin-top:var(--sp-2);">{{ ucfirst($user->role ?? 'Blogger') }}</span>
            </div>

            {{-- Details --}}
            <div style="display:grid; gap:var(--sp-3); margin-bottom:var(--sp-5);">
                <div style="display:flex; justify-content:space-between; padding:var(--sp-3) var(--sp-4); background:var(--clr-surface-2); border-radius:var(--r-lg);">
                    <span class="text-xs text-muted fw-semibold text-uppercase letter-spacing-wide">Email</span>
                    <span class="text-sm fw-medium">{{ $user->Email }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:var(--sp-3) var(--sp-4); background:var(--clr-surface-2); border-radius:var(--r-lg);">
                    <span class="text-xs text-muted fw-semibold text-uppercase letter-spacing-wide">Username</span>
                    <span class="text-sm fw-medium">{{ $user->Username }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:var(--sp-3) var(--sp-4); background:var(--clr-surface-2); border-radius:var(--r-lg);">
                    <span class="text-xs text-muted fw-semibold text-uppercase letter-spacing-wide">Member Since</span>
                    <span class="text-sm fw-medium">{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- CTA --}}
            <div class="flex gap-md">
                @if(Route::has('profile'))
                <a href="{{ route('profile') }}" class="btn btn-primary btn-sm btn-block">Edit Profile</a>
                @else
                <button class="btn btn-primary btn-sm btn-block" disabled>Edit Profile</button>
                @endif
                @if(Route::has('settings'))
                <a href="{{ route('settings') }}" class="btn btn-secondary btn-sm btn-block">Settings</a>
                @else
                <button class="btn btn-secondary btn-sm btn-block" disabled>Settings</button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Quick Actions</h4>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-4 gap-md">
            @if(Route::has('posts.create'))
            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-block" style="flex-direction:column; gap:var(--sp-2); padding:var(--sp-5); height:auto;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>New Post</span>
            </a>
            @endif
            @if(Route::has('categories.index'))
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-block" style="flex-direction:column; gap:var(--sp-2); padding:var(--sp-5); height:auto;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h7v7H3z"/><path d="M14 3h7v7h-7z"/><path d="M14 14h7v7h-7z"/><path d="M3 14h7v7H3z"/></svg>
                <span>Categories</span>
            </a>
            @endif
            @if(Route::has('analytics'))
            <a href="{{ route('analytics') }}" class="btn btn-secondary btn-block" style="flex-direction:column; gap:var(--sp-2); padding:var(--sp-5); height:auto;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                <span>Analytics</span>
            </a>
            @endif
            @if(Route::has('comments.index'))
            <a href="{{ route('comments.index') }}" class="btn btn-secondary btn-block" style="flex-direction:column; gap:var(--sp-2); padding:var(--sp-5); height:auto;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span>Comments</span>
            </a>
            @endif
        </div>
    </div>
</div>

@endsection
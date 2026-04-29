{{-- ══════════════════════════════════════════
     SIDEBAR NAVIGATION
═══════════════════════════════════════════ --}}
<aside class="sidebar" id="main-sidebar">
    <div class="sidebar-inner">

        {{-- ── MAIN ── --}}
        <ul class="sidebar-nav">
            @if(auth()->check() && auth()->user()->isAuthor())
                <li class="sidebar-nav-item">
                    <a href="{{ route('author.dashboard') }}"
                       class="sidebar-nav-link {{ request()->routeIs('author.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        <span>Author Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('author.posts.index') }}"
                       class="sidebar-nav-link {{ request()->routeIs('author.posts.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        <span>My Posts</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('author.profile.show') }}"
                       class="sidebar-nav-link {{ request()->routeIs('author.profile.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>My Profile</span>
                    </a>
                </li>
            @else
                <li class="sidebar-nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif
        </ul>

        {{-- ── CONTENT ── --}}
        @if(!auth()->user()->isAuthor())
        <span class="sidebar-section-title">Content</span>
        <ul class="sidebar-nav">
            @if(Route::has('posts.index'))
            <li class="sidebar-nav-item">
                <a href="{{ route('posts.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    <span>All Posts</span>
                </a>
            </li>
            @endif

            @if(Route::has('posts.create'))
            <li class="sidebar-nav-item">
                <a href="{{ route('posts.create') }}"
                   class="sidebar-nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span>New Post</span>
                </a>
            </li>
            @endif

            @if(Route::has('categories.index'))
            <li class="sidebar-nav-item">
                <a href="{{ route('categories.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3h7v7H3z"/><path d="M14 3h7v7h-7z"/><path d="M14 14h7v7h-7z"/><path d="M3 14h7v7H3z"/>
                    </svg>
                    <span>Categories</span>
                </a>
            </li>
            @endif

            @if(Route::has('media.index'))
            <li class="sidebar-nav-item">
                <a href="{{ route('media.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Media</span>
                </a>
            </li>
            @endif
        </ul>

        {{-- ── MANAGEMENT ── --}}
        <span class="sidebar-section-title">Management</span>
        <ul class="sidebar-nav">
            @if(Route::has('posts.review'))
            <li class="sidebar-nav-item">
                <a href="{{ route('posts.review') }}"
                   class="sidebar-nav-link {{ request()->routeIs('posts.review') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                    </svg>
                    <span>Review Posts</span>
                </a>
            </li>
            @endif

            @if(Route::has('author.media.index'))
            <li class="sidebar-nav-item">
                <a href="{{ route('author.media.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('author.media.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Media Library</span>
                </a>
            </li>
            @endif

            @if(Route::has('comments.index'))
            <li class="sidebar-nav-item">
                <a href="{{ route('comments.index') }}"
                   class="sidebar-nav-link {{ request()->routeIs('comments.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>Comments</span>
                </a>
            </li>
            @endif

            @if(Route::has('analytics'))
            <li class="sidebar-nav-item">
                <a href="{{ route('analytics') }}"
                   class="sidebar-nav-link {{ request()->routeIs('analytics') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                    <span>Analytics</span>
                </a>
            </li>
            @endif
        </ul>
        @endif

        {{-- ── ACCOUNT ── --}}
        <span class="sidebar-section-title">Account</span>
        <ul class="sidebar-nav">
            @if(Route::has('profile'))
            <li class="sidebar-nav-item">
                <a href="{{ route('profile') }}"
                   class="sidebar-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Profile</span>
                </a>
            </li>
            @endif

            @if(Route::has('settings'))
            <li class="sidebar-nav-item">
                <a href="{{ route('settings') }}"
                   class="sidebar-nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m3.08 3.08l4.24 4.24M1 12h6m6 0h6m-1.78 7.78l-4.24-4.24m-3.08-3.08l-4.24-4.24"/>
                    </svg>
                    <span>Settings</span>
                </a>
            </li>
            @endif
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-nav-link w-full" style="border:none; background:transparent; cursor:pointer; text-align:left; font-family:inherit; font-size:inherit; color:var(--clr-danger);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="stroke:var(--clr-danger);">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <p class="text-xsmall text-muted" style="margin:0; text-align:center;">BlogCMS v2.0 · FYP 2026</p>
    </div>
</aside>

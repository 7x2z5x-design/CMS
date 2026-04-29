{{-- ══════════════════════════════════
     TOP NAVIGATION BAR
═══════════════════════════════════ --}}
<nav class="navbar">

    {{-- Brand Logo --}}
    <div class="navbar-logo">
        <a href="{{ auth()->check() && auth()->user()->isAuthor() ? route('author.dashboard') : route('admin.dashboard') }}">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                <rect width="32" height="32" rx="8" fill="#0D9488"/>
                <path d="M8 10h16M8 16h12M8 22h8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            <span>BlogCMS</span>
        </a>
    </div>

    {{-- Sidebar toggle button (visible on mobile only via CSS) --}}
    <button id="sidebar-toggle" class="btn btn-secondary btn-icon" aria-label="Toggle sidebar" style="margin-right: auto;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    {{-- Right-side: actions + profile --}}
    <div class="navbar-profile">

        {{-- Notification button --}}
        <button class="notif-btn" aria-label="Notifications" title="Notifications">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </button>

        {{-- User info + dropdown --}}
        @auth
            <div class="navbar-user-info" style="text-align:right; line-height:1.3;">
                <div class="name">{{ auth()->user()->FullName ?? auth()->user()->Username ?? 'User' }}</div>
                <div class="role">{{ ucfirst(auth()->user()->role ?? 'blogger') }}</div>
            </div>

            {{-- Avatar --}}
            <div class="navbar-avatar">
                @if(auth()->user()->profile_photo)
                    <img src="{{ str_contains(auth()->user()->profile_photo, 'http') ? auth()->user()->profile_photo : asset('storage/' . auth()->user()->profile_photo) }}"
                         alt="{{ auth()->user()->name }}"
                         style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                @else
                    {{ auth()->user()->initials }}
                @endif
            </div>

            {{-- Dropdown menu --}}
            <div class="dropdown">
                <button class="dropdown-toggle" id="navbar-dropdown-btn" aria-label="Account menu">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                <div class="dropdown-menu" id="navbar-dropdown-menu">
                    @if(auth()->check() && auth()->user()->isAuthor())
                    <a href="{{ route('author.dashboard') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('author.profile.show') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        My Profile
                    </a>
                    @else
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    @endif
                    @if(Route::has('settings'))
                    <a href="{{ route('settings') }}" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m3.08 3.08l4.24 4.24M1 12h6m6 0h6m-1.78 7.78l-4.24-4.24m-3.08-3.08l-4.24-4.24"/></svg>
                        Settings
                    </a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Sign In</a>
        @endauth
    </div>
</nav>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS Editor') | NexusAdmin</title>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- NexusAdmin Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin-saas.css') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="admin-body">

    <!-- ==================== SIDEBAR ==================== -->
    <aside class="sidebar" id="sidebar">

        <!-- Brand -->
        <div class="sidebar-brand">
            <i class="ph-fill ph-circles-four"></i>
            NexusAdmin
        </div>

        <!-- Navigation -->
        <ul class="sidebar-nav">

            <!-- CORE Section -->
            <li><span class="sidebar-label">Core</span></li>

            <li>
                <a href="{{ route('editor.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i>
                    Dashboard
                </a>
            </li>

            <!-- CONTENT MANAGEMENT Section -->
            <li><span class="sidebar-label">Content Management</span></li>

            <li>
                <a href="{{ route('editor.posts.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.posts.*') ? 'active' : '' }}">
                    <i class="ph ph-files"></i>
                    Posts Management
                </a>
            </li>

            <li>
                <a href="{{ route('editor.pages.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.pages.*') ? 'active' : '' }}">
                    <i class="ph ph-file-text"></i>
                    Pages Management
                </a>
            </li>

            <li>
                <a href="{{ route('editor.media.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.media.*') ? 'active' : '' }}">
                    <i class="ph ph-images"></i>
                    Media Library
                </a>
            </li>

            <li>
                <a href="{{ route('editor.comments.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.comments.*') ? 'active' : '' }}">
                    <i class="ph ph-chat-circle"></i>
                    Comments Management
                </a>
            </li>

            <!-- EDITORIAL Section -->
            <li><span class="sidebar-label">Editorial</span></li>

            <li>
                <a href="{{ route('editor.categories.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.categories.*') ? 'active' : '' }}">
                    <i class="ph ph-tag"></i>
                    Categories
                </a>
            </li>

            <li>
                <a href="{{ route('editor.tags.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.tags.*') ? 'active' : '' }}">
                    <i class="ph ph-hash"></i>
                    Tags
                </a>
            </li>

            <li>
                <a href="{{ route('editor.scheduled.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.scheduled.*') ? 'active' : '' }}">
                    <i class="ph ph-calendar"></i>
                    Scheduled Content
                </a>
            </li>

            <li>
                <a href="{{ route('editor.drafts.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.drafts.*') ? 'active' : '' }}">
                    <i class="ph ph-file-dotted"></i>
                    Draft Management
                </a>
            </li>

            <!-- REVIEW Section -->
            <li><span class="sidebar-label">Review</span></li>

            <li>
                <a href="{{ route('editor.reviews.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.reviews.*') ? 'active' : '' }}">
                    <i class="ph ph-eye"></i>
                    Pending Review
                </a>
            </li>

            <li>
                <a href="{{ route('editor.approved.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.approved.*') ? 'active' : '' }}">
                    <i class="ph ph-check-circle"></i>
                    Approved Content
                </a>
            </li>

            <li>
                <a href="{{ route('editor.rejected.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.rejected.*') ? 'active' : '' }}">
                    <i class="ph ph-x-circle"></i>
                    Rejected Content
                </a>
            </li>

            <!-- ANALYTICS Section -->
            <li><span class="sidebar-label">Analytics</span></li>

            <li>
                <a href="{{ route('editor.analytics') }}"
                   class="sidebar-link {{ request()->routeIs('editor.analytics.*') ? 'active' : '' }}">
                    <i class="ph ph-chart-line"></i>
                    Content Analytics
                </a>
            </li>

            <li>
                <a href="{{ route('editor.reports.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.reports.*') ? 'active' : '' }}">
                    <i class="ph ph-chart-bar"></i>
                    Performance Reports
                </a>
            </li>

            <li>
                <a href="{{ route('editor.engagement.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.engagement.*') ? 'active' : '' }}">
                    <i class="ph ph-heart"></i>
                    Engagement Metrics
                </a>
            </li>

            <!-- SEO Section -->
            <li><span class="sidebar-label">SEO</span></li>

            <li>
                <a href="{{ route('editor.seo.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.seo.*') ? 'active' : '' }}">
                    <i class="ph ph-magnifying-glass"></i>
                    SEO Optimization
                </a>
            </li>

            <li>
                <a href="{{ route('editor.keywords.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.keywords.*') ? 'active' : '' }}">
                    <i class="ph ph-key"></i>
                    Keywords Management
                </a>
            </li>

            <!-- TOOLS Section -->
            <li><span class="sidebar-label">Tools</span></li>

            <li>
                <a href="{{ route('editor.import.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.import.*') ? 'active' : '' }}">
                    <i class="ph ph-download-simple"></i>
                    Import Content
                </a>
            </li>

            <li>
                <a href="{{ route('editor.export.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.export.*') ? 'active' : '' }}">
                    <i class="ph ph-upload-simple"></i>
                    Export Content
                </a>
            </li>

            <li>
                <a href="{{ route('editor.backup.index') }}"
                   class="sidebar-link {{ request()->routeIs('editor.backup.*') ? 'active' : '' }}">
                    <i class="ph ph-hard-drive"></i>
                    Backup Management
                </a>
            </li>

            <!-- SETTINGS Section -->
            <li><span class="sidebar-label">Settings</span></li>

            <li>
                <a href="{{ route('editor.profile') }}"
                   class="sidebar-link {{ request()->routeIs('editor.profile.*') ? 'active' : '' }}">
                    <i class="ph ph-user"></i>
                    Profile Settings
                </a>
            </li>

            <li>
                <a href="{{ route('editor.preferences') }}"
                   class="sidebar-link {{ request()->routeIs('editor.preferences.*') ? 'active' : '' }}">
                    <i class="ph ph-gear"></i>
                    Editor Preferences
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="sidebar-link logout-link">
                        <i class="ph ph-sign-out"></i>
                        Logout
                    </a>
                </form>
            </li>

        </ul>
    </aside>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Open menu">
        <i class="ph ph-list"></i>
    </button>

    <!-- ==================== MAIN ==================== -->
    <main class="main-wrapper">

        <!-- Top Header -->
        <header class="top-header">
            <div class="header-search">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" placeholder="Search content..." id="globalSearch">
            </div>

            <div class="header-right">
                <!-- Notification Bell -->
                <div class="notification-bell" title="Notifications">
                    <i class="ph ph-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <!-- Dark / Light toggle placeholder -->
                <button class="header-icon-btn" title="Toggle theme" id="themeToggle">
                    <i class="ph ph-moon"></i>
                </button>

                <!-- Editor Profile -->
                <div class="admin-profile">
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->user()->name ?? 'CMS Editor' }}</span>
                        <span class="profile-role">{{ auth()->user()->role ?? 'Editor' }}</span>
                    </div>
                    <div class="avatar">
                        {{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) . strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? 'E', 0, 1)) : 'CE' }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="content-area">

            <!-- Page Header (if page-title section is set) -->
            @hasSection('page-title')
            <div class="page-header">
                <div class="page-header-left">
                    <h1 class="page-title">@yield('page-title')</h1>
                    @hasSection('page-subtitle')
                    <p class="page-subtitle">@yield('page-subtitle')</p>
                    @endif
                </div>
                @hasSection('page-action')
                <div>@yield('page-action')</div>
                @endif
            </div>
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success fade-in">
                    <i class="ph-fill ph-check-circle" style="font-size: 1.25rem;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger fade-in">
                    <i class="ph-fill ph-x-circle" style="font-size: 1.25rem;"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </main>

    @stack('scripts')

    <style>
        /* Category Groups Styles */
        .sidebar-group {
            margin-bottom: 0.25rem;
        }

        .sidebar-group-header {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            color: var(--clr-text-secondary);
            font-weight: 500;
        }

        .sidebar-group-header:hover {
            background: var(--clr-hover-bg);
        }

        .sidebar-submenu {
            display: none;
            padding-left: 1rem;
        }

        .sidebar-submenu.show {
            display: block;
        }

        .category-count {
            background: var(--clr-primary);
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Sidebar Footer Styles */
        .sidebar-footer {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--clr-card-bg);
            border-radius: 0.75rem;
            border: 1px solid var(--clr-border);
        }

        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-primary), var(--clr-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .footer-info {
            flex: 1;
            min-width: 0;
        }

        .footer-name {
            font-weight: 600;
            color: var(--clr-text-primary);
            display: block;
            font-size: 0.875rem;
        }

        .footer-role {
            color: var(--clr-text-secondary);
            font-size: 0.75rem;
            display: block;
            margin-top: 0.125rem;
        }

        /* Additional Editor-specific styles */
        .logout-link {
            color: var(--clr-danger);
        }

        .logout-link:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar-footer {
                position: static;
                margin-top: 1rem;
            }
        }
    </style>

    <script>
        // Toggle category groups
        function toggleCategoryGroup(groupId) {
            const menu = document.getElementById(groupId + '-menu');
            const arrow = document.getElementById(groupId + '-arrow');
            
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                menu.classList.add('show');
                arrow.style.transform = 'rotate(90deg)';
            }
        }

        // Mobile menu toggle
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Theme toggle
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
        });

        // Global search
        document.getElementById('globalSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                // Implement search functionality
                console.log('Searching for:', this.value);
            }
        });
    </script>
</body>
</html>

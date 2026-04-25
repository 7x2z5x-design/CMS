<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS Admin') | NexusAdmin</title>
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
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ph ph-users"></i>
                    User Management
                </a>
            </li>

            <li>
                <a href="{{ route('admin.content.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                    <i class="ph ph-files"></i>
                    Content Management
                </a>
            </li>

            <!-- CATEGORIES Section -->
            <li><span class="sidebar-label">Categories</span></li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('blog-articles')">
                    <i class="ph ph-caret-right" id="blog-articles-arrow"></i>
                    <i class="ph ph-article"></i>
                    Blog & Articles
                    <span class="category-count" id="blog-articles-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="blog-articles-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Blog & Articles']) }}" class="sidebar-link">All Blog Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'News')">News</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'Tutorials')">Tutorials</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'How-To Guides')">How-To Guides</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'Opinion')">Opinion</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'Case Studies')">Case Studies</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Blog & Articles', 'Press Releases')">Press Releases</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('media-content')">
                    <i class="ph ph-caret-right" id="media-content-arrow"></i>
                    <i class="ph ph-video"></i>
                    Media & Content
                    <span class="category-count" id="media-content-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="media-content-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Media & Content']) }}" class="sidebar-link">All Media Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'Videos')">Videos</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'Podcasts')">Podcasts</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'Infographics')">Infographics</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'Galleries')">Galleries</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'Webinars')">Webinars</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Media & Content', 'E-books')">E-books</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('products-services')">
                    <i class="ph ph-caret-right" id="products-services-arrow"></i>
                    <i class="ph ph-shopping-cart"></i>
                    Products & Services
                    <span class="category-count" id="products-services-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="products-services-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Products & Services']) }}" class="sidebar-link">All Product Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Products & Services', 'Physical Products')">Physical Products</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Products & Services', 'Digital Products')">Digital Products</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Products & Services', 'Services')">Services</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Products & Services', 'Subscriptions')">Subscriptions</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Products & Services', 'Bundles')">Bundles</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('events')">
                    <i class="ph ph-caret-right" id="events-arrow"></i>
                    <i class="ph ph-calendar"></i>
                    Events
                    <span class="category-count" id="events-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="events-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Events']) }}" class="sidebar-link">All Event Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Events', 'Conferences')">Conferences</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Events', 'Webinars')">Webinars</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Events', 'Workshops')">Workshops</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Events', 'Meetups')">Meetups</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Events', 'Online Events')">Online Events</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('portfolio-projects')">
                    <i class="ph ph-caret-right" id="portfolio-projects-arrow"></i>
                    <i class="ph ph-briefcase"></i>
                    Portfolio & Projects
                    <span class="category-count" id="portfolio-projects-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="portfolio-projects-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Portfolio & Projects']) }}" class="sidebar-link">All Portfolio Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Portfolio & Projects', 'Web Design')">Web Design</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Portfolio & Projects', 'App Development')">App Development</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Portfolio & Projects', 'Branding')">Branding</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Portfolio & Projects', 'Photography')">Photography</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Portfolio & Projects', 'Case Studies')">Case Studies</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('knowledge-base')">
                    <i class="ph ph-caret-right" id="knowledge-base-arrow"></i>
                    <i class="ph ph-book"></i>
                    Knowledge Base / Docs
                    <span class="category-count" id="knowledge-base-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="knowledge-base-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Knowledge Base / Docs']) }}" class="sidebar-link">All KB Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Knowledge Base / Docs', 'FAQs')">FAQs</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Knowledge Base / Docs', 'Guides')">Guides</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Knowledge Base / Docs', 'API Docs')">API Docs</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Knowledge Base / Docs', 'Release Notes')">Release Notes</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Knowledge Base / Docs', 'Troubleshooting')">Troubleshooting</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('community-social')">
                    <i class="ph ph-caret-right" id="community-social-arrow"></i>
                    <i class="ph ph-users"></i>
                    Community & Social
                    <span class="category-count" id="community-social-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="community-social-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Community & Social']) }}" class="sidebar-link">All Community Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Community & Social', 'Forums')">Forums</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Community & Social', 'Announcements')">Announcements</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Community & Social', 'Q&A')">Q&A</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Community & Social', 'User Stories')">User Stories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Community & Social', 'Discussions')">Discussions</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('jobs-careers')">
                    <i class="ph ph-caret-right" id="jobs-careers-arrow"></i>
                    <i class="ph ph-briefcase"></i>
                    Jobs & Careers
                    <span class="category-count" id="jobs-careers-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="jobs-careers-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Jobs & Careers']) }}" class="sidebar-link">All Job Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Jobs & Careers', 'Full-time')">Full-time</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Jobs & Careers', 'Part-time')">Part-time</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Jobs & Careers', 'Remote')">Remote</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Jobs & Careers', 'Freelance')">Freelance</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Jobs & Careers', 'Internship')">Internship</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('courses-learning')">
                    <i class="ph ph-caret-right" id="courses-learning-arrow"></i>
                    <i class="ph ph-graduation-cap"></i>
                    Courses & Learning
                    <span class="category-count" id="courses-learning-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="courses-learning-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Courses & Learning']) }}" class="sidebar-link">All Course Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Courses & Learning', 'Free Courses')">Free Courses</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Courses & Learning', 'Paid Courses')">Paid Courses</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Courses & Learning', 'Certifications')">Certifications</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Courses & Learning', 'Workshops')">Workshops</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Courses & Learning', 'Quizzes')">Quizzes</a></li>
                </ul>
            </li>

            <li class="sidebar-group">
                <div class="sidebar-group-header" onclick="toggleCategoryGroup('custom')">
                    <i class="ph ph-caret-right" id="custom-arrow"></i>
                    <i class="ph ph-folder"></i>
                    Custom / Uncategorized
                    <span class="category-count" id="custom-count">0</span>
                </div>
                <ul class="sidebar-submenu" id="custom-menu">
                    <li><a href="{{ route('admin.categories.index', ['group' => 'Custom / Uncategorized']) }}" class="sidebar-link">All Custom Categories</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Custom / Uncategorized', 'Miscellaneous')">Miscellaneous</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Custom / Uncategorized', 'Drafts')">Drafts</a></li>
                    <li><a href="#" class="sidebar-link" onclick="quickAddCategory('Custom / Uncategorized', 'Archived')">Archived</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ph ph-faders"></i>
                    Manage All Categories
                </a>
            </li>

            <li>
                <a href="{{ route('admin.tags.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <i class="ph ph-tag"></i>
                    Tag Management
                </a>
            </li>

            <li>
                <a href="{{ route('admin.media.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i class="ph ph-images"></i>
                    Media Management
                </a>
            </li>

            <!-- REPORTING Section -->
            <li><span class="sidebar-label">Reporting</span></li>

            <li>
                <a href="{{ route('admin.analysis.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.analysis.*') ? 'active' : '' }}">
                    <i class="ph ph-chart-bar"></i>
                    Analysis
                </a>
            </li>

            <!-- SYSTEM Section -->
            <li><span class="sidebar-label">System</span></li>

            <li>
                <a href="{{ route('admin.system.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.system.*') ? 'active' : '' }}">
                    <i class="ph ph-gear"></i>
                    System Control
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

        <!-- Sidebar Footer — Admin Profile -->
        <div class="sidebar-footer">
            <div class="avatar">
                {{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) . strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? 'A', 0, 1)) : 'CA' }}
            </div>
            <div class="footer-info">
                <span class="footer-name">{{ auth()->user()->name ?? 'CMS Admin' }}</span>
                <span class="footer-role">{{ auth()->user()->role ?? 'Super Admin' }}</span>
            </div>
        </div>

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
                <input type="text" placeholder="Search users..." id="globalSearch">
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

                <!-- Admin Profile -->
                <div class="admin-profile">
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->user()->name ?? 'CMS Admin' }}</span>
                        <span class="profile-role">{{ auth()->user()->role ?? 'Administrator' }}</span>
                    </div>
                    <div class="avatar">
                        {{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) . strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? 'A', 0, 1)) : 'CA' }}
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
            color: var(--clr-text-primary);
        }

        .sidebar-group-header i:first-child {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
            font-size: 0.875rem;
        }

        .sidebar-group-header.expanded i:first-child {
            transform: rotate(90deg);
        }

        .sidebar-group-header i:nth-child(2) {
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        .category-count {
            margin-left: auto;
            background: var(--clr-primary-bg);
            color: var(--clr-primary);
            padding: 0.125rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            min-width: 1.5rem;
            text-align: center;
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            margin-left: 1rem;
            border-left: 2px solid var(--clr-border);
        }

        .sidebar-submenu.expanded {
            max-height: 500px;
        }

        .sidebar-submenu li {
            margin: 0;
        }

        .sidebar-submenu .sidebar-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: var(--clr-text-secondary);
            border-radius: 0.25rem;
            margin: 0.125rem 0.5rem;
        }

        .sidebar-submenu .sidebar-link:hover {
            background: var(--clr-hover-bg);
            color: var(--clr-text-primary);
        }

        .sidebar-submenu .sidebar-link.active {
            background: var(--clr-primary-bg);
            color: var(--clr-primary);
        }

        /* Quick Add Button */
        .quick-add-btn {
            position: relative;
        }

        .quick-add-btn::after {
            content: '+';
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: var(--clr-primary);
            color: white;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        /* Responsive Mobile Support */
        @media (max-width: 768px) {
            .sidebar-group-header {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }

            .sidebar-group-header i:nth-child(2) {
                font-size: 1rem;
            }

            .category-count {
                font-size: 0.625rem;
                padding: 0.0625rem 0.375rem;
                min-width: 1.25rem;
            }

            .sidebar-submenu .sidebar-link {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
                margin: 0.0625rem 0.25rem;
            }

            .sidebar-submenu {
                margin-left: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar-group-header {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }

            .sidebar-group-header i:nth-child(2) {
                font-size: 0.875rem;
            }

            .category-count {
                font-size: 0.5rem;
                padding: 0.0625rem 0.25rem;
                min-width: 1rem;
            }

            .sidebar-submenu .sidebar-link {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
                margin: 0.0625rem 0.125rem;
            }

            .sidebar-submenu {
                margin-left: 0.25rem;
            }
        }
    </style>

    <script>
        // Mobile sidebar toggle
        const mobileBtn = document.getElementById('mobileMenuToggle');
        const sidebar   = document.getElementById('sidebar');

        if (mobileBtn && sidebar) {
            mobileBtn.addEventListener('click', () => sidebar.classList.toggle('active'));
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 &&
                    !sidebar.contains(e.target) &&
                    !mobileBtn.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            });
        }

        // Auto-hide alerts after 5 s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);

        // Category Groups Toggle Functionality
        function toggleCategoryGroup(groupId) {
            const menu = document.getElementById(groupId + '-menu');
            const arrow = document.getElementById(groupId + '-arrow');
            const header = arrow.parentElement;
            
            if (menu && arrow) {
                menu.classList.toggle('expanded');
                header.classList.toggle('expanded');
                
                // Save state to localStorage
                const isExpanded = menu.classList.contains('expanded');
                localStorage.setItem('category-group-' + groupId, isExpanded);
            }
        }

        // Quick Add Category Function
        function quickAddCategory(group, name) {
            // Open modal with pre-filled data
            const modal = document.getElementById('categoryModal');
            if (modal) {
                // Set the group and name
                const groupSelect = document.querySelector('#categoryModal select[name="category_group"]');
                const nameInput = document.querySelector('#categoryModal input[name="name"]');
                
                if (groupSelect) {
                    groupSelect.value = group;
                }
                
                if (nameInput) {
                    nameInput.value = name;
                    // Generate slug automatically
                    const slugInput = document.querySelector('#categoryModal input[name="slug"]');
                    if (slugInput) {
                        slugInput.value = name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    }
                }
                
                // Show modal
                modal.classList.add('show');
                modal.style.display = 'block';
            }
        }

        // Load saved category group states
        document.addEventListener('DOMContentLoaded', function() {
            const groups = ['blog-articles', 'media-content', 'products-services', 'events', 'portfolio-projects', 'knowledge-base', 'community-social', 'jobs-careers', 'courses-learning', 'custom'];
            
            groups.forEach(groupId => {
                const isExpanded = localStorage.getItem('category-group-' + groupId) === 'true';
                const menu = document.getElementById(groupId + '-menu');
                const arrow = document.getElementById(groupId + '-arrow');
                const header = arrow ? arrow.parentElement : null;
                
                if (isExpanded && menu && arrow && header) {
                    menu.classList.add('expanded');
                    header.classList.add('expanded');
                }
            });

            // Load category counts
            loadCategoryCounts();
        });

        // Load category counts from API
        function loadCategoryCounts() {
            fetch('{{ route("admin.categories.counts") }}')
                .then(response => response.json())
                .then(data => {
                    Object.keys(data).forEach(group => {
                        const groupId = group.toLowerCase().replace(/\s+/g, '-').replace(/[&\/]/g, '-');
                        const countElement = document.getElementById(groupId + '-count');
                        if (countElement) {
                            countElement.textContent = data[group];
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading category counts:', error);
                });
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('categoryModal');
            if (modal && e.target === modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
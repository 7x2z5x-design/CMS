<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlogCMS') — BlogCMS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect fill='%230D9488' width='32' height='32' rx='8'/><text x='16' y='22' font-size='18' font-weight='900' text-anchor='middle' fill='white' font-family='Inter,sans-serif'>B</text></svg>">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page-specific head content -->
    @stack('head')
</head>
<body>

    {{-- ── Top Navigation Bar ── --}}
    @include('layouts.partials.navbar')

    {{-- ── Sidebar Navigation ── --}}
    @include('layouts.partials.sidebar')

    {{-- ── Sidebar Overlay (mobile) ── --}}
    <div id="sidebar-overlay" style="display:none; position:fixed; inset:0; z-index:1150; background:rgba(15,23,42,.45);" onclick="closeSidebar()"></div>

    {{-- ── Main Content Area ── --}}
    <main class="main-content fade-in" id="main-content">

        {{-- Flash Alerts --}}
        @if(session('success'))
            <div class="alert alert-success fade-slide-in mb-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                <div><strong>Success!</strong> {{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger fade-slide-in mb-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div><strong>Error!</strong> {{ session('error') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning fade-slide-in mb-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div><strong>Warning!</strong> {{ session('warning') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info fade-slide-in mb-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <div><strong>Info:</strong> {{ session('info') }}</div>
            </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </main>

    {{-- ── JavaScript ── --}}
    <script>
        /* ── Sidebar Toggle ── */
        function openSidebar() {
            document.querySelector('.sidebar').classList.add('mobile-open');
            document.getElementById('sidebar-overlay').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.querySelector('.sidebar').classList.remove('mobile-open');
            document.getElementById('sidebar-overlay').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebar-toggle');
            if (toggle) {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar.classList.contains('mobile-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            /* ── Navbar Dropdown ── */
            const dropdownBtn = document.getElementById('navbar-dropdown-btn');
            const dropdownMenu = document.getElementById('navbar-dropdown-menu');

            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('open');
                });

                document.addEventListener('click', function (e) {
                    if (!dropdownBtn.contains(e.target)) {
                        dropdownMenu.classList.remove('open');
                    }
                });
            }

            /* ── Auto-dismiss alerts after 5 seconds ── */
            document.querySelectorAll('.alert.fade-slide-in').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-8px)';
                    setTimeout(function () { el.remove(); }, 400);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ isset($title) ? $title.' — ' : '' }}Admin Jotun Paint Center</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/admin.css', 'resources/js/app.js'])
    @endif
</head>
<body class="admin-body">

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <span class="sidebar-brand-mark" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2C8.1 2 3.3 6.8 3.3 12.7v2.6C3.3 21.2 8.1 26 14 26s10.7-4.8 10.7-10.7v-2.6C24.7 6.8 19.9 2 14 2Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M14 3v22M4 14h20M6 9h16M6 19h16" stroke="currentColor" stroke-width="1.5" opacity=".75"/>
                </svg>
            </span>
            <span class="sidebar-brand-text">
                <strong>JOTUN</strong>
                <span>Admin Panel</span>
            </span>
        </a>

        <nav class="sidebar-nav">
            <span class="sidebar-section-label">Menu Utama</span>

            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Dashboard</span>
            </a>

            <a class="sidebar-link {{ request()->routeIs('admin.profil-toko.*') ? 'active' : '' }}"
               href="{{ route('admin.profil-toko.edit') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Profil Toko</span>
            </a>

            <span class="sidebar-section-label">Katalog</span>

            <a class="sidebar-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}"
               href="{{ route('admin.produk.index') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Produk</span>
            </a>

            <a class="sidebar-link {{ request()->routeIs('admin.warna.*') ? 'active' : '' }}"
               href="{{ route('admin.warna.index') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Warna</span>
            </a>

            <span class="sidebar-section-label">Operasional</span>

            <a class="sidebar-link {{ request()->routeIs('admin.tinting.*') ? 'active' : '' }}"
               href="{{ route('admin.tinting.index') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Request Tinting</span>
            </a>

            <a class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"
               href="{{ route('admin.laporan.index') }}">
                <span class="nav-icon" aria-hidden="true"></span>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            &copy; {{ date('Y') }} Jotun Paint Center
        </div>
    </aside>

    {{-- Topbar --}}
    <header class="admin-topbar">
        <div style="display:flex;align-items:center;gap:12px">
            <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M3 5H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3 10H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3 15H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>
        </div>

        <div class="topbar-right">
            <span class="topbar-admin-name">{{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="admin-btn admin-btn-outline admin-btn-sm">Logout</button>
            </form>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="admin-main">
        <div class="admin-content">
            @if (session('success'))
                <div class="admin-alert success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="admin-alert error">{{ session('error') }}</div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>
</body>
</html>

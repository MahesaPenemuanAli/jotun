<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Website resmi cabang Jotun Paint Center Helvetia - Layanan cat premium dan computerized tinting.' }}">

    <title>{{ isset($title) ? $title.' | ' : '' }}Jotun Paint Center Graha Metropolitan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="container header-inner">
                <a class="brand" href="{{ route('home') }}" aria-label="Jotun Paint Center">
                    <span class="brand-text">
                        <strong>JOTUN</strong>
                        <span>GRAHA METROPOLITAN</span>
                    </span>
                </a>

                <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('catalog.index') }}">Katalog</a>
                    <a href="{{ route('calculator.create') }}">Kalkulator</a>
                    <a href="{{ route('tinting.create') }}" class="nav-accent">Color Studio</a>
                    <a href="{{ route('home') }}#lokasi">Lokasi</a>

                    @auth
                        <div class="user-menu-wrapper">
                            <button class="user-menu-trigger" id="userMenuTrigger" aria-expanded="false" aria-haspopup="true">
                                <span class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="user-name-text">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            <div class="user-dropdown" id="userDropdown">
                                <a href="{{ route('pelanggan.dashboard') }}">Dashboard</a>
                                <a href="{{ route('pelanggan.profil') }}">Profil Saya</a>
                                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}">Riwayat Kalkulasi</a>
                                <a href="{{ route('pelanggan.riwayat.tinting') }}">Riwayat Tinting</a>
                                <hr>
                                <form method="POST" action="{{ route('pelanggan.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-logout">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('pelanggan.login') }}" class="nav-login-btn">Masuk</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <div class="container footer-inner">
                <div class="footer-info">
                    <strong>JOTUN PAINT CENTER — GRAHA METROPOLITAN</strong>
                    <p style="margin-bottom: 8px;">Dealer Resmi Cat Jotun. Menyediakan cat premium eksterior & interior asli dengan dukungan mesin pencampuran warna terkomputerisasi (tinting) yang presisi.</p>
                    <p style="font-size: 0.85rem; color: var(--muted);"><strong>Alamat:</strong> Kompleks, Jl. Graha Metropolitan No. 85, Helvetia, Kec. Sunggal, Kabupaten Deli Serdang, Sumatera Utara</p>
                </div>
                <div class="footer-copyright">
                    <span>&copy; {{ date('Y') }} Jotun Paint Center Graha Metropolitan. Hak Cipta Dilindungi.</span>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // User dropdown toggle
        const trigger = document.getElementById('userMenuTrigger');
        const dropdown = document.getElementById('userDropdown');
        if (trigger && dropdown) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = dropdown.classList.toggle('open');
                trigger.setAttribute('aria-expanded', open);
            });
            document.addEventListener('click', () => {
                dropdown.classList.remove('open');
                trigger?.setAttribute('aria-expanded', 'false');
            });
        }
    </script>
</body>
</html>

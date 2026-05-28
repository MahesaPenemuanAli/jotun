<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Website resmi cabang Jotun Paint Center - Layanan cat premium dan computerized tinting.' }}">

    <title>{{ isset($title) ? $title.' | ' : '' }}Jotun Paint Center</title>

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
                        <span>PAINT CENTER</span>
                    </span>
                </a>

                <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('catalog.index') }}">Katalog Produk</a>
                    <a href="{{ route('calculator.create') }}">Kalkulator Cat</a>
                    <a href="{{ route('tinting.create') }}" class="nav-accent">Color Studio (Tinting)</a>
                    <a href="{{ route('home') }}#lokasi">Lokasi & Kontak</a>
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <div class="container footer-inner">
                <div class="footer-info">
                    <strong>JOTUN PAINT CENTER</strong>
                    <p>Dealer Resmi Cat Jotun. Menyediakan cat premium eksterior & interior asli dengan dukungan mesin pencampuran warna terkomputerisasi (tinting) yang presisi.</p>
                </div>
                <div class="footer-copyright">
                    <span>© {{ date('Y') }} Jotun Paint Center Cabang Utama. Hak Cipta Dilindungi.</span>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

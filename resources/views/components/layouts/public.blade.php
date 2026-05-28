<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Website cabang toko cat Jotun.' }}">

    <title>{{ isset($title) ? $title.' — ' : '' }}Jotun Paint Center Cabang</title>

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="page-shell">
        <div class="top-strip" aria-hidden="true"></div>

        <header class="site-header">
            <div class="container header-inner">
                <a class="brand" href="{{ route('home') }}" aria-label="Jotun Paint Center Cabang">
                    <span class="brand-mark" aria-hidden="true">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2C8.1 2 3.3 6.8 3.3 12.7v2.6C3.3 21.2 8.1 26 14 26s10.7-4.8 10.7-10.7v-2.6C24.7 6.8 19.9 2 14 2Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M14 3v22M4 14h20M6 9h16M6 19h16" stroke="currentColor" stroke-width="1.5" opacity=".75"/>
                        </svg>
                    </span>
                    <span class="brand-text">
                        <strong>JOTUN</strong>
                        <span>PAINT CENTER</span>
                    </span>
                </a>

                <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}#fitur">Fitur</a>
                    <a href="{{ route('catalog.index') }}">Katalog</a>
                    <a href="{{ route('calculator.create') }}">Kalkulator</a>
                    <a href="{{ route('tinting.create') }}">Tinting</a>
                    <a href="{{ route('home') }}#roadmap">Roadmap</a>
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <div class="container footer-inner">
                <span>© {{ date('Y') }} Jotun Paint Center Cabang.</span>
                <span>Laravel + Supabase-ready schema.</span>
            </div>
        </footer>
    </div>
</body>
</html>

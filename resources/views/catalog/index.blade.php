<x-layouts.public title="Katalog Produk Cat Premium Jotun" description="Jelajahi produk cat premium Jotun eksterior dan interior. Temukan informasi harga, daya sebar, dan katalog warna resmi di cabang toko kami.">
    <!-- Hero Header -->
    <section class="hero" style="padding: 80px 0 64px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Pilihan Cat Premium</span>
            <h1 style="font-size: 2.8rem; margin-bottom: 16px;">Katalog Produk Cat Jotun</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 720px; margin-bottom: 0;">
                Temukan varian produk terbaik untuk mempercantik dan melindungi properti Anda. Dilengkapi data daya sebar dan harga resmi untuk membantu estimasi kebutuhan Anda.
            </p>
        </div>
    </section>

    <!-- Catalog Content -->
    <section class="section alt-bg">
        <div class="container">
            <!-- Search & Filters Toolbar -->
            <form class="catalog-toolbar" method="GET" action="{{ route('catalog.index') }}">
                <div class="field">
                    <label for="q">Cari Nama Cat</label>
                    <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Contoh: Jotashield atau Majestic...">
                </div>

                <div class="field">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item }}" @selected($category === $item)>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="tintable">Tinting</label>
                    <select id="tintable" name="tintable">
                        <option value="">Semua</option>
                        <option value="1" @selected(($tintable ?? '') === '1')>Bisa Tinting</option>
                        <option value="0" @selected(($tintable ?? '') === '0')>Non-Tinting</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit" style="height: 46px; padding: 0 24px;">Filter</button>

                @if ($search !== '' || filled($category) || $tintable !== null)
                    <a class="btn btn-secondary" href="{{ route('catalog.index') }}" style="height: 46px; display: inline-flex; align-items: center; justify-content: center; padding: 0 20px;">Reset</a>
                @endif
            </form>

            @if ($products->isEmpty())
                <div class="empty-state">
                    <h3>Produk Tidak Ditemukan</h3>
                    <p>Maaf, produk cat yang Anda cari belum tersedia di cabang kami saat ini.</p>
                </div>
            @else
                <!-- Product Grid -->
                <div class="product-grid">
                    @foreach ($products as $product)
                        <article class="product-card">
                            <div class="product-visual-box">
                                @if ($product->gambar)
                                    <img class="product-image" src="{{ $product->gambar }}" alt="{{ $product->nama_produk }}">
                                @else
                                    <div class="product-visual-placeholder">{{ substr($product->nama_produk, 0, 8) }}</div>
                                @endif
                            </div>

                            <div class="product-meta">
                                <span class="product-cat">{{ $product->kategori }}</span>
                                @if ($product->is_tintable)
                                    <span class="product-cat" style="background: var(--jotun-yellow-soft); color: var(--jotun-yellow-hover);">Tinting</span>
                                @else
                                    <span class="product-cat" style="background: #f1f5f9; color: #64748b;">{{ ucfirst($product->tipe_produk ?? 'Pendukung') }}</span>
                                @endif
                                <span class="product-price">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>

                            <h3>{{ $product->nama_produk }}</h3>
                            <p>Daya sebar teoretis sekitar {{ $product->daya_sebar ?? '10' }} m²/liter per lapis.</p>

                            @if ($product->is_tintable)
                                <div class="product-swatches" aria-label="Warna tersedia">
                                    @forelse ($product->warna->take(5) as $color)
                                        <span title="{{ $color->nama_warna }} ({{ $color->kode_warna }})" style="background-color: {{ $color->hex_color ?: '#FDB913' }}"></span>
                                    @empty
                                        <span title="Hubungi kami untuk tinting warna" style="background-color: #E5E7EB"></span>
                                    @endforelse
                                </div>
                            @else
                                <p style="font-size: 0.8rem; color: var(--muted); font-style: italic; margin-top: 8px;">
                                    Produk pendukung — tidak tersedia untuk tinting warna.
                                </p>
                            @endif

                            <div style="margin-top: auto; display:flex; gap:8px; flex-wrap:wrap;">
                                <a class="card-link" href="{{ route('catalog.show', $product->id_produk) }}">Detail Produk</a>
                                @if ($product->is_tintable)
                                    <a class="card-link" href="{{ route('tinting.create') }}" style="background:var(--jotun-yellow);color:#000;">Request Tinting</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($products->hasPages())
                    <nav class="simple-pagination" aria-label="Navigasi katalog">
                        @if ($products->previousPageUrl())
                            <a class="btn btn-secondary" href="{{ $products->previousPageUrl() }}" style="padding: 8px 16px; font-size: 0.85rem;">Sebelumnya</a>
                        @endif
                        <span style="font-size: 0.9rem; color: var(--muted); font-weight: 600;">Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</span>
                        @if ($products->nextPageUrl())
                            <a class="btn btn-secondary" href="{{ $products->nextPageUrl() }}" style="padding: 8px 16px; font-size: 0.85rem;">Berikutnya</a>
                        @endif
                    </nav>
                @endif
            @endif
        </div>
    </section>
</x-layouts.public>

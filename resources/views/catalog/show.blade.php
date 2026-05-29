<x-layouts.public :title="$product->nama_produk" :description="'Spesifikasi dan varian warna cat Jotun '.$product->nama_produk">
    <!-- Detail Header -->
    <section class="section" style="background-color: var(--surface); border-bottom: 1px solid var(--line); padding: 80px 0;">
        <div class="container detail-grid">
            <div class="detail-visual">
                <div class="detail-visual-inner">
                    @if ($product->gambar)
                        <img src="{{ $product->gambar }}" alt="{{ $product->nama_produk }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div style="font-size: 2.2rem; font-weight: 800; color: var(--muted); opacity: 0.4;">
                            JOTUN PREMIUM
                        </div>
                    @endif
                </div>
            </div>

            <div class="detail-content">
                <div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap">
                    <span class="detail-category">{{ $product->kategori }}</span>
                    @if ($product->is_tintable)
                        <span class="detail-category" style="background:var(--jotun-yellow-soft);color:var(--jotun-yellow-hover);">Bisa Tinting</span>
                    @else
                        <span class="detail-category" style="background:#f1f5f9;color:#64748b;">{{ ucfirst($product->tipe_produk ?? 'Pendukung') }}</span>
                    @endif
                </div>
                <h1>{{ $product->nama_produk }}</h1>
                <p style="color: var(--muted); font-size: 1.1rem; margin-bottom: 32px; line-height: 1.7;">
                    Varian produk cat orisinal berkualitas tinggi dari Jotun. Dirancang khusus untuk memberikan hasil akhir yang indah, daya tahan maksimal, dan perlindungan optimal bagi dinding properti Anda.
                </p>

                <div class="detail-price-box">
                    <span class="price-label">Harga Eceran Resmi Cabang (2.5L)</span>
                    <strong class="price-value">Rp{{ number_format($product->harga, 0, ',', '.') }}</strong>
                </div>

                <div class="detail-specs">
                    <div class="spec-item">
                        <span>Kategori Penggunaan</span>
                        <strong>Dinding {{ $product->kategori }}</strong>
                    </div>
                    <div class="spec-item">
                        <span>Estimasi Daya Sebar</span>
                        <strong>{{ $product->daya_sebar ?? '10' }} m² / Liter</strong>
                    </div>
                    <div class="spec-item">
                        <span>Tipe Produk</span>
                        <strong>{{ ucfirst($product->tipe_produk ?? 'Finishing') }}</strong>
                    </div>
                </div>

                <div class="hero-actions" style="margin-top: 16px;">
                    @if ($product->is_tintable)
                        <a class="btn btn-primary" href="{{ route('tinting.create') }}">Campur Warna (Tinting)</a>
                    @else
                        <span style="font-size: 0.9rem; color: var(--muted); font-style: italic; padding: 12px 0;">
                            Produk pendukung — tidak tersedia untuk request tinting warna.
                        </span>
                    @endif
                    <a class="btn btn-secondary" href="{{ route('catalog.index') }}">Kembali Ke Katalog</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Colors Section -->
    @if ($product->is_tintable)
    <section class="section alt-bg">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Palet Resmi</span>
                <h2>Pilihan Warna Siap Tinting</h2>
                <p>Warna-warna orisinal berikut dapat langsung dicampur di mesin dispenser toko kami saat Anda melakukan pemesanan.</p>
            </div>

            @if ($product->warna->isEmpty())
                <div class="empty-state">
                    <h3>Pilihan Warna Belum Diinput</h3>
                    <p>Maaf, daftar warna tinting untuk produk ini sedang diperbarui oleh sistem kami. Anda tetap bisa berkonsultasi warna secara manual dengan langsung menghubungi cabang kami.</p>
                </div>
            @else
                <div class="color-chips-grid">
                    @foreach ($product->warna as $color)
                        <article class="color-chip-card">
                            <span class="color-chip-preview" style="background-color: {{ $color->hex_color ?: '#FDB913' }}"></span>
                            <div>
                                <h4>{{ $color->nama_warna }}</h4>
                                <p>{{ $color->kode_warna ?: 'JTN-Custom' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif
</x-layouts.public>

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
                <span class="detail-category">{{ $product->kategori }}</span>
                <h1>{{ $product->nama_produk }}</h1>
                <p style="color: var(--muted); font-size: 1.1rem; margin-bottom: 32px; line-height: 1.7;">
                    Varian produk cat orisinal berkualitas tinggi dari Jotun. Dirancang khusus untuk memberikan hasil akhir yang indah, daya tahan maksimal, dan perlindungan optimal bagi dinding properti Anda.
                </p>

                <div class="detail-price-box">
                    <span class="price-label">Harga Eceran Resmi Cabang</span>
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
                </div>

                <div class="hero-actions" style="margin-top: 16px;">
                    <a class="btn btn-primary" href="{{ route('tinting.create') }}">Campur Warna (Tinting)</a>
                    <a class="btn btn-secondary" href="{{ route('catalog.index') }}">Kembali Ke Katalog</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Colors Section -->
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
                            <span class="color-chip-preview" data-color="{{ $color->hex_color ?: '#FDB913' }}" style="background-color: {{ $color->hex_color ?: '#FDB913' }}"></span>
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
</x-layouts.public>

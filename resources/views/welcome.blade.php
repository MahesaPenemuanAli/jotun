<x-layouts.public title="Beranda | Cabang Resmi Jotun Paint Center" description="Selamat datang di dealer resmi Jotun Paint Center. Dapatkan cat interior dan eksterior premium dengan teknologi pencampuran warna (tinting) terkomputerisasi.">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Cabang Resmi Jotun Paint Center</span>
                <h1>Akurasi Warna Sempurna Untuk Ruangan Anda.</h1>
                <p>
                    Hadirkan keindahan abadi di setiap sudut rumah Anda. Kami menyediakan katalog cat premium Jotun terlengkap dengan dukungan mesin tinting otomatis untuk hasil warna 99.9% akurat.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('tinting.create') }}">Mulai Campur Warna</a>
                    <a class="btn btn-secondary" href="{{ route('catalog.index') }}">Lihat Katalog Produk</a>
                </div>

                <div class="hero-features">
                    <div class="feature-item">
                        <h3>100%</h3>
                        <p>Jotun Original</p>
                    </div>
                    <div class="feature-item">
                        <h3>10K+</h3>
                        <p>Pilihan Warna</p>
                    </div>
                    <div class="feature-item">
                        <h3>Instan</h3>
                        <p>Proses Tinting</p>
                    </div>
                </div>
            </div>

            <div class="hero-visual" aria-hidden="true">
                <div class="visual-canvas">
                    <div class="visual-swatch" id="heroSwatch"></div>
                    <div class="visual-info">
                        <strong id="heroColorName">Warm Signal Yellow</strong>
                        <span id="heroColorCode">JTN-120</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section alt-bg">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Layanan Unggulan</span>
                <h2>Mengapa Memilih Jotun Paint Center Kami?</h2>
                <p>Kami berkomitmen memberikan pengalaman berbelanja cat terbaik dengan teknologi modern dan pelayanan profesional.</p>
            </div>

            <div class="services-grid">
                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <h3>Mesin Tinting Otomatis</h3>
                    <p>Pencampuran warna cat menggunakan mesin dispenser otomatis terkomputerisasi. Menjamin konsistensi warna yang Anda pilih dari katalog, kapan pun Anda membelinya kembali.</p>
                </article>

                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3>Katalog Warna Terlengkap</h3>
                    <p>Temukan ribuan variasi warna orisinal Jotun untuk eksterior dan interior. Dari warna lembut netral hingga warna berani yang memberikan kesan mewah bagi hunian Anda.</p>
                </article>

                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <h3>Kalkulator Volume Cat</h3>
                    <p>Gunakan kalkulator cat pintar kami untuk mengestimasi kebutuhan volume cat secara tepat sebelum membeli. Menghindari pemborosan budget dan pembelian cat berlebih.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Popular Products Showcase -->
    <section class="section">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Rekomendasi Produk</span>
                <h2>Cat Premium Jotun Terbaik Untuk Anda</h2>
                <p>Kombinasi formulasi perlindungan tingkat tinggi dengan keindahan hasil akhir yang memukau.</p>
            </div>

            <div class="product-grid">
                <!-- Product 1 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <div class="product-visual-placeholder">Jotashield</div>
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Eksterior</span>
                        <span class="product-price">Rp285.000</span>
                    </div>
                    <h3>Jotashield Antifade Colours</h3>
                    <p>Perlindungan cuaca tropis ekstrem yang menjaga warna dinding luar tetap cerah dan bebas jamur hingga bertahun-tahun.</p>
                    <div class="product-swatches">
                        <span style="background-color: #FDB913;" title="Warm Signal Yellow"></span>
                        <span style="background-color: #3D4A5E;" title="Evening Sky"></span>
                        <span style="background-color: #7F8385;" title="Stone Gray"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>

                <!-- Product 2 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <div class="product-visual-placeholder">Majestic</div>
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Interior</span>
                        <span class="product-price">Rp245.000</span>
                    </div>
                    <h3>Majestic True Beauty Matt</h3>
                    <p>Hasil akhir matt yang sangat halus dan mewah untuk dinding dalam ruangan. Mudah dibersihkan dan memiliki kadar VOC yang sangat rendah.</p>
                    <div class="product-swatches">
                        <span style="background-color: #F8F5EC;" title="Classic White"></span>
                        <span style="background-color: #E2E6E7;" title="Morning Fog"></span>
                        <span style="background-color: #7D8C82;" title="Antique Green"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>

                <!-- Product 3 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <div class="product-visual-placeholder">Essence</div>
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Interior</span>
                        <span class="product-price">Rp185.000</span>
                    </div>
                    <h3>Jotun Essence Easy Clean</h3>
                    <p>Didesain untuk kebutuhan harian keluarga. Cat interior ekonomis yang tahan noda ringan, mudah diaplikasikan, dan menutup sempurna.</p>
                    <div class="product-swatches">
                        <span style="background-color: #F7F3EA;" title="Cotton Blossom"></span>
                        <span style="background-color: #E1E3E2;" title="Silver Breeze"></span>
                        <span style="background-color: #D5C2B1;" title="Soft Clay"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>
            </div>
        </div>
    </section>

    <!-- Integrated Paint Calculator -->
    <section class="section alt-bg" id="kalkulator">
        <div class="container form-page-grid">
            <div class="form-help-card">
                <span class="eyebrow">Alat Estimasi</span>
                <h2>Kalkulator Kebutuhan Cat Instan</h2>
                <p>Ketahui volume cat yang diperlukan untuk mengecat ruangan Anda hanya dengan beberapa langkah sederhana.</p>
                <ol>
                    <li>Masukkan ukuran panjang dan tinggi bidang dinding.</li>
                    <li>Pilih standar daya sebar produk cat (rata-rata 10-12 m²/liter).</li>
                    <li>Pilih jumlah lapisan cat yang Anda inginkan (standar profesional 2 lapisan).</li>
                    <li>Sistem akan otomatis menghitung volume cat yang harus Anda beli.</li>
                </ol>
            </div>

            <div class="data-form" data-paint-calculator>
                <div class="form-grid">
                    <div class="field">
                        <label for="panjang_dinding">Panjang Dinding (meter)</label>
                        <input id="panjang_dinding" name="panjang_dinding" type="number" min="0.1" step="0.1" value="6">
                    </div>
                    <div class="field">
                        <label for="tinggi_dinding">Tinggi Dinding (meter)</label>
                        <input id="tinggi_dinding" name="tinggi_dinding" type="number" min="0.1" step="0.1" value="3">
                    </div>
                    <div class="field">
                        <label for="daya_sebar">Daya Sebar Produk</label>
                        <select id="daya_sebar" name="daya_sebar">
                            <option value="10">Jotashield — 10 m²/liter</option>
                            <option value="12" selected>Majestic — 12 m²/liter</option>
                            <option value="11">Essence — 11 m²/liter</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="jumlah_lapisan">Jumlah Lapisan</label>
                        <select id="jumlah_lapisan" name="jumlah_lapisan">
                            <option value="1">1 Lapisan</option>
                            <option value="2" selected>2 Lapisan</option>
                            <option value="3">3 Lapisan</option>
                        </select>
                    </div>
                </div>

                <div class="result-card" style="margin-top: 24px; margin-bottom: 0;">
                    <span>Estimasi Hasil Kalkulasi</span>
                    <strong data-liters-output>3.0 liter</strong>
                    <p>Rekomendasi pembelian minimum: <span data-cans-output style="font-weight: 700;">2 kaleng ukuran 2.5L</span></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Color Studio CTA Banner -->
    <section class="section" style="background-color: var(--surface); text-align: center; border-bottom: 1px solid var(--line);">
        <div class="container" style="max-width: 800px;">
            <span class="eyebrow">Eksperimen Interaktif</span>
            <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Coba Jotun Color Studio Sekarang</h2>
            <p style="color: var(--muted); font-size: 1.1rem; margin-bottom: 32px;">Pilih warna cat, sesuaikan shade kehangatan dan terangnya, dan visualisasikan langsung pada ruangan virtual secara instan sebelum melakukan pemesanan tinting.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('tinting.create') }}" style="font-size: 1.05rem; padding: 14px 32px;">Buka Studio Warna</a>
        </div>
    </section>

    <!-- Branch Location Section -->
    <section class="section branch-map-section" id="lokasi">
        <div class="container">
            <div class="map-card">
                <div class="map-info">
                    <span class="eyebrow">Lokasi Cabang</span>
                    <h3>Kunjungi Toko Kami</h3>
                    <p>Hubungi tim ahli kami secara langsung di cabang Jotun Paint Center terdekat untuk berkonsultasi warna dan memproses pesanan cat tinting Anda.</p>
                    
                    <div class="map-details">
                        <div class="map-detail-item">
                            <div class="map-detail-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="map-detail-content">
                                <strong>Alamat Utama</strong>
                                <span>Jl. Raya Paint Center No. 88, Kota Anda</span>
                            </div>
                        </div>

                        <div class="map-detail-item">
                            <div class="map-detail-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div class="map-detail-content">
                                <strong>Jam Operasional</strong>
                                <span>Senin - Sabtu: 08.00 - 17.00 WIB</span>
                            </div>
                        </div>

                        <div class="map-detail-item">
                            <div class="map-detail-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="map-detail-content">
                                <strong>Hubungi via Telepon / WhatsApp</strong>
                                <span>0812-3456-7890</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-visualizer" aria-hidden="true">
                    <div class="map-graphic">
                        <div class="map-road h"></div>
                        <div class="map-road v"></div>
                        <div class="map-building b1"></div>
                        <div class="map-building b2"></div>
                        <div class="map-pin">
                            <div class="map-pin-pulse"></div>
                            <div class="map-pin-label">Jotun Paint Center</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Front-end Dynamic Swatches Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const heroSwatch = document.getElementById('heroSwatch');
            const heroColorName = document.getElementById('heroColorName');
            const heroColorCode = document.getElementById('heroColorCode');

            const swatches = [
                { name: 'Warm Signal Yellow', code: 'JTN-120', color: '#FDB913' },
                { name: 'Morning Fog', code: 'JTN-002', color: '#E2E6E7' },
                { name: 'Antique Green', code: 'JTN-003', color: '#7D8C82' },
                { name: 'Classic White', code: 'JTN-001', color: '#F8F5EC' },
                { name: 'Soft Clay', code: 'JTN-203', color: '#D5C2B1' },
                { name: 'Evening Sky', code: 'JTN-121', color: '#3D4A5E' }
            ];

            let activeIndex = 0;

            const changeSwatch = () => {
                activeIndex = (activeIndex + 1) % swatches.length;
                const active = swatches[activeIndex];

                if (heroSwatch) {
                    heroSwatch.style.backgroundColor = active.color;
                    heroSwatch.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        heroSwatch.style.transform = 'scale(1)';
                    }, 250);
                }
                if (heroColorName) heroColorName.textContent = active.name;
                if (heroColorCode) heroColorCode.textContent = active.code;
            };

            setInterval(changeSwatch, 3500);
        });
    </script>
</x-layouts.public>

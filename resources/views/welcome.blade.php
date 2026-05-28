<x-layouts.public title="Beranda | Cabang Resmi Jotun Graha Metropolitan Deli Serdang" description="Dealer resmi Jotun Paint Center di Helvetia, Deli Serdang. Dapatkan cat premium eksterior, interior, kayu, dan besi dengan teknologi tinting presisi tinggi.">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Cabang Resmi Jotun Paint Center</span>
                <h1 style="font-size: clamp(2.3rem, 4.5vw, 3.5rem); margin-bottom: 16px;">Perlindungan Berkelas Dunia Untuk Rumah Anda.</h1>
                
                <p style="font-size: 0.95rem; font-weight: 600; color: var(--obsidian); margin-bottom: 12px; display: flex; align-items: flex-start; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--jotun-yellow-hover)" stroke-width="2.5" style="flex-shrink:0; margin-top:2px;">
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Kompleks, Jl. Graha Metropolitan No. 85, Helvetia, Kec. Sunggal, Kab. Deli Serdang, Sumatera Utara</span>
                </p>

                <p style="font-size: 1.05rem; color: var(--muted); margin-bottom: 32px;">
                    Hadirkan keindahan abadi berbekal teknologi perlindungan cat global dari Norwegia. Kami melayani pencampuran warna instan (tinting) terkomputerisasi dengan akurasi sempurna untuk segala jenis kebutuhan hunian Anda.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('tinting.create') }}">Buka Color Studio</a>
                    <a class="btn btn-secondary" href="{{ route('catalog.index') }}">Lihat Pilihan Produk</a>
                </div>

                <div class="hero-features" style="margin-top: 32px;">
                    <div class="feature-item">
                        <h3>1926</h3>
                        <p>Warisan Norwegia</p>
                    </div>
                    <div class="feature-item">
                        <h3>10K+</h3>
                        <p>Pilihan Warna</p>
                    </div>
                    <div class="feature-item">
                        <h3>Presisi</h3>
                        <p>Multicolor Tinting</p>
                    </div>
                </div>
            </div>

            <div class="hero-visual" aria-hidden="true">
                <div class="visual-canvas">
                    <div class="visual-swatch" id="heroSwatch"></div>
                    <div class="visual-info">
                        <strong id="heroColorName">Fenomastic Morning Fog</strong>
                        <span id="heroColorCode">JTN-9918</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Profile & Strengths -->
    <section class="section alt-bg">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Profil & Keunggulan</span>
                <h2>Jotun: Melindungi Struktur Ikonis Dunia</h2>
                <p>Didirikan di Sandefjord, Norwegia pada tahun 1926, Jotun adalah salah satu produsen cat terbesar di dunia yang dipercaya melindungi bangunan-bangunan termegah seperti Menara Eiffel dan Burj Khalifa. Kini, standar perlindungan berkelas dunia tersebut hadir langsung di lingkungan Anda.</p>
            </div>

            <div class="services-grid">
                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3>TrueColour Technology</h3>
                    <p>Cat Jotun dirancang menggunakan formula pigmen murni pilihan yang menjamin konsistensi warna yang cerah, tidak mudah pudar akibat paparan sinar matahari tropis, serta menutup permukaan dinding dengan sempurna.</p>
                </article>

                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3>Sertifikasi Ramah Lingkungan</h3>
                    <p>Produk interior kami tersertifikasi "Green Product" karena rendah emisi VOC (Volatile Organic Compounds), bebas dari bahan kimia berbahaya, serta tidak berbau sehingga ruangan langsung aman dihuni setelah dicat.</p>
                </article>

                <article class="service-card">
                    <div class="service-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3>Ketahanan Cuaca Tropis</h3>
                    <p>Dilengkapi teknologi anti-lumut, anti-jamur, serta kemampuan menolak air (waterproofing) superior yang menjaga eksterior bangunan terhindar dari pengelupasan dan keretakan struktural.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Detailed Color Tinting System Feature -->
    <section class="section" style="background-color: var(--surface);">
        <div class="container hero-grid" style="grid-template-columns: 0.95fr 1.05fr; gap: 64px;">
            <div class="hero-visual" style="height: 380px;" aria-hidden="true">
                <img src="/images/tinting-process.webp" alt="Proses tinting warna Jotun Multicolor" style="width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius-md);">
            </div>
            
            <div>
                <span class="eyebrow">Teknologi Utama</span>
                <h2 style="font-size: 2.2rem; margin-bottom: 20px;">Sistem Tinting Warna Instan & Kustom</h2>
                <p style="color: var(--muted); margin-bottom: 16px; line-height: 1.7;">
                    Di cabang **Jotun Graha Metropolitan Deli Serdang**, Anda tidak perlu lagi terbatas pada warna cat kalengan pabrik yang kaku. Melalui mesin dispenser **Jotun Multicolor**, kami dapat memformulasikan warna kustom secara presisi hanya dalam waktu kurang dari 3 menit.
                </p>
                <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.7;">
                    Teknologi terkomputerisasi kami menjamin konsistensi formula pigmen yang sama persis saat Anda membutuhkan pembelian tambahan di masa mendatang. Kami menyediakan racikan cat khusus untuk:
                </p>
                
                <ul style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; list-style: none; color: var(--obsidian); font-weight: 600; font-size: 0.9rem;">
                    <li style="display:flex; align-items:center; gap:8px;">
                        <span style="width:6px; height:6px; background-color:var(--jotun-yellow); border-radius:50%;"></span>
                        Dinding Interior (Matt & Sheen)
                    </li>
                    <li style="display:flex; align-items:center; gap:8px;">
                        <span style="width:6px; height:6px; background-color:var(--jotun-yellow); border-radius:50%;"></span>
                        Dinding Eksterior Tahan Cuaca
                    </li>
                    <li style="display:flex; align-items:center; gap:8px;">
                        <span style="width:6px; height:6px; background-color:var(--jotun-yellow); border-radius:50%;"></span>
                        Cat Kayu (Woodshield)
                    </li>
                    <li style="display:flex; align-items:center; gap:8px;">
                        <span style="width:6px; height:6px; background-color:var(--jotun-yellow); border-radius:50%;"></span>
                        Cat Besi Anti-Karat (Gardex)
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Popular Products Showcase -->
    <section class="section alt-bg">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">Katalog Cat Real</span>
                <h2>Pilihan Seri Produk Cat Terbaik Jotun</h2>
                <p>Formula khusus berstandar internasional yang disesuaikan untuk setiap permukaan properti Anda.</p>
            </div>

            <div class="product-grid">
                <!-- Product 1 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <img class="product-image" src="/images/jotashield.webp" alt="Jotashield Antifade Colours">
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Eksterior</span>
                        <span class="product-price">Rp285.000</span>
                    </div>
                    <h3>Jotashield Antifade Colours</h3>
                    <p>Melindungi dinding luar rumah secara maksimal dari sinar UV matahari tropis, jamur, serta pengelupasan akibat hujan deras.</p>
                    <div class="product-swatches">
                        <span style="background-color: #FDB913;" title="Warm Signal Yellow (JTN-120)"></span>
                        <span style="background-color: #3D4A5E;" title="Evening Sky (JTN-121)"></span>
                        <span style="background-color: #7F8385;" title="Stone Gray (JTN-123)"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>

                <!-- Product 2 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <img class="product-image" src="/images/majestic-sense.webp" alt="Majestic Sense">
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Interior Premium</span>
                        <span class="product-price">Rp320.000</span>
                    </div>
                    <h3>Majestic Sense</h3>
                    <p>Cat interior termewah Jotun yang menghasilkan dinding halus nan indah, memiliki formulasi pembersih udara, serta tanpa bau.</p>
                    <div class="product-swatches">
                        <span style="background-color: #F8F5EC;" title="Classic White (JTN-001)"></span>
                        <span style="background-color: #E2E6E7;" title="Morning Fog (JTN-002)"></span>
                        <span style="background-color: #7D8C82;" title="Antique Green (JTN-003)"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>

                <!-- Product 3 -->
                <article class="product-card">
                    <div class="product-visual-box">
                        <img class="product-image" src="/images/gardex.webp" alt="Gardex Premium Gloss">
                    </div>
                    <div class="product-meta">
                        <span class="product-cat">Kayu & Besi</span>
                        <span class="product-price">Rp195.000</span>
                    </div>
                    <h3>Gardex Premium Gloss</h3>
                    <p>Cat kayu dan besi premium berpelarut minyak dengan bau sangat rendah, formula cepat kering, serta pelindung karat optimal.</p>
                    <div class="product-swatches">
                        <span style="background-color: #F7F3EA;" title="Cotton Blossom (JTN-201)"></span>
                        <span style="background-color: #E1E3E2;" title="Silver Breeze (JTN-202)"></span>
                        <span style="background-color: #D5C2B1;" title="Soft Clay (JTN-203)"></span>
                    </div>
                    <a class="card-link" href="{{ route('catalog.index') }}">Pelajari Produk</a>
                </article>
            </div>
        </div>
    </section>

    <!-- Integrated Paint Calculator -->
    <section class="section" id="kalkulator">
        <div class="container form-page-grid">
            <div class="form-help-card">
                <span class="eyebrow">Alat Konsultasi Cat</span>
                <h2>Estimasi Volume Cat Dinding Instan</h2>
                <p>Gunakan kalkulator cat kami untuk memperkirakan volume liter yang Anda butuhkan sebelum melakukan tinting di kasir cabang kami.</p>
                <ol style="margin-top: 16px;">
                    <li>Ketik ukuran panjang dan tinggi area dinding.</li>
                    <li>Sistem otomatis menghitung volume cat (daya sebar rata-rata 10-12 m²/liter per lapis).</li>
                    <li>Kami menyarankan 2 lapisan cat untuk tingkat kedalaman warna maksimal.</li>
                </ol>
            </div>

            <div class="data-form" data-paint-calculator>
                <div class="form-grid">
                    <div class="field">
                        <label for="panjang_dinding">Panjang Bidang (meter)</label>
                        <input id="panjang_dinding" name="panjang_dinding" type="number" min="0.1" step="0.1" value="6">
                    </div>
                    <div class="field">
                        <label for="tinggi_dinding">Tinggi Bidang (meter)</label>
                        <input id="tinggi_dinding" name="tinggi_dinding" type="number" min="0.1" step="0.1" value="3">
                    </div>
                    <div class="field">
                        <label for="daya_sebar">Daya Sebar Cat</label>
                        <select id="daya_sebar" name="daya_sebar">
                            <option value="10">Jotashield — 10 m²/liter</option>
                            <option value="12" selected>Majestic — 12 m²/liter</option>
                            <option value="11">Essence / Gardex — 11 m²/liter</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="jumlah_lapisan">Jumlah Lapisan</label>
                        <select id="jumlah_lapisan" name="jumlah_lapisan">
                            <option value="1">1 Lapisan (Tipis)</option>
                            <option value="2" selected>2 Lapisan (Rekomendasi)</option>
                            <option value="3">3 Lapisan (Tebal)</option>
                        </select>
                    </div>
                </div>

                <div class="result-card" style="margin-top: 24px; margin-bottom: 0;">
                    <span>Hasil Estimasi Kebutuhan</span>
                    <strong data-liters-output>3.0 liter</strong>
                    <p>Perkiraan pembelian minimum: <span data-cans-output style="font-weight: 700;">2 kaleng (2.5L)</span></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Branch Location Section -->
    <section class="section branch-map-section alt-bg" id="lokasi">
        <div class="container">
            <div class="map-card">
                <div class="map-info">
                    <span class="eyebrow">Dealer Resmi</span>
                    <h3>Jotun Graha Metropolitan</h3>
                    <p>Hubungi atau kunjungi langsung showroom kami di Deli Serdang untuk melihat katalog warna fisik, berkonsultasi dengan pakar warna, serta melakukan pencampuran cat menggunakan mesin tinting instan.</p>
                    
                    <div class="map-details">
                        <div class="map-detail-item">
                            <div class="map-detail-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="map-detail-content">
                                <strong>Alamat Cabang Graha Metropolitan</strong>
                                <span>Kompleks, Jl. Graha Metropolitan No. 85, Helvetia, Kec. Sunggal, Kabupaten Deli Serdang, Sumatera Utara</span>
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
                                <strong>Jam Operasional Showroom</strong>
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
                                <strong>Kontak Showroom / WhatsApp</strong>
                                <span>0812-3456-7890</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-visualizer" aria-hidden="true">
                    <div class="map-graphic">
                        <div class="map-road h"></div>
                        <div class="map-road v"></div>
                        <div class="map-building b1" style="background-color: var(--line);"></div>
                        <div class="map-building b2" style="background-color: var(--line);"></div>
                        <div class="map-pin">
                            <div class="map-pin-pulse"></div>
                            <div class="map-pin-label">Jotun Graha Metropolitan</div>
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
                { name: 'Morning Fog (Fenomastic)', code: 'JTN-9918', color: '#E2E6E7' },
                { name: 'Warm Signal Yellow', code: 'JTN-120', color: '#FDB913' },
                { name: 'Antique Green', code: 'JTN-003', color: '#7D8C82' },
                { name: 'Classic White', code: 'JTN-001', color: '#F8F5EC' },
                { name: 'Soft Clay (Essence)', code: 'JTN-203', color: '#D5C2B1' },
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

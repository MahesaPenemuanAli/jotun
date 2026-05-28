<x-layouts.public title="Kalkulator Cat Pintar & Estimasi Budget" description="Hitung estimasi kebutuhan liter cat Jotun Anda berdasarkan ukuran ruangan.">
    <section class="hero" style="padding: 80px 0 64px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Alat Konsultasi Mandiri</span>
            <h1 style="font-size: 2.8rem; margin-bottom: 16px;">Kalkulator Kebutuhan Cat</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 720px;">
                Hitung perkiraan volume cat yang dibutuhkan sebelum Anda melakukan pembelian di cabang Graha Metropolitan Deli Serdang.
                @auth
                    Hasil kalkulasi akan otomatis tersimpan di <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" style="color: var(--jotun-yellow-hover); font-weight:700;">riwayat akun Anda</a>.
                @endauth
            </p>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container">
            <form class="data-form" method="POST" action="{{ route('calculator.store') }}" data-paint-calculator-form>
                @csrf

                @if (session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif

                @if (session('calculator_result'))
                    @php($result = session('calculator_result'))
                    <div class="result-card">
                        <span>Hasil Perhitungan Terakhir Anda</span>
                        <strong>{{ $result['hasil_liter'] }} Liter Cat</strong>
                        <p>
                            Rekomendasi Pembelian: <span style="font-weight: 800; color: var(--obsidian);">{{ $result['jumlah_kaleng'] }} Kaleng (Ukuran 2.5L)</span>
                        </p>
                        <p style="font-size: 0.8rem; margin-top: 8px; border-top: 1px solid rgba(0,0,0,0.08); padding-top: 8px; opacity: 0.8;">
                            Rincian: {{ $result['produk'] }} · Luas Bidang {{ $result['luas_dinding'] }} m² · Pengecatan {{ $result['jumlah_lapisan'] }} Lapis.
                        </p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert error">
                        <strong>Periksa kembali input Anda:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Identitas Pelanggan (hanya untuk tamu) -->
                @guest
                    <h3 style="margin-bottom: 16px; font-size: 1rem; font-weight: 700;">Data Pelanggan</h3>
                    <div class="form-grid">
                        <div class="field">
                            <label for="nama_pelanggan">Nama Lengkap Anda</label>
                            <input id="nama_pelanggan" name="nama_pelanggan" type="text" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div class="field">
                            <label for="no_hp">Nomor HP Aktif</label>
                            <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" placeholder="0812xxxxxxxx" required>
                        </div>
                        <div class="field full-field">
                            <label for="email">Alamat Email (Opsional)</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="budi@example.com">
                        </div>
                    </div>
                    <hr style="border: none; border-top: 1px solid var(--line); margin: 28px 0;">
                @endguest

                <h3 style="margin-bottom: 16px; font-size: 1rem; font-weight: 700;">Ukuran & Produk</h3>
                <div class="form-grid">
                    <div class="field full-field">
                        <label for="id_produk">Tipe Cat & Daya Sebar</label>
                        <select id="id_produk" name="id_produk" required @disabled($products->isEmpty())>
                            @forelse ($products as $product)
                                <option value="{{ $product->id_produk }}" data-spread="{{ $product->daya_sebar ?: 10 }}" @selected(old('id_produk') === $product->id_produk)>
                                    {{ $product->nama_produk }} ({{ $product->kategori }}) — {{ $product->daya_sebar ?: 10 }} m²/liter
                                </option>
                            @empty
                                <option value="">Produk cat belum tersedia</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="field">
                        <label for="panjang_dinding">Total Panjang Bidang (m)</label>
                        <input id="panjang_dinding" name="panjang_dinding" type="number" min="0.1" step="0.1" value="{{ old('panjang_dinding', 6) }}" required>
                    </div>
                    <div class="field">
                        <label for="tinggi_dinding">Tinggi Bidang Dinding (m)</label>
                        <input id="tinggi_dinding" name="tinggi_dinding" type="number" min="0.1" step="0.1" value="{{ old('tinggi_dinding', 3) }}" required>
                    </div>
                    <div class="field full-field">
                        <label for="jumlah_lapisan">Jumlah Lapisan Cat</label>
                        <select id="jumlah_lapisan" name="jumlah_lapisan" required>
                            <option value="1" @selected((int) old('jumlah_lapisan', 2) === 1)>1 Lapisan</option>
                            <option value="2" @selected((int) old('jumlah_lapisan', 2) === 2)>2 Lapisan (Rekomendasi)</option>
                            <option value="3" @selected((int) old('jumlah_lapisan', 2) === 3)>3 Lapisan (Warna Kontras)</option>
                        </select>
                    </div>
                </div>

                <!-- Live Visualization -->
                <div class="calc-visual-section">
                    <!-- Wall Preview -->
                    <div class="wall-preview-box">
                        <h4 style="font-size: 0.85rem; color: var(--muted); margin-bottom: 16px; font-weight: 600;">Ilustrasi Bidang Dinding</h4>
                        <svg id="wallSvg" viewBox="0 0 300 200" style="width: 100%; max-width: 300px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--bg-light);">
                            <rect id="wallRect" x="30" y="20" width="240" height="160" fill="var(--jotun-yellow-soft)" stroke="var(--jotun-yellow)" stroke-width="2" rx="3"/>
                            <text id="wallWidthLabel" x="150" y="195" text-anchor="middle" font-size="11" fill="var(--muted)" font-weight="700">6.0 m</text>
                            <text id="wallHeightLabel" x="15" y="105" text-anchor="middle" font-size="11" fill="var(--muted)" font-weight="700" transform="rotate(-90, 15, 105)">3.0 m</text>
                            <text id="wallAreaLabel" x="150" y="105" text-anchor="middle" font-size="16" fill="var(--obsidian)" font-weight="800">18.0 m²</text>
                        </svg>
                    </div>

                    <!-- Result Cards -->
                    <div>
                        <h4 style="font-size: 0.85rem; color: var(--muted); margin-bottom: 16px; font-weight: 600;">Estimasi Kebutuhan Cat</h4>
                        <div class="calc-results-grid">
                            <div class="calc-result-item">
                                <span class="result-num" id="calcArea">18.0</span>
                                <span class="result-label">Luas Bidang (m²)</span>
                            </div>
                            <div class="calc-result-item">
                                <span class="result-num" id="calcPaintArea">36.0</span>
                                <span class="result-label">Total Area Cat (m²)</span>
                            </div>
                            <div class="calc-result-item highlight">
                                <span class="result-num" id="calcLiters">3.0</span>
                                <span class="result-label">Liter Cat Dibutuhkan</span>
                            </div>
                            <div class="calc-result-item highlight">
                                <span class="result-num" id="calcCans">2</span>
                                <span class="result-label">Kaleng (2.5L)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary form-submit" type="submit" style="margin-top: 32px;" @disabled($products->isEmpty())>
                    @auth
                        Hitung & Simpan ke Riwayat Akun
                    @else
                        Hitung & Simpan Riwayat Estimasi
                    @endauth
                </button>
            </form>
        </div>
    </section>
</x-layouts.public>

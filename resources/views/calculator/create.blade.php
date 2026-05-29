<x-layouts.public title="Kalkulator Cat Pintar & Estimasi Budget" description="Hitung estimasi kebutuhan liter cat Jotun Anda berdasarkan ukuran ruangan.">
    <section class="hero" style="padding: 80px 0 64px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Alat Konsultasi Mandiri</span>
            <h1 style="font-size: 2.8rem; margin-bottom: 16px;">Kalkulator Kebutuhan Cat</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 720px;">
                Hitung perkiraan volume cat yang dibutuhkan sebelum Anda melakukan pembelian di cabang Graha Metropolitan.
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

                {{-- Smart Result Card --}}
                @if (session('calculator_result'))
                    @php($result = session('calculator_result'))
                    <div class="result-card">
                        <span>Hasil Perhitungan — {{ $result['produk'] }}</span>
                        <strong>{{ $result['hasil_liter'] }} Liter Cat Dibutuhkan</strong>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin:16px 0;font-size:0.85rem;">
                            <div><span style="color:var(--muted)">Luas Dinding</span><br><strong>{{ $result['luas_dinding'] }} m²</strong></div>
                            <div><span style="color:var(--muted)">Lapisan</span><br><strong>{{ $result['jumlah_lapisan'] }}x</strong></div>
                            <div><span style="color:var(--muted)">Daya Sebar</span><br><strong>{{ $result['daya_sebar'] }} m²/L</strong></div>
                            <div><span style="color:var(--muted)">Total Area</span><br><strong>{{ $result['total_area'] }} m²</strong></div>
                        </div>

                        @if (!empty($result['rekomendasi']))
                            <div style="border-top:1px solid rgba(0,0,0,0.08);padding-top:14px;margin-top:8px;">
                                <strong style="font-size:0.9rem;display:block;margin-bottom:8px;">Rekomendasi Pembelian Kaleng:</strong>
                                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                                    @foreach ($result['rekomendasi'] as $item)
                                        <span style="background:var(--jotun-yellow-soft);padding:6px 14px;border-radius:6px;font-size:0.85rem;font-weight:600;">
                                            {{ $item['jumlah'] }}x {{ $item['ukuran'] }}L
                                            @if ($item['harga'])
                                                <span style="font-weight:400;color:var(--muted);margin-left:4px;">@ Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                                <div style="margin-top:10px;font-size:0.82rem;color:var(--muted);">
                                    Total cat dibeli: <strong style="color:var(--obsidian)">{{ $result['total_liter_beli'] }}L</strong>
                                    · Estimasi sisa: <strong>{{ $result['sisa_liter'] }}L</strong>
                                    @if ($result['estimasi_harga'])
                                        · Estimasi biaya: <strong style="color:var(--jotun-yellow-hover)">Rp{{ number_format($result['estimasi_harga'], 0, ',', '.') }}</strong>
                                    @endif
                                </div>
                            </div>
                        @endif
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
                                <option value="{{ $product->id_produk }}"
                                        data-spread="{{ $product->daya_sebar ?: 10 }}"
                                        data-sizes='@json($product->ukuranAktif->map(fn($u) => ["liter" => (float)$u->ukuran_liter, "harga" => $u->harga]))'
                                        @selected(old('id_produk') === $product->id_produk)>
                                    {{ $product->nama_produk }} ({{ $product->kategori }}{{ $product->tipe_produk !== 'finishing' ? ' · '.ucfirst($product->tipe_produk ?? '') : '' }}) — {{ $product->daya_sebar ?: 10 }} m²/L
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
                    <div class="wall-preview-box">
                        <h4 style="font-size: 0.85rem; color: var(--muted); margin-bottom: 16px; font-weight: 600;">Ilustrasi Bidang Dinding</h4>
                        <svg id="wallSvg" viewBox="0 0 300 200" style="width: 100%; max-width: 300px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--bg-light);">
                            <rect id="wallRect" x="30" y="20" width="240" height="160" fill="var(--jotun-yellow-soft)" stroke="var(--jotun-yellow)" stroke-width="2" rx="3"/>
                            <text id="wallWidthLabel" x="150" y="195" text-anchor="middle" font-size="11" fill="var(--muted)" font-weight="700">6.0 m</text>
                            <text id="wallHeightLabel" x="15" y="105" text-anchor="middle" font-size="11" fill="var(--muted)" font-weight="700" transform="rotate(-90, 15, 105)">3.0 m</text>
                            <text id="wallAreaLabel" x="150" y="105" text-anchor="middle" font-size="16" fill="var(--obsidian)" font-weight="800">18.0 m²</text>
                        </svg>
                    </div>

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
                                <span class="result-label">Kaleng Dibutuhkan</span>
                            </div>
                        </div>
                        <div id="calcRecommendation" style="margin-top:12px;font-size:0.82rem;color:var(--muted);"></div>
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

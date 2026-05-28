<x-layouts.public title="Kalkulator Cat Pintar & Estimasi Budget" description="Hitung estimasi kebutuhan liter cat Jotun Anda berdasarkan ukuran ruangan dan simpan riwayat estimasi Anda untuk mempermudah pembelian di toko.">
    <!-- Header Hero -->
    <section class="hero" style="padding: 80px 0 64px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Alat Konsultasi Mandiri</span>
            <h1 style="font-size: 2.8rem; margin-bottom: 16px;">Kalkulator Kebutuhan Cat</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 720px; margin-bottom: 0;">
                Hitung perkiraan volume cat yang dibutuhkan sebelum Anda melakukan pembelian. Data perhitungan Anda akan otomatis tersimpan dalam sistem agar staff toko kami dapat langsung mempersiapkan pesanan Anda secara instan saat Anda berkunjung ke cabang kami.
            </p>
        </div>
    </section>

    <!-- Calculator Section -->
    <section class="section alt-bg">
        <div class="container form-page-grid">
            <!-- Sidebar Info -->
            <div class="form-help-card">
                <h2>Panduan Estimasi</h2>
                <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 24px; line-height: 1.6;">
                    Mengetahui jumlah cat yang tepat membantu Anda menghemat biaya dan meminimalkan sisa cat yang terbuang.
                </p>
                <ol>
                    <li>Masukkan nama lengkap dan nomor HP Anda untuk melacak riwayat kalkulasi saat bertransaksi di kasir cabang kami.</li>
                    <li>Pilih tipe produk cat yang Anda inginkan (daya sebar cat eksterior dan interior dapat berbeda).</li>
                    <li>Masukkan ukuran total panjang bidang dinding dan tingginya secara akurat.</li>
                    <li>Pilih jumlah lapisan pengecatan. Standar profesional untuk hasil warna yang maksimal adalah 2 lapisan cat.</li>
                </ol>
            </div>

            <!-- Calculation Form -->
            <form class="data-form" method="POST" action="{{ route('calculator.store') }}">
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

                <div class="form-grid">
                    <div class="field">
                        <label for="nama_pelanggan">Nama Lengkap Anda</label>
                        <input id="nama_pelanggan" name="nama_pelanggan" type="text" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="field">
                        <label for="no_hp">Nomor HP Aktif</label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" placeholder="Contoh: 0812xxxxxxxx" required>
                    </div>

                    <div class="field full-field">
                        <label for="email">Alamat Email (Opsional)</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="budi@example.com">
                    </div>

                    <div class="field full-field">
                        <label for="id_produk">Tipe Cat & Daya Sebar</label>
                        <select id="id_produk" name="id_produk" required @disabled($products->isEmpty())>
                            @forelse ($products as $product)
                                <option value="{{ $product->id_produk }}" @selected(old('id_produk') === $product->id_produk)>
                                    {{ $product->nama_produk }} ({{ $product->kategori }}) — Daya Sebar: {{ $product->daya_sebar ?: 10 }} m²/liter
                                </option>
                            @empty
                                <option value="">Produk cat belum tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="field">
                        <label for="panjang_dinding">Total Panjang Bidang (Meter)</label>
                        <input id="panjang_dinding" name="panjang_dinding" type="number" min="0.1" step="0.1" value="{{ old('panjang_dinding', 6) }}" required>
                    </div>

                    <div class="field">
                        <label for="tinggi_dinding">Tinggi Bidang Dinding (Meter)</label>
                        <input id="tinggi_dinding" name="tinggi_dinding" type="number" min="0.1" step="0.1" value="{{ old('tinggi_dinding', 3) }}" required>
                    </div>

                    <div class="field full-field">
                        <label for="jumlah_lapisan">Jumlah Lapisan Cat</label>
                        <select id="jumlah_lapisan" name="jumlah_lapisan" required>
                            <option value="1" @selected((int) old('jumlah_lapisan', 2) === 1)>1 Lapisan (Pengecatan Ulang Tipis)</option>
                            <option value="2" @selected((int) old('jumlah_lapisan', 2) === 2)>2 Lapisan (Standar Profesional Rekomendasi)</option>
                            <option value="3" @selected((int) old('jumlah_lapisan', 2) === 3)>3 Lapisan (Warna Khusus Kontras Tinggi)</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary form-submit" type="submit" @disabled($products->isEmpty())>
                    Hitung & Simpan Riwayat Estimasi
                </button>
            </form>
        </div>
    </section>
</x-layouts.public>

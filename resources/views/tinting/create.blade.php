<x-layouts.public title="Jotun Color Studio | Pencampuran Warna Premium" description="Eksperimen dengan campuran warna cat Jotun di Color Studio interaktif.">
    <!-- Header Hero -->
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Studio Pencampuran Warna</span>
            <h1 style="font-size: 2.8rem; margin-bottom: 16px;">Jotun Color Studio</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 800px; margin-bottom: 0;">
                Eksperimen secara visual dengan kombinasi warna cat premium kami. Pilih jenis cat, tentukan warna dasar, dan sesuaikan shade Anda. Formula kustom Anda akan dikirim ke mesin tinting cabang <strong>Graha Metropolitan Deli Serdang</strong>.
            </p>
        </div>
    </section>

    <!-- Interactive Workspace Section -->
    <section class="section alt-bg" style="padding: 56px 0;">
        <div class="container">
            <form class="color-studio" method="POST" action="{{ route('tinting.store') }}" data-tinting-studio-form>
                @csrf

                <!-- Left Panel: Workplace -->
                <div class="studio-workplace">
                    @if (session('success'))
                        <div class="alert success" style="margin-bottom: 0; width: 100%;">
                            <strong>Pemesanan Berhasil!</strong><br>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert error" style="margin-bottom: 0; width: 100%;">
                            <strong>Periksa Kembali Input Anda:</strong>
                            <ul style="margin-top: 4px; padding-left: 16px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Pilih Produk Cat -->
                    <div class="studio-step">
                        <h3><span class="step-number">1</span> Pilih Tipe Cat Premium</h3>
                        <div class="studio-product-grid">
                            @forelse ($products as $product)
                                <div class="studio-product-card @if($loop->first) active @endif"
                                     data-product-card-id="{{ $product->id_produk }}"
                                     data-product-price="{{ $product->harga }}"
                                     data-product-category="{{ $product->kategori }}"
                                     data-product-spread="{{ $product->daya_sebar ?? '10' }}">
                                    <div class="active-badge" aria-hidden="true">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#0E1118" stroke-width="4">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </div>
                                    <h4>{{ $product->nama_produk }}</h4>
                                    <p>{{ $product->kategori }} · Rp{{ number_format($product->harga, 0, ',', '.') }}</p>
                                </div>
                            @empty
                                <div style="grid-column: 1/-1; text-align: center; color: var(--muted); padding: 12px; border: 1px dashed var(--line); border-radius: var(--radius-sm);">
                                    Produk cat belum tersedia
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Step 2: Pilih Warna Dasar -->
                    <div class="studio-step">
                        <h3><span class="step-number">2</span> Pilih Warna Dasar Cat</h3>

                        <!-- Search & Filter Controls -->
                        <div class="color-picker-controls" style="margin-bottom:16px; display:flex; flex-direction:column; gap:12px;">
                            <div class="field" style="margin:0">
                                <input type="text" id="colorSearch" placeholder="Cari nama atau kode warna..." style="width:100%; min-height:42px; padding:10px 16px; border:1px solid var(--line); border-radius:var(--radius-sm); font-size:0.9rem; background:var(--surface); color:var(--ink);">
                            </div>

                            <div class="color-category-filters" style="display:flex; gap:6px; overflow-x:auto; padding-bottom:6px; scrollbar-width:none;-webkit-overflow-scrolling:touch;">
                                <button type="button" class="filter-pill active" data-filter="all">Semua</button>
                                <button type="button" class="filter-pill" data-filter="Putih">Putih</button>
                                <button type="button" class="filter-pill" data-filter="Abu-abu">Abu-abu</button>
                                <button type="button" class="filter-pill" data-filter="Biru">Biru</button>
                                <button type="button" class="filter-pill" data-filter="Hijau">Hijau</button>
                                <button type="button" class="filter-pill" data-filter="Kuning">Kuning</button>
                                <button type="button" class="filter-pill" data-filter="Merah">Merah</button>
                                <button type="button" class="filter-pill" data-filter="Coklat">Coklat</button>
                                <button type="button" class="filter-pill" data-filter="Netral">Netral</button>
                                <button type="button" class="filter-pill" data-filter="Pastel">Pastel</button>
                                <button type="button" class="filter-pill" data-filter="Gelap">Gelap</button>
                            </div>
                        </div>

                        <!-- No product selected message -->
                        <div id="colorSelectPrompt" style="display:none; text-align:center; color:var(--muted); padding:24px 12px; border:1px dashed var(--line); border-radius:var(--radius-md); background:var(--surface);">
                            Pilih produk terlebih dahulu untuk melihat warna yang tersedia.
                        </div>

                        <!-- Color Grid from Database -->
                        <div class="studio-color-grid" id="colorGridContainer" style="max-height:420px; overflow-y:auto; display:grid; grid-template-columns:repeat(auto-fill, minmax(48px, 1fr)); gap:10px; padding:14px; border:1px solid var(--line); border-radius:var(--radius-md); background:var(--surface);">
                            @foreach ($products as $product)
                                @foreach ($product->warna as $color)
                                    <button type="button"
                                         class="studio-color-chip"
                                         style="background-color: {{ $color->hex_color ?: '#FDB913' }}; aspect-ratio:1; border-radius:50%; border:2px solid var(--surface); box-shadow:0 0 0 1px var(--line); cursor:pointer; position:relative; padding:0; min-width:0;"
                                         title="{{ $color->nama_warna }} ({{ $color->kode_warna }})"
                                         data-color-chip-id="{{ $color->id_warna }}"
                                         data-color-chip-product="{{ $product->id_produk }}"
                                         data-color-chip-hex="{{ $color->hex_color ?: '#FDB913' }}"
                                         data-color-chip-name="{{ $color->nama_warna }}"
                                         data-color-chip-code="{{ $color->kode_warna }}"
                                         data-color-chip-category="{{ $color->kategori_warna ?? 'Netral' }}">
                                    </button>
                                @endforeach
                            @endforeach
                        </div>

                        <!-- No results message -->
                        <div id="colorNoResults" style="display:none; text-align:center; color:var(--muted); padding:16px; font-size:0.9rem;">
                            Tidak ada warna yang cocok dengan filter Anda.
                        </div>

                        <!-- Color count info -->
                        <div id="colorCountInfo" style="margin-top:8px; font-size:0.78rem; color:var(--muted); text-align:right;"></div>

                        <!-- Selected Color Preview Card -->
                        <div class="selected-color-preview-card" style="margin-top:16px; padding:14px 18px; display:flex; align-items:center; gap:16px; border:1px solid var(--line); border-radius:var(--radius-md); background:var(--bg-light); transition: var(--transition);">
                            <div id="previewColorSwatch" style="width:48px; height:48px; border-radius:50%; border:2px solid var(--surface); box-shadow:0 3px 10px rgba(0,0,0,0.08); flex-shrink:0; background-color:#E5E7EB; transition: background-color 0.2s ease;"></div>
                            <div style="flex-grow: 1;">
                                <span style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:var(--jotun-yellow-hover); display:block; letter-spacing:0.05em;" id="previewColorCategory">—</span>
                                <strong style="font-size:1.05rem; color:var(--obsidian); display:block; line-height:1.2; margin-top:2px;" id="previewColorName">Pilih warna dari grid di atas</strong>
                                <code style="font-size:0.8rem; color:var(--muted); font-family:monospace; margin-top:2px; display:inline-block;" id="previewColorCode">—</code>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Visual Preview & Shade Blender -->
                    <div class="studio-step" style="flex-grow: 1; display: flex; flex-direction: column;">
                        <h3><span class="step-number">3</span> Eksperimen Shade & Visualisasi Dinding</h3>

                        <div class="studio-preview-box">
                            <div class="room-preview" id="roomPreviewCanvas">
                                <span class="preview-status" id="activeColorBadge">Belum ada warna dipilih</span>
                                <svg class="room-overlay-svg" viewBox="0 0 800 600" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M 0 0 L 800 0 L 800 600 L 0 600 Z" fill="rgba(0,0,0,0.05)" />
                                    <rect x="480" y="80" width="220" height="240" rx="4" fill="#FFFFFF" stroke="#E5E7EB" stroke-width="6" />
                                    <line x1="590" y1="80" x2="590" y2="320" stroke="#E5E7EB" stroke-width="4" />
                                    <line x1="480" y1="200" x2="700" y2="200" stroke="#E5E7EB" stroke-width="4" />
                                    <rect x="486" y="86" width="98" height="108" fill="rgba(255,255,255,0.25)" />
                                    <polygon points="0,480 800,480 800,600 0,600" fill="#EAEAEF" />
                                    <line x1="0" y1="480" x2="800" y2="480" stroke="#D1D5DB" stroke-width="3" />
                                    <rect x="0" y="468" width="800" height="12" fill="#F9FAFB" stroke="#E5E7EB" stroke-width="1" />
                                    <path d="M 120 480 L 150 480 L 142 420 L 128 420 Z" fill="#D1D5DB" />
                                    <path d="M 115 420 C 100 380 70 390 90 350 C 110 310 135 340 135 340 C 135 340 160 310 180 350 C 200 390 170 380 155 420 Z" fill="#7D8C82" opacity="0.9" />
                                    <rect x="250" y="380" width="100" height="16" rx="4" fill="#1E2229" />
                                    <rect x="270" y="396" width="60" height="84" fill="#334155" />
                                    <line x1="260" y1="396" x2="260" y2="480" stroke="#1E2229" stroke-width="6" stroke-linecap="round" />
                                    <line x1="340" y1="396" x2="340" y2="480" stroke="#1E2229" stroke-width="6" stroke-linecap="round" />
                                    <line x1="280" y1="396" x2="280" y2="480" stroke="#1E2229" stroke-width="4" />
                                    <line x1="320" y1="396" x2="320" y2="480" stroke="#1E2229" stroke-width="4" />
                                    <ellipse cx="300" cy="480" rx="55" ry="8" fill="rgba(0,0,0,0.08)" />
                                </svg>
                            </div>

                            <div class="shade-blender">
                                <div>
                                    <h4>Campur & Blender Shade</h4>
                                    <div class="slider-group">
                                        <div class="slider-field">
                                            <div class="slider-header">
                                                <span>Keterangan Warna (Lightness)</span>
                                                <span id="lightnessVal">100%</span>
                                            </div>
                                            <input type="range" class="studio-slider" id="sliderLightness" min="40" max="160" value="100" aria-label="Keterangan Warna">
                                        </div>
                                        <div class="slider-field">
                                            <div class="slider-header">
                                                <span>Kehangatan Warna (Warmth)</span>
                                                <span id="warmthVal">Karakter Asli</span>
                                            </div>
                                            <input type="range" class="studio-slider" id="sliderWarmth" min="-30" max="30" value="0" aria-label="Kehangatan Warna">
                                        </div>
                                    </div>
                                </div>

                                <div class="formula-display">
                                    <h5>Komposisi Racikan Pigmen Cat</h5>
                                    <div class="formula-bars">
                                        <div class="formula-bar-item">
                                            <span class="formula-label">Base Cat</span>
                                            <div class="formula-track"><div class="formula-fill base" id="formulaBase" style="width: 90%;"></div></div>
                                            <span class="formula-value" id="formulaBaseText">90%</span>
                                        </div>
                                        <div class="formula-bar-item">
                                            <span class="formula-label">Pigmen Kuning</span>
                                            <div class="formula-track"><div class="formula-fill tint-a" id="formulaTintA" style="width: 7%;"></div></div>
                                            <span class="formula-value" id="formulaTintAText">7%</span>
                                        </div>
                                        <div class="formula-bar-item">
                                            <span class="formula-label">Pigmen Merah</span>
                                            <div class="formula-track"><div class="formula-fill tint-b" id="formulaTintB" style="width: 3%;"></div></div>
                                            <span class="formula-value" id="formulaTintBText">3%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Controls & Customer Form -->
                <div class="studio-control-panel">
                    <div class="studio-step">
                        <h3><span class="step-number">4</span> Detail Pemesanan Cat</h3>

                        <div class="field full-field" style="margin-top: 16px;">
                            <label for="jumlah_kaleng">Jumlah Kaleng Cat</label>
                            <input id="jumlah_kaleng" name="jumlah_kaleng" type="number" min="1" max="100" value="{{ old('jumlah_kaleng', 1) }}" required style="width: 100%;">
                        </div>

                        <div class="field full-field" style="margin-top: 16px;">
                            <label for="can_size">Ukuran Kemasan Cat</label>
                            <select id="can_size" name="can_size" style="width: 100%;">
                                <option value="2.5" selected>2.5 Liter (Small Can)</option>
                                <option value="20">20 Liter (Large Pail)</option>
                            </select>
                        </div>
                    </div>

                    <div class="studio-step" style="margin-top: 36px; flex-grow: 1;">
                        <h3><span class="step-number">5</span> Informasi Kontak Pelanggan</h3>

                        @auth
                            <div style="padding:12px 0; font-size:0.9rem; color:var(--muted);">
                                Anda login sebagai <strong>{{ Auth::user()->name }}</strong>. Data pelanggan akan otomatis terhubung ke akun Anda.
                            </div>
                        @else
                            <div class="form-grid" style="grid-template-columns: 1fr; gap: 16px; margin-top: 16px;">
                                <div class="field">
                                    <label for="nama_pelanggan">Nama Lengkap</label>
                                    <input id="nama_pelanggan" name="nama_pelanggan" type="text" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required style="width: 100%;">
                                </div>
                                <div class="field">
                                    <label for="no_hp">Nomor HP / WhatsApp</label>
                                    <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" placeholder="Contoh: 0812xxxxxxxx" required style="width: 100%;">
                                </div>
                                <div class="field">
                                    <label for="email">Alamat Email (Opsional)</label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="budi@example.com" style="width: 100%;">
                                </div>
                            </div>
                        @endauth
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="id_produk" id="selectedProductInput" value="{{ old('id_produk', $products->first()?->id_produk) }}">
                    <input type="hidden" name="id_warna" id="selectedColorInput" value="{{ old('id_warna') }}">

                    <!-- Checkout -->
                    <div class="studio-checkout">
                        <div class="studio-price-box">
                            <span>Estimasi Total Pembayaran</span>
                            <strong id="studioPriceEstimate">Rp0</strong>
                        </div>
                        <button class="btn btn-primary" type="submit" style="width: 100%; height: 50px; font-size: 1rem; font-weight: 700;">
                            Kirim Request Tinting Kustom
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>

<x-layouts.admin :title="'Edit Warna'">

    <div class="admin-card" style="max-width:720px">
        <div class="admin-card-header">
            <h2>Edit Warna: {{ $color->nama_warna }}</h2>
            <a href="{{ route('admin.warna.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">← Kembali</a>
        </div>
        <div class="admin-card-body">
            @if ($errors->any())
                <div class="admin-alert error">
                    <strong>Periksa kembali form:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.warna.update', $color->id_warna) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-field full-width">
                        <label for="id_produk">Produk</label>
                        <select id="id_produk" name="id_produk" required>
                            @foreach ($products as $prod)
                                <option value="{{ $prod->id_produk }}" {{ old('id_produk', $color->id_produk) === $prod->id_produk ? 'selected' : '' }}>{{ $prod->nama_produk }} ({{ $prod->kategori }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label for="nama_warna">Nama Warna</label>
                        <input id="nama_warna" name="nama_warna" type="text" value="{{ old('nama_warna', $color->nama_warna) }}" required>
                    </div>

                    <div class="admin-field">
                        <label for="kode_warna">Kode Warna</label>
                        <input id="kode_warna" name="kode_warna" type="text" value="{{ old('kode_warna', $color->kode_warna) }}">
                    </div>

                    <div class="admin-field">
                        <label for="hex_color">Hex Color</label>
                        <div style="display:flex;gap:10px;align-items:center">
                            <input id="hex_color" name="hex_color" type="text" value="{{ old('hex_color', $color->hex_color) }}" placeholder="#FDB913" style="flex:1" oninput="document.getElementById('color_picker').value=this.value">
                            <input type="color" id="color_picker" value="{{ old('hex_color', $color->hex_color ?? '#FDB913') }}" style="width:44px;height:44px;border:1px solid var(--admin-line);border-radius:10px;padding:2px;cursor:pointer" oninput="document.getElementById('hex_color').value=this.value">
                        </div>
                    </div>

                    <div class="admin-field">
                        <label for="kategori_warna">Kategori Warna</label>
                        <select id="kategori_warna" name="kategori_warna" required>
                            <option value="">Pilih kategori...</option>
                            <option value="Putih" {{ old('kategori_warna', $color->kategori_warna) === 'Putih' ? 'selected' : '' }}>Putih</option>
                            <option value="Abu-abu" {{ old('kategori_warna', $color->kategori_warna) === 'Abu-abu' ? 'selected' : '' }}>Abu-abu</option>
                            <option value="Biru" {{ old('kategori_warna', $color->kategori_warna) === 'Biru' ? 'selected' : '' }}>Biru</option>
                            <option value="Hijau" {{ old('kategori_warna', $color->kategori_warna) === 'Hijau' ? 'selected' : '' }}>Hijau</option>
                            <option value="Kuning" {{ old('kategori_warna', $color->kategori_warna) === 'Kuning' ? 'selected' : '' }}>Kuning</option>
                            <option value="Merah" {{ old('kategori_warna', $color->kategori_warna) === 'Merah' ? 'selected' : '' }}>Merah</option>
                            <option value="Coklat" {{ old('kategori_warna', $color->kategori_warna) === 'Coklat' ? 'selected' : '' }}>Coklat</option>
                            <option value="Netral" {{ old('kategori_warna', $color->kategori_warna) === 'Netral' ? 'selected' : '' }}>Netral</option>
                            <option value="Pastel" {{ old('kategori_warna', $color->kategori_warna) === 'Pastel' ? 'selected' : '' }}>Pastel</option>
                            <option value="Gelap" {{ old('kategori_warna', $color->kategori_warna) === 'Gelap' ? 'selected' : '' }}>Gelap</option>
                        </select>
                    </div>

                    <div class="admin-field full-width">
                        <label>Gambar Warna</label>

                        @if ($color->gambar)
                            <div style="margin-bottom:10px;display:flex;align-items:center;gap:12px">
                                <img class="img-thumb" style="width:64px;height:64px"
                                     src="{{ str_starts_with($color->gambar, 'http') ? $color->gambar : asset('storage/'.$color->gambar) }}"
                                     alt="{{ $color->nama_warna }}">
                                <span style="font-size:0.85rem;color:var(--admin-muted)">Gambar saat ini</span>
                            </div>
                        @endif

                        <div class="image-mode-tabs">
                            <button type="button" class="image-mode-tab active" onclick="switchImageMode('url', this)">URL Gambar</button>
                            <button type="button" class="image-mode-tab" onclick="switchImageMode('upload', this)">Upload File</button>
                        </div>

                        <input type="hidden" name="gambar_mode" id="gambar_mode" value="url">

                        <div id="gambar_url_field">
                            <input name="gambar_url" type="url" value="{{ old('gambar_url', str_starts_with($color->gambar ?? '', 'http') ? $color->gambar : '') }}" placeholder="https://example.com/warna.jpg">
                            <span class="field-hint">Kosongkan jika tidak ingin mengubah gambar.</span>
                        </div>

                        <div id="gambar_upload_field" style="display:none">
                            <div class="file-upload-zone">
                                <input name="gambar_file" type="file" accept="image/*">
                            </div>
                            <span class="field-hint">Max 2MB. Format: JPG, PNG, WEBP.</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top:24px;display:flex;gap:10px">
                    <button type="submit" class="admin-btn admin-btn-primary">Perbarui Warna</button>
                    <a href="{{ route('admin.warna.index') }}" class="admin-btn admin-btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchImageMode(mode, btn) {
            document.getElementById('gambar_mode').value = mode;
            document.getElementById('gambar_url_field').style.display = mode === 'url' ? '' : 'none';
            document.getElementById('gambar_upload_field').style.display = mode === 'upload' ? '' : 'none';
            document.querySelectorAll('.image-mode-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>

</x-layouts.admin>

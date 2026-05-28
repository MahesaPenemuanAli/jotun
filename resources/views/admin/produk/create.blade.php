<x-layouts.admin :title="'Tambah Produk'">

    <div class="admin-card" style="max-width:720px">
        <div class="admin-card-header">
            <h2>Tambah Produk Baru</h2>
            <a href="{{ route('admin.produk.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">← Kembali</a>
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

            <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="admin-form-grid">
                    <div class="admin-field">
                        <label for="nama_produk">Nama Produk</label>
                        <input id="nama_produk" name="nama_produk" type="text" value="{{ old('nama_produk') }}" required placeholder="Contoh: Jotashield Antifade">
                    </div>

                    <div class="admin-field">
                        <label for="kategori">Kategori</label>
                        <input id="kategori" name="kategori" type="text" value="{{ old('kategori') }}" required placeholder="Contoh: Eksterior, Interior, Primer">
                    </div>

                    <div class="admin-field">
                        <label for="harga">Harga (Rp)</label>
                        <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', 0) }}" required>
                    </div>

                    <div class="admin-field">
                        <label for="daya_sebar">Daya Sebar (m²/liter)</label>
                        <input id="daya_sebar" name="daya_sebar" type="number" min="0" step="0.01" value="{{ old('daya_sebar') }}" placeholder="Contoh: 12.00">
                    </div>

                    <div class="admin-field full-width">
                        <label>Gambar Produk</label>

                        <div class="image-mode-tabs">
                            <button type="button" class="image-mode-tab active" onclick="switchImageMode('url', this)">URL Gambar</button>
                            <button type="button" class="image-mode-tab" onclick="switchImageMode('upload', this)">Upload File</button>
                        </div>

                        <input type="hidden" name="gambar_mode" id="gambar_mode" value="url">

                        <div id="gambar_url_field">
                            <input name="gambar_url" type="url" value="{{ old('gambar_url') }}" placeholder="https://example.com/gambar.jpg">
                            <span class="field-hint">Paste URL gambar dari internet.</span>
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
                    <button type="submit" class="admin-btn admin-btn-primary">Simpan Produk</button>
                    <a href="{{ route('admin.produk.index') }}" class="admin-btn admin-btn-outline">Batal</a>
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

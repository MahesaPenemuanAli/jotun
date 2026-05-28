<x-layouts.admin :title="'Profil Toko'">

    <div class="admin-card" style="max-width:720px">
        <div class="admin-card-header">
            <h2>Edit Profil Toko</h2>
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

            <form method="POST" action="{{ route('admin.profil-toko.update') }}">
                @csrf @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-field full-width">
                        <label for="nama_toko">Nama Toko</label>
                        <input id="nama_toko" name="nama_toko" type="text" value="{{ old('nama_toko', $profil->nama_toko ?? '') }}" required placeholder="Nama toko cabang">
                    </div>

                    <div class="admin-field full-width">
                        <label for="alamat">Alamat</label>
                        <input id="alamat" name="alamat" type="text" value="{{ old('alamat', $profil->alamat ?? '') }}" required placeholder="Alamat lengkap toko">
                    </div>

                    <div class="admin-field">
                        <label for="kontak">Kontak (Telepon/HP)</label>
                        <input id="kontak" name="kontak" type="text" value="{{ old('kontak', $profil->kontak ?? '') }}" placeholder="081234567890">
                    </div>

                    <div class="admin-field full-width">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi singkat tentang toko cabang...">{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
                    </div>
                </div>

                <div style="margin-top:24px">
                    <button type="submit" class="admin-btn admin-btn-primary">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>

<x-layouts.admin :title="'Warna'">

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Daftar Warna</h2>
            <a href="{{ route('admin.warna.create', $produkId ? ['produk' => $produkId] : []) }}" class="admin-btn admin-btn-yellow admin-btn-sm">+ Tambah Warna</a>
        </div>
        <div class="admin-card-body" style="padding-bottom:0">
            {{-- Toolbar --}}
            <form class="admin-toolbar" method="GET" action="{{ route('admin.warna.index') }}" style="margin-bottom:18px">
                <div class="admin-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari warna atau kode...">
                </div>
                <div class="admin-filter" style="display:flex;gap:10px;">
                    <select name="produk" onchange="this.form.submit()">
                        <option value="">Semua Produk</option>
                        @foreach ($products as $prod)
                            <option value="{{ $prod->id_produk }}" {{ $produkId == $prod->id_produk ? 'selected' : '' }}>{{ $prod->nama_produk }}</option>
                        @endforeach
                    </select>

                    <select name="kategori_warna" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="Putih" {{ $kategoriWarna === 'Putih' ? 'selected' : '' }}>Putih</option>
                        <option value="Abu-abu" {{ $kategoriWarna === 'Abu-abu' ? 'selected' : '' }}>Abu-abu</option>
                        <option value="Biru" {{ $kategoriWarna === 'Biru' ? 'selected' : '' }}>Biru</option>
                        <option value="Hijau" {{ $kategoriWarna === 'Hijau' ? 'selected' : '' }}>Hijau</option>
                        <option value="Kuning" {{ $kategoriWarna === 'Kuning' ? 'selected' : '' }}>Kuning</option>
                        <option value="Merah" {{ $kategoriWarna === 'Merah' ? 'selected' : '' }}>Merah</option>
                        <option value="Coklat" {{ $kategoriWarna === 'Coklat' ? 'selected' : '' }}>Coklat</option>
                        <option value="Netral" {{ $kategoriWarna === 'Netral' ? 'selected' : '' }}>Netral</option>
                        <option value="Pastel" {{ $kategoriWarna === 'Pastel' ? 'selected' : '' }}>Pastel</option>
                        <option value="Gelap" {{ $kategoriWarna === 'Gelap' ? 'selected' : '' }}>Gelap</option>
                    </select>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Filter</button>
                @if ($search || $produkId || $kategoriWarna)
                    <a href="{{ route('admin.warna.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">Reset</a>
                @endif
            </form>

            {{-- Table --}}
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Warna</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Kategori</th>
                            <th>Produk</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($colors as $color)
                            <tr>
                                <td>
                                    <div class="color-preview-box">
                                        <span class="color-swatch" style="background:{{ $color->hex_color ?? '#ccc' }}"></span>
                                        <code style="font-size:0.8rem;color:var(--admin-muted)">{{ $color->hex_color ?? '-' }}</code>
                                    </div>
                                </td>
                                <td><strong>{{ $color->nama_warna }}</strong></td>
                                <td>{{ $color->kode_warna ?? '-' }}</td>
                                <td><span class="badge badge-diproses" style="background:var(--admin-yellow-soft);color:var(--admin-ink)">{{ $color->kategori_warna ?? '-' }}</span></td>
                                <td>{{ $color->produk->nama_produk ?? '-' }}</td>
                                <td>
                                    @if ($color->gambar)
                                        <img class="img-thumb"
                                             src="{{ str_starts_with($color->gambar, 'http') ? $color->gambar : asset('storage/'.$color->gambar) }}"
                                             alt="{{ $color->nama_warna }}">
                                    @else
                                        <span style="color:var(--admin-muted);font-size:0.82rem">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.warna.edit', $color->id_warna) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('admin.warna.destroy', $color->id_warna) }}" onsubmit="return confirm('Hapus warna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="admin-empty">
                                        <div class="empty-icon">🧪</div>
                                        <p>Belum ada warna. <a href="{{ route('admin.warna.create') }}">Tambah warna pertama</a>.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($colors->hasPages())
                <div class="admin-pagination">
                    {{ $colors->links('admin.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>

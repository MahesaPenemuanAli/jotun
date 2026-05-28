<x-layouts.admin :title="'Produk'">

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Daftar Produk</h2>
            <a href="{{ route('admin.produk.create') }}" class="admin-btn admin-btn-yellow admin-btn-sm">+ Tambah Produk</a>
        </div>
        <div class="admin-card-body" style="padding-bottom:0">
            {{-- Toolbar --}}
            <form class="admin-toolbar" method="GET" action="{{ route('admin.produk.index') }}" style="margin-bottom:18px">
                <div class="admin-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk...">
                </div>
                <div class="admin-filter">
                    <select name="kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Cari</button>
                @if ($search || $category)
                    <a href="{{ route('admin.produk.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">Reset</a>
                @endif
            </form>

            {{-- Table --}}
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Daya Sebar</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->gambar)
                                        <img class="img-thumb"
                                             src="{{ str_starts_with($product->gambar, 'http') ? $product->gambar : asset('storage/'.$product->gambar) }}"
                                             alt="{{ $product->nama_produk }}">
                                    @else
                                        <div class="img-thumb" style="display:grid;place-items:center;color:var(--admin-muted);font-size:1.2rem">🎨</div>
                                    @endif
                                </td>
                                <td><strong>{{ $product->nama_produk }}</strong></td>
                                <td>{{ $product->kategori }}</td>
                                <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->daya_sebar ? $product->daya_sebar.' m²/L' : '-' }}</td>
                                <td>{{ $product->warna_count }} warna</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.warna.index', ['produk' => $product->id_produk]) }}" class="admin-btn admin-btn-outline admin-btn-sm" title="Lihat warna">🧪</a>
                                        <a href="{{ route('admin.produk.edit', $product->id_produk) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('admin.produk.destroy', $product->id_produk) }}" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="admin-empty">
                                        <div class="empty-icon">🎨</div>
                                        <p>Belum ada produk. <a href="{{ route('admin.produk.create') }}">Tambah produk pertama</a>.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="admin-pagination">
                    {{ $products->links('admin.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>

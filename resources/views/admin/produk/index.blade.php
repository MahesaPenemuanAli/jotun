<x-layouts.admin :title="'Produk'">

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Daftar Produk</h2>
            <a href="{{ route('admin.produk.create') }}" class="admin-btn admin-btn-yellow admin-btn-sm">+ Tambah Produk</a>
        </div>
        <div class="admin-card-body" style="padding-bottom:0">
            {{-- Toolbar --}}
            <form class="admin-toolbar" method="GET" action="{{ route('admin.produk.index') }}" style="margin-bottom:18px;flex-wrap:wrap">
                <div class="admin-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk...">
                </div>
                <div class="admin-filter" style="display:flex;gap:8px;flex-wrap:wrap">
                    <select name="kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <select name="tintable" onchange="this.form.submit()">
                        <option value="">Tinting: Semua</option>
                        <option value="1" {{ $tintable === '1' ? 'selected' : '' }}>Bisa Tinting</option>
                        <option value="0" {{ $tintable === '0' ? 'selected' : '' }}>Non-Tinting</option>
                    </select>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Status: Semua</option>
                        <option value="aktif" {{ ($status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ ($status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Filter</button>
                @if ($search || $category || $tintable !== null || $status)
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
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Daya Sebar</th>
                            <th>Status</th>
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
                                        <div class="img-thumb" style="display:grid;place-items:center;color:var(--admin-muted);font-size:0.7rem;font-weight:700">{{ strtoupper(substr($product->nama_produk, 0, 3)) }}</div>
                                    @endif
                                </td>
                                <td><strong>{{ $product->nama_produk }}</strong></td>
                                <td>
                                    <span class="admin-badge" style="background:{{ $product->kategori === 'Interior' ? '#3B82F6' : ($product->kategori === 'Eksterior' ? '#10B981' : '#8B5CF6') }};color:#fff">{{ $product->kategori }}</span>
                                </td>
                                <td>
                                    @if ($product->is_tintable)
                                        <span class="admin-badge" style="background:var(--admin-accent);color:#000">Tinting</span>
                                    @else
                                        <span class="admin-badge" style="background:#64748B;color:#fff">{{ ucfirst($product->tipe_produk ?? 'non-tinting') }}</span>
                                    @endif
                                </td>
                                <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->daya_sebar ? $product->daya_sebar.' m²/L' : '-' }}</td>
                                <td>
                                    @if ($product->status_produk === 'aktif')
                                        <span class="admin-badge" style="background:#059669;color:#fff">Aktif</span>
                                    @else
                                        <span class="admin-badge" style="background:#DC2626;color:#fff">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $product->warna_count }} warna</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.warna.index', ['produk' => $product->id_produk]) }}" class="admin-btn admin-btn-outline admin-btn-sm" title="Lihat warna">Warna</a>
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
                                <td colspan="9">
                                    <div class="admin-empty">
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

<x-layouts.admin :title="'Laporan & Riwayat'">

    @if ($errors->any())
        <div class="admin-alert error">
            Data filter tidak valid.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Filter Laporan</h2>
            <a href="{{ route('admin.laporan.exportCsv', request()->query()) }}" class="admin-btn admin-btn-primary admin-btn-sm">
                Export CSV
            </a>
        </div>
        <div class="admin-card-body">
            <form class="admin-toolbar" method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="admin-field" style="min-width:190px">
                    <label for="start_date">Tanggal Mulai</label>
                    <input id="start_date" type="date" name="start_date" value="{{ $filters['start_date'] }}">
                </div>
                <div class="admin-field" style="min-width:190px">
                    <label for="end_date">Tanggal Akhir</label>
                    <input id="end_date" type="date" name="end_date" value="{{ $filters['end_date'] }}">
                </div>
                <div class="admin-field admin-filter" style="min-width:200px">
                    <label for="id_produk">Produk</label>
                    <select id="id_produk" name="id_produk">
                        <option value="">Semua Produk</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id_produk }}" @selected($filters['id_produk'] === $product->id_produk)>
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field admin-filter" style="min-width:180px">
                    <label for="status">Status Tinting</label>
                    <select id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected($filters['status'] === 'pending')>Pending</option>
                        <option value="diproses" @selected($filters['status'] === 'diproses')>Diproses</option>
                        <option value="selesai" @selected($filters['status'] === 'selesai')>Selesai</option>
                        <option value="dibatalkan" @selected($filters['status'] === 'dibatalkan')>Dibatalkan</option>
                    </select>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end">
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Terapkan</button>
                    <a href="{{ route('admin.laporan.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="stat-grid">
        <div class="admin-stat-card">
            <span class="stat-icon yellow">📋</span>
            <span class="stat-label">Total Request</span>
            <span class="stat-value">{{ $totalRequest }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon blue">🕒</span>
            <span class="stat-label">Pending</span>
            <span class="stat-value">{{ $statusCounts['pending'] }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon green">✅</span>
            <span class="stat-label">Selesai</span>
            <span class="stat-value">{{ $statusCounts['selesai'] }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon red">🧮</span>
            <span class="stat-label">Riwayat Kalkulasi</span>
            <span class="stat-value">{{ $totalKalkulasi }}</span>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Laporan Request Tinting</h2>
        </div>
        <div class="admin-card-body" style="padding:0">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Produk / Warna</th>
                            <th>Kaleng</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $req)
                            <tr>
                                <td>{{ optional($req->tanggal_request)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <strong>{{ $req->pelanggan->nama_pelanggan ?? '-' }}</strong><br>
                                    <small style="color:var(--admin-muted)">{{ $req->pelanggan->no_hp ?? '' }}</small>
                                </td>
                                <td>
                                    @foreach ($req->detail as $detail)
                                        <div style="margin-bottom:4px">
                                            {{ $detail->warna->produk->nama_produk ?? '-' }} - {{ $detail->warna->nama_warna ?? '-' }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($req->detail as $detail)
                                        {{ $detail->jumlah_kaleng }}<br>
                                    @endforeach
                                </td>
                                <td><span class="badge badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.tinting.show', $req->id_request) }}" class="admin-btn admin-btn-outline admin-btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="admin-empty">
                                        <div class="empty-icon">📄</div>
                                        <p>Tidak ada data request tinting pada filter saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($requests->hasPages())
                <div class="admin-pagination">
                    {{ $requests->links('admin.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Riwayat Kalkulasi Pelanggan</h2>
            <span style="font-size:.86rem;color:var(--admin-muted)">
                Total liter: {{ number_format($totalLiter, 2, ',', '.') }} L
            </span>
        </div>
        <div class="admin-card-body" style="padding:0">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Ukuran Dinding (m)</th>
                            <th>Hasil Liter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatKalkulasi as $item)
                            <tr>
                                <td>{{ optional($item->tanggal_kalkulasi)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <strong>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</strong><br>
                                    <small style="color:var(--admin-muted)">{{ $item->pelanggan->no_hp ?? '' }}</small>
                                </td>
                                <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                                <td>{{ $item->panjang_dinding }} x {{ $item->tinggi_dinding }}</td>
                                <td>{{ number_format((float) $item->hasil_liter, 2, ',', '.') }} L</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="admin-empty">
                                        <div class="empty-icon">🧮</div>
                                        <p>Belum ada riwayat kalkulasi pada filter saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>

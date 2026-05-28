<x-layouts.admin :title="'Dashboard'">

    {{-- Stat Cards --}}
    <div class="stat-grid">
        <div class="admin-stat-card">
            <span class="stat-icon yellow">🎨</span>
            <span class="stat-label">Total Produk</span>
            <span class="stat-value">{{ $totalProduk }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon blue">🧪</span>
            <span class="stat-label">Total Warna</span>
            <span class="stat-value">{{ $totalWarna }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon red">📋</span>
            <span class="stat-label">Request Pending</span>
            <span class="stat-value">{{ $requestPending }}</span>
        </div>
        <div class="admin-stat-card">
            <span class="stat-icon green">👥</span>
            <span class="stat-label">Total Pelanggan</span>
            <span class="stat-value">{{ $totalPelanggan }}</span>
        </div>
    </div>

    {{-- Latest Tinting Requests --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Request Tinting Terbaru</h2>
            <a href="{{ route('admin.tinting.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">Lihat semua</a>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestRequests as $req)
                            <tr>
                                <td>{{ $req->tanggal_request->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $req->pelanggan->nama_pelanggan ?? '-' }}</strong><br>
                                    <small style="color:var(--admin-muted)">{{ $req->pelanggan->no_hp ?? '' }}</small>
                                </td>
                                <td>
                                    @foreach ($req->detail as $detail)
                                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                                            @if ($detail->warna->hex_color)
                                                <span class="color-swatch" style="background:{{ $detail->warna->hex_color }};width:22px;height:22px"></span>
                                            @endif
                                            <span>{{ $detail->warna->produk->nama_produk ?? '' }} — {{ $detail->warna->nama_warna }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($req->detail as $detail)
                                        {{ $detail->jumlah_kaleng }} kaleng<br>
                                    @endforeach
                                </td>
                                <td><span class="badge badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.tinting.show', $req->id_request) }}" class="admin-btn admin-btn-outline admin-btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:28px;color:var(--admin-muted)">
                                    Belum ada request tinting.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.admin>

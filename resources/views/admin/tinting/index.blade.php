<x-layouts.admin :title="'Request Tinting'">

    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Kelola Request Tinting</h2>
        </div>
        <div class="admin-card-body" style="padding-bottom:0">
            {{-- Status tabs --}}
            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:18px">
                <a href="{{ route('admin.tinting.index') }}"
                   class="admin-btn admin-btn-sm {{ !$status ? 'admin-btn-primary' : 'admin-btn-outline' }}">
                    Semua ({{ $statusCounts['all'] }})
                </a>
                <a href="{{ route('admin.tinting.index', ['status' => 'pending']) }}"
                   class="admin-btn admin-btn-sm {{ $status === 'pending' ? 'admin-btn-yellow' : 'admin-btn-outline' }}">
                    Pending ({{ $statusCounts['pending'] }})
                </a>
                <a href="{{ route('admin.tinting.index', ['status' => 'diproses']) }}"
                   class="admin-btn admin-btn-sm {{ $status === 'diproses' ? 'admin-btn-primary' : 'admin-btn-outline' }}">
                    Diproses ({{ $statusCounts['diproses'] }})
                </a>
                <a href="{{ route('admin.tinting.index', ['status' => 'selesai']) }}"
                   class="admin-btn admin-btn-sm {{ $status === 'selesai' ? 'admin-btn-success' : 'admin-btn-outline' }}">
                    Selesai ({{ $statusCounts['selesai'] }})
                </a>
                <a href="{{ route('admin.tinting.index', ['status' => 'dibatalkan']) }}"
                   class="admin-btn admin-btn-sm {{ $status === 'dibatalkan' ? 'admin-btn-danger' : 'admin-btn-outline' }}">
                    Dibatalkan ({{ $statusCounts['dibatalkan'] }})
                </a>
            </div>

            {{-- Search --}}
            <form class="admin-toolbar" method="GET" action="{{ route('admin.tinting.index') }}" style="margin-bottom:18px">
                @if ($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="admin-search">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama/no HP pelanggan...">
                </div>
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Cari</button>
                @if ($search)
                    <a href="{{ route('admin.tinting.index', $status ? ['status' => $status] : []) }}" class="admin-btn admin-btn-outline admin-btn-sm">Reset</a>
                @endif
            </form>

            {{-- Table --}}
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
                                <td>{{ $req->tanggal_request->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $req->pelanggan->nama_pelanggan ?? '-' }}</strong><br>
                                    <small style="color:var(--admin-muted)">{{ $req->pelanggan->no_hp ?? '' }}</small>
                                </td>
                                <td>
                                    @foreach ($req->detail as $detail)
                                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px">
                                            @if ($detail->warna->hex_color ?? null)
                                                <span class="color-swatch" style="background:{{ $detail->warna->hex_color }};width:20px;height:20px"></span>
                                            @endif
                                            <span style="font-size:0.88rem">{{ $detail->warna->produk->nama_produk ?? '' }} — {{ $detail->warna->nama_warna ?? '' }}</span>
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
                                        <div class="empty-icon">📋</div>
                                        <p>Tidak ada request tinting{{ $status ? ' dengan status '.ucfirst($status) : '' }}.</p>
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

</x-layouts.admin>

<x-layouts.public title="Riwayat Request Tinting" description="Lihat semua riwayat request tinting warna Anda.">
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Akun Pelanggan</span>
            <h1 style="font-size: 2.4rem; margin-bottom: 8px;">Riwayat Request Tinting</h1>
            <p style="color: var(--muted);">Pantau status pesanan pencampuran warna cat kustom Anda.</p>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container">
            <div class="dashboard-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="dash-nav-item">Dashboard</a>
                <a href="{{ route('pelanggan.profil') }}" class="dash-nav-item">Profil Saya</a>
                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="dash-nav-item">Riwayat Kalkulasi</a>
                <a href="{{ route('pelanggan.riwayat.tinting') }}" class="dash-nav-item active">Riwayat Tinting</a>
            </div>

            @if(is_countable($requests) && count($requests) > 0)
                <div class="tinting-history-grid">
                    @foreach($requests as $req)
                        <div class="tinting-history-card">
                            <div class="tinting-card-header">
                                <span class="tinting-date">{{ $req->tanggal_request->format('d M Y') }}</span>
                                <span class="status-badge status-{{ $req->status }}">{{ ucfirst($req->status) }}</span>
                            </div>
                            <div class="tinting-card-id">Kode: {{ Str::limit($req->id_request, 8) }}...</div>
                            @foreach($req->detail as $detail)
                                <div class="tinting-card-detail">
                                    <span class="color-dot" style="background-color: {{ $detail->warna->hex_color ?? '#ccc' }};"></span>
                                    <span>{{ $detail->warna->nama_warna ?? '-' }} ({{ $detail->warna->kode_warna ?? '-' }})</span>
                                    <span class="tinting-qty">{{ $detail->jumlah_kaleng }} kaleng</span>
                                </div>
                            @endforeach
                            @if($req->detail->first()?->warna?->produk)
                                <div class="tinting-card-product">{{ $req->detail->first()->warna->produk->nama_produk }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($requests->hasPages())
                    <nav class="simple-pagination" style="margin-top: 24px;">
                        {{ $requests->links() }}
                    </nav>
                @endif
            @else
                <div class="empty-state">
                    <h3>Belum Ada Request Tinting</h3>
                    <p>Anda belum membuat request pencampuran warna. Kunjungi <a href="{{ route('tinting.create') }}">Color Studio</a> untuk memulai.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>

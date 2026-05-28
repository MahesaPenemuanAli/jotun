<x-layouts.public title="Riwayat Kalkulasi Cat" description="Lihat semua riwayat kalkulasi kebutuhan cat Anda.">
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Akun Pelanggan</span>
            <h1 style="font-size: 2.4rem; margin-bottom: 8px;">Riwayat Kalkulasi Cat</h1>
            <p style="color: var(--muted);">Semua perhitungan kebutuhan cat yang pernah Anda simpan.</p>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container">
            <div class="dashboard-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="dash-nav-item">Dashboard</a>
                <a href="{{ route('pelanggan.profil') }}" class="dash-nav-item">Profil Saya</a>
                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="dash-nav-item active">Riwayat Kalkulasi</a>
                <a href="{{ route('pelanggan.riwayat.tinting') }}" class="dash-nav-item">Riwayat Tinting</a>
            </div>

            @if(is_countable($riwayat) && count($riwayat) > 0)
                <div class="history-table-wrap">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Produk Cat</th>
                                <th>Ukuran (P × T)</th>
                                <th>Lapisan</th>
                                <th>Hasil (Liter)</th>
                                <th>Kaleng (2.5L)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $i => $calc)
                                <tr>
                                    <td>{{ $riwayat->firstItem() + $i }}</td>
                                    <td>{{ $calc->tanggal_kalkulasi->format('d M Y') }}</td>
                                    <td>{{ $calc->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ $calc->panjang_dinding }} × {{ $calc->tinggi_dinding }} m</td>
                                    <td>{{ $calc->jumlah_lapisan ?? 2 }}×</td>
                                    <td><strong>{{ number_format($calc->hasil_liter, 1) }} L</strong></td>
                                    <td><strong>{{ $calc->jumlah_kaleng ?? ceil($calc->hasil_liter / 2.5) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($riwayat->hasPages())
                    <nav class="simple-pagination" style="margin-top: 24px;">
                        {{ $riwayat->links() }}
                    </nav>
                @endif
            @else
                <div class="empty-state">
                    <h3>Belum Ada Riwayat</h3>
                    <p>Anda belum menyimpan kalkulasi cat apapun. Gunakan <a href="{{ route('calculator.create') }}">Kalkulator Cat</a> untuk memulai.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>

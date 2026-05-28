<x-layouts.public title="Dashboard Pelanggan" description="Dashboard akun pelanggan Jotun Paint Center.">
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Akun Pelanggan</span>
            <h1 style="font-size: 2.4rem; margin-bottom: 8px;">Selamat datang, {{ $user->name }}!</h1>
            <p style="color: var(--muted); font-size: 1rem;">Kelola riwayat kalkulasi, request tinting, dan profil Anda dari satu tempat.</p>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container">
            @if (session('success'))
                <div class="alert success" style="margin-bottom: 24px;">{{ session('success') }}</div>
            @endif

            <!-- Quick Nav -->
            <div class="dashboard-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="dash-nav-item active">Dashboard</a>
                <a href="{{ route('pelanggan.profil') }}" class="dash-nav-item">Profil Saya</a>
                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="dash-nav-item">Riwayat Kalkulasi</a>
                <a href="{{ route('pelanggan.riwayat.tinting') }}" class="dash-nav-item">Riwayat Tinting</a>
            </div>

            <!-- Stats Grid -->
            <div class="dashboard-grid">
                <div class="stat-card">
                    <span class="stat-value">{{ $totalKalkulasi }}</span>
                    <span class="stat-label">Kalkulasi Tersimpan</span>
                    <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="stat-link">Lihat Semua</a>
                </div>

                <div class="stat-card">
                    <span class="stat-value">{{ $totalTinting }}</span>
                    <span class="stat-label">Request Tinting</span>
                    <a href="{{ route('pelanggan.riwayat.tinting') }}" class="stat-link">Lihat Semua</a>
                </div>

                <div class="stat-card">
                    <span class="stat-value">{{ $lastTinting ? ucfirst($lastTinting->status) : '—' }}</span>
                    <span class="stat-label">Status Pesanan Terakhir</span>
                    @if($lastTinting)
                        <span class="stat-sub">{{ $lastTinting->tanggal_request->format('d M Y') }}</span>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="display: flex; gap: 16px; margin-top: 32px; flex-wrap: wrap;">
                <a href="{{ route('calculator.create') }}" class="btn btn-primary">Kalkulator Cat</a>
                <a href="{{ route('tinting.create') }}" class="btn btn-secondary">Color Studio (Tinting)</a>
                <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Katalog Produk</a>
            </div>

            <!-- Recent Calculations -->
            @if($recentCalcs->isNotEmpty())
                <div style="margin-top: 48px;">
                    <h3 style="margin-bottom: 16px;">Kalkulasi Terbaru</h3>
                    <div class="history-table-wrap">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Luas Dinding</th>
                                    <th>Hasil (Liter)</th>
                                    <th>Kaleng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCalcs as $calc)
                                    <tr>
                                        <td>{{ $calc->tanggal_kalkulasi->format('d M Y') }}</td>
                                        <td>{{ $calc->produk->nama_produk ?? '-' }}</td>
                                        <td>{{ number_format($calc->panjang_dinding * $calc->tinggi_dinding, 1) }} m²</td>
                                        <td>{{ number_format($calc->hasil_liter, 1) }} L</td>
                                        <td>{{ $calc->jumlah_kaleng ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>

<x-layouts.public title="Profil Saya" description="Lihat informasi profil akun pelanggan Anda.">
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Akun Pelanggan</span>
            <h1 style="font-size: 2.4rem; margin-bottom: 8px;">Profil Saya</h1>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container" style="max-width: 640px;">
            @if (session('success'))
                <div class="alert success" style="margin-bottom: 24px;">{{ session('success') }}</div>
            @endif

            <div class="dashboard-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="dash-nav-item">Dashboard</a>
                <a href="{{ route('pelanggan.profil') }}" class="dash-nav-item active">Profil Saya</a>
                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="dash-nav-item">Riwayat Kalkulasi</a>
                <a href="{{ route('pelanggan.riwayat.tinting') }}" class="dash-nav-item">Riwayat Tinting</a>
            </div>

            <div class="auth-card" style="margin-top: 8px;">
                <div class="profil-row">
                    <span class="profil-label">Nama Lengkap</span>
                    <span class="profil-value">{{ $user->name }}</span>
                </div>
                <div class="profil-row">
                    <span class="profil-label">Alamat Email</span>
                    <span class="profil-value">{{ $user->email }}</span>
                </div>
                <div class="profil-row">
                    <span class="profil-label">Nomor HP</span>
                    <span class="profil-value">{{ $pelanggan->no_hp ?? '-' }}</span>
                </div>
                <div class="profil-row">
                    <span class="profil-label">Akun Dibuat</span>
                    <span class="profil-value">{{ $user->created_at->format('d F Y') }}</span>
                </div>

                <a href="{{ route('pelanggan.profil.edit') }}" class="btn btn-primary" style="width: 100%; height: 46px; margin-top: 24px; display: flex; align-items: center; justify-content: center;">Edit Profil</a>
            </div>
        </div>
    </section>
</x-layouts.public>

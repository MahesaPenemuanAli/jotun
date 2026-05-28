<x-layouts.public title="Edit Profil" description="Perbarui informasi profil akun pelanggan Anda.">
    <section class="hero" style="padding: 80px 0 48px; background-color: var(--surface); border-bottom: 1px solid var(--line);">
        <div class="container">
            <span class="eyebrow">Akun Pelanggan</span>
            <h1 style="font-size: 2.4rem; margin-bottom: 8px;">Edit Profil</h1>
        </div>
    </section>

    <section class="section alt-bg">
        <div class="container" style="max-width: 460px;">
            <div class="dashboard-nav">
                <a href="{{ route('pelanggan.dashboard') }}" class="dash-nav-item">Dashboard</a>
                <a href="{{ route('pelanggan.profil') }}" class="dash-nav-item active">Profil Saya</a>
                <a href="{{ route('pelanggan.riwayat.kalkulasi') }}" class="dash-nav-item">Riwayat Kalkulasi</a>
                <a href="{{ route('pelanggan.riwayat.tinting') }}" class="dash-nav-item">Riwayat Tinting</a>
            </div>

            <div class="auth-card" style="margin-top: 8px;">
                @if ($errors->any())
                    <div class="alert error">
                        <ul style="padding-left: 16px; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pelanggan.profil.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="field">
                        <label for="email_display">Alamat Email</label>
                        <input id="email_display" type="email" value="{{ $user->email }}" disabled style="opacity: 0.6; cursor: not-allowed;">
                        <span style="font-size: 0.78rem; color: var(--muted);">Email tidak dapat diubah.</span>
                    </div>

                    <div class="field">
                        <label for="no_hp">Nomor HP</label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $pelanggan->no_hp ?? '') }}" required>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--line); margin: 24px 0;">

                    <div class="field">
                        <label for="password">Password Baru (Opsional)</label>
                        <input id="password" name="password" type="password" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password baru">
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button class="btn btn-primary" type="submit" style="flex: 1; height: 46px;">Simpan Perubahan</button>
                        <a href="{{ route('pelanggan.profil') }}" class="btn btn-secondary" style="height: 46px; display: flex; align-items: center; justify-content: center; padding: 0 20px;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.public>

<x-layouts.public title="Masuk ke Akun Anda" description="Login ke akun pelanggan Jotun Paint Center untuk mengakses dashboard, riwayat kalkulasi, dan request tinting Anda.">
    <section class="section" style="padding: 100px 0 80px;">
        <div class="container" style="max-width: 460px;">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Masuk ke Akun</h1>
                    <p>Akses riwayat kalkulasi, request tinting, dan profil Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="alert error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('pelanggan.login.submit') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Masukkan password" required>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                        <input id="remember" name="remember" type="checkbox" style="width: 16px; height: 16px; accent-color: var(--jotun-yellow);">
                        <label for="remember" style="font-size: 0.85rem; color: var(--muted); margin-bottom: 0;">Ingat saya</label>
                    </div>

                    <button class="btn btn-primary" type="submit" style="width: 100%; height: 48px; font-size: 1rem;">Masuk</button>
                </form>

                <div class="auth-footer">
                    <p>Belum punya akun? <a href="{{ route('pelanggan.register') }}">Daftar sekarang</a></p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>

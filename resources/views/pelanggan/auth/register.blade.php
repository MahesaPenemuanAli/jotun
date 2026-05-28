<x-layouts.public title="Daftar Akun Baru" description="Buat akun pelanggan Jotun Paint Center untuk menyimpan riwayat kalkulasi dan request tinting Anda.">
    <section class="section" style="padding: 100px 0 80px;">
        <div class="container" style="max-width: 460px;">
            <div class="auth-card">
                <div class="auth-header">
                    <h1>Buat Akun Baru</h1>
                    <p>Daftar untuk menyimpan riwayat kalkulasi dan request tinting.</p>
                </div>

                @if ($errors->any())
                    <div class="alert error">
                        <ul style="padding-left: 16px; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pelanggan.register.submit') }}">
                    @csrf
                    <div class="field">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                    </div>

                    <div class="field">
                        <label for="email">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>

                    <div class="field">
                        <label for="no_hp">Nomor HP / WhatsApp</label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" placeholder="0812xxxxxxxx" required>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Minimal 8 karakter" required>
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password" required>
                    </div>

                    <button class="btn btn-primary" type="submit" style="width: 100%; height: 48px; font-size: 1rem;">Daftar Akun</button>
                </form>

                <div class="auth-footer">
                    <p>Sudah punya akun? <a href="{{ route('pelanggan.login') }}">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>

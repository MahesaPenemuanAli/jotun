<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>Login — Admin Jotun Paint Center</title>

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/admin.css'])
    @endif
</head>
<body class="admin-body">
    <div class="login-page">
        <div class="login-card">
            <a class="login-brand" href="{{ route('home') }}">
                <span class="login-brand-mark" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2C8.1 2 3.3 6.8 3.3 12.7v2.6C3.3 21.2 8.1 26 14 26s10.7-4.8 10.7-10.7v-2.6C24.7 6.8 19.9 2 14 2Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M14 3v22M4 14h20M6 9h16M6 19h16" stroke="currentColor" stroke-width="1.5" opacity=".75"/>
                    </svg>
                </span>
                <span class="login-brand-text">
                    <strong>JOTUN</strong>
                    <span>ADMIN PANEL</span>
                </span>
            </a>

            <div class="login-heading">
                <h1>Masuk ke Dashboard</h1>
                <p>Gunakan akun admin toko Anda.</p>
            </div>

            @if ($errors->any())
                <div class="admin-alert error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="admin-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="admin@jotun-cabang.test">
                </div>

                <div class="admin-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="••••••••">
                </div>

                <label class="login-remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>

                <button type="submit" class="admin-btn admin-btn-primary login-submit">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>

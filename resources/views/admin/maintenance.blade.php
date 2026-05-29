<x-layouts.admin :title="'Maintenance'">
    <div class="admin-card" style="max-width:720px">
        <div class="admin-card-header">
            <h2>Database Maintenance</h2>
        </div>
        <div class="admin-card-body">
            <p style="color:var(--admin-muted);margin-bottom:20px;font-size:0.9rem">
                Halaman ini hanya aktif di environment lokal/development atau jika <code>ENABLE_ADMIN_MAINTENANCE=true</code> di file <code>.env</code>.
            </p>

            @if (session('success'))
                <div class="admin-alert success" style="margin-bottom:16px">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="admin-alert error" style="margin-bottom:16px">{{ session('error') }}</div>
            @endif
            @if (session('log_output'))
                <details open style="margin-bottom:20px;background:var(--admin-card);border:1px solid var(--admin-border);border-radius:8px;padding:14px">
                    <summary style="cursor:pointer;font-weight:600;font-size:0.85rem;color:var(--admin-accent)">Output Log</summary>
                    <pre style="margin-top:10px;font-size:0.78rem;white-space:pre-wrap;color:var(--admin-text-secondary);max-height:300px;overflow-y:auto">{{ session('log_output') }}</pre>
                </details>
            @endif

            @php($needsKey = filled(env('MAINTENANCE_KEY', '')))

            <div style="display:flex;flex-direction:column;gap:16px">
                {{-- Migrate --}}
                <form method="POST" action="{{ route('admin.maintenance.migrate') }}" onsubmit="return confirm('Yakin ingin menjalankan migration? Pastikan Anda sudah backup database.')">
                    @csrf
                    @if ($needsKey)
                        <div class="admin-field" style="margin-bottom:10px">
                            <label for="migrate_key">Maintenance Key</label>
                            <input id="migrate_key" name="maintenance_key" type="password" required placeholder="Masukkan maintenance key dari .env">
                        </div>
                    @endif
                    <button type="submit" class="admin-btn admin-btn-primary" style="width:100%">Jalankan Migration</button>
                </form>

                {{-- Seed --}}
                <form method="POST" action="{{ route('admin.maintenance.seed') }}" onsubmit="return confirm('Yakin ingin menjalankan seeder? Data yang sudah ada akan di-update, bukan dihapus.')">
                    @csrf
                    @if ($needsKey)
                        <div class="admin-field" style="margin-bottom:10px">
                            <label for="seed_key">Maintenance Key</label>
                            <input id="seed_key" name="maintenance_key" type="password" required placeholder="Masukkan maintenance key dari .env">
                        </div>
                    @endif
                    <button type="submit" class="admin-btn admin-btn-yellow" style="width:100%">Jalankan Database Seeder</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

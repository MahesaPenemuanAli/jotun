# Roadmap Pengembangan Website Cabang Toko Cat Jotun

Dokumen ini menjadi panduan bertahap agar pengembangan bisa dilakukan aman, ringan, dan tidak melewati kapasitas AI dalam satu kali pekerjaan.

## Tujuan Website

Website ini dibuat untuk satu cabang toko cat Jotun dengan fitur utama berdasarkan ERD:

1. Profil toko cabang.
2. Katalog produk cat.
3. Daftar warna produk.
4. Kalkulator kebutuhan cat.
5. Form request tinting dari pelanggan.
6. Manajemen request tinting oleh admin.
7. Laporan toko/admin.

## Prinsip Teknis

- Framework: Laravel.
- Database online: Supabase PostgreSQL.
- UI: ringan, modern, dominan kuning Jotun dengan aksen biru tua dan merah.
- Frontend: CSS custom minimal, tidak bergantung pada komponen berat.
- Data sensitif seperti password dan Supabase credentials tidak boleh di-hardcode.
- Gambar produk/warna disimpan sebagai URL atau path storage, bukan binary di database.

## Tahap 1 — Fondasi Sistem

Status: dikerjakan pada tahap ini.

Output:

- Roadmap pengembangan.
- Migration database sesuai ERD.
- Model Laravel dan relasi utama.
- Seed data awal untuk demo.
- Landing page awal bertema Jotun.

Batasan:

- Belum ada login admin aktif.
- Belum ada CRUD admin.
- Belum konek langsung ke Supabase sampai konfigurasi `.env` disiapkan.

## Tahap 2 — Koneksi Supabase dan Validasi Schema

Target:

- Konfigurasi `.env` ke Supabase PostgreSQL.
- Jalankan migration ke Supabase.
- Validasi tabel, foreign key, dan seed.
- Siapkan storage policy jika gambar akan di-upload ke Supabase Storage.

Yang perlu Anda siapkan:

- Project Supabase.
- Database password Supabase.
- Connection string PostgreSQL dari Supabase.

Contoh variabel yang harus Anda isi di `.env`:

- `DB_CONNECTION=pgsql`
- `DB_HOST=...`
- `DB_PORT=5432`
- `DB_DATABASE=postgres`
- `DB_USERNAME=postgres`
- `DB_PASSWORD=...`

## Tahap 3 — Halaman Publik

Target:

- Halaman profil toko.
- Halaman katalog produk.
- Detail produk dan pilihan warna.
- Kalkulator cat berbasis daya sebar produk.
- Form request tinting pelanggan.

Catatan UX:

- Pelanggan tidak perlu login untuk request tinting tahap awal.
- Pelanggan cukup mengisi nama, nomor HP, email opsional, produk/warna, dan jumlah kaleng.

## Tahap 4 — Admin Auth dan Dashboard

Target:

- Login admin.
- Dashboard ringkas.
- CRUD profil toko.
- CRUD produk.
- CRUD warna.
- Kelola request tinting: pending, diproses, selesai, dibatalkan.

Saran keamanan:

- Password wajib di-hash Laravel.
- Batasi halaman admin dengan middleware auth.
- Jangan buka endpoint admin tanpa proteksi.

## Tahap 5 — Laporan dan Riwayat

Target:

- Laporan admin per periode.
- Riwayat kalkulasi pelanggan.
- Export laporan sederhana ke PDF/CSV jika dibutuhkan.
- Filter laporan berdasarkan tanggal, produk, dan status request.

## Tahap 6 — Optimasi, Testing, dan Deployment

Target:

- Testing fitur utama.
- Optimasi asset dengan Vite build.
- Cache konfigurasi Laravel.
- Deploy ke hosting yang mendukung Laravel dan PostgreSQL/Supabase.

Checklist deployment:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` sudah valid.
- Database Supabase sudah dimigrasi.
- `npm run build` sudah dijalankan.
- `php artisan config:cache` dan `php artisan route:cache` dijalankan di server jika sesuai.

## Saran Pengembangan

- Gunakan UUID untuk primary key agar cocok dengan sistem online dan lebih aman dari enumerasi ID.
- Gunakan `unsignedBigInteger` untuk harga Rupiah tanpa desimal.
- Gunakan field `gambar` sebagai string URL agar ringan.
- Mulai dari fitur publik dulu, baru admin dashboard.
- Setelah schema stabil, baru tambah upload gambar dan fitur lanjutan.

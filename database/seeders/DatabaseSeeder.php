<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\DetailRequestTinting;
use App\Models\KatalogProduk;
use App\Models\Laporan;
use App\Models\Pelanggan;
use App\Models\ProfilToko;
use App\Models\RequestTinting;
use App\Models\RiwayatKalkulasi;
use App\Models\User;
use App\Models\Warna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ["email" => "test@example.com"],
            [
                "name" => "Test User",
                "password" => "password",
            ],
        );

        $admin = Admin::query()->updateOrCreate(
            ["email" => "admin@jotun-cabang.test"],
            [
                "nama_admin" => "Admin Jotun Cabang",
                "password" => "password",
                "no_hp" => "081234567890",
            ],
        );

        ProfilToko::query()->updateOrCreate(
            ["id_admin" => $admin->id_admin],
            [
                "nama_toko" => "Jotun Paint Center Cabang Utama",
                "alamat" => "Jl. Contoh Raya No. 10, Kota Anda",
                "kontak" => "081234567890",
                "deskripsi" =>
                    "Cabang toko cat Jotun dengan layanan konsultasi produk, kalkulasi kebutuhan cat, dan request tinting warna.",
            ],
        );

        $produkEksterior = KatalogProduk::query()->updateOrCreate(
            [
                "id_admin" => $admin->id_admin,
                "nama_produk" => "Jotashield Antifade Colours",
            ],
            [
                "kategori" => "Eksterior",
                "harga" => 285000,
                "daya_sebar" => 10.0,
                "gambar" => null,
            ],
        );

        $produkInterior = KatalogProduk::query()->updateOrCreate(
            [
                "id_admin" => $admin->id_admin,
                "nama_produk" => "Majestic True Beauty Matt",
            ],
            [
                "kategori" => "Interior",
                "harga" => 245000,
                "daya_sebar" => 12.0,
                "gambar" => null,
            ],
        );

        $produkInteriorEkonomis = KatalogProduk::query()->updateOrCreate(
            [
                "id_admin" => $admin->id_admin,
                "nama_produk" => "Jotun Essence Easy Clean",
            ],
            [
                "kategori" => "Interior",
                "harga" => 185000,
                "daya_sebar" => 11.0,
                "gambar" => null,
            ],
        );

        // ─── Colors for Majestic True Beauty (Interior) ──────────────────
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInterior->id_produk, "kode_warna" => "JTN-001"],
            ["nama_warna" => "Classic White", "hex_color" => "#F8F5EC", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInterior->id_produk, "kode_warna" => "JTN-002"],
            ["nama_warna" => "Morning Fog", "hex_color" => "#E2E6E7", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInterior->id_produk, "kode_warna" => "JTN-003"],
            ["nama_warna" => "Antique Green", "hex_color" => "#7D8C82", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInterior->id_produk, "kode_warna" => "JTN-004"],
            ["nama_warna" => "Soft Teal", "hex_color" => "#829A9E", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInterior->id_produk, "kode_warna" => "JTN-005"],
            ["nama_warna" => "Warm Sand", "hex_color" => "#D8CBB5", "gambar" => null]
        );

        // ─── Colors for Jotashield Antifade (Eksterior) ─────────────────
        $warnaKuning = Warna::query()->updateOrCreate(
            ["id_produk" => $produkEksterior->id_produk, "kode_warna" => "JTN-120"],
            ["nama_warna" => "Warm Signal Yellow", "hex_color" => "#FDB913", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkEksterior->id_produk, "kode_warna" => "JTN-121"],
            ["nama_warna" => "Evening Sky", "hex_color" => "#3D4A5E", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkEksterior->id_produk, "kode_warna" => "JTN-122"],
            ["nama_warna" => "Crimson Glory", "hex_color" => "#9B2C2C", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkEksterior->id_produk, "kode_warna" => "JTN-123"],
            ["nama_warna" => "Stone Gray", "hex_color" => "#7F8385", "gambar" => null]
        );

        // ─── Colors for Essence Easy Clean (Interior Ekonomis) ──────────
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInteriorEkonomis->id_produk, "kode_warna" => "JTN-201"],
            ["nama_warna" => "Cotton Blossom", "hex_color" => "#F7F3EA", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInteriorEkonomis->id_produk, "kode_warna" => "JTN-202"],
            ["nama_warna" => "Silver Breeze", "hex_color" => "#E1E3E2", "gambar" => null]
        );
        Warna::query()->updateOrCreate(
            ["id_produk" => $produkInteriorEkonomis->id_produk, "kode_warna" => "JTN-203"],
            ["nama_warna" => "Soft Clay", "hex_color" => "#D5C2B1", "gambar" => null]
        );

        $pelanggan = Pelanggan::query()->updateOrCreate(
            ["email" => "pelanggan@example.test"],
            [
                "nama_pelanggan" => "Pelanggan Demo",
                "no_hp" => "089876543210",
            ],
        );

        RiwayatKalkulasi::query()->updateOrCreate(
            [
                "id_pelanggan" => $pelanggan->id_pelanggan,
                "id_produk" => $produkInterior->id_produk,
                "tanggal_kalkulasi" => now()->toDateString(),
            ],
            [
                "panjang_dinding" => 6.0,
                "tinggi_dinding" => 3.0,
                "hasil_liter" => 1.5,
            ],
        );

        $request = RequestTinting::query()->updateOrCreate(
            [
                "id_pelanggan" => $pelanggan->id_pelanggan,
                "tanggal_request" => now()->toDateString(),
            ],
            [
                "id_admin" => $admin->id_admin,
                "status" => "pending",
            ],
        );

        DetailRequestTinting::query()->updateOrCreate(
            [
                "id_request" => $request->id_request,
                "id_warna" => $warnaKuning->id_warna,
            ],
            [
                "jumlah_kaleng" => 2,
            ],
        );

        Laporan::query()->updateOrCreate(
            [
                "id_admin" => $admin->id_admin,
                "tanggal_laporan" => now()->toDateString(),
                "periode_laporan" => now()->format("F Y"),
            ],
            [
                "isi_laporan" =>
                    "Laporan demo: katalog produk, warna, kalkulasi, dan request tinting sudah memiliki data awal.",
            ],
        );
    }
}

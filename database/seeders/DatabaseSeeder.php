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

    public function run(): void
    {
        // ── Base admin & toko ──
        User::query()->firstOrCreate(
            ["email" => "test@example.com"],
            ["name" => "Test User", "password" => "password"],
        );

        $admin = Admin::query()->updateOrCreate(
            ["email" => "admin@jotun-cabang.test"],
            [
                "nama_admin" => "Admin Jotun Cabang",
                "password" => "password",
                "no_hp" => "0812-3456-7890",
            ],
        );

        ProfilToko::query()->updateOrCreate(
            ["id_admin" => $admin->id_admin],
            [
                "nama_toko" => "Jotun Paint Center Graha Metropolitan",
                "alamat" => "Kompleks, Jl. Graha Metropolitan No. 85, Helvetia, Kec. Sunggal, Kabupaten Deli Serdang, Sumatera Utara",
                "kontak" => "0812-3456-7890",
                "deskripsi" => "Dealer Resmi Cat Jotun Graha Metropolitan Deli Serdang. Menyediakan cat premium eksterior, interior, kayu, dan besi orisinal lengkap dengan sistem pencampuran warna (tinting) instan terkomputerisasi.",
            ],
        );

        // ── Products, sizes, colors ──
        $this->call([
            JotunProductSeeder::class,
            ProdukUkuranSeeder::class,
            JotunColorSeeder::class,
        ]);

        // ── Demo data ──
        $pelanggan = Pelanggan::query()->updateOrCreate(
            ["email" => "pelanggan@example.test"],
            ["nama_pelanggan" => "Pelanggan Demo", "no_hp" => "089876543210"],
        );

        $produkInterior = KatalogProduk::query()->where('nama_produk', 'Majestic Sense')->first();
        $produkEksterior = KatalogProduk::query()->where('nama_produk', 'Jotashield Antifade Colours')->first();

        if ($produkInterior) {
            RiwayatKalkulasi::query()->updateOrCreate(
                [
                    "id_pelanggan" => $pelanggan->id_pelanggan,
                    "id_produk" => $produkInterior->id_produk,
                    "tanggal_kalkulasi" => now()->toDateString(),
                ],
                [
                    "panjang_dinding" => 6.0,
                    "tinggi_dinding" => 3.0,
                    "jumlah_lapisan" => 2,
                    "hasil_liter" => 3.0,
                    "jumlah_kaleng" => 2,
                ],
            );
        }

        if ($produkEksterior) {
            $warnaKuning = Warna::query()
                ->where('id_produk', $produkEksterior->id_produk)
                ->where('kode_warna', 'JTN-120')
                ->first();

            if ($warnaKuning) {
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
                    ["jumlah_kaleng" => 2],
                );
            }
        }

        Laporan::query()->updateOrCreate(
            [
                "id_admin" => $admin->id_admin,
                "tanggal_laporan" => now()->toDateString(),
                "periode_laporan" => now()->format("F Y"),
            ],
            [
                "isi_laporan" => "Laporan bulanan: katalog produk, warna, kalkulasi, dan request tinting sudah memiliki data awal.",
            ],
        );
    }
}

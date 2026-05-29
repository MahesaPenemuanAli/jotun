<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\KatalogProduk;
use Illuminate\Database\Seeder;

class JotunProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::query()->firstOrFail();

        $products = [
            // ── Interior ──
            ['nama_produk' => 'Majestic Sense',              'kategori' => 'Interior',    'harga' => 650000, 'daya_sebar' => 12.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => '/images/majestic-sense.webp'],
            ['nama_produk' => 'Majestic True Beauty Matt',    'kategori' => 'Interior',    'harga' => 580000, 'daya_sebar' => 12.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Majestic True Beauty Sheen',   'kategori' => 'Interior',    'harga' => 620000, 'daya_sebar' => 12.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Majestic Pure Color',          'kategori' => 'Interior',    'harga' => 450000, 'daya_sebar' => 12.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Essence Easy Wipe',            'kategori' => 'Interior',    'harga' => 380000, 'daya_sebar' => 11.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Essence Cover Plus Sheen',     'kategori' => 'Interior',    'harga' => 350000, 'daya_sebar' => 11.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],

            // ── Eksterior ──
            ['nama_produk' => 'Jotashield Infinity',          'kategori' => 'Eksterior',   'harga' => 700000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotashield Ultra Clean',       'kategori' => 'Eksterior',   'harga' => 650000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotashield Flex',              'kategori' => 'Eksterior',   'harga' => 550000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotashield Antifade Colours',  'kategori' => 'Eksterior',   'harga' => 500000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => '/images/jotashield.webp'],
            ['nama_produk' => 'Jotun Tough Shield Max',       'kategori' => 'Eksterior',   'harga' => 420000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotun Tough Shield',           'kategori' => 'Eksterior',   'harga' => 380000, 'daya_sebar' => 10.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => null],

            // ── Kayu & Besi ──
            ['nama_produk' => 'Gardex Premium Gloss',         'kategori' => 'Kayu & Besi', 'harga' => 250000, 'daya_sebar' => 11.0, 'is_tintable' => true,  'tipe_produk' => 'finishing', 'status_produk' => 'aktif', 'gambar' => '/images/gardex.webp'],

            // ── Pendukung ──
            ['nama_produk' => 'Jotashield Primer',            'kategori' => 'Eksterior',   'harga' => 280000, 'daya_sebar' => 10.0, 'is_tintable' => false, 'tipe_produk' => 'primer',        'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotun Ultra Primer',           'kategori' => 'Interior',    'harga' => 260000, 'daya_sebar' => 10.0, 'is_tintable' => false, 'tipe_produk' => 'primer',        'status_produk' => 'aktif', 'gambar' => null],
            ['nama_produk' => 'Jotun WaterGuard',             'kategori' => 'Eksterior',   'harga' => 350000, 'daya_sebar' =>  8.0, 'is_tintable' => false, 'tipe_produk' => 'waterproofing', 'status_produk' => 'aktif', 'gambar' => null],
        ];

        foreach ($products as $data) {
            KatalogProduk::query()->updateOrCreate(
                ['id_admin' => $admin->id_admin, 'nama_produk' => $data['nama_produk']],
                collect($data)->except('nama_produk')->toArray()
            );
        }
    }
}

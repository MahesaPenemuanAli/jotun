<?php

namespace Database\Seeders;

use App\Models\KatalogProduk;
use App\Models\ProdukUkuran;
use Illuminate\Database\Seeder;

class ProdukUkuranSeeder extends Seeder
{
    public function run(): void
    {
        // Ukuran per kelompok produk
        $interiorSizes   = [1.0, 2.5, 5.0, 20.0];
        $eksteriorSizes  = [2.5, 5.0, 20.0];
        $gardexSizes     = [0.9, 2.5, 5.0];
        $pendukungSizes  = [2.5, 5.0, 20.0];

        // Harga multiplier relatif terhadap harga dasar (2.5L)
        // harga_dasar = $product->harga (ini sudah untuk 2.5L)
        $sizeMultipliers = [
            '0.9' => 0.40,
            '1.0' => 0.45,
            '2.5' => 1.00,
            '5.0' => 1.90,
            '20.0' => 7.20,
        ];

        $mapping = [
            // Interior
            'Majestic Sense'              => $interiorSizes,
            'Majestic True Beauty Matt'    => $interiorSizes,
            'Majestic True Beauty Sheen'   => $interiorSizes,
            'Majestic Pure Color'          => $interiorSizes,
            'Essence Easy Wipe'            => $interiorSizes,
            'Essence Cover Plus Sheen'     => $interiorSizes,
            // Eksterior
            'Jotashield Infinity'          => $eksteriorSizes,
            'Jotashield Ultra Clean'       => $eksteriorSizes,
            'Jotashield Flex'              => $eksteriorSizes,
            'Jotashield Antifade Colours'  => $eksteriorSizes,
            'Jotun Tough Shield Max'       => $eksteriorSizes,
            'Jotun Tough Shield'           => $eksteriorSizes,
            // Kayu & Besi
            'Gardex Premium Gloss'         => $gardexSizes,
            // Pendukung
            'Jotashield Primer'            => $pendukungSizes,
            'Jotun Ultra Primer'           => $pendukungSizes,
            'Jotun WaterGuard'             => $pendukungSizes,
        ];

        foreach ($mapping as $namaProduk => $sizes) {
            $product = KatalogProduk::query()
                ->where('nama_produk', $namaProduk)
                ->first();

            if (! $product) {
                continue;
            }

            $basePrice = (int) $product->harga;

            foreach ($sizes as $liter) {
                $multiplier = $sizeMultipliers[(string) number_format($liter, 1)] ?? 1.0;
                $price = (int) round($basePrice * $multiplier);

                ProdukUkuran::query()->updateOrCreate(
                    [
                        'id_produk' => $product->id_produk,
                        'ukuran_liter' => $liter,
                    ],
                    [
                        'harga' => $price,
                        'status' => 'aktif',
                    ]
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\KatalogProduk;
use App\Models\Warna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JotunColorSeeder extends Seeder
{
    public function run(): void
    {
        // ── Master color palette ──
        $interiorColors = [
            ['kode'=>'JTN-1624','nama'=>'Classic White','hex'=>'#F8F5EC','kat'=>'Putih'],
            ['kode'=>'JTN-0553','nama'=>'Pearl White','hex'=>'#F7F3EA','kat'=>'Putih'],
            ['kode'=>'JTN-0567','nama'=>'Ivory Dream','hex'=>'#FAF4E3','kat'=>'Putih'],
            ['kode'=>'JTN-0571','nama'=>'Snow White','hex'=>'#FEFCF7','kat'=>'Putih'],
            ['kode'=>'JTN-0582','nama'=>'Lily White','hex'=>'#F9F6EE','kat'=>'Putih'],
            ['kode'=>'JTN-0590','nama'=>'Cotton White','hex'=>'#F5F2E8','kat'=>'Putih'],
            ['kode'=>'JTN-9918','nama'=>'Morning Fog','hex'=>'#E2E6E7','kat'=>'Abu-abu'],
            ['kode'=>'JTN-0394','nama'=>'Soft Grey','hex'=>'#D6D8D5','kat'=>'Abu-abu'],
            ['kode'=>'JTN-12077','nama'=>'Sheer Grey','hex'=>'#D4D0C9','kat'=>'Abu-abu'],
            ['kode'=>'JTN-0396','nama'=>'Silver Mist','hex'=>'#C8CCCA','kat'=>'Abu-abu'],
            ['kode'=>'JTN-0401','nama'=>'Pewter','hex'=>'#B0B4B2','kat'=>'Abu-abu'],
            ['kode'=>'JTN-0410','nama'=>'Dove Grey','hex'=>'#A5A9A7','kat'=>'Abu-abu'],
            ['kode'=>'JTN-3162','nama'=>'Sky Blue','hex'=>'#B5CDE0','kat'=>'Biru'],
            ['kode'=>'JTN-3215','nama'=>'Nordic Breeze','hex'=>'#A8C4D4','kat'=>'Biru'],
            ['kode'=>'JTN-4180','nama'=>'Soft Teal','hex'=>'#829A9E','kat'=>'Biru'],
            ['kode'=>'JTN-4192','nama'=>'Azure Hint','hex'=>'#C4D8E2','kat'=>'Biru'],
            ['kode'=>'JTN-4210','nama'=>'Calm Blue','hex'=>'#9BB8C8','kat'=>'Biru'],
            ['kode'=>'JTN-4225','nama'=>'Pacific Blue','hex'=>'#6D9BB5','kat'=>'Biru'],
            ['kode'=>'JTN-4240','nama'=>'Steel Blue','hex'=>'#5A8399','kat'=>'Biru'],
            ['kode'=>'JTN-8469','nama'=>'Antique Green','hex'=>'#7D8C82','kat'=>'Hijau'],
            ['kode'=>'JTN-8470','nama'=>'Green Leaf','hex'=>'#5F6B5A','kat'=>'Hijau'],
            ['kode'=>'JTN-8252','nama'=>'Green Harmony','hex'=>'#A2B29F','kat'=>'Hijau'],
            ['kode'=>'JTN-8478','nama'=>'Pale Linden','hex'=>'#CBD5C0','kat'=>'Hijau'],
            ['kode'=>'JTN-8290','nama'=>'Sage Garden','hex'=>'#B4C4A8','kat'=>'Hijau'],
            ['kode'=>'JTN-8305','nama'=>'Mint Leaf','hex'=>'#A8D4B8','kat'=>'Hijau'],
            ['kode'=>'JTN-8320','nama'=>'Spring Green','hex'=>'#8FC4A0','kat'=>'Hijau'],
            ['kode'=>'JTN-1453','nama'=>'Vanilla Latte','hex'=>'#F0E6D0','kat'=>'Kuning'],
            ['kode'=>'JTN-1460','nama'=>'Butter Cream','hex'=>'#F5E8C8','kat'=>'Kuning'],
            ['kode'=>'JTN-1475','nama'=>'Honey Gold','hex'=>'#E8D4A0','kat'=>'Kuning'],
            ['kode'=>'JTN-1490','nama'=>'Warm Amber','hex'=>'#D4B878','kat'=>'Kuning'],
            ['kode'=>'JTN-2125','nama'=>'Misty Rose','hex'=>'#F2D4D0','kat'=>'Merah'],
            ['kode'=>'JTN-2140','nama'=>'Blush Pink','hex'=>'#E8B8B0','kat'=>'Merah'],
            ['kode'=>'JTN-2155','nama'=>'Terracotta Light','hex'=>'#D4A090','kat'=>'Merah'],
            ['kode'=>'JTN-2170','nama'=>'Coral Reef','hex'=>'#C08878','kat'=>'Merah'],
            ['kode'=>'JTN-2185','nama'=>'Rustic Red','hex'=>'#A06050','kat'=>'Merah'],
            ['kode'=>'JTN-7236','nama'=>'Warm Sand','hex'=>'#D8CBB5','kat'=>'Coklat'],
            ['kode'=>'JTN-1987','nama'=>'Cocoa Cream','hex'=>'#C9B49A','kat'=>'Coklat'],
            ['kode'=>'JTN-12179','nama'=>'Embrace','hex'=>'#C5A894','kat'=>'Coklat'],
            ['kode'=>'JTN-12180','nama'=>'Present','hex'=>'#B5B0A2','kat'=>'Coklat'],
            ['kode'=>'JTN-10961','nama'=>'Raw Canvas','hex'=>'#C6B79B','kat'=>'Coklat'],
            ['kode'=>'JTN-5503','nama'=>'Natural Clay','hex'=>'#C39D83','kat'=>'Coklat'],
            ['kode'=>'JTN-5520','nama'=>'Cappuccino','hex'=>'#A08060','kat'=>'Coklat'],
            ['kode'=>'JTN-5535','nama'=>'Mocha Brown','hex'=>'#8B6B50','kat'=>'Coklat'],
            ['kode'=>'JTN-10678','nama'=>'Space','hex'=>'#D6CEBE','kat'=>'Netral'],
            ['kode'=>'JTN-1024','nama'=>'Timeless','hex'=>'#E6E3D8','kat'=>'Netral'],
            ['kode'=>'JTN-10679','nama'=>'Washed Linen','hex'=>'#CDC5B4','kat'=>'Netral'],
            ['kode'=>'JTN-12182','nama'=>'Gentle Whisper','hex'=>'#E5E1D8','kat'=>'Netral'],
            ['kode'=>'JTN-10695','nama'=>'Soft Silk','hex'=>'#E0D8C8','kat'=>'Netral'],
            ['kode'=>'JTN-10710','nama'=>'Warm Linen','hex'=>'#D8D0BE','kat'=>'Netral'],
            ['kode'=>'JTN-10725','nama'=>'Natural Beige','hex'=>'#D0C4B0','kat'=>'Netral'],
            ['kode'=>'JTN-6354','nama'=>'Dusty Lavender','hex'=>'#C5B8C9','kat'=>'Pastel'],
            ['kode'=>'JTN-20184','nama'=>'Tender Pink','hex'=>'#E5C9C5','kat'=>'Pastel'],
            ['kode'=>'JTN-20185','nama'=>'Friendly Pink','hex'=>'#DCAEAB','kat'=>'Pastel'],
            ['kode'=>'JTN-20186','nama'=>'Lavender Touch','hex'=>'#D2C7D4','kat'=>'Pastel'],
            ['kode'=>'JTN-4894','nama'=>'Ocean Air','hex'=>'#DFECF0','kat'=>'Pastel'],
            ['kode'=>'JTN-7628','nama'=>'Treasure','hex'=>'#C2C7B5','kat'=>'Pastel'],
            ['kode'=>'JTN-4910','nama'=>'Baby Blue','hex'=>'#C8DDE8','kat'=>'Pastel'],
            ['kode'=>'JTN-4925','nama'=>'Powder Lilac','hex'=>'#D8C8D8','kat'=>'Pastel'],
            ['kode'=>'JTN-4940','nama'=>'Peach Blossom','hex'=>'#F0D8C8','kat'=>'Pastel'],
            ['kode'=>'JTN-4955','nama'=>'Lemon Sorbet','hex'=>'#F5ECC0','kat'=>'Pastel'],
            ['kode'=>'JTN-4970','nama'=>'Mint Cream','hex'=>'#D0E8D8','kat'=>'Pastel'],
            ['kode'=>'JTN-9913','nama'=>'Matrix','hex'=>'#6B6E70','kat'=>'Gelap'],
            ['kode'=>'JTN-9938','nama'=>'Blackish','hex'=>'#2D2F31','kat'=>'Gelap'],
            ['kode'=>'JTN-1434','nama'=>'Elegant','hex'=>'#58524B','kat'=>'Gelap'],
            ['kode'=>'JTN-5081','nama'=>'Sagebrush','hex'=>'#6D7268','kat'=>'Gelap'],
            ['kode'=>'JTN-9950','nama'=>'Charcoal Ink','hex'=>'#3A3D40','kat'=>'Gelap'],
            ['kode'=>'JTN-9960','nama'=>'Deep Espresso','hex'=>'#4A3828','kat'=>'Gelap'],
            ['kode'=>'JTN-9970','nama'=>'Midnight Navy','hex'=>'#1E2A3A','kat'=>'Gelap'],
        ];

        $eksteriorColors = [
            ['kode'=>'JTN-120','nama'=>'Warm Signal Yellow','hex'=>'#FDB913','kat'=>'Kuning'],
            ['kode'=>'JTN-121','nama'=>'Evening Sky','hex'=>'#3D4A5E','kat'=>'Gelap'],
            ['kode'=>'JTN-122','nama'=>'Crimson Glory','hex'=>'#9B2C2C','kat'=>'Merah'],
            ['kode'=>'JTN-123','nama'=>'Stone Gray','hex'=>'#7F8385','kat'=>'Abu-abu'],
            ['kode'=>'JTN-5012','nama'=>'Arctic White','hex'=>'#F4F1EA','kat'=>'Putih'],
            ['kode'=>'JTN-5245','nama'=>'Sahara Beige','hex'=>'#D4BC96','kat'=>'Coklat'],
            ['kode'=>'JTN-5301','nama'=>'Tropical Green','hex'=>'#4A7C59','kat'=>'Hijau'],
            ['kode'=>'JTN-5402','nama'=>'Ocean Mist','hex'=>'#8EAFB2','kat'=>'Pastel'],
            ['kode'=>'JTN-5510','nama'=>'Terracotta','hex'=>'#C4755B','kat'=>'Merah'],
            ['kode'=>'JTN-5611','nama'=>'Charcoal','hex'=>'#3C3C3C','kat'=>'Gelap'],
            ['kode'=>'JTN-5720','nama'=>'Olive Grove','hex'=>'#6B7B4F','kat'=>'Hijau'],
            ['kode'=>'JTN-5815','nama'=>'Desert Rose','hex'=>'#D4A09A','kat'=>'Pastel'],
            ['kode'=>'JTN-5930','nama'=>'Caramel Gold','hex'=>'#C49B48','kat'=>'Kuning'],
            ['kode'=>'JTN-6010','nama'=>'Nordic Gray','hex'=>'#B0B3B2','kat'=>'Abu-abu'],
            ['kode'=>'JTN-6111','nama'=>'Deep Navy','hex'=>'#2C3E50','kat'=>'Gelap'],
            ['kode'=>'JTN-1141','nama'=>'Natural Beige Ext','hex'=>'#D3C5AE','kat'=>'Coklat'],
            ['kode'=>'JTN-1973','nama'=>'Objective','hex'=>'#C3BEB4','kat'=>'Netral'],
            ['kode'=>'JTN-1032','nama'=>'Iron Grey','hex'=>'#8C8D8A','kat'=>'Abu-abu'],
            ['kode'=>'JTN-4250','nama'=>'Polar Blue','hex'=>'#D0DFE7','kat'=>'Pastel'],
            ['kode'=>'JTN-4629','nama'=>'Slate Blue','hex'=>'#5C7180','kat'=>'Biru'],
            ['kode'=>'JTN-5180','nama'=>'Oslo','hex'=>'#3B4F55','kat'=>'Gelap'],
            ['kode'=>'JTN-0099','nama'=>'Black','hex'=>'#1C1D1F','kat'=>'Gelap'],
            ['kode'=>'JTN-7030','nama'=>'Earthy Brown','hex'=>'#5C4D43','kat'=>'Gelap'],
            ['kode'=>'JTN-8422','nama'=>'Green Tea','hex'=>'#A6B79D','kat'=>'Hijau'],
            ['kode'=>'JTN-3180','nama'=>'Rose Petal','hex'=>'#ECD4D1','kat'=>'Pastel'],
            ['kode'=>'JTN-10429','nama'=>'Discrete','hex'=>'#9C9993','kat'=>'Abu-abu'],
            ['kode'=>'JTN-10249','nama'=>'Sober','hex'=>'#524F4A','kat'=>'Gelap'],
            ['kode'=>'JTN-10963','nama'=>'Golden Bronze','hex'=>'#957E59','kat'=>'Kuning'],
            ['kode'=>'JTN-4618','nama'=>'Light Teal','hex'=>'#A3C5C7','kat'=>'Pastel'],
            ['kode'=>'JTN-4638','nama'=>'Marine Blue','hex'=>'#1E3F5A','kat'=>'Gelap'],
            ['kode'=>'JTN-0398','nama'=>'Concrete Grey','hex'=>'#A3A6A5','kat'=>'Abu-abu'],
            ['kode'=>'JTN-8009','nama'=>'Forest Fern','hex'=>'#3D5A42','kat'=>'Gelap'],
            ['kode'=>'JTN-2374','nama'=>'Brick Red','hex'=>'#9E4F42','kat'=>'Merah'],
            ['kode'=>'JTN-1016','nama'=>'Antique Sand','hex'=>'#D6C3AA','kat'=>'Coklat'],
            ['kode'=>'JTN-1376','nama'=>'Mist','hex'=>'#E2E0D9','kat'=>'Netral'],
        ];

        $gardexColors = [
            ['kode'=>'JTN-201','nama'=>'Cotton Blossom','hex'=>'#F7F3EA','kat'=>'Putih'],
            ['kode'=>'JTN-202','nama'=>'Silver Breeze','hex'=>'#E1E3E2','kat'=>'Abu-abu'],
            ['kode'=>'JTN-203','nama'=>'Soft Clay','hex'=>'#D5C2B1','kat'=>'Coklat'],
            ['kode'=>'JTN-7101','nama'=>'Jet Black','hex'=>'#1A1A1A','kat'=>'Gelap'],
            ['kode'=>'JTN-7202','nama'=>'Fire Engine Red','hex'=>'#C0392B','kat'=>'Merah'],
            ['kode'=>'JTN-7303','nama'=>'Royal Blue','hex'=>'#2E5FA1','kat'=>'Biru'],
            ['kode'=>'JTN-7404','nama'=>'Emerald','hex'=>'#1E8449','kat'=>'Hijau'],
            ['kode'=>'JTN-7505','nama'=>'Sunshine Yellow','hex'=>'#F4C430','kat'=>'Kuning'],
            ['kode'=>'JTN-7606','nama'=>'Chocolate Brown','hex'=>'#6B4226','kat'=>'Coklat'],
            ['kode'=>'JTN-7707','nama'=>'Dove White','hex'=>'#EDEDEA','kat'=>'Putih'],
            ['kode'=>'JTN-7808','nama'=>'Gun Metal','hex'=>'#52575D','kat'=>'Gelap'],
            ['kode'=>'JTN-7909','nama'=>'Copper Bronze','hex'=>'#B87333','kat'=>'Kuning'],
            ['kode'=>'JTN-801','nama'=>'Ivory Gloss','hex'=>'#FAF4E3','kat'=>'Putih'],
            ['kode'=>'JTN-802','nama'=>'Pewter Gray','hex'=>'#7B8084','kat'=>'Abu-abu'],
            ['kode'=>'JTN-803','nama'=>'Midnight Blue','hex'=>'#1A2B4C','kat'=>'Gelap'],
            ['kode'=>'JTN-804','nama'=>'Forest Green','hex'=>'#224A29','kat'=>'Gelap'],
            ['kode'=>'JTN-805','nama'=>'Signal Red','hex'=>'#A61C1C','kat'=>'Merah'],
            ['kode'=>'JTN-806','nama'=>'Bright Orange','hex'=>'#D35400','kat'=>'Merah'],
            ['kode'=>'JTN-807','nama'=>'Creamy Vanilla','hex'=>'#F3E5AB','kat'=>'Pastel'],
            ['kode'=>'JTN-808','nama'=>'Plum Purple','hex'=>'#4A235A','kat'=>'Gelap'],
            ['kode'=>'JTN-809','nama'=>'Sky Sparkle','hex'=>'#85C1E9','kat'=>'Pastel'],
            ['kode'=>'JTN-810','nama'=>'Minty Green','hex'=>'#A2D9CE','kat'=>'Pastel'],
            ['kode'=>'JTN-811','nama'=>'Slate Grey','hex'=>'#5D6D7E','kat'=>'Abu-abu'],
            ['kode'=>'JTN-812','nama'=>'Mahogany','hex'=>'#4A2711','kat'=>'Gelap'],
            ['kode'=>'JTN-813','nama'=>'Golden Ochre','hex'=>'#D4AC0D','kat'=>'Kuning'],
        ];

        // ── Map colors to products ──
        DB::transaction(function () use ($interiorColors, $eksteriorColors, $gardexColors) {
            $interiorProducts = [
                'Majestic Sense',
                'Majestic True Beauty Matt',
                'Majestic True Beauty Sheen',
                'Majestic Pure Color',
                'Essence Easy Wipe',
                'Essence Cover Plus Sheen',
            ];

            $eksteriorProducts = [
                'Jotashield Infinity',
                'Jotashield Ultra Clean',
                'Jotashield Flex',
                'Jotashield Antifade Colours',
                'Jotun Tough Shield Max',
                'Jotun Tough Shield',
            ];

            $gardexProducts = [
                'Gardex Premium Gloss',
            ];

            $this->seedColorsForProducts($interiorColors, $interiorProducts);
            $this->seedColorsForProducts($eksteriorColors, $eksteriorProducts);
            $this->seedColorsForProducts($gardexColors, $gardexProducts);
        });
    }

    private function seedColorsForProducts(array $colors, array $productNames): void
    {
        $products = KatalogProduk::query()
            ->aktif()
            ->tintable()
            ->whereIn('nama_produk', $productNames)
            ->get()
            ->keyBy('nama_produk');

        foreach ($productNames as $name) {
            $product = $products->get($name);

            if (! $product) {
                $this->command?->warn("Produk aktif/tintable tidak ditemukan: {$name}");
                continue;
            }

            foreach ($colors as $c) {
                Warna::query()->updateOrCreate(
                    [
                        'id_produk' => $product->id_produk,
                        'kode_warna' => $c['kode'],
                    ],
                    [
                        'nama_warna' => $c['nama'],
                        'hex_color' => $c['hex'],
                        'kategori_warna' => $c['kat'],
                    ]
                );
            }

            $this->command?->info("{$name}: " . count($colors) . " warna berhasil disinkronkan.");
        }
    }
}

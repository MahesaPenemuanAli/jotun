<?php

namespace App\Http\Controllers;

use App\Models\KatalogProduk;
use App\Models\Pelanggan;
use App\Models\ProdukUkuran;
use App\Models\RiwayatKalkulasi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaintCalculatorController extends Controller
{
    public function create(): View
    {
        $products = KatalogProduk::query()
            ->aktif()
            ->with('ukuranAktif')
            ->orderBy('kategori')
            ->orderBy('nama_produk')
            ->get();

        return view('calculator.create', [
            'products' => $products,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $isLoggedIn = $user !== null;

        $rules = [
            'id_produk' => ['required', 'exists:katalog_produk,id_produk'],
            'panjang_dinding' => ['required', 'numeric', 'min:0.1', 'max:1000'],
            'tinggi_dinding' => ['required', 'numeric', 'min:0.1', 'max:1000'],
            'jumlah_lapisan' => ['required', 'integer', 'min:1', 'max:5'],
        ];

        if (! $isLoggedIn) {
            $rules['nama_pelanggan'] = ['required', 'string', 'max:255'];
            $rules['no_hp'] = ['required', 'string', 'max:30'];
            $rules['email'] = ['nullable', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        $product = KatalogProduk::query()->whereKey($validated['id_produk'])->firstOrFail();
        $spreadRate = max((float) ($product->daya_sebar ?: 10), 0.1);
        $wallArea = (float) $validated['panjang_dinding'] * (float) $validated['tinggi_dinding'];
        $paintArea = $wallArea * (int) $validated['jumlah_lapisan'];
        $liters = round($paintArea / $spreadRate, 2);

        // Smart can combination
        $recommendation = $this->calculateCanCombination($product, $liters);

        if ($isLoggedIn) {
            $customer = $user->pelanggan;
            if (! $customer) {
                $customer = Pelanggan::create([
                    'user_id' => $user->id,
                    'nama_pelanggan' => $user->name,
                    'email' => $user->email,
                ]);
            }
        } else {
            $customerLookup = filled($validated['email'] ?? null)
                ? ['email' => $validated['email']]
                : ['no_hp' => $validated['no_hp']];

            $customer = Pelanggan::query()->updateOrCreate($customerLookup, [
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'] ?? null,
            ]);
        }

        $cans = $recommendation['total_kaleng'] ?: max(1, (int) ceil($liters / 2.5));

        RiwayatKalkulasi::create([
            'id_pelanggan' => $customer->id_pelanggan,
            'id_produk' => $product->id_produk,
            'tanggal_kalkulasi' => now()->toDateString(),
            'panjang_dinding' => $validated['panjang_dinding'],
            'tinggi_dinding' => $validated['tinggi_dinding'],
            'jumlah_lapisan' => $validated['jumlah_lapisan'],
            'hasil_liter' => $liters,
            'jumlah_kaleng' => $cans,
        ]);

        return redirect()
            ->route('calculator.create')
            ->withInput($request->except('email'))
            ->with('success', 'Kalkulasi berhasil disimpan ke riwayat.')
            ->with('calculator_result', [
                'produk' => $product->nama_produk,
                'kategori' => $product->kategori,
                'tipe' => $product->tipe_produk,
                'daya_sebar' => $spreadRate,
                'luas_dinding' => number_format($wallArea, 2, ',', '.'),
                'jumlah_lapisan' => $validated['jumlah_lapisan'],
                'total_area' => number_format($paintArea, 2, ',', '.'),
                'hasil_liter' => number_format($liters, 2, ',', '.'),
                'hasil_liter_raw' => $liters,
                'jumlah_kaleng' => $cans,
                'rekomendasi' => $recommendation['items'],
                'total_liter_beli' => $recommendation['total_liter'],
                'sisa_liter' => $recommendation['sisa'],
                'estimasi_harga' => $recommendation['estimasi_harga'],
            ]);
    }

    /**
     * Calculate optimal can combination for required liters.
     */
    private function calculateCanCombination(KatalogProduk $product, float $requiredLiters): array
    {
        $sizes = ProdukUkuran::query()
            ->where('id_produk', $product->id_produk)
            ->where('status', 'aktif')
            ->orderByDesc('ukuran_liter')
            ->get();

        // Fallback if no sizes defined
        if ($sizes->isEmpty()) {
            $cans = max(1, (int) ceil($requiredLiters / 2.5));
            return [
                'items' => [['ukuran' => 2.5, 'jumlah' => $cans, 'harga' => null]],
                'total_kaleng' => $cans,
                'total_liter' => $cans * 2.5,
                'sisa' => round($cans * 2.5 - $requiredLiters, 2),
                'estimasi_harga' => null,
            ];
        }

        // Greedy algorithm: largest cans first
        $remaining = $requiredLiters;
        $items = [];
        $totalLiter = 0;
        $totalHarga = 0;
        $totalKaleng = 0;
        $hasPrice = true;

        foreach ($sizes as $size) {
            $liter = (float) $size->ukuran_liter;
            if ($liter <= 0) continue;

            $count = (int) floor($remaining / $liter);
            if ($count > 0) {
                $items[] = [
                    'ukuran' => $liter,
                    'jumlah' => $count,
                    'harga' => $size->harga,
                ];
                $remaining -= $count * $liter;
                $totalLiter += $count * $liter;
                $totalKaleng += $count;
                if ($size->harga) {
                    $totalHarga += $count * $size->harga;
                } else {
                    $hasPrice = false;
                }
            }
        }

        // If remaining > 0, add smallest can that covers it
        if ($remaining > 0.01) {
            $smallestFit = $sizes->sortBy('ukuran_liter')
                ->first(fn ($s) => (float) $s->ukuran_liter >= $remaining);

            if (! $smallestFit) {
                $smallestFit = $sizes->sortByDesc('ukuran_liter')->last();
            }

            if ($smallestFit) {
                $existingIdx = collect($items)->search(
                    fn ($item) => $item['ukuran'] == (float) $smallestFit->ukuran_liter
                );
                if ($existingIdx !== false) {
                    $items[$existingIdx]['jumlah']++;
                } else {
                    $items[] = [
                        'ukuran' => (float) $smallestFit->ukuran_liter,
                        'jumlah' => 1,
                        'harga' => $smallestFit->harga,
                    ];
                }
                $totalLiter += (float) $smallestFit->ukuran_liter;
                $totalKaleng++;
                if ($smallestFit->harga) {
                    $totalHarga += $smallestFit->harga;
                } else {
                    $hasPrice = false;
                }
            }
        }

        // Sort items by size descending for display
        usort($items, fn ($a, $b) => $b['ukuran'] <=> $a['ukuran']);

        return [
            'items' => $items,
            'total_kaleng' => $totalKaleng,
            'total_liter' => round($totalLiter, 1),
            'sisa' => round(max(0, $totalLiter - $requiredLiters), 2),
            'estimasi_harga' => $hasPrice ? $totalHarga : null,
        ];
    }
}

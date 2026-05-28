<?php

namespace App\Http\Controllers;

use App\Models\KatalogProduk;
use App\Models\Pelanggan;
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
        $cans = max(1, (int) ceil($liters / 2.5));

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
                'luas_dinding' => number_format($wallArea, 2, ',', '.'),
                'jumlah_lapisan' => $validated['jumlah_lapisan'],
                'hasil_liter' => number_format($liters, 2, ',', '.'),
                'jumlah_kaleng' => $cans,
            ]);
    }
}

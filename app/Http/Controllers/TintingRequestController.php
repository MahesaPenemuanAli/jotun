<?php

namespace App\Http\Controllers;

use App\Models\DetailRequestTinting;
use App\Models\KatalogProduk;
use App\Models\Pelanggan;
use App\Models\RequestTinting;
use App\Models\Warna;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TintingRequestController extends Controller
{
    public function create(): View
    {
        $products = KatalogProduk::query()
            ->aktif()
            ->tintable()
            ->with([
                "warna" => function ($query): void {
                    $query->orderBy("nama_warna");
                },
            ])
            ->orderBy("kategori")
            ->orderBy("nama_produk")
            ->get();

        return view("tinting.create", [
            "products" => $products,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $isLoggedIn = $user !== null;

        $rules = [
            "id_produk" => ["required", "exists:katalog_produk,id_produk"],
            "id_warna" => ["required", "exists:warna,id_warna"],
            "jumlah_kaleng" => ["required", "integer", "min:1", "max:100"],
        ];

        if (! $isLoggedIn) {
            $rules["nama_pelanggan"] = ["required", "string", "max:255"];
            $rules["no_hp"] = ["required", "string", "max:30"];
            $rules["email"] = ["nullable", "email", "max:255"];
        }

        $validated = $request->validate($rules);

        // Verify product is tintable
        $product = KatalogProduk::query()
            ->aktif()
            ->tintable()
            ->whereKey($validated["id_produk"])
            ->firstOrFail();

        // Verify color belongs to product
        $color = Warna::query()
            ->where("id_produk", $product->id_produk)
            ->whereKey($validated["id_warna"])
            ->firstOrFail();

        $requestTinting = DB::transaction(function () use ($validated, $user, $isLoggedIn, $product, $color): RequestTinting {
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
                $customerLookup = filled($validated["email"] ?? null)
                    ? ["email" => $validated["email"]]
                    : ["no_hp" => $validated["no_hp"]];

                $customer = Pelanggan::query()->updateOrCreate($customerLookup, [
                    "nama_pelanggan" => $validated["nama_pelanggan"],
                    "no_hp" => $validated["no_hp"],
                    "email" => $validated["email"] ?? null,
                ]);
            }

            $requestTinting = RequestTinting::create([
                "id_pelanggan" => $customer->id_pelanggan,
                "id_admin" => $product->id_admin,
                "tanggal_request" => now()->toDateString(),
                "status" => "pending",
            ]);

            DetailRequestTinting::create([
                "id_request" => $requestTinting->id_request,
                "id_warna" => $color->id_warna,
                "jumlah_kaleng" => $validated["jumlah_kaleng"],
            ]);

            return $requestTinting;
        });

        return redirect()
            ->route("tinting.create")
            ->with(
                "success",
                "Request tinting berhasil dikirim! Kode request: " .
                    $requestTinting->id_request,
            );
    }
}

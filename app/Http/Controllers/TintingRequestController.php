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
use Illuminate\Support\Facades\DB;

class TintingRequestController extends Controller
{
    public function create(): View
    {
        $products = KatalogProduk::query()
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
        $validated = $request->validate([
            "nama_pelanggan" => ["required", "string", "max:255"],
            "no_hp" => ["required", "string", "max:30"],
            "email" => ["nullable", "email", "max:255"],
            "id_produk" => ["required", "exists:katalog_produk,id_produk"],
            "id_warna" => ["required", "exists:warna,id_warna"],
            "jumlah_kaleng" => ["required", "integer", "min:1", "max:100"],
        ]);

        $requestTinting = DB::transaction(function () use (
            $validated,
        ): RequestTinting {
            $customerLookup = filled($validated["email"] ?? null)
                ? ["email" => $validated["email"]]
                : ["no_hp" => $validated["no_hp"]];

            $customer = Pelanggan::query()->updateOrCreate($customerLookup, [
                "nama_pelanggan" => $validated["nama_pelanggan"],
                "no_hp" => $validated["no_hp"],
                "email" => $validated["email"] ?? null,
            ]);

            $color = Warna::query()
                ->with("produk")
                ->where("id_produk", $validated["id_produk"])
                ->whereKey($validated["id_warna"])
                ->firstOrFail();

            $requestTinting = RequestTinting::create([
                "id_pelanggan" => $customer->id_pelanggan,
                "id_admin" => $color->produk?->id_admin,
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
                "Request tinting berhasil dikirim. Kode request: " .
                    $requestTinting->id_request,
            );
    }
}

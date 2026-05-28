<?php

namespace App\Http\Controllers;

use App\Models\KatalogProduk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query("q", ""));
        $category = $request->query("kategori");

        $products = KatalogProduk::query()
            ->with("warna")
            ->when($search !== "", function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where("nama_produk", "like", "%{$search}%")
                        ->orWhere("kategori", "like", "%{$search}%");
                });
            })
            ->when(filled($category), function ($query) use ($category): void {
                $query->where("kategori", $category);
            })
            ->orderBy("kategori")
            ->orderBy("nama_produk")
            ->paginate(9)
            ->withQueryString();

        $categories = KatalogProduk::query()
            ->select("kategori")
            ->whereNotNull("kategori")
            ->distinct()
            ->orderBy("kategori")
            ->pluck("kategori");

        return view("catalog.index", [
            "products" => $products,
            "categories" => $categories,
            "search" => $search,
            "category" => $category,
        ]);
    }

    public function show(string $idProduk): View
    {
        $product = KatalogProduk::query()
            ->with("warna")
            ->whereKey($idProduk)
            ->firstOrFail();

        return view("catalog.show", [
            "product" => $product,
        ]);
    }
}

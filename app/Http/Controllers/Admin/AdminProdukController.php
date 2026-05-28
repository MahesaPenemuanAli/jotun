<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KatalogProduk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProdukController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $category = $request->query('kategori');

        $products = KatalogProduk::query()
            ->withCount('warna')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('nama_produk', 'like', "%{$search}%")
                      ->orWhere('kategori', 'like', "%{$search}%");
                });
            })
            ->when(filled($category), function ($query) use ($category): void {
                $query->where('kategori', $category);
            })
            ->orderBy('kategori')
            ->orderBy('nama_produk')
            ->paginate(10)
            ->withQueryString();

        $categories = KatalogProduk::query()
            ->select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.produk.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'category' => $category,
        ]);
    }

    public function create(): View
    {
        return view('admin.produk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'daya_sebar' => ['nullable', 'numeric', 'min:0'],
            'gambar_mode' => ['nullable', 'string', 'in:url,upload'],
            'gambar_url' => ['nullable', 'url', 'max:2048'],
            'gambar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        $gambar = $this->resolveGambar($request);

        KatalogProduk::create([
            'id_admin' => Auth::guard('admin')->id(),
            'nama_produk' => $validated['nama_produk'],
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'daya_sebar' => $validated['daya_sebar'] ?? null,
            'gambar' => $gambar,
        ]);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $product = KatalogProduk::whereKey($id)->firstOrFail();

        return view('admin.produk.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $product = KatalogProduk::whereKey($id)->firstOrFail();

        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'daya_sebar' => ['nullable', 'numeric', 'min:0'],
            'gambar_mode' => ['nullable', 'string', 'in:url,upload'],
            'gambar_url' => ['nullable', 'url', 'max:2048'],
            'gambar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        $gambar = $this->resolveGambar($request) ?? $product->gambar;

        $product->update([
            'nama_produk' => $validated['nama_produk'],
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'daya_sebar' => $validated['daya_sebar'] ?? null,
            'gambar' => $gambar,
        ]);

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = KatalogProduk::whereKey($id)->firstOrFail();

        // Delete uploaded image if it exists in storage
        if ($product->gambar && ! str_starts_with($product->gambar, 'http')) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Resolve gambar from URL or uploaded file.
     */
    private function resolveGambar(Request $request): ?string
    {
        $mode = $request->input('gambar_mode', 'url');

        if ($mode === 'upload' && $request->hasFile('gambar_file')) {
            return $request->file('gambar_file')->store('produk', 'public');
        }

        if ($mode === 'url' && filled($request->input('gambar_url'))) {
            return $request->input('gambar_url');
        }

        return null;
    }
}

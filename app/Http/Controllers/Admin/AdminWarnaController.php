<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KatalogProduk;
use App\Models\Warna;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminWarnaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $produkId = $request->query('produk');

        $colors = Warna::query()
            ->with('produk')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('nama_warna', 'like', "%{$search}%")
                      ->orWhere('kode_warna', 'like', "%{$search}%");
                });
            })
            ->when(filled($produkId), function ($query) use ($produkId): void {
                $query->where('id_produk', $produkId);
            })
            ->orderBy('nama_warna')
            ->paginate(12)
            ->withQueryString();

        $products = KatalogProduk::orderBy('nama_produk')->get();

        return view('admin.warna.index', [
            'colors' => $colors,
            'products' => $products,
            'search' => $search,
            'produkId' => $produkId,
        ]);
    }

    public function create(Request $request): View
    {
        $products = KatalogProduk::orderBy('nama_produk')->get();

        return view('admin.warna.create', [
            'products' => $products,
            'selectedProduk' => $request->query('produk'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_produk' => ['required', 'exists:katalog_produk,id_produk'],
            'nama_warna' => ['required', 'string', 'max:255'],
            'kode_warna' => ['nullable', 'string', 'max:255'],
            'hex_color' => ['nullable', 'string', 'max:20'],
            'gambar_mode' => ['nullable', 'string', 'in:url,upload'],
            'gambar_url' => ['nullable', 'url', 'max:2048'],
            'gambar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        $gambar = $this->resolveGambar($request);

        Warna::create([
            'id_produk' => $validated['id_produk'],
            'nama_warna' => $validated['nama_warna'],
            'kode_warna' => $validated['kode_warna'] ?? null,
            'hex_color' => $validated['hex_color'] ?? null,
            'gambar' => $gambar,
        ]);

        return redirect()
            ->route('admin.warna.index', ['produk' => $validated['id_produk']])
            ->with('success', 'Warna berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $color = Warna::with('produk')->whereKey($id)->firstOrFail();
        $products = KatalogProduk::orderBy('nama_produk')->get();

        return view('admin.warna.edit', [
            'color' => $color,
            'products' => $products,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $color = Warna::whereKey($id)->firstOrFail();

        $validated = $request->validate([
            'id_produk' => ['required', 'exists:katalog_produk,id_produk'],
            'nama_warna' => ['required', 'string', 'max:255'],
            'kode_warna' => ['nullable', 'string', 'max:255'],
            'hex_color' => ['nullable', 'string', 'max:20'],
            'gambar_mode' => ['nullable', 'string', 'in:url,upload'],
            'gambar_url' => ['nullable', 'url', 'max:2048'],
            'gambar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        $gambar = $this->resolveGambar($request) ?? $color->gambar;

        $color->update([
            'id_produk' => $validated['id_produk'],
            'nama_warna' => $validated['nama_warna'],
            'kode_warna' => $validated['kode_warna'] ?? null,
            'hex_color' => $validated['hex_color'] ?? null,
            'gambar' => $gambar,
        ]);

        return redirect()
            ->route('admin.warna.index')
            ->with('success', 'Warna berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $color = Warna::whereKey($id)->firstOrFail();

        if ($color->gambar && ! str_starts_with($color->gambar, 'http')) {
            Storage::disk('public')->delete($color->gambar);
        }

        $color->delete();

        return redirect()
            ->route('admin.warna.index')
            ->with('success', 'Warna berhasil dihapus.');
    }

    private function resolveGambar(Request $request): ?string
    {
        $mode = $request->input('gambar_mode', 'url');

        if ($mode === 'upload' && $request->hasFile('gambar_file')) {
            return $request->file('gambar_file')->store('warna', 'public');
        }

        if ($mode === 'url' && filled($request->input('gambar_url'))) {
            return $request->input('gambar_url');
        }

        return null;
    }
}

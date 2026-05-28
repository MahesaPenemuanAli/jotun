<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestTinting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminTintingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q', ''));

        $requests = RequestTinting::query()
            ->with(['pelanggan', 'detail.warna.produk'])
            ->when(filled($status), function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search): void {
                $query->whereHas('pelanggan', function ($q) use ($search): void {
                    $q->where('nama_pelanggan', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->latest('tanggal_request')
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $statusCounts = [
            'all' => RequestTinting::count(),
            'pending' => RequestTinting::where('status', 'pending')->count(),
            'diproses' => RequestTinting::where('status', 'diproses')->count(),
            'selesai' => RequestTinting::where('status', 'selesai')->count(),
            'dibatalkan' => RequestTinting::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.tinting.index', [
            'requests' => $requests,
            'status' => $status,
            'search' => $search,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function show(string $id): View
    {
        $tintingRequest = RequestTinting::with([
            'pelanggan',
            'admin',
            'detail.warna.produk',
        ])->whereKey($id)->firstOrFail();

        return view('admin.tinting.show', [
            'tintingRequest' => $tintingRequest,
        ]);
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $tintingRequest = RequestTinting::whereKey($id)->firstOrFail();

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'diproses', 'selesai', 'dibatalkan'])],
        ]);

        $tintingRequest->update([
            'status' => $validated['status'],
            'id_admin' => Auth::guard('admin')->id(),
        ]);

        $statusLabels = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return redirect()
            ->route('admin.tinting.show', $id)
            ->with('success', 'Status request diubah menjadi: ' . ($statusLabels[$validated['status']] ?? $validated['status']));
    }
}

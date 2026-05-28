<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KatalogProduk;
use App\Models\RequestTinting;
use App\Models\RiwayatKalkulasi;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLaporanController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->resolveFilters($request);

        $tintingQuery = $this->buildTintingQuery($filters);
        $requests = (clone $tintingQuery)
            ->with(['pelanggan', 'detail.warna.produk'])
            ->latest('tanggal_request')
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $summaryBaseQuery = $this->buildTintingQuery($filters);
        $totalRequest = (clone $summaryBaseQuery)->count();
        $statusCounts = [
            'pending' => (clone $summaryBaseQuery)->where('status', 'pending')->count(),
            'diproses' => (clone $summaryBaseQuery)->where('status', 'diproses')->count(),
            'selesai' => (clone $summaryBaseQuery)->where('status', 'selesai')->count(),
            'dibatalkan' => (clone $summaryBaseQuery)->where('status', 'dibatalkan')->count(),
        ];

        $riwayatQuery = $this->buildRiwayatQuery($filters);
        $riwayatKalkulasi = (clone $riwayatQuery)
            ->with(['pelanggan', 'produk'])
            ->latest('tanggal_kalkulasi')
            ->latest('created_at')
            ->limit(20)
            ->get();
        $totalKalkulasi = (clone $riwayatQuery)->count();
        $totalLiter = (float) ((clone $riwayatQuery)->sum('hasil_liter'));

        return view('admin.laporan.index', [
            'filters' => $filters,
            'products' => KatalogProduk::query()->orderBy('nama_produk')->get(['id_produk', 'nama_produk']),
            'requests' => $requests,
            'statusCounts' => $statusCounts,
            'totalRequest' => $totalRequest,
            'riwayatKalkulasi' => $riwayatKalkulasi,
            'totalKalkulasi' => $totalKalkulasi,
            'totalLiter' => $totalLiter,
        ]);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filters = $this->resolveFilters($request);

        $rows = $this->buildTintingQuery($filters)
            ->with(['pelanggan', 'detail.warna.produk'])
            ->latest('tanggal_request')
            ->latest('created_at')
            ->get();

        $fileName = 'laporan-request-tinting-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($rows): void {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }

            fputcsv($handle, [
                'Tanggal',
                'Pelanggan',
                'No HP',
                'Status',
                'Produk / Warna',
                'Jumlah Kaleng',
            ]);

            foreach ($rows as $request) {
                $products = $request->detail
                    ->map(fn ($detail) => ($detail->warna->produk->nama_produk ?? '-') . ' - ' . ($detail->warna->nama_warna ?? '-'))
                    ->implode(' | ');
                $cans = $request->detail
                    ->map(fn ($detail) => (string) $detail->jumlah_kaleng)
                    ->implode(' | ');

                fputcsv($handle, [
                    optional($request->tanggal_request)->format('Y-m-d') ?? '-',
                    $request->pelanggan->nama_pelanggan ?? '-',
                    $request->pelanggan->no_hp ?? '-',
                    $request->status,
                    $products,
                    $cans,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function resolveFilters(Request $request): array
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:pending,diproses,selesai,dibatalkan'],
            'id_produk' => ['nullable', 'exists:katalog_produk,id_produk'],
        ]);

        return [
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'status' => $validated['status'] ?? null,
            'id_produk' => $validated['id_produk'] ?? null,
        ];
    }

    private function buildTintingQuery(array $filters): Builder
    {
        return RequestTinting::query()
            ->when($filters['start_date'], function (Builder $query, string $startDate): void {
                $query->whereDate('tanggal_request', '>=', $startDate);
            })
            ->when($filters['end_date'], function (Builder $query, string $endDate): void {
                $query->whereDate('tanggal_request', '<=', $endDate);
            })
            ->when($filters['status'], function (Builder $query, string $status): void {
                $query->where('status', $status);
            })
            ->when($filters['id_produk'], function (Builder $query, string $idProduk): void {
                $query->whereHas('detail.warna', function (Builder $warnaQuery) use ($idProduk): void {
                    $warnaQuery->where('id_produk', $idProduk);
                });
            });
    }

    private function buildRiwayatQuery(array $filters): Builder
    {
        return RiwayatKalkulasi::query()
            ->when($filters['start_date'], function (Builder $query, string $startDate): void {
                $query->whereDate('tanggal_kalkulasi', '>=', $startDate);
            })
            ->when($filters['end_date'], function (Builder $query, string $endDate): void {
                $query->whereDate('tanggal_kalkulasi', '<=', $endDate);
            })
            ->when($filters['id_produk'], function (Builder $query, string $idProduk): void {
                $query->where('id_produk', $idProduk);
            });
    }
}

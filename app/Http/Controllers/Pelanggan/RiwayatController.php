<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function kalkulasi(): View
    {
        $pelanggan = Auth::user()->pelanggan;

        $riwayat = $pelanggan
            ? $pelanggan->riwayatKalkulasi()
                ->with('produk')
                ->orderByDesc('tanggal_kalkulasi')
                ->orderByDesc('created_at')
                ->paginate(10)
            : collect();

        return view('pelanggan.riwayat-kalkulasi', [
            'riwayat' => $riwayat,
        ]);
    }

    public function tinting(): View
    {
        $pelanggan = Auth::user()->pelanggan;

        $requests = $pelanggan
            ? $pelanggan->requestTinting()
                ->with(['detail.warna.produk'])
                ->orderByDesc('tanggal_request')
                ->orderByDesc('created_at')
                ->paginate(10)
            : collect();

        return view('pelanggan.riwayat-tinting', [
            'requests' => $requests,
        ]);
    }
}

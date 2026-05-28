<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        $totalKalkulasi = $pelanggan ? $pelanggan->riwayatKalkulasi()->count() : 0;
        $totalTinting = $pelanggan ? $pelanggan->requestTinting()->count() : 0;
        $lastTinting = $pelanggan
            ? $pelanggan->requestTinting()->with('detail.warna')->latest('tanggal_request')->first()
            : null;
        $recentCalcs = $pelanggan
            ? $pelanggan->riwayatKalkulasi()->with('produk')->latest('tanggal_kalkulasi')->take(5)->get()
            : collect();

        return view('pelanggan.dashboard', [
            'user' => $user,
            'pelanggan' => $pelanggan,
            'totalKalkulasi' => $totalKalkulasi,
            'totalTinting' => $totalTinting,
            'lastTinting' => $lastTinting,
            'recentCalcs' => $recentCalcs,
        ]);
    }
}

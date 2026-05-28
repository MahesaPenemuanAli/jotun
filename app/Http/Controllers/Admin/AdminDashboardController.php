<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KatalogProduk;
use App\Models\Pelanggan;
use App\Models\RequestTinting;
use App\Models\Warna;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        $totalProduk = KatalogProduk::count();
        $totalWarna = Warna::count();
        $totalPelanggan = Pelanggan::count();
        $requestPending = RequestTinting::where('status', 'pending')->count();

        $latestRequests = RequestTinting::with(['pelanggan', 'detail.warna.produk'])
            ->latest('tanggal_request')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'admin' => $admin,
            'totalProduk' => $totalProduk,
            'totalWarna' => $totalWarna,
            'totalPelanggan' => $totalPelanggan,
            'requestPending' => $requestPending,
            'latestRequests' => $latestRequests,
        ]);
    }
}

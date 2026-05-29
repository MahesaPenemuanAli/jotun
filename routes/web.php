<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminMaintenanceController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\Admin\AdminProfilTokoController;
use App\Http\Controllers\Admin\AdminTintingController;
use App\Http\Controllers\Admin\AdminWarnaController;
use App\Http\Controllers\Pelanggan\AuthController;
use App\Http\Controllers\Pelanggan\DashboardController;
use App\Http\Controllers\Pelanggan\ProfilController;
use App\Http\Controllers\Pelanggan\RiwayatController;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\TintingRequestController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───────────────────────────────────────────────

Route::view("/", "welcome")->name("home");

Route::get("/katalog", [PublicCatalogController::class, "index"])->name("catalog.index");
Route::get("/katalog/{idProduk}", [PublicCatalogController::class, "show"])->name("catalog.show");

Route::get("/kalkulator", [App\Http\Controllers\PaintCalculatorController::class, 'create'])->name("calculator.create");
Route::post("/kalkulator", [App\Http\Controllers\PaintCalculatorController::class, 'store'])->name("calculator.store");

Route::get("/request-tinting", [TintingRequestController::class, "create"])->name("tinting.create");
Route::post("/request-tinting", [TintingRequestController::class, "store"])->name("tinting.store");

// ─── Pelanggan Auth Routes ──────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/akun/login', [AuthController::class, 'showLogin'])->name('pelanggan.login');
    Route::post('/akun/login', [AuthController::class, 'login'])->name('pelanggan.login.submit');
    Route::get('/akun/register', [AuthController::class, 'showRegister'])->name('pelanggan.register');
    Route::post('/akun/register', [AuthController::class, 'register'])->name('pelanggan.register.submit');
});

Route::post('/akun/logout', [AuthController::class, 'logout'])->name('pelanggan.logout')->middleware('auth');

// ─── Pelanggan Protected Routes ─────────────────────────────────

Route::prefix('akun')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('pelanggan.dashboard');
    Route::get('/profil', [ProfilController::class, 'show'])->name('pelanggan.profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('pelanggan.profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('pelanggan.profil.update');
    Route::get('/riwayat-kalkulasi', [RiwayatController::class, 'kalkulasi'])->name('pelanggan.riwayat.kalkulasi');
    Route::get('/riwayat-tinting', [RiwayatController::class, 'tinting'])->name('pelanggan.riwayat.tinting');
});

// ─── Admin Auth Routes ──────────────────────────────────────────

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// ─── Admin Protected Routes ─────────────────────────────────────

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('profil-toko', [AdminProfilTokoController::class, 'edit'])->name('admin.profil-toko.edit');
    Route::put('profil-toko', [AdminProfilTokoController::class, 'update'])->name('admin.profil-toko.update');

    Route::get('produk', [AdminProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('produk/create', [AdminProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('produk/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('produk/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');

    Route::get('warna', [AdminWarnaController::class, 'index'])->name('admin.warna.index');
    Route::get('warna/create', [AdminWarnaController::class, 'create'])->name('admin.warna.create');
    Route::post('warna', [AdminWarnaController::class, 'store'])->name('admin.warna.store');
    Route::get('warna/{id}/edit', [AdminWarnaController::class, 'edit'])->name('admin.warna.edit');
    Route::put('warna/{id}', [AdminWarnaController::class, 'update'])->name('admin.warna.update');
    Route::delete('warna/{id}', [AdminWarnaController::class, 'destroy'])->name('admin.warna.destroy');

    Route::get('tinting', [AdminTintingController::class, 'index'])->name('admin.tinting.index');
    Route::get('tinting/{id}', [AdminTintingController::class, 'show'])->name('admin.tinting.show');
    Route::patch('tinting/{id}/status', [AdminTintingController::class, 'updateStatus'])->name('admin.tinting.updateStatus');

    Route::get('laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/export-csv', [AdminLaporanController::class, 'exportCsv'])->name('admin.laporan.exportCsv');

    // ─── Maintenance (secured) ──────────────────────────────────
    Route::get('maintenance', [AdminMaintenanceController::class, 'index'])->name('admin.maintenance');
    Route::post('maintenance/migrate', [AdminMaintenanceController::class, 'runMigrate'])->name('admin.maintenance.migrate');
    Route::post('maintenance/seed', [AdminMaintenanceController::class, 'runSeed'])->name('admin.maintenance.seed');
});

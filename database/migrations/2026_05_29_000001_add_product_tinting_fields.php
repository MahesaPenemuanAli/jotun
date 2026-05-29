<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('katalog_produk', function (Blueprint $table) {
            $table->boolean('is_tintable')->default(false)->after('daya_sebar');
            $table->string('status_produk', 20)->default('aktif')->after('is_tintable');
            $table->string('tipe_produk', 50)->nullable()->after('status_produk');
        });

        // Unique constraint: one product name per admin
        Schema::table('katalog_produk', function (Blueprint $table) {
            $table->unique(['id_admin', 'nama_produk'], 'katalog_produk_admin_nama_unique');
        });

        // Unique constraint: one color code per product
        Schema::table('warna', function (Blueprint $table) {
            $table->unique(['id_produk', 'kode_warna'], 'warna_produk_kode_unique');
        });
    }

    public function down(): void
    {
        Schema::table('warna', function (Blueprint $table) {
            $table->dropUnique('warna_produk_kode_unique');
        });

        Schema::table('katalog_produk', function (Blueprint $table) {
            $table->dropUnique('katalog_produk_admin_nama_unique');
        });

        Schema::table('katalog_produk', function (Blueprint $table) {
            $table->dropColumn(['is_tintable', 'status_produk', 'tipe_produk']);
        });
    }
};

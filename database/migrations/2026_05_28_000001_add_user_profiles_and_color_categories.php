<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id_pelanggan')
                  ->constrained('users')->nullOnDelete();
        });

        Schema::table('riwayat_kalkulasi', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_lapisan')->default(2)->after('tinggi_dinding');
            $table->unsignedInteger('jumlah_kaleng')->default(1)->after('hasil_liter');
        });

        Schema::table('warna', function (Blueprint $table) {
            $table->string('kategori_warna', 50)->nullable()->after('hex_color')->index();
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('riwayat_kalkulasi', function (Blueprint $table) {
            $table->dropColumn(['jumlah_lapisan', 'jumlah_kaleng']);
        });

        Schema::table('warna', function (Blueprint $table) {
            $table->dropColumn('kategori_warna');
        });
    }
};

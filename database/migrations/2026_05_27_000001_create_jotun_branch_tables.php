<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id_admin')->primary();
            $table->string('nama_admin');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp', 30)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('profil_toko', function (Blueprint $table) {
            $table->uuid('id_toko')->primary();
            $table->uuid('id_admin');
            $table->string('nama_toko');
            $table->string('alamat');
            $table->string('kontak', 30)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('admins')->cascadeOnDelete();
        });

        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid('id_laporan')->primary();
            $table->uuid('id_admin');
            $table->date('tanggal_laporan');
            $table->string('periode_laporan');
            $table->text('isi_laporan');
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('admins')->cascadeOnDelete();
        });

        Schema::create('pelanggan', function (Blueprint $table) {
            $table->uuid('id_pelanggan')->primary();
            $table->string('nama_pelanggan');
            $table->string('no_hp', 30)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('katalog_produk', function (Blueprint $table) {
            $table->uuid('id_produk')->primary();
            $table->uuid('id_admin');
            $table->string('nama_produk');
            $table->string('kategori')->index();
            $table->unsignedBigInteger('harga')->default(0);
            $table->decimal('daya_sebar', 6, 2)->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('admins')->cascadeOnDelete();
        });

        Schema::create('warna', function (Blueprint $table) {
            $table->uuid('id_warna')->primary();
            $table->uuid('id_produk');
            $table->string('kode_warna')->nullable()->index();
            $table->string('nama_warna');
            $table->string('hex_color', 20)->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('katalog_produk')->cascadeOnDelete();
        });

        Schema::create('riwayat_kalkulasi', function (Blueprint $table) {
            $table->uuid('id_kalkulasi')->primary();
            $table->uuid('id_pelanggan');
            $table->uuid('id_produk');
            $table->date('tanggal_kalkulasi');
            $table->decimal('panjang_dinding', 8, 2);
            $table->decimal('tinggi_dinding', 8, 2);
            $table->decimal('hasil_liter', 8, 2);
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('katalog_produk')->cascadeOnDelete();
        });

        Schema::create('request_tinting', function (Blueprint $table) {
            $table->uuid('id_request')->primary();
            $table->uuid('id_pelanggan');
            $table->uuid('id_admin')->nullable();
            $table->date('tanggal_request');
            $table->string('status')->default('pending')->index();
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->cascadeOnDelete();
            $table->foreign('id_admin')->references('id_admin')->on('admins')->nullOnDelete();
        });

        Schema::create('detail_request_tinting', function (Blueprint $table) {
            $table->uuid('id_detail')->primary();
            $table->uuid('id_request');
            $table->uuid('id_warna');
            $table->unsignedInteger('jumlah_kaleng')->default(1);
            $table->timestamps();

            $table->foreign('id_request')->references('id_request')->on('request_tinting')->cascadeOnDelete();
            $table->foreign('id_warna')->references('id_warna')->on('warna')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_request_tinting');
        Schema::dropIfExists('request_tinting');
        Schema::dropIfExists('riwayat_kalkulasi');
        Schema::dropIfExists('warna');
        Schema::dropIfExists('katalog_produk');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('profil_toko');
        Schema::dropIfExists('admins');
    }
};

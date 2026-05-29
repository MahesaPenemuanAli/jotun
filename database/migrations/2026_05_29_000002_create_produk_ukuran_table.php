<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_ukuran', function (Blueprint $table) {
            $table->uuid('id_ukuran')->primary();
            $table->uuid('id_produk');
            $table->decimal('ukuran_liter', 5, 1);
            $table->unsignedBigInteger('harga')->nullable();
            $table->unsignedInteger('stok')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->timestamps();

            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('katalog_produk')
                  ->cascadeOnDelete();

            $table->unique(['id_produk', 'ukuran_liter'], 'produk_ukuran_produk_liter_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_ukuran');
    }
};

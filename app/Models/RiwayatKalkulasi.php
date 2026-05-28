<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKalkulasi extends Model
{
    use HasUuids;

    protected $table = 'riwayat_kalkulasi';

    protected $primaryKey = 'id_kalkulasi';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_kalkulasi',
        'id_pelanggan',
        'id_produk',
        'tanggal_kalkulasi',
        'panjang_dinding',
        'tinggi_dinding',
        'jumlah_lapisan',
        'hasil_liter',
        'jumlah_kaleng',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kalkulasi' => 'date',
            'panjang_dinding' => 'decimal:2',
            'tinggi_dinding' => 'decimal:2',
            'hasil_liter' => 'decimal:2',
            'jumlah_lapisan' => 'integer',
            'jumlah_kaleng' => 'integer',
        ];
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(KatalogProduk::class, 'id_produk', 'id_produk');
    }
}

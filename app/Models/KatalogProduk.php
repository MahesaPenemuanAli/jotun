<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KatalogProduk extends Model
{
    use HasUuids;

    protected $table = 'katalog_produk';

    protected $primaryKey = 'id_produk';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_produk',
        'id_admin',
        'nama_produk',
        'kategori',
        'harga',
        'daya_sebar',
        'gambar',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'daya_sebar' => 'decimal:2',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function warna(): HasMany
    {
        return $this->hasMany(Warna::class, 'id_produk', 'id_produk');
    }

    public function riwayatKalkulasi(): HasMany
    {
        return $this->hasMany(RiwayatKalkulasi::class, 'id_produk', 'id_produk');
    }
}

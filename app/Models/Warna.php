<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warna extends Model
{
    use HasUuids;

    protected $table = 'warna';

    protected $primaryKey = 'id_warna';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_warna',
        'id_produk',
        'kode_warna',
        'nama_warna',
        'hex_color',
        'kategori_warna',
        'gambar',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(KatalogProduk::class, 'id_produk', 'id_produk');
    }

    public function detailRequestTinting(): HasMany
    {
        return $this->hasMany(DetailRequestTinting::class, 'id_warna', 'id_warna');
    }
}

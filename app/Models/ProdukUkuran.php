<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukUkuran extends Model
{
    use HasUuids;

    protected $table = 'produk_ukuran';

    protected $primaryKey = 'id_ukuran';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_ukuran',
        'id_produk',
        'ukuran_liter',
        'harga',
        'stok',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'ukuran_liter' => 'decimal:1',
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(KatalogProduk::class, 'id_produk', 'id_produk');
    }
}

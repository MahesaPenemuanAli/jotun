<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'is_tintable',
        'status_produk',
        'tipe_produk',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'daya_sebar' => 'decimal:2',
            'is_tintable' => 'boolean',
        ];
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status_produk', 'aktif');
    }

    public function scopeTintable(Builder $query): Builder
    {
        return $query->where('is_tintable', true);
    }

    // ─── Relationships ───────────────────────────────────────

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function warna(): HasMany
    {
        return $this->hasMany(Warna::class, 'id_produk', 'id_produk');
    }

    public function ukuran(): HasMany
    {
        return $this->hasMany(ProdukUkuran::class, 'id_produk', 'id_produk');
    }

    public function ukuranAktif(): HasMany
    {
        return $this->ukuran()->where('status', 'aktif')->orderBy('ukuran_liter');
    }

    public function riwayatKalkulasi(): HasMany
    {
        return $this->hasMany(RiwayatKalkulasi::class, 'id_produk', 'id_produk');
    }
}

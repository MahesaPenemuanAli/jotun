<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasUuids;

    protected $table = 'pelanggan';

    protected $primaryKey = 'id_pelanggan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_pelanggan',
        'user_id',
        'nama_pelanggan',
        'no_hp',
        'email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requestTinting(): HasMany
    {
        return $this->hasMany(RequestTinting::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function riwayatKalkulasi(): HasMany
    {
        return $this->hasMany(RiwayatKalkulasi::class, 'id_pelanggan', 'id_pelanggan');
    }
}

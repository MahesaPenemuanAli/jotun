<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestTinting extends Model
{
    use HasUuids;

    protected $table = 'request_tinting';

    protected $primaryKey = 'id_request';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_request',
        'id_pelanggan',
        'id_admin',
        'tanggal_request',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_request' => 'date',
        ];
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailRequestTinting::class, 'id_request', 'id_request');
    }
}

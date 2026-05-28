<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailRequestTinting extends Model
{
    use HasUuids;

    protected $table = 'detail_request_tinting';

    protected $primaryKey = 'id_detail';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_detail',
        'id_request',
        'id_warna',
        'jumlah_kaleng',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_kaleng' => 'integer',
        ];
    }

    public function requestTinting(): BelongsTo
    {
        return $this->belongsTo(RequestTinting::class, 'id_request', 'id_request');
    }

    public function warna(): BelongsTo
    {
        return $this->belongsTo(Warna::class, 'id_warna', 'id_warna');
    }
}

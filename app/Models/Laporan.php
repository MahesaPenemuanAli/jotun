<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasUuids;

    protected $table = 'laporan';

    protected $primaryKey = 'id_laporan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_laporan',
        'id_admin',
        'tanggal_laporan',
        'periode_laporan',
        'isi_laporan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_laporan' => 'date',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}

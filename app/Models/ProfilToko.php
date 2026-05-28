<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilToko extends Model
{
    use HasUuids;

    protected $table = 'profil_toko';

    protected $primaryKey = 'id_toko';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_toko',
        'id_admin',
        'nama_toko',
        'alamat',
        'kontak',
        'deskripsi',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}

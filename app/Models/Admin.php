<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasUuids, Notifiable;

    protected $table = 'admins';

    protected $primaryKey = 'id_admin';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_admin',
        'nama_admin',
        'email',
        'password',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function profilToko(): HasOne
    {
        return $this->hasOne(ProfilToko::class, 'id_admin', 'id_admin');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_admin', 'id_admin');
    }

    public function produk(): HasMany
    {
        return $this->hasMany(KatalogProduk::class, 'id_admin', 'id_admin');
    }

    public function requestTinting(): HasMany
    {
        return $this->hasMany(RequestTinting::class, 'id_admin', 'id_admin');
    }
}

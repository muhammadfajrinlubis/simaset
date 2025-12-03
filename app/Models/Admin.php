<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';        // Nama tabel
    protected $primaryKey = 'id';      // Primary key

    protected $fillable = [
        'nama',
        'email',
        'passwordHash',
        'status_aktif'
    ];

    public function getAuthPassword()
    {
        return $this->passwordHash;
    }
    public function barang()
    {
        return $this->hasMany(Barang::class, 'admin_id');
    }
}

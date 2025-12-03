<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Nama tabel (opsional karena Laravel otomatis pakai 'barang')
    protected $table = 'barang';

    // Kolom yang boleh diisi
    protected $fillable = [
        'namaBarang',
        'tahun',
        'jenisBarang',
        'nomorNUP',
        'kondisi',
        'lokasi',
        'latitude',
        'longitude',
        'fotoBarang',
        'admin_id',
    ];

    // Casting agar tahun menjadi integer otomatis
    protected $casts = [
        'tahun' => 'integer',
    ];

    // Jika nanti kamu tambahkan admin_id → ini relasinya
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

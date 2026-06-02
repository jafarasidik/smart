<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstansiXJabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'nama_jabatan',
    ];

    protected $table = 'instansi_x_jabatans';

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_jabatan_instansi');
    }
}

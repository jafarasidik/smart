<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'instansi',
        'email',
        'id_jabatan_instansi',
    ];

    protected $table = 'pesertas';

    public function rapat()
    {
        return $this->belongsToMany(Rapat::class, 'kehadirans', 'id_peserta', 'id_rapat')
                    ->withPivot('status', 'tandatangan')
                    ->withTimestamps();
    }

    public function jxi()
    {
        return $this->belongsTo(InstansiXJabatan::class, 'id_jabatan_instansi');
    }

    public function rapatPeserta()
    {
        return $this->belongsToMany(
            Rapat::class,
            'rapat_pesertas',
            'id_peserta',
            'id_rapat'
        );
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_peserta');
    }
}

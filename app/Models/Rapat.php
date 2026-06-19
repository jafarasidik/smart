<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'id_ruangan',
        'id_user',
    ];

    protected $table = 'rapats';

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function peserta()
    {
        // Parameter: ModelTujuan, NamaTabelPivot, FK_ModelIni, FK_ModelTujuan
        return $this->belongsToMany(Peserta::class, 'rapat_pesertas', 'id_rapat', 'id_peserta')
                    ->withPivot('uuid') // Kunci agar kolom 'uuid' di pivot bisa diakses
                    ->withTimestamps(); // Tambahkan ini jika tabel pivot Anda punya created_at & updated_at
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'id_rapat');
    }

    public function notulensi()
    {
        return $this->hasMany(Notulensi::class, 'id_rapat');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function getCountdownAttribute()
    {
        $hari = Carbon::today()->diffInDays($this->tanggal->startOfDay(), false);

        if ($hari == 0) return 'Hari ini';
        if ($hari == 1) return 'Besok';
        if ($hari > 1) return $hari . ' hari lagi';

        return 'Sudah lewat';
    }

    public function pesertaKehadiran()
    {
        return $this->belongsToMany(
            Peserta::class,
            'kehadirans',
            'id_rapat',
            'id_peserta'
        )->withPivot('status', 'tandatangan');
    }
}

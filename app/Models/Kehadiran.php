<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rapat',
        'id_peserta',
        'status',
        'tandatangan',
    ];

    protected $table = 'kehadirans';
}

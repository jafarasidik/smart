<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rapat',
        'isi_notulensi',
        'file',
        'publish',
        'sampai',
    ];

    protected $table = 'notulensis';

    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }
}

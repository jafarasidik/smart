<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function index(){
        $now = Carbon::today();
        $rapat = Rapat::whereDate('tanggal', '>=', $now)
            ->where('status', true)
            ->withCount('peserta')
            ->get();
        
        $notulensi = Notulensi::where('publish', true)
            ->whereDate('sampai', '>=', $now)
            ->get();
        foreach ($notulensi as $n) {
            $n->isi_notulensi = Str::words($n->isi_notulensi, 20, '...');
        }
        return view('index', compact('rapat', 'notulensi'));
    }

    public function login(){
        return view('login');
    }
}

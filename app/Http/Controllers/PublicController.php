<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return view('index', compact('rapat', 'notulensi'));
    }
}

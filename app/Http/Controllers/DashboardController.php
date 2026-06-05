<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Peserta;
use App\Models\Rapat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tr = Rapat::where('status', true)->count(); //total rapat
        $tp = Peserta::count(); //total peserta
        $totalKehadiran = Kehadiran::count();
        $totalHadir = Kehadiran::where('status', true)->count();

        $rh = $totalKehadiran > 0
            ? round(($totalHadir / $totalKehadiran) * 100, 2)
            : 0;
        $ua = User::count(); //total user admin
        $now = Carbon::now(); //get tanggal sekarang
        $rapat_mendatang = Rapat::whereDate('tanggal', '>=', now())
            ->where('status', true)
            ->withCount('peserta')
            ->get();
        return view('main.dashboard', compact('tr', 'tp', 'rh', 'ua','rapat_mendatang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function chartKehadiran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);
        
        $validator->after(function ($validator) use ($request) {
        
            if (
                $request->tanggal_awal &&
                $request->tanggal_akhir &&
                $request->tanggal_awal > $request->tanggal_akhir
            ) {
                $validator->errors()->add(
                    'tanggal_awal',
                    'Tanggal awal tidak boleh lebih besar dari tanggal akhir.'
                );
        
                $validator->errors()->add(
                    'tanggal_akhir',
                    'Tanggal akhir tidak boleh lebih kecil dari tanggal awal.'
                );
            }
        });
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

        $data = Kehadiran::join('rapats', 'kehadirans.id_rapat', '=', 'rapats.id')
            ->selectRaw("
                YEAR(rapats.tanggal) as tahun,
                MONTH(rapats.tanggal) as bulan,
                COUNT(*) as total,
                SUM(CASE WHEN kehadirans.status = 1 THEN 1 ELSE 0 END) as hadir
            ")
            ->whereBetween('rapats.tanggal', [
                $tanggalAwal,
                $tanggalAkhir
            ])
            ->groupBy(
                DB::raw('YEAR(rapats.tanggal)'),
                DB::raw('MONTH(rapats.tanggal)')
            )
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $months = [];

        $current = $tanggalAwal->copy()->startOfMonth();

        while ($current <= $tanggalAkhir) {

            $key = $current->format('Y-m');

            $months[$key] = [
                'label' => $current->translatedFormat('M Y'),
                'value' => 0
            ];

            $current->addMonth();
        }

        foreach ($data as $item) {

            $key = sprintf(
                '%04d-%02d',
                $item->tahun,
                $item->bulan
            );
    
            if (isset($months[$key])) {
    
                $months[$key]['value'] =
                    $item->total > 0
                    ? round(($item->hadir / $item->total) * 100, 2)
                    : 0;
            }
        }
    
        return response()->json([
            'categories' => array_column($months, 'label'),
            'series' => array_column($months, 'value')
        ]);
    }
    public function logout(Request $request)
    {
        // 1. Keluar dari sistem autentikasi Laravel
        Auth::logout();

        // 2. Hancurkan session user yang sedang aktif agar tidak bisa disalahgunakan
        $request->session()->invalidate();

        // 3. Regenerasi token CSRF baru untuk keamanan session berikutnya
        $request->session()->regenerateToken();

        // 4. Tampilkan notifikasi sukses menggunakan RealRashid SweetAlert
        toast('Anda telah berhasil keluar.', 'success')->position('top-end');

        // 5. Alihkan pengguna kembali ke halaman login atau beranda
        return redirect()->route('login');
    }
}

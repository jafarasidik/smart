<?php

namespace App\Providers;

use App\Models\Kehadiran;
use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Batasi agar tidak berjalan di console/terminal, tidak berjalan saat request AJAX, dan pastikan tabelnya ada
        if (!$this->app->runningInConsole() && !request()->ajax() && Schema::hasTable('rapats') && Schema::hasTable('kehadirans')) {
            
            $sekarang = Carbon::now();

            // 1. Ambil ID rapat yang statusnya masih 'Aktif' TAPI waktunya sudah hangus/lewat
            $rapatLewatIds = Rapat::where('status', 'Aktif')
                ->where(function($query) use ($sekarang) {
                    $query->where('tanggal', '<', $sekarang->toDateString())
                          ->orWhere(function($q) use ($sekarang) {
                              $q->where('tanggal', $sekarang->toDateString())
                                ->where('waktu_selesai', '<', $sekarang->toTimeString());
                          });
                })
                ->pluck('id')
                ->toArray();

            // Jika ada rapat yang waktunya sudah lewat, kita proses otomatisasi kehadirannya
            if (count($rapatLewatIds) > 0) {
                
                // Gunakan Database Transaction agar proses insert massal ini aman dan tidak korup jika terputus di tengah jalan
                DB::transaction(function () use ($rapatLewatIds) {
                    
                    // Ambil data rapat berserta peserta terdaftar (dari pivot) dan data kehadirannya
                    $rapats = Rapat::with(['peserta', 'kehadiran'])->whereIn('id', $rapatLewatIds)->get();

                    foreach ($rapats as $rapat) {
                        // Ambil daftar id_peserta yang SUDAH mengisi absensi (Hadir/Izin/Tidak Hadir) di rapat ini
                        $sudahAbsenIds = $rapat->kehadiran->pluck('id_peserta')->toArray();

                        // Looping semua peserta yang SEHARUSNYA hadir berdasarkan data tabel pivot rapat_pesertas
                        foreach ($rapat->peserta as $peserta) {
                            
                            // JIKA id_peserta ini TIDAK ADA di dalam daftar yang sudah absen, maka dia "Alpa/Mangkir"
                            if (!in_array($peserta->id, $sudahAbsenIds)) {
                                Kehadiran::create([
                                    'id_rapat'    => $rapat->id,
                                    'id_peserta'  => $peserta->id,
                                    'status'      => 'Tidak Hadir',
                                    'alasan'      => 'Sistem: Otomatis Tidak Hadir karena rapat telah selesai',
                                    'tandatangan' => null
                                ]);
                            }
                        }
                    }

                    // 2. SETELAH semua peserta yang absen dipetakan ke 'Tidak Hadir', 
                    // baru update status rapat-rapat tersebut di database menjadi 'Selesai'
                    Rapat::whereIn('id', $rapatLewatIds)->update(['status' => 'Selesai']);
                });
            }
        }
    }
}

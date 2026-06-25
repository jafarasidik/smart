<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mengecek apakah request datang dari AJAX/Fetch
        if ($request->ajax() || $request->wantsJson()) {
            $tanggalMulai = $request->tanggal_mulai;
            $tanggalSelesai = $request->tanggal_selesai;

            // Load data rapat beserta relasi ruangan, peserta terdaftar, dan data kehadiran
            $rapats = Rapat::with(['ruangan', 'peserta', 'kehadiran'])
                ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
                ->get();

            // Lakukan pemetaan (mapping) untuk mencari tahu siapa yang belum absen
            $dataTransformasi = $rapats->map(function ($rapat) {
                // Ambil semua peserta yang terdaftar di rapat_pesertas
                $semuaPeserta = $rapat->peserta; 
                
                // Ambil semua id_peserta yang sudah tercatat di tabel kehadirans
                $sudahAbsenIds = $rapat->kehadiran->pluck('id_peserta')->toArray();

                // Cari peserta terdaftar yang id-nya belum ada di tabel kehadirans
                $belumAbsenNama = $semuaPeserta->filter(function ($peserta) use ($sudahAbsenIds) {
                    return !in_array($peserta->id, $sudahAbsenIds);
                })->pluck('nama')->toArray(); // Output: ['Nama A', 'Nama B']

                // Masukkan atribut tambahan ke dalam objek JSON
                $rapat->peserta_count = $semuaPeserta->count();
                $rapat->belum_absen_nama = $belumAbsenNama;

                return $rapat;
            });

            return response()->json([
                'success' => true,
                'data' => $dataTransformasi
            ]);
        }

        // Tampilan awal halaman laporan
        return view('main.laporan'); 
    }

    public function exportPdf(Request $request)
    {
        // Ambil input range tanggal filter dari request ajax/URL parameter
        // Jika nama input di form Anda adalah 'tanggal_mulai', sesuaikan request-nya di sini
        $startDate = $request->tanggal_mulai;
        $endDate = $request->tanggal_selesai;

        // Ambil data rapat lengkap dengan relasi peserta (dari pivot) dan data kehadirans
        $laporanRapat = Rapat::with(['ruangan', 'peserta', 'kehadiran'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // Load view PDF dan kirimkan datanya
        $pdf = Pdf::loadView('laporan.export_pdf', compact('laporanRapat'))
                  ->setPaper('a4', 'landscape'); // Menggunakan Landscape karena kolomnya cukup banyak

        // Berikan nama file download secara dinamis
        $namaFile = 'Laporan_Agenda_Rapat_' . $startDate . '_sd_' . $endDate . '.pdf';

        // Tampilkan pratinjau di browser
        return $pdf->stream($namaFile);
    }
}

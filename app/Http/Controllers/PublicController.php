<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Notulensi;
use App\Models\Peserta;
use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
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

    public function login()
    {
        // Cek apakah user datang karena dicegat oleh middleware auth
        if (session()->has('auth_required')) {
            toast('Silakan login terlebih dahulu untuk mengakses halaman.', 'warning')->position('top-end');
        }

        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login'); // Sesuaikan dengan nama blade login kamu
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
        $maxAttempts = 3;

        // 1. Cek apakah statusnya sudah resmi terkunci
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            toast("Akses Terkunci! Silakan tunggu $seconds detik.", 'error')->position('top-end');
            return back()->with('is_locked', true)->onlyInput('email');
        }

        // 2. Proses Autentikasi
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);
            $nama = auth()->user()->nama;
            toast("Selamat datang kembali, $nama!", 'success')->position('top-end');
            return redirect()->intended(route('dashboard'));
        }

        // 3. JIKA GAGAL LOGIN (Perbaikan Logika Timer di Sini)
        
        // Naikkan hitungan kegagalan tanpa mengatur durasi kunci panjang dulu
        // Gunakan durasi kecil (misal 10 menit) hanya agar hitungan tidak hilang di tengah jalan
        RateLimiter::hit($throttleKey, 600); 
        
        $attemptsLeft = RateLimiter::remaining($throttleKey, $maxAttempts);

        // Jika sisa percobaan sudah habis (0), timpa kunci tersebut dengan durasi murni 60 detik!
        if ($attemptsLeft <= 0) {
            RateLimiter::clear($throttleKey); // reset kunci sementara
            RateLimiter::hit($throttleKey, 60); // set kunci mati total selama 60 detik murni
            
            toast("Akses Terkunci! Anda telah salah 3 kali. Silakan tunggu 60 detik.", 'error')->position('top-end');
            return back()->with('is_locked', true)->onlyInput('email');
        }

        // Jika masih ada sisa percobaan (salah ke-1 atau ke-2)
        toast()->warning('Login Gagal', "Email atau password salah. Sisa percobaan: $attemptsLeft kali lagi.");

        return back()->onlyInput('email');
    }

    public function prosesAbsensiHadir($uuid)
    {
        // 1. Cari data di tabel pivot berdasarkan UUID unik tersebut
        $pivotData = DB::table('rapat_pesertas')
            ->where('uuid', $uuid)
            ->first();

        // Jika UUID tidak ditemukan (tautan palsu / salah ketik)
        if (!$pivotData) {
            abort(404, 'Tautan absensi tidak valid atau kadaluwarsa.');
        }

        // 2. Ambil data Rapat untuk memastikan status rapat masih aktif
        $rapat = Rapat::where('id', $pivotData->id_rapat)->first();
        
        if ($rapat->status == 0) {
            return view('gagal', ['message' => 'Maaf, absensi gagal karena agenda rapat ini sudah tidak aktif / ditutup.']);
        }

        // --- TAMBAHAN LOGIKA VALIDASI WAKTU JADWAL RAPAT ---
        // Asumsi: format di database $rapat->tanggal adalah 'YYYY-MM-DD', $rapat->waktu_mulai dan $rapat->waktu_selesai adalah 'HH:MM:SS' atau 'HH:MM'
        
        // Gabungkan tanggal rapat dengan waktu mulai & waktu selesai menjadi objek Carbon penuh
        $tanggalHanya = substr($rapat->tanggal, 0, 10); 

        // Gabungkan kembali dengan aman
        $waktuMulaiRapat = Carbon::parse($tanggalHanya . ' ' . $rapat->waktu_mulai);
        $waktuSelesaiRapat = Carbon::parse($tanggalHanya . ' ' . $rapat->waktu_selesai);
        $waktuSekarang = Carbon::now();

        // Cek apakah waktu sekarang berada DI LUAR rentang waktu rapat
        if ($waktuSekarang->lt($waktuMulaiRapat)) {
            // Jika belum masuk jam rapat
            return view('gagal', [
                'message' => 'Maaf, absensi belum dibuka. Rapat dijadwalkan mulai pada tanggal '. $rapat->tanggal->translatedFormat('j F Y') . ' pukul ' . $waktuMulaiRapat->format('H:i') . ' WIB.'
            ]);
        }

        if ($waktuSekarang->gt($waktuSelesaiRapat)) {
            // Jika sudah melewati jam selesai rapat (seperti kasus pukul 19:02)
            return view('gagal', [
                'message' => 'Maaf, Anda terlambat. Sesi absensi untuk agenda rapat ini telah berakhir pada tanggal '. $rapat->tanggal->translatedFormat('j F Y') . ' pukul ' . $waktuSelesaiRapat->format('H:i') . ' WIB.'
            ]);
        }
        // --- END LOGIKA VALIDASI WAKTU ---


        // 3. Cek apakah peserta ini sudah mengisi kehadiran sebelumnya di tabel kehadiran
        $sudahAbsen = DB::table('kehadirans')
            ->where('id_rapat', $pivotData->id_rapat)
            ->where('id_peserta', $pivotData->id_peserta)
            ->exists();

        if ($sudahAbsen) {
            return view('sukses', ['message' => 'Anda sudah melakukan absensi sebelumnya pada rapat ini.']);
        }

        // 4. Jika lolos semua validasi, arahkan ke halaman form ttd / proses kehadiran
        $peserta = Peserta::where('id', $pivotData->id_peserta)->first();

        return view('index', [
            'rapat' => $rapat,
            'peserta' => $peserta,
            'uuid' => $uuid 
        ]);
    }

    public function prosesAbsensiSimpan(Request $request, $uuid)
    {
        // 1. Validasi awal dari tabel pivot untuk memastikan token UUID ini valid
        $pivotData = DB::table('rapat_pesertas')
            ->where('uuid', $uuid)
            ->first();

        if (!$pivotData) {
            abort(404, 'Data presensi tidak ditemukan atau token tidak valid.');
        }

        // 2. Cek apakah rapat masih aktif
        $rapat = DB::table('rapats')->where('id', $pivotData->id_rapat)->first();
        if ($rapat->status == 0) {
            toast('Absensi gagal karena agenda rapat ini sudah ditutup!', 'error')->position('top-end');
            return redirect()->back();
        }

        // 3. Cek apakah peserta ini sudah melakukan absen sebelumnya (mencegah double submit)
        $sudahAbsen = DB::table('kehadirans')
            ->where('id_rapat', $pivotData->id_rapat)
            ->where('id_peserta', $pivotData->id_peserta)
            ->exists();

        if ($sudahAbsen) {
            toast('Anda sudah melakukan pengisian presensi sebelumnya.', 'warning')->position('top-end');
            return redirect()->back();
        }

        // 4. Validasi input formulir sesuai status pilihan
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'alasan' => 'required_if:status,Izin,Tidak Hadir|nullable|string',
            'tanda_tangan' => 'required_if:status,Hadir|nullable|string', // String base64 dari canvas
        ]);

        try {
            $namaFileTtd = null;

            // 5. Proses Tanda Tangan Digital jika statusnya "hadir"
            if ($request->status === 'Hadir' && $request->filled('tanda_tangan')) {
                $image_parts = explode(";base64,", $request->tanda_tangan);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1]; // png
                $image_base64 = base64_decode($image_parts[1]);

                // Buat nama file unik untuk gambar tanda tangan
                $namaFileTtd = 'ttd_' . $pivotData->id_rapat . '_' . $pivotData->id_peserta . '_' . time() . '.' . $image_type;

                // Simpan file gambar ke dalam folder: storage/app/public/tanda_tangan/
                // Menyimpan file menggunakan custom disk Anda
                Storage::disk('public_ttd')->put($namaFileTtd, $image_base64);
                
                // Jika kolom DB Anda ingin mencatat path lengkapnya, gunakan ini:
                $namaFileTtd = 'public_ttd/' . $namaFileTtd;
            }

            // 6. Simpan data ke tabel kehadirans
            // (Sesuaikan nama kolom di bawah dengan struktur tabel kehadirans Anda)
            $kehadiran = Kehadiran::create([
                'id_rapat'     => $pivotData->id_rapat,
                'id_peserta'   => $pivotData->id_peserta,
                'status'       => $request->status,
                'alasan'       => $request->status === 'Hadir' ? null : $request->alasan,
                'tandatangan'  => $namaFileTtd,
            ]);

            // Menggunakan RealRashid SweetAlert jika Anda menggunakannya di Mazer
            toast('Presensi berhasil dikirim. Terima kasih!', 'success')->position('top-end');
            
            // Kembalikan ke halaman sukses atau view pemberitahuan bahwa absen sukses
            return view('sukses', [
                'message' => 'Terima kasih, data presensi Anda telah berhasil direkam sistem.'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}

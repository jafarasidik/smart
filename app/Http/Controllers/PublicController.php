<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
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

            toast('Selamat datang kembali!', 'success')->position('top-end');
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
        alert()->warning('Login Gagal', "Email atau password salah. Sisa percobaan: $attemptsLeft kali lagi.");

        return back()->onlyInput('email');
    }
}

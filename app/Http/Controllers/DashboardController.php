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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function settings(){
        $data = auth()->user();
        return view('main.settings', compact('data'));
    }

    public function updateProfile(Request $request){
        $user = User::findOrFail(auth()->user()->id);
        $request->validate([
            'nama'             => 'required|string|max:255',
            // Pastikan email unik, tapi abaikan (ignore) email milik user ini sendiri
            'email'            => 'required|string|email|max:255|unique:users,email,' . $user->id, 
            'password'         => 'nullable|string|min:8',
            // 'required_with:password' memastikan confirm_password wajib diisi JIKA password diisi
            'confirm_password' => 'nullable|required_with:password|same:password', 
            'foto_profile'     => 'nullable|mimes:jpg,jpeg,png|max:4096',
        ], [
            'nama.required'             => 'Nama admin wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'              => 'Password baru minimal harus 8 karakter.',
            'confirm_password.required_with' => 'Konfirmasi password wajib diisi jika Anda ingin mengubah password.',
            'confirm_password.same'     => 'Konfirmasi password tidak cocok dengan password baru.',
            'foto_profile.mimes'        => 'Format foto harus berupa JPG, JPEG, PNG.',
            'foto_profile.max'          => 'Ukuran file maksimal 4MB.',
        ]);

        $filePath = null;
        $fileLamaYangAkanDihapus = null;

        try {
            // 2. LOGIKA FILE: Proses upload dipindah ke LUAR transaksi database agar variabel $filePath terbaca di Catch
            if ($request->hasFile('foto_profile')) {
                $filePath = $request->file('foto_profile')->store('', 'public_foto'); 
                if ($user->foto != '7.jpg') {
                    $fileLamaYangAkanDihapus = $user->foto; 
                }
                
            }

            DB::transaction(function () use ($request, $user, $filePath) {
                // 3. Siapkan data yang pasti diubah
                // Perbaikan typo: $request->publsih diubah menjadi $request->publish
                // Konversi inputan publish menjadi boolean asli (true/false)
                $dataToUpdate = [
                    'nama'      => $request->nama, 
                    'email'     => $request->email,
                ];

                // Perbaikan: Menggunakan sintaks array [] bukan properti objek ->
                if ($filePath) {
                    $dataToUpdate['foto'] = $filePath;
                }

                if ($request->filled('password')) {
                    $dataToUpdate['password'] = Hash::make($request->password);
                }

                // 4. Jalankan perintah update ke database
                $user->update($dataToUpdate);
            });

            // 5. JIKA DB SUKSES: Hapus file lama yang digantikan dari storage
            if ($fileLamaYangAkanDihapus && Storage::disk('public_foto')->exists($fileLamaYangAkanDihapus)) {
                Storage::disk('public_foto')->delete($fileLamaYangAkanDihapus);
            }

            toast('Akun berhasil diperbarui.', 'success')->position('top-end');
            return redirect()->route('pengaturan');

        } catch (\Exception $e) {
            // 6. JIKA DB ERROR: Hapus file baru yang gagal masuk ke DB agar tidak jadi sampah
            if ($filePath && Storage::disk('public_foto')->exists($filePath)) {
                Storage::disk('public_foto')->delete($filePath);
            }

            alert()->error('Gagal Memperbarui', $e->getMessage());
            return back()->withInput();
        }
    }
}

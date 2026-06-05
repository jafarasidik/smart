<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::select('id','nama', 'email')->get();
        return view('main.data.admin', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.data.components.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Sisi Server
        // 'confirmed' akan otomatis mencari input bernama 'password_confirmation' atau 'confirm_password'
        $request->validate([
            'nama'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users,email', // ganti 'users' dengan nama tabel Anda jika berbeda
            'password'         => 'required|string|min:8',
            'confirm_password' => 'required|same:password', // Memastikan konfirmasi cocok dengan password
        ], [
            // Kustomisasi pesan error bahasa Indonesia
            'nama.required'             => 'Nama admin wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email ini sudah terdaftar di sistem.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal harus 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same'     => 'Konfirmasi password tidak cocok dengan password.',
        ]);
        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                
                // 3. Simpan ke tabel user
                User::create([
                    'nama'     => $request->nama, // Kiri: nama kolom di DB, Kanan: nama input di blade
                    'email'    => $request->email,
                    'password' => Hash::make($request->password), // WAJIB di-hash demi keamanan
                ]);
            });

            toast('Data admin berhasil ditambahkan!', 'success')->position('top-end');
            return redirect()->route('data.admin');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        if ($id == auth()->user()->id) {
            toast('Tidak dapat edit data sendiri! ubah di pengaturan.', 'error')->position('top-end');
            return redirect()->route('data.admin');
        }
        $data = User::findOrFail($id);
        return view('main.data.components.admin.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Data Sisi Server
        $request->validate([
            'nama'             => 'required|string|max:255',
            // Pastikan email unik, tapi abaikan (ignore) email milik user ini sendiri
            'email'            => 'required|string|email|max:255|unique:users,email,' . $id, 
            'password'         => 'nullable|string|min:8',
            // 'required_with:password' memastikan confirm_password wajib diisi JIKA password diisi
            'confirm_password' => 'nullable|required_with:password|same:password', 
        ], [
            'nama.required'             => 'Nama admin wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email ini sudah digunakan oleh akun lain.',
            'password.min'              => 'Password baru minimal harus 8 karakter.',
            'confirm_password.required_with' => 'Konfirmasi password wajib diisi jika Anda ingin mengubah password.',
            'confirm_password.same'     => 'Konfirmasi password tidak cocok dengan password baru.',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);

                // 2. Siapkan data yang pasti diubah (Nama dan Email)
                // Perbaikan: Ambil dari input request yang benar ($request->nama dan $request->email)
                $dataToUpdate = [
                    'nama'  => $request->nama, // Ubah ke 'nama' jika kolom DB Anda menggunakan bahasa Indonesia
                    'email' => $request->email,
                ];

                // 3. LOGIKA OPSIONAL: Hanya enkripsi dan update password JIKA diisi oleh user
                if ($request->filled('password')) {
                    $dataToUpdate['password'] = Hash::make($request->password);
                }

                // 4. Jalankan perintah update ke database
                $user->update($dataToUpdate);
            });

            toast('Data admin berhasil diperbarui.', 'success')->position('top-end');
            return redirect()->route('data.admin');

        } catch (\Exception $e) {
            alert()->error('Gagal Memperbarui', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            // hapus peserta
            $user->delete();
            toast('Data admin berhasil dihapus.', 'success')->position('top-end');
            return redirect()->route('data.admin');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal menghapus data admin: ' . $e->getMessage()
            );
        }
    }
}

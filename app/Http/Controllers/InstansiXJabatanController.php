<?php

namespace App\Http\Controllers;

use App\Models\InstansiXJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstansiXJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = InstansiXJabatan::get();
        return view('main.data.instansixjabatan', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instansi = InstansiXJabatan::select('nama_instansi')
            ->distinct()
            ->orderBy('nama_instansi')
            ->pluck('nama_instansi');

        $jabatan = InstansiXJabatan::select('nama_jabatan')
            ->distinct()
            ->orderBy('nama_jabatan')
            ->pluck('nama_jabatan');
        return view('main.data.components.instansijabatan.create', compact('instansi', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi'  => 'required|string|max:100',
            'jabatan'   => 'required|string|max:100',
        ]);

        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                
                // 3. Simpan ke tabel rapats
                $ixj = InstansiXJabatan::create([
                    'nama_instansi' => $request->instansi,
                    'nama_jabatan'  => $request->jabatan,
                ]);
            });

            return redirect()->route('data.ixj')->with('success', 'Instansi dan Jabatan berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InstansiXJabatan $instansiXJabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = InstansiXJabatan::findOrFail($id);
        $instansi = InstansiXJabatan::select('nama_instansi')
            ->distinct()
            ->orderBy('nama_instansi')
            ->pluck('nama_instansi');

        $jabatan = InstansiXJabatan::select('nama_jabatan')
            ->distinct()
            ->orderBy('nama_jabatan')
            ->pluck('nama_jabatan');
        return view('main.data.components.instansijabatan.edit', compact('data','instansi', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'instansi'  => 'required|string|max:100',
            'jabatan'   => 'required|string|max:100',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $ixj = InstansiXJabatan::findOrFail($id);
    
                // 1. Update data utama rapat
                $ixj->update([
                    'nama_instansi' => $request->instansi,
                    'nama_jabatan'  => $request->jabatan,
                ]);
            });
    
            return redirect()->route('data.ixj')->with('success', 'Instansi dan jabatan berhasil diperbarui!');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = InstansiXJabatan::findOrFail($id);

        try {
            // hapus peserta
            $data->delete();
            return redirect()->route('data.ixj')
                ->with('success', 'Instansi dan jabatan berhasil dihapus!');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal menghapus instansi dan jabatan: ' . $e->getMessage()
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\InstansiXJabatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Peserta::get();
        return view("main.data.peserta", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jxi = InstansiXJabatan::get();
        return view('main.data.components.peserta.create', compact('jxi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'              => 'required|string|max:255',
            'jabatanxinstansi'  => 'required|exists:instansi_x_jabatans,id',
            'whatsapp'          => 'required|numeric',
        ]);

        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                
                // 3. Simpan ke tabel rapats
                $rapat = Peserta::create([
                    'nama'                      => $request->nama,
                    'id_jabatan_instansi'       => $request->jabatanxinstansi,
                    'whatsapp'                  => $request->whatsapp,
                ]);
            });

            return redirect()->route('data.peserta')->with('success', 'Peserta berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peserta $peserta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Peserta::findOrFail($id);
        $jxi = InstansiXJabatan::get();

        return view('main.data.components.peserta.edit', compact('data', 'jxi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'jabatanxinstansi'  => 'required|exists:instansi_x_jabatans,id',
            'whatsapp'          => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $peserta = Peserta::findOrFail($id);
    
                // 1. Update data utama rapat
                $peserta->update([
                    'nama'                      => $request->nama,
                    'id_jabatan_instansi'       => $request->jabatanxinstansi,
                    'whatsapp'                  => $request->whatsapp,
                ]);
            });
    
            return redirect()->route('data.peserta')->with('success', 'Peserta berhasil diperbarui!');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);

        try {

            // hapus pivot rapat_pesertas
            $peserta->rapatPeserta()->detach();

            // hapus kehadiran
            $peserta->kehadiran()->delete();

            // hapus peserta
            $peserta->delete();
            return redirect()->route('data.peserta')
                ->with('success', 'Peserta berhasil dihapus!');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal menghapus peserta: ' . $e->getMessage()
            );
        }
    }
}

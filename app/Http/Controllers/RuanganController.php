<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ruangan::get();
        return view("main.data.ruangan", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.data.components.ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'          => 'required|string|max:255|unique:ruangans,nama',
            'lokasi'        => 'required|string|max:255|unique:ruangans,lokasi',
        ]);

        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                
                // 3. Simpan ke tabel rapats
                $ruangan = Ruangan::create([
                    'nama'                      => $request->nama,
                    'lokasi'                    => $request->lokasi,
                ]);
            });
            toast('Ruangan berhasil ditambahkan.', 'success')->position('top-end');
            return redirect()->route('data.ruangan');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruangan $ruangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Ruangan::findOrFail($id);

        return view('main.data.components.ruangan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage. 
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $ruangan = Ruangan::findOrFail($id);
    
                // 1. Update data utama rapat
                $ruangan->update([
                    'nama'          => $request->nama,
                    'lokasi'        => $request->lokasi,
                ]);
            });
            toast('Ruangan berhasil diperbarui.', 'success')->position('top-end');
            return redirect()->route('data.ruangan');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        try {

            // hapus ruangan
            $ruangan->delete();
            toast('Ruangan berhasil dihapus.', 'success')->position('top-end');
            return redirect()->route('data.ruangan');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal menghapus ruangan: ' . $e->getMessage()
            );
        }
    }
}

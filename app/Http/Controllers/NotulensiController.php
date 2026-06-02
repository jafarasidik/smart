<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NotulensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Notulensi::with('rapat')->get();
        return view('main.data.notulensi', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agenda = Rapat::get();
        return view('main.data.components.notulensi.create', compact('agenda'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'rapat'         => 'required|exists:rapats,id',
            'isi'           => 'required',
            'file_dokumen'  => 'nullable|mimes:pdf,docx|max:4096',
            'publish'       => 'required',
            'aktif_sampai'  => 'nullable|date'
        ], [
            'rapat.exists'         => 'Agenda tidak terdaftar',
            'file_dokumen.mimes'    => 'File yang diupload hanya PDF dan DOC',
            'file_dokumen.max'      => 'File yang diupload max 4MB',
        ]);

        // 1. Inisialisasi variabel file di luar try-catch
        $filePath = null;

        try {
            // 2. Upload file dilakukan SEBELUM transaksi database
            if ($request->hasFile('file_dokumen')) {
                // Parameter kedua adalah nama disk baru kita
                $filePath = $request->file('file_dokumen')->store('', 'public_direct'); 
            }

            // 3. Jalankan transaksi database
            DB::transaction(function () use ($request, $filePath) {
                Notulensi::create([
                    'id_rapat'      => $request->rapat,
                    'isi_notulensi' => $request->isi,
                    'file'          => $filePath,
                    'publish'       => $request->publish,
                    'sampai'        => $request->aktif_sampai
                ]);
            });

            return redirect()->route('data.notulensi')->with('success', 'Notulensi berhasil ditambahkan!');

        } catch (\Exception $e) {
            // 4. JIKA DATABASE ERROR: Hapus file yang terlanjur terupload agar tidak jadi file sampah
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notulensi $notulensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notulensi $notulensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notulensi $notulensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notulensi $notulensi)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotulensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Notulensi::with('rapat')->get();
        foreach ($data as $n) {
            $n->isi_notulensi = Str::words($n->isi_notulensi, 20, '...');
        }
        
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
            toast('Notulensi berhasil ditambahkan.', 'success')->position('top-end');
            return redirect()->route('data.notulensi');

        } catch (\Exception $e) {
            // 4. JIKA DATABASE ERROR: Hapus file yang terlanjur terupload agar tidak jadi file sampah
            if ($filePath && Storage::disk('public_direct')->exists($filePath)) {
                Storage::disk('public_direct')->delete($filePath);
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
    public function edit($id)
    {
        $data = Notulensi::findOrFail($id);
        $rapat = Rapat::orderBy('id', 'asc')->get();
        return view('main.data.components.notulensi.edit', compact('data', 'rapat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Data Sisi Server
        $request->validate([
            'rapat'         => 'required|exists:rapats,id',
            'isi'           => 'required',
            'file_dokumen'  => 'nullable|mimes:pdf,docx|max:4096',
            'publish'       => 'required',
            // PERBAIKAN LOGIKA: Wajib diisi jika nilai 'publish' adalah string 'true' atau bolean true
            'aktif_sampai'  => 'required_if:publish,true|nullable|date'
        ], [
            'rapat.exists'          => 'Agenda tidak terdaftar',
            'file_dokumen.mimes'    => 'File yang diupload hanya PDF dan DOC',
            'file_dokumen.max'      => 'File yang diupload max 4MB',
            'aktif_sampai.required_if' => 'Tanggal aktif sampai wajib diisi jika notulensi dipublikasikan.',
        ]);

        $notulensi = Notulensi::findOrFail($id);
        $filePath = null;
        $fileLamaYangAkanDihapus = null;

        try {
            // 2. LOGIKA FILE: Proses upload dipindah ke LUAR transaksi database agar variabel $filePath terbaca di Catch
            if ($request->hasFile('file_dokumen')) {
                $filePath = $request->file('file_dokumen')->store('', 'public_direct'); 
                
                // Catat nama file lama untuk dihapus nanti jika transaksi DB sukses
                $fileLamaYangAkanDihapus = $notulensi->file; 
            }

            DB::transaction(function () use ($request, $notulensi, $filePath) {
                // 3. Siapkan data yang pasti diubah
                // Perbaikan typo: $request->publsih diubah menjadi $request->publish
                // Konversi inputan publish menjadi boolean asli (true/false)
                $isPublished = filter_var($request->publish, FILTER_VALIDATE_BOOLEAN);
                $dataToUpdate = [
                    'id_rapat' => $request->rapat, 
                    'isi'      => $request->isi,
                    'publish'  => $isPublished,
                ];

                // Perbaikan: Menggunakan sintaks array [] bukan properti objek ->
                if ($filePath) {
                    $dataToUpdate['file'] = $filePath;
                }

                // Atur nilai 'sampai' (jika publish false, set null agar bersih di database)
                $dataToUpdate['sampai'] = $isPublished ? $request->aktif_sampai : null;

                // 4. Jalankan perintah update ke database
                $notulensi->update($dataToUpdate);
            });

            // 5. JIKA DB SUKSES: Hapus file lama yang digantikan dari storage
            if ($fileLamaYangAkanDihapus && Storage::disk('public_direct')->exists($fileLamaYangAkanDihapus)) {
                Storage::disk('public_direct')->delete($fileLamaYangAkanDihapus);
            }

            toast('Notulensi berhasil diperbarui.', 'success')->position('top-end');
            return redirect()->route('data.notulensi');

        } catch (\Exception $e) {
            // 6. JIKA DB ERROR: Hapus file baru yang gagal masuk ke DB agar tidak jadi sampah
            if ($filePath && Storage::disk('public_direct')->exists($filePath)) {
                Storage::disk('public_direct')->delete($filePath);
            }

            alert()->error('Gagal Memperbarui', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // 1. Pindahkan ke dalam try agar jika ID tidak ditemukan, langsung ditangkap oleh catch
            $notulensi = Notulensi::findOrFail($id);

            // 2. Hapus file fisik di storage jika ada
            if ($notulensi->file && Storage::disk('public_direct')->exists($notulensi->file)) {
                Storage::disk('public_direct')->delete($notulensi->file);
            }
            
            // 3. Hapus data dari database
            $notulensi->delete();

            toast('Notulensi berhasil dihapus.', 'success')->position('top-end');
            return redirect()->route('data.notulensi');

        } catch (\Exception $e) {
            // 4. Samakan notifikasi error menggunakan SweetAlert agar seragam dengan fungsi lainnya
            alert()->error('Gagal Menghapus', 'Gagal menghapus notulensi: ' . $e->getMessage());
            
            return back();
        }
    }
}

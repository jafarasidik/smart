<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Rapat;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Rapat::get();
        return view("main.data.agenda", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruangan = Ruangan::get();
        $peserta = Peserta::orderBy('nama', 'asc')->with('jxi')->get();
        return view('main.data.components.agenda.create', compact('ruangan', 'peserta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'status' => 'required|in:0,1',
            'ruangan' => 'required|exists:ruangans,id',
            'pesertas' => 'required|array|min:1', // Harus pilih minimal 1 peserta
        ], [
            'pesertas.required' => 'Silakan pilih minimal satu peserta rapat.'
        ]);
        if ($request->waktu_selesai <= $request->waktu_mulai) {
            return redirect()->back()
                ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai!')
                ->withInput();
        }
        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                
                // 3. Simpan ke tabel rapats
                $rapat = Rapat::create([
                    'nama'          => $request->nama,
                    'tanggal'       => $request->tanggal,
                    'waktu_mulai'   => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'status'        => $request->status,
                    'id_ruangan'    => $request->ruangan, // Sesuai name="ruangan" di form
                    'id_user'       => 1,        // ID Admin yang input
                ]);

                // 4. Simpan ke tabel pivot rapat_pesertas
                // attach() akan memasukkan array ID peserta ke tabel relasi
                $rapat->peserta()->attach($request->pesertas);
            });

            return redirect()->route('data.agenda')->with('success', 'Agenda rapat berhasil dibuat!');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data rapat beserta relasi pesertanya
        $data = Rapat::with(['peserta', 'kehadiran'])->findOrFail($id);
        $ruangan = Ruangan::all();
        $peserta = Peserta::orderBy('nama', 'asc')->get();

        return view('main.data.components.agenda.show', compact('data', 'ruangan', 'peserta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data rapat beserta relasi pesertanya
        $data = Rapat::with('peserta')->findOrFail($id);
        $ruangan = Ruangan::all();
        $peserta = Peserta::orderBy('nama', 'asc')->get();

        return view('main.data.components.agenda.edit', compact('data', 'ruangan', 'peserta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'status' => 'required|in:0,1',
            'ruangan' => 'required|exists:ruangans,id',
            'pesertas' => 'required|array|min:1',
        ],[
            'pesertas.required' => 'Silakan pilih minimal satu peserta rapat.'
        ]);
        if ($request->waktu_selesai <= $request->waktu_mulai) {
            return redirect()->back()
                ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai!')
                ->withInput();
        }
        try {
            DB::transaction(function () use ($request, $id) {
                $rapat = Rapat::findOrFail($id);
    
                // 1. Update data utama rapat
                $rapat->update([
                    'nama'          => $request->nama,
                    'tanggal'       => $request->tanggal,
                    'waktu_mulai'   => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'status'        => $request->status,
                    'id_ruangan'    => $request->ruangan,
                ]);
    
                // 2. Sinkronisasi tabel pivot rapat_pesertas
                // sync() akan:
                // - Menghapus peserta yang tidak ada di form update
                // - Menambah peserta baru yang baru dicentang
                // - Membiarkan peserta yang tetap dicentang
                $rapat->peserta()->sync($request->pesertas);
            });
    
            return redirect()->route('data.agenda')->with('success', 'Agenda rapat berhasil diperbarui!');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $rapat = Rapat::findOrFail($id);

        $sekarang = Carbon::now();
        $tanggal = Carbon::parse($rapat->tanggal)->toDateString();

        $mulai = Carbon::parse($tanggal . ' ' . $rapat->waktu_mulai);
        $selesai = Carbon::parse($tanggal . ' ' . $rapat->waktu_selesai);

        // cek apakah sekarang berada di antara mulai dan selesai
        if ($rapat->status && $sekarang->between($mulai, $selesai)) {
            return back()->with(
                'error',
                'Rapat sedang berlangsung dan tidak dapat dihapus!'
            );
        }

        try {
            $rapat->peserta()->detach();

            $rapat->kehadiran()->delete();

            $rapat->delete();
            return redirect()->route('data.agenda')
                ->with('success', 'Agenda rapat berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with(
                'error',
                'Gagal menghapus data: ' . $e->getMessage()
            );
        }
    }
}

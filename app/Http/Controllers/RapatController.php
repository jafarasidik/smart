<?php

namespace App\Http\Controllers;

use App\Mail\AgendaRapatMail;
use App\Models\Peserta;
use App\Models\Rapat;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'status' => 'required|in:Aktif,Tidak Aktif,Selesai',
            'ruangan' => 'required|exists:ruangans,id',
            'pesertas' => 'required|array|min:1', // Harus pilih minimal 1 peserta
        ], [
            'pesertas.required' => 'Silakan pilih minimal satu peserta rapat.'
        ]);
        if ($request->waktu_selesai <= $request->waktu_mulai) {
            toast('Waktu selesai harus lebih besar dari waktu mulai!', 'error')->position('top-end');
            return redirect()->back()
                ->withInput();
        }
        try {
            // 2. Gunakan Transaction untuk keamanan data
            DB::transaction(function () use ($request) {
                $admin = auth()->user()->id;
                // 3. Simpan ke tabel rapats
                $rapat = Rapat::create([
                    'nama'          => $request->nama,
                    'tanggal'       => $request->tanggal,
                    'waktu_mulai'   => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'status'        => $request->status,
                    'id_ruangan'    => $request->ruangan, // Sesuai name="ruangan" di form
                    'id_user'       => $admin,        // ID Admin yang input
                ]);

                // 4. Simpan ke tabel pivot rapat_pesertas
                // attach() akan memasukkan array ID peserta ke tabel relasi
                // Buat format array berpasangan untuk menyimpan kolom tambahan (uuid) ke pivot
                $pivotData = [];
                foreach ($request->pesertas as $pesertaId) {
                    $pivotData[$pesertaId] = [
                        'uuid' => (string) Str::uuid() // UUID unik yang berbeda untuk setiap peserta
                    ];
                }

                // attach() menerima array asosiatif: [id_peserta => ['uuid' => '...']]
                $rapat->peserta()->attach($pivotData);
            });
            toast('Agenda rapat berhasil dibuat.', 'success')->position('top-end');
            return redirect()->route('data.agenda');

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
        $data->waktu_mulai = Carbon::parse($data->waktu_mulai);
        $data->waktu_selesai = Carbon::parse($data->waktu_selesai);
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
            'status' => 'required|in:Aktif,Tidak Aktif,Selesai',
            'ruangan' => 'required|exists:ruangans,id',
            'pesertas' => 'required|array|min:1',
        ],[
            'pesertas.required' => 'Silakan pilih minimal satu peserta rapat.'
        ]);
        if ($request->waktu_selesai <= $request->waktu_mulai) {
            toast('Waktu selesai harus lebih besar dari waktu mulai!', 'error')->position('top-end');
            return redirect()->back()
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
                $pivotData = [];
                
                // Ambil data peserta yang SUDAH terdaftar sebelumnya beserta UUID lama mereka
                $currentPeserta = $rapat->peserta()->pluck('uuid', 'id_peserta')->toArray(); 
                // Catatan: Sesuaikan 'id_peserta' jika nama foreign key di pivot Anda berbeda (misal 'id_peserta')

                foreach ($request->pesertas as $pesertaId) {
                    if (isset($currentPeserta[$pesertaId])) {
                        // Jika peserta sudah ada sebelumnya, PERTAHANKAN UUID lamanya agar token email tidak berubah/rusak
                        $pivotData[$pesertaId] = [
                            'uuid' => $currentPeserta[$pesertaId]
                        ];
                    } else {
                        // Jika ini peserta baru yang baru ditambahkan, BUATKAN UUID baru
                        $pivotData[$pesertaId] = [
                            'uuid' => (string) Str::uuid()
                        ];
                    }
                }

                // GANTI attach() MENJADI sync()
                // sync() menerima array asosiatif: [id_peserta => ['uuid' => '...']]
                $rapat->peserta()->sync($pivotData);
            });
            toast('Agenda rapat berhasil diperbarui.', 'success')->position('top-end');
            return redirect()->route('data.agenda');
    
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
        $tanggalStr = $rapat->tanggal->format('Y-m-d');

        // Gabungkan tanggal rapat dengan jam selesai rapat
        $waktuSelesaiRapat = Carbon::parse($tanggalStr . ' ' . $rapat->waktu_selesai);

        // JIKA waktu sekarang BELUM MELEBIHI waktu selesai agenda, maka TIDAK BISA dihapus
        if ($sekarang->lessThanOrEqualTo($waktuSelesaiRapat) && $rapat->status == "Aktif") {
            toast('Agenda rapat belum selesai atau sedang berjalan, tidak dapat dihapus!', 'error')->position('top-end');
            return back();
        }

        // JIKA lolos pengecekan di atas (artinya sudah lewat), jalankan proses hapus
        try {
            DB::transaction(function () use ($rapat) {
                
                // 1. Hapus relasi Many-to-Many ke peserta
                $rapat->peserta()->detach();

                // 2. Hapus file tanda tangan jika ada
                foreach ($rapat->kehadiran as $hadir) {
                    if ($hadir->tandatangan) {
                        if (Storage::disk('public_direct')->exists($hadir->tandatangan)) {
                            Storage::disk('public_direct')->delete($hadir->tandatangan);
                        }
                    }
                }

                // 3. Hapus data absensi dan notulensi
                $rapat->kehadiran()->delete();
                $rapat->notulensi()->delete();

                // 4. Hapus data utama Rapat
                $rapat->delete();
            });

            toast('Agenda rapat berhasil dihapus.', 'success')->position('top-end');
            return redirect()->route('data.agenda');

        } catch (\Exception $e) {
            alert()->error('Gagal Menghapus Data', $e->getMessage());
            return back();
        }
    }

    public function getAgendaJson($id)
    {
        $agenda = Rapat::with('ruangan')->findOrFail($id);
        
        // Ambil peserta langsung dari query builder tabel pivot agar mendapat kolom UUID-nya
        $peserta = DB::table('rapat_pesertas')
            ->join('pesertas', 'rapat_pesertas.id_peserta', '=', 'pesertas.id')
            ->where('rapat_pesertas.id_rapat', $id)
            ->select('pesertas.id', 'pesertas.nama', 'pesertas.email', 'rapat_pesertas.uuid')
            ->get();

        return response()->json([
            'nama'          => $agenda->nama,
            // Pastikan $agenda->tanggal sudah di-cast sebagai 'date' atau 'datetime' di Model agar bisa pakai translatedFormat
            'tanggal'       => $agenda->tanggal->translatedFormat('j F Y'),
            'waktu_mulai'   => $agenda->waktu_mulai,
            'waktu_selesai' => $agenda->waktu_selesai,
            'ruangan'       => $agenda->ruangan->nama,
            'peserta'       => $peserta
        ]);
    }

    public function kirimEmailPeserta(Request $request, $id)
    {
        // Menerima array berisi UUID peserta yang dicentang oleh user
        $selectedUuids = $request->input('uuids', []);

        if (empty($selectedUuids)) {
            return response()->json(['status' => 'error', 'message' => 'Pilih minimal satu peserta.'], 422);
        }

        $agenda = Rapat::findOrFail($id);

        // Ambil data peserta & uuid dari DB berdasarkan pilihan user saja
        $penerima = \DB::table('rapat_pesertas')
            ->join('pesertas', 'rapat_pesertas.id_peserta', '=', 'pesertas.id')
            ->where('rapat_pesertas.id_rapat', $id)
            ->whereIn('rapat_pesertas.uuid', $selectedUuids)
            ->select('pesertas.nama', 'pesertas.email', 'rapat_pesertas.uuid')
            ->get();

        foreach ($penerima as $p) {
            // Tautan absensi unik bawa UUID masing-masing untuk cegah kecurangan
            $linkAbsen = env('APP_URL') . '/absensi/hadir/' . $p->uuid;

            // Kirim email (Disarankan pakai Mail::queue untuk performa)
            Mail::to($p->email)->send(new AgendaRapatMail($agenda, $p->nama, $linkAbsen));
        }

        return response()->json([
            'status' => 'success',
            'message' => count($penerima) . ' Email undangan dengan token kehadiran unik berhasil dikirim!'
        ]);
    }
}

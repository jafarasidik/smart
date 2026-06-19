<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART - PRESENSI RAPAT {{ $rapat->nama }}</title>

    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="/assets/mazer/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/iconly.css">
    <style>
        .transition-all { transition: all 0.3s ease-in-out; }
        .custom-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important; }
        .fs-7 { font-size: 0.9rem; }
        .text-xs { font-size: 0.75rem; }
        
        /* Style Tambahan untuk Canvas Tanda Tangan */
        .signature-container {
            border: 2px dashed #ced4da;
            background-color: #f8f9fa;
            border-radius: 5px;
            position: relative;
            cursor: crosshair;
        }
        .signature-pad {
            width: 100%;
            height: 200px;
        }
        html[data-theme='dark'] .signature-container {
            background-color: #1e1e2e;
            border-color: #444;
        }
    </style>
</head>

<body>
    <script src="/assets/mazer/static/js/initTheme.js"></script>
    
    <header>
        <nav class="navbar navbar-expand navbar-light navbar-top px-4">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="#">
                    <img src="/assets/mazer/static/images/logo/logo.svg" alt="Logo">
                </a>
            </div>
        </nav>
    </header>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                
                <div class="card custom-card-hover transition-all shadow-sm border border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon blue me-3">
                                <i class="bi bi-calendar-event-fill text-white"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Informasi Rapat</h5>
                                <span class="text-xs text-muted">Pastikan Anda mengisi kehadiran pada agenda yang benar</span>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-borderless fs-7 mb-0">
                            <tr>
                                <td class="fw-bold" width="30%">Nama Agenda</td>
                                <td>: {{ $rapat->nama }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Waktu Rapat</td>
                                <td>: {{ $rapat->tanggal->translatedFormat('j F Y') }} ({{ $rapat->waktu_mulai }} - {{ $rapat->waktu_selesai }} WIB)</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title text-white mb-0">Formulir Presensi Kehadiran</h5>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('agenda.absensi.simpan', $uuid) }}" method="POST" id="form-presensi">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="nama">Nama Peserta</label>
                                <input type="text" class="form-control bg-light" id="nama" value="{{ $peserta->nama }}" readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="instansi">Instansi</label>
                                        <input type="text" class="form-control bg-light" id="instansi" value="{{ $peserta->jxi->nama_instansi }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control bg-light" id="jabatan" value="{{ $peserta->jxi->nama_jabatan }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Status Kehadiran <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-hadir" value="Hadir" checked required>
                                        <label class="form-check-label" for="status-hadir">Hadir</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-izin" value="Izin">
                                        <label class="form-check-label" for="status-izin">Izin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-tidak" value="Tidak Hadir">
                                        <label class="form-check-label" for="status-tidak">Tidak Hadir</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3 d-none" id="wrapper-alasan">
                                <label class="form-label fw-bold">Alasan Keterangan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alasan" id="alasan" rows="3" placeholder="Tuliskan alasan ketidakhadiran Anda..."></textarea>
                            </div>

                            <div class="form-group mb-4" id="wrapper-ttd">
                                <label class="form-label fw-bold">Tanda Tangan Digital <span class="text-danger">*</span></label>
                                <div class="signature-container p-1">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="text-xs text-muted">*Gunakan mouse atau sentuhan layar ponsel Anda untuk bertanda tangan</span>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="clear-signature">
                                        <i class="bi bi-trash-fill"></i> Bersihkan
                                    </button>
                                </div>
                                <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg block shadow">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Kirim Presensi Kehadiran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/assets/mazer/static/js/components/dark.js"></script>
    <script src="/assets/mazer/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/mazer/compiled/js/app.js"></script>
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Inisialisasi Kanvas Tanda Tangan
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)' // Background transparan
            });

            // Fungsi penyesuaian ukuran kanvas agar responsif di HP/Desktop
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear(); // Bersihkan kanvas setelah diubah ukurannya
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            // Tombol bersihkan TTD
            document.getElementById('clear-signature').addEventListener('click', function() {
                signaturePad.clear();
            });

            // 2. Logika Toggle Status Kehadiran (Hadir / Izin / Tidak Hadir)
            const radioStatus = document.querySelectorAll('input[name="status"]');
            const wrapperAlasan = document.getElementById('wrapper-alasan');
            const alasanInput = document.getElementById('alasan');
            const wrapperTtd = document.getElementById('wrapper-ttd');

            radioStatus.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Hadir') {
                        wrapperAlasan.classList.add('d-none');
                        alasanInput.removeAttribute('required');
                        wrapperTtd.classList.remove('d-none');
                    } else {
                        // Jika memilih Izin atau Tidak Hadir
                        wrapperAlasan.classList.remove('d-none');
                        alasanInput.setAttribute('required', 'required');
                        wrapperTtd.classList.add('d-none'); // Sembunyikan TTD jika tidak datang
                    }
                });
            });

            // 3. Validasi Sebelum Form di-Submit
            const form = document.getElementById('form-presensi');
            form.addEventListener('submit', function (e) {
                const statusTerpilih = document.querySelector('input[name="status"]:checked').value;

                if (statusTerpilih === 'Hadir') {
                    if (signaturePad.isEmpty()) {
                        e.preventDefault();
                        alert('Silakan isi tanda tangan digital Anda terlebih dahulu!');
                        return false;
                    }
                    // Konversi coretan tanda tangan menjadi string Base64 gambar PNG
                    const dataUrl = signaturePad.toDataURL('image/png');
                    document.getElementById('tanda_tangan').value = dataUrl;
                }
            });
        });
    </script>
</body>

</html>
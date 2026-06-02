<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART - DAFTAR AGENDA DAN NOTULENSI RAPAT</title>

    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">
    <style>
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
        .custom-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
        .fs-7 { font-size: 0.9rem; }
        .text-xs { font-size: 0.75rem; }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>
    <!-- Start content here -->
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a class="navbar-brand ms-4" href="index.html">
                <img src="/assets/mazer/static/images/logo/logo.svg">
            </a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold text-primary mb-1">Daftar Agenda Rapat</h2>
            <p class="text-muted fs-5">Yayasan Bakti Tunas Husada</p>
            <div style="width: 60px; height: 4px; background-color: #435ebe; margin: 0 auto; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            @forelse($rapat as $r)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm custom-card-hover transition-all">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span
                                    class="badge bg-light-success text-success text-xs font-bold px-2 py-1 rounded">Aktif</span>
                                <small class="text-muted font-semibold"><i class="bi bi-hash text-primary"></i>
                                    ID-{{ $r->id }}</small>
                            </div>

                            <h5 class="card-title fw-bold text-gray-800 mb-3 text-capitalize line-clamp-2"
                                style="min-height: 3rem;">
                                {{ $r->nama }} {{-- Sesuaikan nama kolom database Anda --}}
                            </h5>

                            <div class="mb-4 text-muted fs-7">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar3 text-primary me-2 mb-2 fs-6"></i>
                                    <span><strong>Tanggal:</strong>
                                        {{ $r->tanggal->translatedFormat('j F Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock text-warning me-2 mb-2 fs-6"></i>
                                    <span><strong>Mulai:</strong>
                                        {{ $r->waktu_mulai }} WIB</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history text-danger me-2 mb-2 fs-6"></i>
                                    <span><strong>Selesai:</strong>
                                        {{ $r->waktu_selesai }} WIB</span>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('index') }}"
                                    class="btn btn-primary w-100 py-2 font-semibold shadow-sm rounded-pill d-flex align-items-center justify-content-center">
                                    <i class="bi bi-pencil-square me-2 mb-2"></i> Isi Presensi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm py-5">
                        <div class="card-body">
                            <i class="bi bi-calendar-x text-muted display-1 mb-3"></i>
                            <h4 class="text-gray-600 font-semibold">Tidak ada agenda rapat hari ini</h4>
                            <p class="text-muted">Silakan periksa kembali di lain waktu.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase fw-bold text-primary mb-1">Daftar Notulensi Rapat</h2>
            <p class="text-muted fs-5">Yayasan Bakti Tunas Husada</p>
            <div style="width: 60px; height: 4px; background-color: #435ebe; margin: 0 auto; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            @forelse($notulensi as $n)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm custom-card-hover transition-all">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span
                                    class="badge bg-light-success text-success text-xs font-bold px-2 py-1 rounded">Aktif</span>
                                <small class="text-muted font-semibold"><i class="bi bi-hash text-primary"></i>
                                    ID-{{ $n->id }}</small>
                            </div>

                            <h5 class="card-title fw-bold text-gray-800 mb-3 text-capitalize line-clamp-2"
                                style="min-height: 3rem;">
                                {{ $n->rapat->nama }} {{-- Sesuaikan nama kolom database Anda --}}
                            </h5>

                            <div class="mb-4 text-muted fs-7">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar3 text-primary me-2 mb-2 fs-6"></i>
                                    <span><strong>Tanggal Rapat:</strong>
                                        {{ $n->rapat->tanggal->translatedFormat('j F Y') }}</span>
                                </div>
                                <div class="d-flex align-items-start mb-2"> {{-- Diubah ke align-items-start agar ikon tetap rapi di atas jika teks baris baru --}}
                                    <i class="bi bi-book-fill text-warning me-2 mt-1 fs-6"></i>
                                    <span>
                                        <strong>Isi Notulensi:</strong>
                                        {{ \Illuminate\Support\Str::words($n->isi_notulensi, 20, '...') }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history text-danger me-2 mb-2 fs-6"></i>
                                    <span><strong>File:</strong>
                                        @if($n->file)
                                            <a href="{{ asset('file/' . $n->file) }}" target="_blank">Lihat Dokumen</a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif</span>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('index') }}"
                                    class="btn btn-primary w-100 py-2 font-semibold shadow-sm rounded-pill d-flex align-items-center justify-content-center">
                                    <i class="bi bi-eye me-2 mb-2"></i> Lihat Selengkapnya...
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm py-5">
                        <div class="card-body">
                            <i class="bi bi-book-half text-muted display-1 mb-3"></i>
                            <h4 class="text-gray-600 font-semibold">Tidak ada notulensi rapat hari ini</h4>
                            <p class="text-muted">Silakan periksa kembali di lain waktu.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- End content -->
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>

    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
</body>

</html>

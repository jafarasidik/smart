@extends('layout.layout')
@section('title', 'SMART - BUAT RAPAT')
@section('page_header', 'Tambah Data Rapat')
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.agenda.store') }}" method="post" class="form" data-parsley-validate id="formAgenda">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="nama" class="form-label mandatory">Nama Rapat</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama Rapat" value="{{ old('nama') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tanggal" class="form-label mandatory">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="waktu_mulai" class="form-label mandatory">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control"
                                    value="{{ old('waktu_mulai') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="waktu_selesai" class="form-label mandatory">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                                    value="{{ old('waktu_selesai') }}" required data-parsley-time-after="#waktu_mulai"
                                    data-parsley-time-after-message="Waktu selesai tidak boleh kurang dari atau sama dengan waktu mulai.">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="status" class="form-label mandatory">Status Rapat</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="ruangan" class="form-label mandatory">Ruangan</label>
                                <select name="ruangan" id="ruangan" class="form-select" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach ($ruangan as $r)
                                        <option value="{{ $r->id }}"
                                            {{ old('ruangan') == $r->id ? 'selected' : '' }}>{{ $r->nama }} -
                                            {{ $r->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="mb-3 align-items-center">
                                <div class="divider">
                                    <div class="divider-text">
                                        <h5>Pilih Peserta Undangan</h5>
                                    </div>
                                </div>
                                <!-- Fitur Cari Peserta -->
                                <input type="text" id="searchPeserta" class="form-control"
                                    placeholder="Cari nama atau jabatan peserta...">
                            </div>

                            <div class="row" id="daftarPeserta"
                                style="max-height: 400px; overflow-y: auto; padding: 5px;">
                                @foreach ($peserta as $p)
                                    <div class="col-12 col-md-4 col-lg-3 mb-2 item-peserta">
                                        <!-- Menggunakan col-md-4 atau col-lg-3 agar lebih banyak card menyamping -->
                                        <div class="card h-100 border shadow-sm" style="border-radius: 8px;">
                                            <div class="card-body p-2 d-flex align-items-center">
                                                <!-- Checkbox Custom yang Lebih Kecil -->
                                                <div class="custom-control custom-checkbox mr-2">
                                                    <input type="checkbox" name="pesertas[]" value="{{ $p->id }}"
                                                        class="custom-control-input checkbox-peserta"
                                                        id="p{{ $p->id }}">
                                                    <label class="custom-control-label" for="p{{ $p->id }}"></label>
                                                </div>

                                                <div style="line-height: 1.2;">
                                                    <strong class="nama-peserta d-block text-truncate"
                                                        style="font-size: 0.9rem; max-width: 150px;"
                                                        title="{{ $p->nama }}">
                                                        {{ $p->nama }}
                                                    </strong>
                                                    <small class="jabatan-peserta text-muted d-block"
                                                        style="font-size: 0.75rem;">
                                                        {{ $p->jxi->nama_jabatan }}
                                                    </small>
                                                    <span class="badge badge-light border text-dark p-1"
                                                        style="font-size: 0.65rem; margin-top: 2px;">
                                                        {{ $p->jxi->nama_instansi }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Elemen Pesan Tidak Ditemukan (Default Sembunyi) -->
                                <div id="noResults" class="col-12 text-center py-4 w-100" style="display: none;">
                                    <div class="alert alert-light border">
                                        <i class="fas fa-search mr-2"></i> Nama peserta "<strong><span
                                                id="searchTerm"></span></strong>" tidak ditemukan.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.agenda') }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>

                            <div>
                                <button type="reset" class="btn btn-sm btn-light me-1">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-check-circle"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('meta')
    <style>
        /* Menghilangkan margin default pada custom control agar lebih rapat */
        .custom-control-label::before,
        .custom-control-label::after {
            top: 0.15rem;
            left: -1.25rem;
        }

        /* Efek hover agar admin tahu card mana yang sedang ditunjuk */
        .item-peserta .card:hover {
            border-color: #4e73df;
            background-color: #f8f9fc;
            cursor: pointer;
        }

        /* Scrollbar yang lebih tipis (modern) */
        #daftarPeserta::-webkit-scrollbar {
            width: 6px;
        }

        #daftarPeserta::-webkit-scrollbar-thumb {
            background-color: #d1d3e2;
            border-radius: 10px;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            // 1. Daftarkan custom validator bernama 'timeAfter'
            window.Parsley.addValidator('timeAfter', {
                validateString: function(value, requirement) {
                    // Ambil nilai dari input waktu_mulai yang ditargetkan (#waktu_mulai)
                    var startTime = $(requirement).val();

                    // Jika salah satu input belum diisi, lewati validasi dulu (ditangani oleh atribut 'required')
                    if (!value || !startTime) {
                        return true;
                    }

                    // Membandingkan string waktu secara langsung (Format 'HH:MM' aman dibandingkan secara string asalkan panjangnya sama)
                    return value > startTime;
                },
                requirementType: 'string'
            });

            // 2. Trigger validasi ulang waktu_selesai jika user mengubah kembali waktu_mulai
            $('#waktu_mulai').on('change', function() {
                var selesaiInput = $('#waktu_selesai');
                // Jika waktu_selesai sudah ada isinya, paksa cek ulang validasinya
                if (selesaiInput.val()) {
                    selesaiInput.parsley().validate();
                }
            });

            // Inisialisasi Parsley pada form (ganti #form-kamu sesuai id form asli kamu)
            $('#formAgenda').parsley();
        });

        document.getElementById('searchPeserta').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.item-peserta');
            let noResults = document.getElementById('noResults');
            let searchTermSpan = document.getElementById('searchTerm');
            let countVisible = 0; // Counter untuk card yang tampil

            items.forEach(function(item) {
                let nama = item.querySelector('.nama-peserta').innerText.toLowerCase();
                let jabatan = item.querySelector('.jabatan-peserta').innerText.toLowerCase();

                if (nama.indexOf(filter) > -1 || jabatan.indexOf(filter) > -1) {
                    item.style.display = "";
                    countVisible++; // Tambah jika ada yang cocok
                } else {
                    item.style.display = "none";
                }
            });

            // Logika menampilkan pesan jika tidak ada yang cocok
            if (countVisible === 0) {
                noResults.style.display = "block";
                searchTermSpan.innerText = this.value; // Tampilkan teks yang diketik user
            } else {
                noResults.style.display = "none";
            }
        });
    </script>
@endpush

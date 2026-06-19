@extends('layout.layout')
@section('title', 'SMART - INFO DATA ' . $data->nama)
@section('page_header', 'Info Data ' . $data->nama)
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="nama">Nama Rapat</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                placeholder="Masukkan Nama Rapat" value="{{ old('nama', $data->nama) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ old('tanggal', $data->tanggal->format('Y-m-d')) }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control"
                                value="{{ old('waktu_mulai', isset($data) ? \Carbon\Carbon::parse($data->waktu_mulai)->format('H:i') : '') }}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                                value="{{ old('waktu_selesai', isset($data) ? \Carbon\Carbon::parse($data->waktu_selesai)->format('H:i') : '') }}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="status">Status Rapat</label>
                            <select name="status" id="status" class="form-select" disabled>
                                <option value="">-- Pilih Status --</option>
                                <option value="1" {{ old('status', $data->status) == '1' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ old('status', $data->status) == '0' ? 'selected' : '' }}>Tidak
                                    Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="ruangan">Ruangan</label>
                            <select name="ruangan" id="ruangan" class="form-select" disabled>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangan as $r)
                                    <option value="{{ $r->id }}"
                                        {{ old('ruangan', $data->id_ruangan) == $r->id ? 'selected' : '' }}>
                                        {{ $r->nama }} - {{ $r->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="mb-3 align-items-center">
                            <div class="divider">
                                <div class="divider-text">
                                    <h5>Daftar Kehadiran Peserta</h5>
                                </div>
                            </div>
                        </div>

                        @php
                            $no = 1;
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Asal Instansi</th>
                                        <th width="15%" class="text-center">Status</th>
                                        <th>Alasan / Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->peserta as $p)
                                        @php
                                            // Ambil data kehadiran berdasarkan id_peserta
                                            $kehadiran = $data->kehadiran->where('id_peserta', $p->id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td class="fw-bold">{{ $p->nama }}</td>
                                            <td>{{ $p->jxi->nama_jabatan }}</td>
                                            <td>{{ $p->jxi->nama_instansi }}</td>
                                            <td class="text-center">
                                                @if ($kehadiran)
                                                    @if ($kehadiran->status === 'Hadir')
                                                        <span
                                                            class="badge bg-light-success text-success fw-bold">Hadir</span>
                                                    @elseif ($kehadiran->status === 'Izin')
                                                        <span
                                                            class="badge bg-light-warning text-warning fw-bold">Izin</span>
                                                    @else
                                                        <span class="badge bg-light-danger text-danger fw-bold">Tidak
                                                            Hadir</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-light-secondary text-secondary">Belum
                                                        Mengisi</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- Pengecekan aman: Jika $kehadiran ada dan kolom alasan terisi, tampilkan. Jika tidak, tampilkan '-' --}}
                                                {{ $kehadiran && $kehadiran->alasan ? $kehadiran->alasan : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between mt-2">
                        <a href="{{ route('data.agenda') }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </div>
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

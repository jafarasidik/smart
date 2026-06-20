@extends('layout.layout')
@section('title', 'SMART - EDIT DATA NOTULENSI ' . $data->rapat->nama)
@section('page_header', 'Edit Data Notulensi ' . $data->rapat->nama)
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.notulensi.update', $data->id) }}" method="post" class="form"
                    enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <label for="rapat" class="form-label mandatory">Nama Agenda Rapat</label>
                            <select name="rapat" id="rapat" class="form-select" required>
                                <option value="">-- Pilih Agenda Rapat --</option>
                                @foreach ($rapat as $a)
                                    <option value="{{ $a->id }}"
                                        {{ old('rapat', $data->id_rapat) == $a->id ? 'selected' : '' }}>
                                        {{ $a->nama }} -
                                        {{ optional($a->tanggal)->translatedFormat('j F Y') ?? 'Tanggal Belum Diatur' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="isi" class="form-label mandatory">Isi Notulensi</label>
                            <textarea name="isi" id="isi" cols="30" rows="10" class="form-control"
                                placeholder="Masukkan notulensi" required>{{ $data->isi_notulensi }}</textarea>
                        </div>
                        <div class="col-md-12 col-12 mt-2">
                            <label for="file_dokumen" class="form-label">Upload File</label><small class="text-muted"> | Opsional</small>
                            <input type="file" name="file_dokumen" id="file_dokumen" class="form-control"
                                accept=".pdf, .docx, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <small class="text-small">Dokumen Sebelumnya :
                                @if ($data->file)
                                    <a href="{{ asset('file/' . $data->file) }}" target="_blank">Lihat Dokumen</a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </small>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.notulensi') }}" class="btn btn-sm btn-warning">
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

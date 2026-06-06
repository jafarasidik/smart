@extends('layout.layout')
@section('title', 'SMART - TAMBAH DATA NOTULENSI')
@section('page_header', 'Tambah Data Notulensi')
@section('konten')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.notulensi.store') }}" method="post" class="form" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="rapat" class="form-label mandatory">Nama Agenda Rapat</label>
                            <select name="rapat" id="rapat" class="form-select" required>
                                <option value="">-- Pilih Agenda Rapat --</option>
                                @foreach ($agenda as $a)
                                    <option value="{{ $a->id }}" {{ old('rapat') == $a->id ? 'selected' : '' }}>
                                        {{ $a->nama }} - {{ $a->tanggal->translatedFormat('j F Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="isi" class="form-label mandatory">Isi Notulensi</label>
                            <textarea name="isi" id="isi" cols="30" rows="10" class="form-control"
                                placeholder="Masukkan notulensi" required></textarea>
                        </div>
                        <div class="col-md-12 col-12 mt-2">
                            <label for="file_dokumen" class="form-label">Upload File</label>
                            <input type="file" name="file_dokumen" id="file_dokumen" class="form-control" accept=".pdf, .docx, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <small class="text-small">Opsional</small>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <label for="publish" class="form-label mandatory">Tampilkan Publik</label>
                            <select name="publish" id="publish" class="form-select" required>
                                <option value="">-- Pilih Tampilkan Publik --</option>
                                <option value="1" {{ old('publish') == '1' ? 'selected' : '' }}>
                                    Ya
                                </option>
                                <option value="0" {{ old('publish') == '0' ? 'selected' : '' }}>
                                    Tidak
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 col-12 mt-2" id="aktif-sampai-wrapper" style="display: none;">
                            <label for="aktif_sampai" class="form-label mandatory">Aktif Sampai</label>
                            <input type="date" name="aktif_sampai" id="aktif_sampai" class="form-control"
                                value="{{ old('aktif_sampai') }}">
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
    </section>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const publish = document.getElementById('publish');
            const wrapper = document.getElementById('aktif-sampai-wrapper');
            const aktifSampai = document.getElementById('aktif_sampai');

            function toggleAktifSampai() {

                if (publish.value === '1') {
                    wrapper.style.display = 'block';
                    aktifSampai.required = true;
                } else {
                    wrapper.style.display = 'none';
                    aktifSampai.required = false;
                }
            }

            // saat pertama load
            toggleAktifSampai();

            // saat select berubah
            publish.addEventListener('change', toggleAktifSampai);

        });
    </script>
@endpush

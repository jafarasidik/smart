@extends('layout.layout')
@section('title', 'SMART - EDIT DATA INSTANSI DAN JABATAN ' . $data->nama_instansi . ' - ' . $data->nama_jabatan)
@section('page_header', 'Edit Data Instansi dan Jabatan ' . $data->nama_instansi . ' - ' . $data->nama_jabatan)
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.ixj.update', $data->id) }}" method="post" class="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <label for="instansi">Nama Instansi</label>
                            <select name="instansi" id="instansi" class="form-select select2" required>
    
                                <option value="">-- Pilih Instansi --</option>
    
                                @foreach ($instansi as $item)
                                    <option value="{{ $item }}" {{ old('instansi', $data->nama_instansi) == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
    
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="jabatan">Nama Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select select2" required>
    
                                <option value="">-- Pilih Jabatan --</option>
    
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item }}" {{ old('jabatan', $data->nama_jabatan) == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
    
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.ixj') }}" class="btn btn-sm btn-warning">
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
@push('script')
    <script>
        $('.select2').select2({
            tags: true,
            placeholder: 'Pilih atau ketik instansi',
            width: '100%'
        });
    </script>
@endpush

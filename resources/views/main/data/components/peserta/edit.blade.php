@extends('layout.layout')
@section('title', 'SMART - EDIT DATA PESERTA ' . $data->nama)
@section('page_header', 'Edit Data Peserta ' . $data->nama)
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.peserta.update', $data->id) }}" method="post" class="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="nama">Nama Peserta</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Peserta" value="{{ old('nama', $data->nama) }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="jabatanxinstansi">Jabatan dan Instansi</label>
                                <select name="jabatanxinstansi" id="jabatanxinstansi" class="form-select" required>
                                    <option value="">-- Pilih Jabatan dan Instansi --</option>
                                    @foreach ($jxi as $i)
                                        <option value="{{ $i->id }}" {{ old('jabatanxinstansi', $data->id_jabatan_instansi) == $i->id ? 'selected' : '' }}>{{ $i->nama_jabatan }} - {{ $i->nama_instansi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="whatsapp">Whatsapp</label>
                                <input type="number" name="whatsapp" id="whatsapp" class="form-control" placeholder="Masukkan Nomor Whatsapp" value="{{ old('whatsapp', $data->whatsapp) }}" required>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.peserta') }}" class="btn btn-sm btn-warning">
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
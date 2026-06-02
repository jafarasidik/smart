@extends('layout.layout')
@section('title', 'SMART - TAMBAH DATA RUANGAN')
@section('page_header', 'Tambah Data Ruangan')
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.ruangan.store') }}" method="post" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama">Nama Ruangan</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Ruangan" value="{{ old('nama') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="lokasi">Lokasi Ruangan</label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Masukkan Lokasi Ruangan" value="{{ old('lokasi') }}" required>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.ruangan') }}" class="btn btn-sm btn-warning">
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
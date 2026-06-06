@extends('layout.layout')
@section('title', 'SMART - TAMBAH DATA ADMIN')
@section('page_header', 'Tambah Data Admin')
@section('konten')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.admin.store') }}" method="post" class="form" data-parsley-validate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="nama" class="form-label mandatory">Nama Admin</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama Admin" value="{{ old('nama') }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email" class="form-label mandatory">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Masukkan Email" value="{{ old('email') }}" required
                                    data-parsley-type="email" data-parsley-type-message="Email tidak valid">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="password" class="form-label mandatory">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="********" required data-parsley-minlength="8" data-parsley-minlength-message="Password minimal 8 karakter">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="confirm_password" class="form-label mandatory">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="********" required data-parsley-equalto="#password"
                                    data-parsley-equalto-message="Password tidak sama.">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <a href="{{ route('data.admin') }}" class="btn btn-sm btn-warning">
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

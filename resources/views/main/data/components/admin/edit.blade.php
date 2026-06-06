@extends('layout.layout')
@section('title', 'SMART - EDIT DATA ADMIN ' . $data->nama)
@section('page_header', 'Edit Data Admin ' . $data->nama)
@section('konten')
    <div class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('data.admin.update', $data->id) }}" method="post" class="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="nama" class="form-class mandatory">Nama Admin</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama Admin" value="{{ old('nama', $data->nama) }}" required
                                    autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email" class="form-class mandatory">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Masukkan Email" value="{{ old('email', $data->email) }}" required
                                    data-parsley-type="email" data-parsley-type-message="Email tidak valid">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="********" data-parsley-minlength="8"
                                    data-parsley-minlength-message="Password minimal 8 karakter">
                                <small class="text-small">Opsional</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="confirm_password" id="label_confirm">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="********" data-parsley-equalto="#password"
                                    data-parsley-equalto-message="Password tidak sama."
                                    data-parsley-required-message="Konfirmasi password harus diisi jika password baru diisi.">
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
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#password').on('input', function() {
                var passwordValue = $(this).val();
                var confirmPassword = $('#confirm_password');
                var label = document.getElementById("label_confirm");

                if (passwordValue.length > 0) {
                    // Jika password diisi, buat konfirmasi password menjadi REQUIRED
                    confirmPassword.attr('required', 'required');
                    label.classList.add('mandatory');
                } else {
                    // Jika password kosong, hapus required dan bersihkan error parsley-nya
                    confirmPassword.removeAttr('required');
                    confirmPassword.parsley().reset();
                    label.classList.remove('mandatory');
                }

                // Memaksa Parsley memperbarui ulang aturan validasi pada input tersebut
                confirmPassword.parsley().validate();
            });
        });
    </script>
@endpush
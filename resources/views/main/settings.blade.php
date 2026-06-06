@extends('layout.layout')
@section('title', 'SMART - PENGATURAN AKUN')
@section('page_header', 'Pengaturan Akun')
@section('konten')
    <section class="section">

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="{{ asset('foto/' . auth()->user()->foto) }}" alt="Avatar">
                            </div>

                            <h3 class="mt-3">{{ auth()->user()->nama }}</h3>
                            <p class="text-small">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengaturan.update', auth()->user()->id) }}" method="post"
                            enctype="multipart/form-data" data-parsley-validate id="formSettings">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama" class="form-label mandatory">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Masukkan Nama" value="{{ auth()->user()->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label mandatory">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Masukkan Email" value="{{ auth()->user()->email }}" required data-parsley-type="email" data-parsley-type-message="Email tidak valid">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan password baru" data-parsley-minlength="8"
                                    data-parsley-minlength-message="Password minimal 8 karakter">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="Masukkan konfirmasi password baru" data-parsley-equalto="#password"
                                    data-parsley-equalto-message="Password tidak sama."
                                    data-parsley-required-message="Konfirmasi password harus diisi jika password baru diisi.">
                            </div>
                            <div class="form-group">
                                <label for="foto_profile" class="form-label">Update Foto</label>
                                <input type="file" name="foto_profile" id="foto_profile" class="form-control"
                                    accept=".jpg,.jpeg,.png" data-parsley-fileextension="jpg, jpeg, png"
                                    data-parsley-fileextension-message="Hanya diperbolehkan mengupload file gambar berformat JPG, JPEG, atau PNG.">
                                <small class="text-muted">Format yang didukung: JPG, JPEG, PNG</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#password').on('input', function() {
                var passwordValue = $(this).val();
                var confirmPassword = $('#confirm_password');

                if (passwordValue.length > 0) {
                    // Jika password diisi, buat konfirmasi password menjadi REQUIRED
                    confirmPassword.attr('required', 'required');
                } else {
                    // Jika password kosong, hapus required dan bersihkan error parsley-nya
                    confirmPassword.removeAttr('required');
                    confirmPassword.parsley().reset();
                }

                // Memaksa Parsley memperbarui ulang aturan validasi pada input tersebut
                confirmPassword.parsley().validate();
            });

            window.Parsley.addValidator('fileextension', {
                validateString: function(value, requirement) {
                    // Ambil ekstensi file yang diupload (diubah ke lowercase)
                    var fileExtension = value.split('.').pop().toLowerCase();

                    // Ambil daftar ekstensi yang diizinkan dari atribut (dipecah jadi array)
                    var allowedExtensions = requirement.split(',').map(function(item) {
                        return item.trim().toLowerCase();
                    });

                    // Cek apakah ekstensi file ada di dalam daftar yang diizinkan
                    return allowedExtensions.indexOf(fileExtension) > -1;
                },
                requirementType: 'string'
            });
            $('#formSettings').parsley();
        });
    </script>
@endpush

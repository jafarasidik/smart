<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART - LOGIN</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            /* Background gradien lembut agar terlihat menarik dan modern */
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-1px);
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">

                <div class="card login-card p-4 bg-white">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-shield-lock-fill fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">Sistem Manajemen Rapat</h4>
                            <p class="text-muted small">Silakan masuk ke akun Anda</p>
                        </div>

                        <form action="{{ route('auth') }}" method="POST">
                            @csrf <div class="mb-3">
                                <label Presidential for="email"
                                    class="form-label text-secondary small fw-semibold">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0"
                                        id="email" placeholder="nama@email.com" value="{{ old('email') }}" required
                                        @if (session('is_locked')) disabled @endif>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label text-secondary small fw-semibold mb-0">Kata
                                        Sandi</label>
                                    <a href="#" class="text-decoration-none small text-primary">Lupa Sandi?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i
                                            class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0"
                                        id="password" placeholder="••••••••" required
                                        @if (session('is_locked')) disabled @endif>
                                </div>
                            </div>

                            <div class="form-check mb-4 text-start">
                                <input type="checkbox" name="remember" class="form-check-input" id="rememberMe"
                                    @if (session('is_locked')) disabled @endif>
                                <label class="form-check-label text-muted small" for="rememberMe">Ingat saya di
                                    perangkat ini</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm mb-3"
                                @if (session('is_locked')) disabled @endif>
                                @if (session('is_locked'))
                                    <i class="bi bi-hourglass-split me-2"></i> Akses Terkunci...
                                @else
                                    Masuk
                                @endif
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('sweetalert::alert')
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART - Presensi Gagal</title>

    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/iconly.css">

    <style>
        .error-cross {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background-color: #dc3545;
            border-radius: 50%;

            /* Gunakan kombinasi flexbox yang disempurnakan */
            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .error-cross i {
            font-size: 40px;
            color: white;

            /* Tambahan untuk menetralkan line-height bawaan icon font */
            line-height: 1;
            display: inline-block;
        }

        .error-cross-css {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background-color: #dc3545;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* Membuat garis silang diagonal */
        .error-cross-css::before,
        .error-cross-css::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 4px;
            background-color: white;
            border-radius: 2px;
        }

        .error-cross-css::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .error-cross-css::after {
            transform: translate(-50%, -50%) rotate(-45deg);
        }
    </style>
</head>

<body>
    <script src="/assets/mazer/static/js/initTheme.js"></script>

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-sm-8 col-12 text-center">

                <div class="card shadow-lg border-0 p-4">
                    <div class="card-body">
                        <div class="error-cross-css mb-4"></div>

                        <h3 class="fw-bold text-danger mb-2">Presensi Gagal!</h3>

                        <p class="text-muted fs-6 px-3">
                            {{ $message ?? 'Maaf, tautan presensi tidak valid, sudah kadaluwarsa, atau agenda rapat ini telah ditutup.' }}
                        </p>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="alert alert-light-danger text-start fs-7 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Jika Anda merasa ini adalah kesalahan teknis, silakan hubungi bagian Sekretariat atau Admin
                            Rapat untuk mendapatkan bantuan absen manual.
                        </div>
                    </div>
                </div>

                <p class="text-muted text-xs mt-3">&copy; {{ date('Y') }} Ihsanul Arif.
                </p>
            </div>
        </div>
    </div>

    <script src="/assets/mazer/static/js/components/dark.js"></script>
    <script src="/assets/mazer/compiled/js/app.js"></script>
</body>

</html>

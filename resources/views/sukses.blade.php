<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART - Presensi Berhasil</title>

    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/iconly.css">

    <style>
        .error-cross,
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-cross {
            background-color: #dc3545;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .success-checkmark {
            background-color: #198754;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);
        }

        .error-cross svg,
        .success-checkmark svg {
            color: white;
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
                        <div class="success-checkmark mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                            </svg>
                        </div>

                        <h3 class="fw-bold text-success mb-2">Presensi Berhasil!</h3>

                        <p class="text-muted fs-6 px-3">
                            {{ $message ?? 'Terima kasih, data presensi kehadiran Anda telah berhasil direkam ke dalam sistem kami.' }}
                        </p>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="alert alert-light-success text-start fs-7 mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i> Anda sekarang dapat menutup halaman browser ini
                            dengan aman.
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @stack('meta')
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="/assets/mazer/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/mazer/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="/assets/mazer/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
</head>
<body>
    <script src="/assets/mazer/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}"><span>SMART</span></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3">
                                    </path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ request()->is('main') ? 'active' : '' }} ">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Halaman</li>

                        <li
                            class="sidebar-item {{ request()->is('main/data/agenda') || request()->is('main/data/agenda/*') || request()->is('main/data/peserta') || request()->is('main/data/peserta/*') || request()->is('main/data/ruangan') || request()->is('main/data/ruangan/*') || request()->is('main/data/instansi-jabatan') || request()->is('main/data/instansi-jabatan/*') || request()->is('main/data/notulensi') || request()->is('main/data/notulensi/*') ? 'active' : '' }} has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-database-fill"></i>
                                <span>Data Master</span>
                            </a>

                            <ul class="submenu">
                                <li class="submenu-item {{ request()->is('main/data/agenda') || request()->is('main/data/agenda/*') ? 'active' : '' }}">
                                    <a href="{{ route('data.agenda') }}"
                                        class="submenu-link">Data Agenda Rapat</a>
                                </li>
                                <li class="submenu-item {{ request()->is('main/data/peserta') || request()->is('main/data/peserta/*') ? 'active' : '' }}">
                                    <a href="{{ route('data.peserta') }}"
                                        class="submenu-link">Data Peserta</a>
                                </li>
                                <li class="submenu-item {{ request()->is('main/data/ruangan') || request()->is('main/data/ruangan/*') ? 'active' : '' }}">
                                    <a href="{{ route('data.ruangan') }}"
                                        class="submenu-link">Data Ruangan</a>
                                </li>
                                <li class="submenu-item {{ request()->is('main/data/instansi-jabatan') || request()->is('main/data/instansi-jabatan/*') ? 'active' : '' }}">
                                    <a href="{{ route('data.ixj') }}"
                                    class="submenu-link">Data Jabatan dan Instansi</a>
                                </li>
                                <li class="submenu-item {{ request()->is('main/data/notulensi') || request()->is('main/data/notulensi/*') ? 'active' : '' }}">
                                    <a href="{{ route('data.notulensi') }}"
                                        class="submenu-link">Data Notulensi</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Laporan</li>

                        <li
                            class="sidebar-item {{ request()->is('main/laporan/registrasi') || request()->is('main/laporan/modifikasi') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-book-fill"></i>
                                <span>Laporan Agenda Rapat</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Pengaturan</li>

                        <li class="sidebar-item {{ request()->is('main/pengaturan') ? 'active' : '' }} ">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-person-fill-gear"></i>
                                <span>Pengaturan Akun</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collpase"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                <li class="nav-item dropdown me-3">
                                    <a href="#" class="nav-link active dropdown-toggle text-gray-600"
                                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-bell bi-sub fs-4"></i>
                                        <span class="badge badge-notification bg-danger">0</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-center dropdown-menu-sm-end notification-dropdown"
                                        aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-header">
                                            <h6>Notifikasi</h6>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">Tester</h6>
                                            <p class="mb-0 text-sm text-gray-600">Email</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="/assets/mazer/compiled/jpg/7.jpg" alt="Foto Profile">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, Tester!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="icon-mid bi bi-gear me-2"></i>
                                            Pengaturan</a></li>
                                    <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="event.preventDefault();document.getElementById('logout-admin').submit();">
                                            <form action="#" method="POST" id="logout-admin">
                                                @csrf
                                            </form>
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                            Keluar
                                        </a>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <h3>@yield('page_header')</h3>
                    </div>
                    @yield('konten')
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; Muhammad Ihsanul Arif</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Start content here -->

    <!-- End content -->
    <script src="/assets/mazer/extensions/jquery/jquery.min.js"></script>
    <script src="/assets/mazer/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/mazer/static/js/components/dark.js"></script>
    <script src="/assets/mazer/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/mazer/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/mazer/compiled/js/app.js"></script>
    <script src="/vendor/sweetalert/sweetalert.all.js"></script>
    <script src="/assets/mazer/static/js/pages/datatables.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('script')
    @include('sweetalert::alert')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
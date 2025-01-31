<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') | Sistem Pendukung Keputusan metode AHP & WP</title>
    <link rel="shortcut icon"
        href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/images/logo/favicon.svg"
        type="image/x-icon" />
    <link rel="shortcut icon"
        href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/images/logo/favicon.png"
        type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css" />
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.css"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css"
        integrity="sha256-h2Gkn+H33lnKlQTNntQyLXMWq7/9XI2rlPCsLsVcUBs=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>
</head>

<body onload="switchvalidation()">
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('home.index') }}">
                                {{-- <img src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/images/logo/logo.svg"
                                    alt="Logo" /> --}}
                            </a>
                        </div>
                        {{-- <x-theme /> --}}
                        <div class="sidebar-toggler x">
                            <a href="javascript:void(0)" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        @auth
                            <li class="sidebar-title">Menu</li>
                            <li class="sidebar-item">
                                <a href="{{ route('home.index') }}" class="sidebar-link">
                                    <i class="bi bi-house-fill"></i> <span>Beranda</span>
                                </a>
                            </li>
                            @if(Auth::user()->role === 'admin')
                                <li class="sidebar-item">
                                    <a href="{{ route('employees.index') }}" class="sidebar-link">
                                        <i class="bi bi-person-plus"></i> <span>Karyawan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item has-sub">
                                    <a href="#" class="sidebar-link">
                                        <i class="bi bi-clipboard-data-fill"></i> <span>Data Master</span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="submenu-item">
                                            <a href="{{ route('kriteria.index') }}" class="submenu-link">
                                                Kriteria
                                            </a>
                                        </li>
                                        <li class="submenu-item">
                                            <a href="{{ route('subkriteria.index') }}" class="submenu-link">
                                                Sub Kriteria
                                            </a>
                                        </li>
                                        <li class="submenu-item">
                                            <a href="{{ route('alternatif.index') }}" class="submenu-link">
                                                Alternatif
                                            </a>
                                        </li>
                                        <li class="submenu-item">
                                            <a href="{{ route('alternatif.index') }}" class="submenu-link">
                                                Pegawai
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li @class([
                                'sidebar-item',
                                'has-sub',
                                'active' => request()->is('bobot/hasil') || request()->is('bobot/sub/*'),
                            ])>
                                <a href="#" class="sidebar-link">
                                    <i class="bi bi-calculator-fill"></i> <span>Pembobotan</span>
                                </a>
                                <ul class="submenu">
                                    <li @class(['submenu-item', 'active' => request()->is('bobot/hasil')])>
                                        <a href="{{ route('bobotkriteria.index') }}" class="submenu-link">
                                            Kriteria
                                        </a>
                                    </li>
                                    <li @class(['submenu-item', 'active' => request()->is('bobot/sub/*')])>
                                        <a href="{{ route('bobotsubkriteria.pick') }}" class="submenu-link">
                                            Sub Kriteria
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('nilai.index') }}" class="sidebar-link">
                                    <i class="bi bi-pen-fill"></i> <span>Penilaian Alternatif</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('nilai.lihat') }}" class="sidebar-link">
                                    <i class="bi bi-bar-chart-line-fill"></i> <span>Hasil</span>
                                </a>
                            </li>
                        @else
                            <li class="sidebar-item active">
                                <a href="{{ route('login') }}" class="sidebar-link">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> <span>Login</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header class="mb-3">
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="javascript:void(0)" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-label="Toggle navigation"
                            aria-controls="navbarSupportedContent" aria-expanded="false">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            @auth
                                <ul class="navbar-nav ms-auto mb-lg-0">
                                    <li class="nav-item me-5">
                                        <a class="nav-link active text-gray-600" href="{{ route('php.info') }}"
                                            target="_blank">
                                            PHP Info
                                        </a>
                                    </li>
                                </ul>
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="user-menu d-flex">
                                            <div class="user-name text-end me-3">
                                                <p class="mb-0 text-gray-600">{{ auth()->user()->name }}</p>
                                            </div>
                                            <div class="user-img d-flex align-items-center">
                                                <div class="avatar me-3 {{ session('avatar-bg') }}">
                                                    <div class="avatar-content">
                                                        {{ substr(auth()->user()->name, 0, 1) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                        style="min-width: 11rem">
                                        <li>
                                            <h6 class="dropdown-header">Akun</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('akun.show') }}">
                                                <i class="icon-mid bi bi-person me-2"></i> Edit Akun
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" id="logout-btn">
                                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            @endauth
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <h3>@yield('subtitle')</h3>
                        @hasSection('page-desc')
                            <p class="text-subtitle text-muted">@yield('page-desc')</p>
                        @endif
                    </div>
                    <section class="content">
                        <x-no-script /><x-errors />
                        <x-alert type="error" icon="bi bi-x-circle-fill" />
                        <x-alert type="warning" icon="bi bi-exclamation-circle-fill" />
                        <x-alert type="success" icon="bi bi-check-circle-fill" />
                        @yield('content')
                    </section>
                </div>
                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>{{ date('Y') }} &copy; Sistem Pendukung Keputusan</p>
                        </div>
                        <div class="float-end">
                            {{-- <p>Template dibuat oleh
								<a href="https://ahmadsaugi.com">Saugi Zuramai</a>
							</p> --}}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-html5-3.0.0/r-3.0.0/datatables.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/2.0.0/sorting/natural.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="{{ asset('js/popup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tooltip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/validate.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '#logout-btn', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });

        function formloading(formEl, disable) {
            $(formEl).prop('disabled', disable);
            if (disable) $('.spinner-grow').removeClass('d-none');
            else $('.spinner-grow').addClass('d-none');
        }
    </script>
    @yield('js')
</body>

</html>

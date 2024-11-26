<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free" lang="en" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>
            {{ @$title != '' ? "$title |" : '' }}
            {{ settings()->get('nama_sistem', 'SiAKeu') }}
        </title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link type="image/x-icon" href="{{ asset('img/logo-sma.png') }}" rel="icon" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Icons. Uncomment required icon fonts -->
        <link href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" rel="stylesheet" />

        <!-- Core CSS -->
        <link class="template-customizer-core-css" href="{{ asset('sneat') }}/assets/vendor/css/core.css"
            rel="stylesheet" />
        <link class="template-customizer-theme-css" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css"
            rel="stylesheet" />
        <link href="{{ asset('sneat') }}/assets/css/demo.css" rel="stylesheet" />

        <!-- Vendors CSS -->
        <link href="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" />

        <link href="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apex-charts.css" rel="stylesheet" />

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{ asset('sneat') }}/assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('sneat') }}/assets/js/config.js"></script>
        <link href="{{ asset('icon/css/all.css') }}" rel="stylesheet">
        <style>
            .layout-navbar .navbar-dropdown .dropdown-menu {
                min-width: 22rem;
            }

            /*mengaktifkan sub-menu*/
            .menu-item.active>a,
            .menu-item.active>a:hover {
                background-color: #007bff;
                color: white;
            }

            .menu-sub .active>a {
                background-color: #f0f0f0;
            }
        </style>
        <script>
            popupCenter = ({
                url,
                title,
                w,
                h
            }) => {
                // Fixes dual-screen position                             Most browsers      Firefox
                const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
                const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

                const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                    .documentElement.clientWidth : screen.width;
                const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                    .documentElement.clientHeight : screen.height;

                const systemZoom = width / window.screen.availWidth;
                const left = (width - w) / 2 / systemZoom + dualScreenLeft
                const top = (height - h) / 2 / systemZoom + dualScreenTop
                const newWindow = window.open(url, title,
                    `
          scrollbars=yes,
          width=${w / systemZoom},
          height=${h / systemZoom},
          top=${top},
          left=${left}
          `
                )

                if (window.focus) newWindow.focus();
            }
        </script>
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <aside class="layout-menu menu-vertical menu bg-menu-theme" id="layout-menu">
                    <div class="app-brand demo">
                        <a class="app-brand-link" href="{{ route('operator.dashboard') }}">
                            <img src="{{ asset('img/logo-sma.png') }}" style="width: 70px">
                            <span class="demo menu-text fw-bolder ms-2" style="font-size: 25px">SiAKeu</span>
                        </a>

                        <a class="layout-menu-toggle menu-link text-large d-block d-xl-none ms-auto"
                            href="javascript:void(0);">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>

                    <ul class="menu-inner py-1">

                        <!-- Dashboard -->
                        <li class="menu-item {{ \Route::is('operator.dashboard') ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('operator.dashboard') }}">
                                <i class="menu-icon tf-icons fa fa-gauge"></i>
                                <div data-i18n="Analytics">Dashboard</div>
                            </a>
                        </li>

                        <!-- Layouts -->
                        <li
                            class="menu-item {{ \Route::is('operator.tagihan.*') || \Route::is('operator.transaksi.*') ? 'active open' : '' }}">
                            <a class="menu-link menu-toggle" href="">
                                <i class="menu-icon tf-icons fa fa-circle-dollar-to-slot"></i>
                                <div data-i18n="Layouts">Pembayaran Siswa</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="{{ \Route::is('operator.tagihan.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('operator.tagihan.index') }}">
                                        <div data-i18n="Basic"><i class="fa fa-file-invoice"></i> Tagihan Siswa</div>
                                    </a>
                                </li>
                                <li
                                    class="{{ \Route::is('operator.transaksi.index') || \Route::is('operator.transaksi.show') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('operator.transaksi.index') }}">
                                        <div data-i18n="Basic"><i class="fa fa-money-bill"></i> Transaksi Pembayaran
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('logout') }}">
                                <i class="menu-icon tf-icons fa fa-sign-out"></i>
                                <div data-i18n="Basic">Keluar</div>
                            </a>
                        </li>
                    </ul>
                </aside>
                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->

                    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                        id="layout-navbar">
                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-xl-0 d-xl-none me-3">
                            <a class="nav-item nav-link me-xl-4 px-0" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <!-- Search -->
                            <div class="navbar-nav align-items-center">
                                {!! Form::open(['route' => 'tagihan.index', 'method' => 'GET']) !!}
                                <div class="nav-item d-flex align-items-center">
                                    <i class="bx bx-search fs-4 lh-0"></i>
                                    <input class="form-control border-0 shadow-none" name="q" type="text"
                                        value="{{ request('q') }}" aria-label="Search..."
                                        placeholder="Cari Tagihan" />
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- /Search -->

                            <ul class="navbar-nav align-items-center ms-auto flex-row">
                                <!-- Place this tag where you want the button to render. -->

                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                        href="javascript:void(0);">
                                        <div class="avatar avatar-online">
                                            <img class="w-px-40 rounded-circle h-auto"
                                                src="{{ \Storage::url('image/user.png') }}" alt />
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="me-3 flex-shrink-0">
                                                        <div class="avatar avatar-online">
                                                            <img class="w-px-40 rounded-circle h-auto"
                                                                src="{{ \Storage::url('image/user.png') }}" alt />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span
                                                            class="fw-semibold d-block">{{ Auth()->user()->name }}</span>
                                                        <small class="text-muted">{{ Auth()->user()->email }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('user.edit', auth()->user()->id) }}">
                                                <i class="fa fa-user me-2"></i>
                                                <span class="align-middle">Profil Saya</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}">
                                                <i class="fa fa-sign-out me-2"></i>
                                                <span class="align-middle">Keluar</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->
                            </ul>

                        </div>
                    </nav>
                    @if (session('alert'))
                        <div class="container mt-3">
                            <div class="alert alert-dark fw-bold">
                                {{ session('alert') }}
                            </div>
                        </div>
                    @endif

                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        <div class="container-xxl flex-grow-1 container-p-y">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                                </div>
                            @endif
                            @include('flash::message')
                            @yield('content')
                        </div>
                        <!-- / Content -->

                        {{--  <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->  --}}

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        {{--  <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div>  --}}

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('sneat') }}/assets/vendor/libs/jquery/jquery.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/js/bootstrap.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <!-- Main JS -->
        <script src="{{ asset('sneat') }}/assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="{{ asset('sneat') }}/assets/js/dashboards-analytics.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.rupiah').mask("#.##0", {
                    reverse: true
                });
                $('.select2').select2();
            });
        </script>
    </body>

</html>

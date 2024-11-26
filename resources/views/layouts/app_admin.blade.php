<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free" lang="en" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>{{ @$title != '' ? "$title |" : '' }} {{ settings()->get('nama_sistem', 'SiAKeu') }}</title>
        <meta name="description" content="" />

        <!-- Favicon -->
        <link type="image/x-icon" href="{{ asset('img/logo-sma.png') }}" rel="icon" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Core CSS -->
        <link href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" rel="stylesheet" />
        <link class="template-customizer-core-css" href="{{ asset('sneat') }}/assets/vendor/css/core.css"
            rel="stylesheet" />
        <link class="template-customizer-theme-css" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css"
            rel="stylesheet" />
        <link href="{{ asset('sneat') }}/assets/css/demo.css" rel="stylesheet" />
        <link href="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" />
        <link href="{{ asset('icon/css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('sneat') }}/assets/vendor/js/helpers.js"></script>
        <script src="{{ asset('sneat') }}/assets/js/config.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        {{-- {!! $dashboardChart->cdn() ?? '' !!} --}}

        <!-- Custom Styles -->
        <style>
            .layout-navbar .navbar-dropdown .dropdown-menu {
                min-width: 22rem;
            }

            .custom-select-wrapper {
                position: relative;
            }

            .custom-select-wrapper::after {
                content: "\f078";
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                position: absolute;
                top: 50%;
                right: 15px;
                transform: translateY(-50%);
                pointer-events: none;
            }

            .custom-select {
                padding-right: 30px;
            }

            .input-search-wrapper {
                position: relative;
            }

            .input-search-wrapper::before {
                content: "\f002";
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                position: absolute;
                top: 50%;
                left: 10px;
                transform: translateY(-50%);
                pointer-events: none;
                color: #aaa;
            }

            .input-search {
                padding-left: 30px;
            }

            .menu-item.active>a,
            .menu-item.active>a:hover {
                background-color: #007bff;
                color: white;
            }

            .menu-sub .active>a {
                background-color: #f0f0f0;
            }
        </style>
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <aside class="layout-menu menu-vertical menu bg-menu-theme" id="layout-menu">
                    <div class="app-brand demo">
                        <a class="app-brand-link" href="{{ route('admin.dashboard') }}">
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
                        <li class="menu-item {{ \Route::is('admin.dashboard') ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('admin.dashboard') }}">
                                <i class="menu-icon tf-icons fa fa-gauge"></i>
                                <div data-i18n="Analytics">Dashboard</div>
                            </a>
                        </li>

                        <!-- Layouts -->
                        <li
                            class="menu-item {{ \Route::is('user.*') ||
                            \Route::is('tahun_ajaran.*') ||
                            \Route::is('kelas.*') ||
                            \Route::is('siswa.*') ||
                            \Route::is('wali.*') ||
                            \Route::is('arsiptag.*')
                                ? 'active open'
                                : '' }}">
                            <a class="menu-link menu-toggle" href="">
                                <i class="menu-icon tf-icons fa fa-database"></i>
                                <div data-i18n="Layouts">Master Data</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="{{ \Route::is('user.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('user.index') }}">
                                        <i class="menu-icon tf-icons fa fa-user" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Pengguna</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('tahun_ajaran.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('tahun_ajaran.index') }}">
                                        <i class="menu-icon tf-icons fa fa-calendar" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Tahun Ajaran</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('kelas.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('kelas.index') }}">
                                        <i class="menu-icon tf-icons fa fa-rocket" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Kelas</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('siswa.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('siswa.index') }}">
                                        <i class="menu-icon tf-icons fa fa-users" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Siswa</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('wali.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('wali.index') }}">
                                        <i class="menu-icon tf-icons fa fa-user-group" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Wali Siswa</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('arsiptag.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('arsiptag.index') }}">
                                        <i class="menu-icon tf-icons fa fa-folder-open" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Arsip</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="menu-item {{ \Route::is('banksekolah.*') || \Route::is('tagihan.*') || \Route::is('pembayaran.*') ? 'active open' : '' }}">
                            <a class="menu-link menu-toggle" href="#">
                                <i class="menu-icon tf-icons fa fa-money-bill-wave"></i>
                                <div data-i18n="Layouts">Keuangan</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="{{ \Route::is('banksekolah.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('banksekolah.index') }}">
                                        <i class="menu-icon tf-icons fa fa-school" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Rekening Sekolah</div>
                                    </a>
                                </li>
                                {{--  <li class="{{ \Route::is('jp.*')? 'active' : '' }}">
                  <a href="{{ route('jp.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-money-bill-transfer" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Jenis Pembayaran</div>
                  </a>
                </li>  --}}
                                <li class="{{ \Route::is('tagihan.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('tagihan.index') }}">
                                        <i class="menu-icon tf-icons fa fa-file-invoice" style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Tagihan</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('pembayaran.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('pembayaran.index') }}">
                                        <i class="menu-icon tf-icons fa fa-money-bill-alt"
                                            style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">
                                            Konfirmasi Pembayaran
                                            <span
                                                class="badge rounded-pill badge-dot badge-notifications {{ auth()->user()->unreadNotifications->count() > 0 ? 'bg-danger' : 'bg-secondary' }} border">
                                                {{ auth()->user()->unreadNotifications->count() }}
                                            </span>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="menu-item {{ \Route::is('pemasukan.*') || \Route::is('pengeluaran.*') || \Route::is('kas.*') ? 'active open' : '' }}">
                            <a class="menu-link menu-toggle" href="">
                                <i class="menu-icon tf-icons fa fa-calculator"></i>
                                <div data-i18n="Layouts">Kas</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="{{ \Route::is('pemasukan.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('pemasukan.index') }}">
                                        <i class="menu-icon tf-icons fa fa-sort-amount-up"
                                            style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Pemasukan</div>
                                    </a>
                                </li>
                                <li class="{{ \Route::is('pengeluaran.*') ? 'active' : '' }}">
                                    <a class="menu-link" href="{{ route('pengeluaran.index') }}">
                                        <i class="menu-icon tf-icons fa fa-sort-amount-down"
                                            style="font-size: 1em;"></i>
                                        <div data-i18n="Basic">Pengeluaran</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item {{ \Route::is('laporanform.*') ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('laporanform.create') }}">
                                <i class="menu-icon tf-icons fa fa-book"></i>
                                <div data-i18n="Basic">Laporan</div>
                            </a>
                        </li>

                        <li class="menu-item {{ \Route::is('setting.*') ? 'active' : '' }}"
                            style="justify-content: space-between">
                            <a class="menu-link" href="{{ route('setting.create') }}">
                                <i class="menu-icon tf-icons fa fa-gear"></i>
                                <div data-i18n="Basic">Pengaturan</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('logout.manual') }}">
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
                                <li class="nav-item lh-1 me-3">
                                    {{--  <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >  --}}
                                </li>

                                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-xl-2 me-3">
                                    <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" href="javascript:void(0);" aria-expanded="true">
                                        <span class="position-relative">
                                            <i class="bx bx-bell bx-md"></i>
                                            <span
                                                class="badge rounded-pill badge-dot badge-notifications {{ auth()->user()->unreadNotifications->count() > 0 ? 'bg-danger' : 'bg-secondary' }} border">
                                                {{ auth()->user()->unreadNotifications->count() }}
                                            </span>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-0" data-bs-popper="static">
                                        <li class="dropdown-menu-header border-bottom">
                                            <div class="dropdown-header d-flex align-items-center py-3">
                                                <h6 class="mb-0 me-auto">Notification</h6>
                                                <div class="d-flex align-items-center h6 mb-0">
                                                    <span class="badge bg-label-primary me-2"></span>
                                                    <a class="dropdown-notifications-all p-2" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-original-title="Mark all as read"
                                                        href="javascript:void(0)" aria-label="Mark all as read"><i
                                                            class="bx bx-envelope-open text-heading"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown-notifications-list scrollable-container ps">
                                            <ul class="list-group list-group-flush">
                                                @foreach (auth()->user()->unreadNotifications as $notification)
                                                    <li
                                                        class="list-group-item list-group-item-action dropdown-notifications-item">
                                                        <a
                                                            href="{{ url($notification->data['url'] . '?=' . $notification->id) }}">
                                                            <div class="d-flex">
                                                                <div class="flex-grow-1">
                                                                    <h6 class="small mb-0">
                                                                        {{ $notification->data['title'] }}</h6>
                                                                    <small
                                                                        class="d-block text-body mb-1">{{ ucwords($notification->data['messages']) }}</small>
                                                                    <small
                                                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                                </div>
                                                                <div
                                                                    class="dropdown-notifications-actions flex-shrink-0">
                                                                    <a class="dropdown-notifications-read"
                                                                        href="javascript:void(0)"><span
                                                                            class="badge badge-dot"></span></a>
                                                                    <a class="dropdown-notifications-archive"
                                                                        href="javascript:void(0)"><span
                                                                            class="bx bx-x"></span></a>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                <div class="ps__thumb-x" tabindex="0"
                                                    style="left: 0px; width: 0px;"></div>
                                            </div>
                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                <div class="ps__thumb-y" tabindex="0"
                                                    style="top: 0px; height: 0px;"></div>
                                            </div>
                                        </li>
                                        <li class="border-top">
                                            <div class="d-grid p-4">
                                                <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                                    <small class="align-middle">View all notifications</small>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

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
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">Profil Saya</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout.manual') }}">
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
                    <!-- / Navbar -->
                    @if (isset($activeYear))
                        <div class="container mt-2">
                            <div class="alert alert-info">
                                <span>Tahun Ajaran Saat Ini :
                                    {{ $activeYear->tahun_ajaran ?? 'Belum ada tahun ajaran aktif' }}</span>
                            </div>
                        </div>
                    @endif

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
                            @yield('js')
                        </div>
                        <!-- / Content -->

                        {{--  <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
@@ -518,19 +494,19 @@ class="footer-link me-4"
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
@@ -539,36 +515,30 @@ class="btn btn-danger btn-buy-now"
      >
    </div>  --}}

        <!-- Core JS -->
        <script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/js/bootstrap.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>

        <!-- Main JS -->
        <script src="{{ asset('sneat') }}/assets/js/main.js"></script>
        <script src="{{ asset('sneat') }}/assets/js/dashboards-analytics.js"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
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

        @stack('scripts')
        {{-- {!! $dashboardChart->script() ?? '' !!} --}}
    </body>

</html>


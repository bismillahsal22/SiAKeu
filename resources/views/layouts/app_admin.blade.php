<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>
      {{ @$title != '' ? "$title |" : '' }}
      {{ settings()->get('nama_sistem', 'SiAKeu') }}
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-sma.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('sneat') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat') }}/assets/js/config.js"></script>
    <link rel="stylesheet" href="{{ asset('icon/css/all.css') }}">
    <style>
      .layout-navbar .navbar-dropdown .dropdown-menu{
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

    /*mengaktifkan sub-menu*/
    .menu-item.active > a,
    .menu-item.active > a:hover {
      background-color: #007bff;
      color: white;
    }

    .menu-sub .active > a {
      background-color: #f0f0f0;
    }
  </style>

    </style>
    <script>
      popupCenter = ({url, title, w, h}) => {
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;
    
        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add LarapexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/larapex-charts"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
              <img src="{{ asset('img/logo-sma.png') }}" style="width: 70px">
              <span class="demo menu-text fw-bolder ms-2" style="font-size: 25px">SiAKeu</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <ul class="menu-inner py-1">
            
            <!-- Dashboard -->
            <li class="menu-item {{ \Route::is('admin.dashboard')? 'active' : '' }}">
              <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons fa fa-gauge"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Layouts -->
            <li class="menu-item
              {{ \Route::is('user.*') ||
                \Route::is('tahun_ajaran.*') ||
                \Route::is('kelas.*') ||
                \Route::is('siswa.*') ||
                \Route::is('wali.*') ||
                \Route::is('arsiptag.*')? 'active open' : ''
              }}">
              <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa fa-database"></i>
                <div data-i18n="Layouts">Master Data</div>
              </a>

              <ul class="menu-sub">
                <li class="{{ \Route::is('user.*')? 'active' : '' }}">
                  <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-user" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Pengguna</div>
                  </a>
                </li>
                <li class="{{ \Route::is('tahun_ajaran.*')? 'active' : '' }}">
                  <a href="{{ route('tahun_ajaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-calendar" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Tahun Ajaran</div>
                  </a>
                </li>
                <li class="{{ \Route::is('kelas.*')? 'active' : '' }}">
                  <a href="{{ route('kelas.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-rocket" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Kelas</div>
                  </a>
                </li>
                <li class="{{ \Route::is('siswa.*')? 'active' : '' }}">
                  <a href="{{ route('siswa.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-users" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Siswa</div>
                  </a>
                </li>
                <li class="{{ \Route::is('wali.*')? 'active' : '' }}">
                  <a href="{{ route('wali.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-user-group" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Wali Siswa</div>
                  </a>
                </li>
                <li class="{{ \Route::is('arsiptag.*')? 'active' : '' }}">
                  <a href="{{ route('arsiptag.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-folder-open" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Arsip</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item
              {{  \Route::is('banksekolah.*') || \Route::is('tagihan.*') || \Route::is('pembayaran.*')? 'active open' : '' }}">
              <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa fa-money-bill-wave"></i>
                <div data-i18n="Layouts">Keuangan</div>
              </a>
              <ul class="menu-sub">
                <li class="{{ \Route::is('banksekolah.*')? 'active' : '' }}">
                  <a href="{{ route('banksekolah.index') }}" class="menu-link">
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
                <li class="{{ \Route::is('tagihan.*')? 'active' : '' }}">
                  <a href="{{ route('tagihan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-file-invoice" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Tagihan</div>
                  </a>
                </li>
                <li class="{{ \Route::is('pembayaran.*')? 'active' : '' }}">
                  <a href="{{ route('pembayaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-money-bill-alt" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">
                      Konfirmasi Pembayaran
                      <span class="badge rounded-pill badge-dot badge-notifications border
                        {{ auth()->user()->unreadNotifications->count() > 0 ? 'bg-danger' : 'bg-secondary' }}">
                        {{ auth()->user()->unreadNotifications->count() }}
                      </span>
                    </div>
                  </a>
                </li>
                
              </ul>
            </li>
            <li class="menu-item 
              {{ 
                \Route::is('pemasukan.*') || 
                \Route::is('pengeluaran.*') || 
                \Route::is('kas.*') ? 'active open' : '' 
              }}">
              <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa fa-calculator"></i>
                <div data-i18n="Layouts">Kas</div>
              </a>
              <ul class="menu-sub">
                <li class="{{ \Route::is('pemasukan.*')? 'active' : '' }}">
                  <a href="{{ route('pemasukan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-sort-amount-up" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Pemasukan</div>
                  </a>
                </li>
                <li class="{{ \Route::is('pengeluaran.*')? 'active' : '' }}">
                  <a href="{{ route('pengeluaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa fa-sort-amount-down" style="font-size: 1em;"></i>
                    <div data-i18n="Basic">Pengeluaran</div>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="menu-item {{ \Route::is('laporanform.*')? 'active' : '' }}">
              <a href="{{ route('laporanform.create') }}" class="menu-link">
                <i class="menu-icon tf-icons fa fa-book"></i>
                <div data-i18n="Basic">Laporan</div>
              </a>
            </li>

            <li class="menu-item {{ \Route::is('setting.*')? 'active' : '' }}" style="justify-content: space-between">
              <a href="{{ route('setting.create') }}" class="menu-link">
                <i class="menu-icon tf-icons fa fa-gear"></i>
                <div data-i18n="Basic">Pengaturan</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('logout.manual') }}" class="menu-link">
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

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                {!! Form::open(['route' => 'tagihan.index', 'method' => 'GET']) !!}
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Cari Tagihan"
                    aria-label="Search..."
                    name="q"
                    value="{{ request('q') }}"
                  />
                </div>
                {!! Form::close() !!}
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
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
                
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                    <span class="position-relative">
                      <i class="bx bx-bell bx-md"></i>
                      <span class="badge rounded-pill badge-dot badge-notifications border
                        {{ auth()->user()->unreadNotifications->count() > 0 ? 'bg-danger' : 'bg-secondary' }}">
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
                          <a href="javascript:void(0)" class="dropdown-notifications-all p-2" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i class="bx bx-envelope-open text-heading"></i></a>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container ps">
                      <ul class="list-group list-group-flush">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <a href="{{ url($notification->data['url'] . '?=' . $notification->id) }}">
                          <div class="d-flex">
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">{{ $notification->data['title'] }}</h6>
                              <small class="mb-1 d-block text-body">{{ ucwords($notification->data['messages']) }}</small>
                              <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                            </div>
                          </div>
                        </a>
                        </li>
                        @endforeach
                      </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
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
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ \Storage::url('image/user.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ \Storage::url('image/user.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ Auth()->user()->name }}</span>
                            <small class="text-muted">{{ Auth()->user()->email }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('user.edit', auth()->user()->id) }}">
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
          <div class="container mt-2">
            <div class="alert alert-info">
              <span>Tahun Ajaran Saat Ini : {{ $activeYear->tahun_ajaran ?? 'Belum ada tahun ajaran aktif' }}</span>
            </div>
          </div>
          

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              @if($errors->any())
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
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $('.rupiah').mask("#.##0", {
          reverse: true});
        $('.select2').select2();
      });
    </script>
  </body>
</html>

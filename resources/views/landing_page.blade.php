<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('img/logo-sma.png') }}" type="image/png">
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="container">
                <a href="" class="logo">
                    <img src="{{ asset('img/logo-sma.png') }}" alt="Logo">
                    <span class="logo-text">SiAKeu</span>
                </a>
                <div class="button-group">
                    <a href="{{ route('login.operator') }}" class="btn btn-primary">Login Operator</a>
                    <a href="{{ route('login.admin') }}" class="btn btn-primary">Login Administrator</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Daftar Administrator</a>
                </div>
            </div>
        </nav>
        <main class="body">
            <div class="container">
                <div class="column1">
                    <div class="content">
                        <h2>SELAMAT DATANG DI<br> SISTEM ADMINISTRASI KEUANGAN <br> SMA NEGERI 1 SEYEGAN</h2>
                        <p>Silahkan membuat akun untuk Wali Siswa
                            Pembayaran dan Monitoring Sumbangan Sukarela Orang Tua Putra Putri Anda.
                        </p>
                        <div class="button-group">
                            <a href="{{ route('register.wali.show') }}" class="btn btn-secondary">Daftar Wali Siswa</a>
                            <a href="{{ route('login.wali') }}" class="btn btn-primary">Login Wali Siswa</a>
                        </div>
                    </div>
                </div>
                <div class="column2">
                    <div class="content">
                        <img src="{{ asset('img/logo-sma.png') }}" alt="">
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="footer">
        <div class="container">
          <p>&copy; Copyright 2024
        </p>
        </div>
    </footer>
</body>
</html>
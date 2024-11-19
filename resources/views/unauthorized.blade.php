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
                    <a href="{{ route('logout') }}" class="btn btn-primary">kembali Ke Halaman Awal</a>

                </div>
            </div>
        </nav>


    </div>


</body>

</html>
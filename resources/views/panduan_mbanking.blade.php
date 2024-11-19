@extends('layouts.app_blank')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #4CAF50;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            border-bottom: 2px solid #fff;
        }
        header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        ol {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        li {
            margin-bottom: 20px;
            padding-left: 20px;
            position: relative;
        }
        .highlight {
            background-color: #e7f7e7;
            border-left: 5px solid #4CAF50;
            padding: 10px;
            margin-bottom: 15px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: #fff;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
        }
        .icon {
            font-size: 24px;
            color: #4CAF50;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Panduan Pembayaran via Mobile Banking</h1>
        </div>
    </header>

    <div class="container">
        <div class="content">
            <h2>Langkah-langkah Pembayaran:</h2>
            <ol>
                <li>
                    <i class="fas fa-mobile-alt icon"></i>
                    <strong>Buka Aplikasi Mobile Banking:</strong>
                    Akses aplikasi mobile banking Anda dari ponsel. Pastikan Anda sudah login dengan kredensial yang benar.
                </li>
                <li>
                    <i class="fas fa-credit-card icon"></i>
                    <strong>Pilih Menu Pembayaran:</strong>
                    Di dalam aplikasi, cari dan pilih menu "Pembayaran" atau "Tagihan".
                </li>
                <li>
                    <i class="fas fa-tags icon"></i>
                    <strong>Pilih Jenis Pembayaran:</strong>
                    Pilih jenis pembayaran yang ingin Anda lakukan, seperti "Tagihan Listrik", "Telepon", atau "Pajak".
                </li>
                <li>
                    <i class="fas fa-file-alt icon"></i>
                    <strong>Masukkan Nomor Referensi:</strong>
                    Input nomor referensi atau ID pembayaran yang diberikan oleh penyedia layanan atau tercantum di tagihan Anda.
                </li>
                <li>
                    <i class="fas fa-money-bill-alt icon"></i>
                    <strong>Masukkan Jumlah Pembayaran:</strong>
                    Isi jumlah yang akan dibayar sesuai dengan tagihan yang tertera.
                </li>
                <li>
                    <i class="fas fa-check-circle icon"></i>
                    <strong>Verifikasi Detail Pembayaran:</strong>
                    Periksa kembali detail pembayaran Anda untuk memastikan semuanya benar sebelum melanjutkan.
                </li>
                <li>
                    <i class="fas fa-check-square icon"></i>
                    <strong>Konfirmasi Pembayaran:</strong>
                    Setelah memeriksa detailnya, konfirmasikan pembayaran dan tunggu hingga aplikasi mengonfirmasi transaksi.
                </li>
                <li>
                    <i class="fas fa-print icon"></i>
                    <strong>Simpan Bukti Pembayaran:</strong>
                    Simpan atau ambil tangkapan layar bukti pembayaran untuk referensi di masa depan.
                </li>
            </ol>

            <div class="highlight">
                <h3>Tips:</h3>
                <p>Pastikan Anda melakukan transaksi di jaringan internet yang aman dan tidak membagikan informasi akun Anda kepada pihak lain.</p>
            </div>
        </div>
    </div>

@endsection

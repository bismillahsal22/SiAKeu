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
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
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
            display: flex;
            align-items: center;
        }
        .icon {
            font-size: 30px;
            color: #4CAF50;
            margin-right: 15px;
        }
        .description {
            flex: 1;
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
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Panduan Pembayaran via ATM</h1>
        </div>
    </header>

    <div class="container">
        <div class="content">
            <h2>Langkah-langkah Pembayaran:</h2>
            <ol>
                <li>
                    <i class="fas fa-credit-card icon"></i>
                    <div class="description">
                        <strong>Masukkan Kartu ATM:</strong> 
                        Masukkan kartu ATM Anda ke dalam mesin ATM dan masukkan PIN Anda dengan benar.
                    </div>
                </li>
                <li>
                    <i class="fas fa-list-alt icon"></i>
                    <div class="description">
                        <strong>Pilih Menu Pembayaran:</strong>
                        Pada layar utama, pilih menu "Pembayaran" atau "Transaksi".
                    </div>
                </li>
                <li>
                    <i class="fas fa-tags icon"></i>
                    <div class="description">
                        <strong>Pilih Jenis Pembayaran:</strong>
                        Pilih jenis pembayaran yang sesuai, misalnya "Tagihan", "Telepon", atau "Lainnya".
                    </div>
                </li>
                <li>
                    <i class="fas fa-hashtag icon"></i>
                    <div class="description">
                        <strong>Masukkan Nomor Referensi:</strong>
                        Masukkan nomor referensi atau ID pembayaran yang diberikan oleh penyedia layanan.
                    </div>
                </li>
                <li>
                    <i class="fas fa-dollar-sign icon"></i>
                    <div class="description">
                        <strong>Masukkan Jumlah Pembayaran:</strong>
                        Masukkan jumlah yang akan dibayar sesuai dengan tagihan Anda.
                    </div>
                </li>
                <li>
                    <i class="fas fa-check icon"></i>
                    <div class="description">
                        <strong>Verifikasi Transaksi:</strong>
                        Periksa kembali detail pembayaran Anda untuk memastikan semuanya benar. Pilih "Ya" untuk melanjutkan.
                    </div>
                </li>
                <li>
                    <i class="fas fa-thumbs-up icon"></i>
                    <div class="description">
                        <strong>Konfirmasi Pembayaran:</strong>
                        Setelah memeriksa detailnya, konfirmasikan pembayaran dan tunggu hingga mesin mengonfirmasi transaksi.
                    </div>
                </li>
                <li>
                    <i class="fas fa-receipt icon"></i>
                    <div class="description">
                        <strong>Ambil Struk:</strong>
                        Ambil struk yang dikeluarkan oleh mesin ATM sebagai bukti transaksi. Simpan struk tersebut untuk referensi.
                    </div>
                </li>
            </ol>

            <div class="highlight">
                <h3>Tips:</h3>
                <p>Selalu pastikan Anda berada di lingkungan yang aman saat melakukan transaksi. Jangan pernah membagikan PIN Anda kepada siapa pun.</p>
            </div>
        </div>
    </div>
</html>
@endsection

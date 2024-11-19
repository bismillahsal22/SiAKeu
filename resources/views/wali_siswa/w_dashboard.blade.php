@extends('layouts.app_template_wali')

@section('content')
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h4 class="card-title text-primary fw-bold">SELAMAT DATANG WALI SISWA, {{ auth()->user()->name }}</h4>
                        <p class="mb-4">
                            Kamu mendapatkan <span class="text-danger fw-bold">{{ auth()->user()->unreadNotifications->count() }}</span> 
                            notifikasi yang belum dilihat. Klik tombol di bawah ini untuk melihat informasi pembayaran  <span class="fw-bold">via Transfer</span>
                        </p>
                        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-primary btn-sm">Lihat Tagihan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

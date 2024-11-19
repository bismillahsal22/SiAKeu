@extends('layouts.app_auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-5 d-flex justify-content-center align-items-center flex-column left-box" style="background: #109490;">
                <h3 class="text-white text-center">Sistem Administrasi Keuangan</h3>
                <div class="feature-image mb-3">
                    <img src="img\logo-sma.png" class="img-fluid" style="width: 250px;">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    @if ($errors->any())
                        @foreach ($errors->all() as $err )
                            <p class="alert alert-danger">{{ $err }}</p>  
                        @endforeach
                    @endif

                    <h3 class="text-center mb-4" style="font-weight: bold;">@yield('title', $title)</h3>
                    
                    <form method="POST" action="{{ route('daftar_akun.action') }}">
                        @csrf
                        <div class="mb-2" style="font-size: 14px">
                            <label>Nama <span class="text-danger"></span></label>
                            <input type="text" class="form-control form-control bg-light" name="nama" value="{{ old('nama') }}">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label>Username <span class="text-danger"></span></label>
                            <input type="text" class="form-control form-control bg-light" name="username" value="{{ old('username') }}">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label>Password <span class="text-danger"></span></label>
                            <input type="password" class="form-control form-control bg-light" name="password">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label>Konfirmasi Password <span class="text-danger"></span></label>
                            <input type="password" class="form-control form-control bg-light" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">@yield('title', $title)</button>
                        </div>
                        <div class="row">
                            <small class="text-center">Sudah memiliki Akun?<a href="{{ route('login') }}">Masuk</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
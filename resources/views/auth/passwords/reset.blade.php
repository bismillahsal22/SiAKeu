@extends('layouts.app_auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-5 d-flex justify-content-center align-items-center flex-column left-box" style="background: #109490;">
                <h3 class="text-white text-center mt-3" style="font-weight: 600;">SiAKeu <br>SMA Negeri 1 Seyegan</h3>
                <div class="feature-image mb-3">
                    <img src="{{ asset('img/logo-sma.png') }}" class="img-fluid" style="width: 250px;">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    @if(session('success'))
                        <p class="alert alert-success">{{ session('success')}}</p>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $err )
                            <p class="alert alert-danger">{{ $err }}</p>  
                        @endforeach
                    @endif

                    <h3 class="text-center mt-5" style="font-weight: bold;">Lupa Password</h3>
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="container mt-3">
                            <div class="mb-2" style="font-size: 14px;">
                                <label for="email" class="form-label">Email<span class="text-danger"></span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email yang sudah terdaftar" style="font-size: 12px" autofocus>
                            </div>
                            <div class="mb-2" style="font-size: 14px">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control bg-light" name="password">
                            </div>
                            <div class="mb-2" style="font-size: 14px">
                                <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control bg-light" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Reset Password</button>
                            </div>
                            <div class="row">
                                <small class="text-center">Silahkan Masuk Akun Anda Kembali?<a href="{{ route('login') }}">Masuk</a></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
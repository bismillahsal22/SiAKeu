@extends('layouts.app_auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-5 d-flex justify-content-center align-items-center flex-column left-box" style="background: #109490;">
                <h2 class="text-white text-center" style="font-weight: 600;">Selamat Datang<br>Wali Siswa</h2>
                <div class="feature-image mb-3">
                    <img src="img\logo-sma.png" class="img-fluid" style="width: 250px;">
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

                    <h3 class="text-center mb-4" style="font-weight: bold;">Login<br>Wali Siswa</h3>
                    
                    <form method="POST" action="{{ route('postloginwali') }}">
                        @csrf
                        <div class="mb-2" style="font-size: 14px">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control bg-light" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control bg-light" name="password">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Ingatkan Saya</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="{{ route('password.request') }}">Lupa Password?</a></small>
                            </div>                         
                        </div>
                        <div class="row">
                            <small class="text-center">Sudah memiliki Akun?<a href="{{ route('register.wali.show') }}">Daftar Akun</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
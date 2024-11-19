@extends('layouts.app_auth')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-5 d-flex justify-content-center align-items-center flex-column left-box" style="background: #109490;">
                <h2 class="text-white text-center" style="font-weight: 600;">Selamat Datang,<br>Operator SiAKeu</h2>
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

                    <h3 class="text-center mb-4" style="font-weight: bold;">Login<br>Operator</h3>
                    
                    <form method="POST" action="{{ route('postloginoperator') }}">
                        @csrf
                        <div class="mb-2" style="font-size: 14px">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control bg-light" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control bg-light" name="password">
                        </div>
                        <div class="mb-2" style="font-size: 14px">
                            <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Tahun Ajaran',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
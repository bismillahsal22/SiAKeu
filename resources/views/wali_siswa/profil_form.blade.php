@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}          
                    <div class="row">
                        <label for="name" class="col-sm-2">Nama</label>
                        <div class="form-input col-sm-10">
                            {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nohp" class="col-sm-2">Nomor Handphone</label>
                        <div class="col-sm-10">
                            {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nohp') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="email" class="col-sm-2">Email</label>
                        <div class="col-sm-10">
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="basic-default-password32" class="col-md-2">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="basic-default-password32" placeholder="············" aria-describedby="basic-default-password">
                                <span class="input-group-text cursor-pointer" id="basic-default-password">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    @if(\Route::is('user.create'))
                    <div class="row mt-3">
                        <label for="akses" class="col-sm-2">Akses</label>   
                        <div class="col-sm-10">
                            {!! Form::select(
                                'akses', 
                                [
                                    'operator' => 'Operator Sekolah',
                                    'admin' => 'Administrator',
                                    'wali' => 'Wali Siswa'
                                ],
                                null,
                                ['class' => 'form-control'],
                                ) !!}
                            <span class="text-danger">{{ $errors->first('akses') }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger"><a href="{{ route('wali.w_dashboard') }}" style="color: white">Batal</a></button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

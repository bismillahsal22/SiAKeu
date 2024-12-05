@extends('layouts.app_admin')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header" style="font-weight: 900"><i class="fa fa-gear"></i> Pengaturan Sistem</h5>
                <div class="card-body">                 
                    <div class="container">
                        {!! Form::open([
                            'route' => 'setting.store',
                            'method' => 'POST'
                        ]) !!}
                        <div class="divider">
                            <div class="divider-text" style="color: #109490;; font-size:18px; font-weight:bold"><i class="fa fa-info-circle"></i> Informasi Sekolah</div>
                        </div>
                        <div class="row mt-2">
                                <label for="nama_app" class="col-md-2">Nama Sekolah</label>
                                <div class="col-md-10">
                                    {!! Form::text('nama_app', settings()->get('nama_app'), ['class' => 'form-control', 'autofocus']) !!}
                                    <span class="text-danger">{{ $errors->first('nama_app') }}</span>
                                </div>
                        </div>
                        <div class="row mt-2">
                            <label for="akreditasi" class="col-md-2">Akreditasi Sekolah</label>
                            <div class="col-md-10">
                                {!! Form::text('akreditasi', settings()->get('akreditasi'), ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('akreditasi') }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="web" class="col-md-2">Website Sekolah</label>
                            <div class="col-md-10">
                                {!! Form::text('web', settings()->get('web'), ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('web') }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                                <label for="email" class="col-md-2">Email Sekollah</label>
                                <div class="col-md-10">
                                    {!! Form::text('email', settings()->get('email'), ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                        <div class="row mt-2">
                            <label for="hp_app" class="col-md-2">Telepon Sekolah</label>
                            <div class="col-md-10">
                                {!! Form::number('hp_app', settings()->get('hp_app'), ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('hp_app') }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="alamat_app" class="col-md-2">Alamat Lengkap</label>
                            <div class="col-md-10">
                                {!! Form::textarea('alamat_app', settings()->get('alamat_app'), ['class' => 'form-control', 'rows' => '2']) !!}
                                <span class="text-danger">{{ $errors->first('alamat_app') }}</span>
                            </div>
                        </div>
                              
                        <div class="divider">
                            <div class="divider-text" style="color: #007bff; font-size:18px; font-weight:bold"><i class="fa fa-info-circle"></i> Informasi Sistem</div>
                        </div>
                        <div class="row mt-2">
                             <label for="nama_sistem" class="col-md-2">Nama Sistem</label>
                             <div class="col-md-10">
                                {!! Form::text('nama_sistem', settings()->get('nama_sistem'), ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('nama_sistem') }}</span>
                             </div>
                        </div>
                        <div class="row mt-2">
                            <label for="pagination_app" class="col-md-2">Data Setiap Halaman</label>
                            <div class="col-md-10">
                                {!! Form::number('pagination_app', settings()->get('pagination_app'), ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('pagination_app') }}</span>
                            </div>
                        </div>
                        <div class="text-center mt-1">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary mt-3']) !!}
                        </div>
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

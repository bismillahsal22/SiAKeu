@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}   
                    <div class="row">
                        <label for="tanggal" class="col-sm-2">Tanggal</label>
                        <div class="form-input col-sm-10">    
                            {!! Form::date('tanggal', $model->tanggal ? $model->tanggal->format('Y-m-d') : null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="jumlah" class="col-sm-2">Nominal</label>
                        <div class="col-sm-10">
                            {!! Form::text('jumlah', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="keterangan" class="col-sm-2">Keterangan</label>
                        <div class="col-sm-10">
                            {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="jenis" class="col-sm-2">Jenis</label>
                        <div class="col-sm-10">
                            {!! Form::text('jenis', $jenis, ['class' => 'form-control', 'readonly' => true]) !!}
                            <span class="text-danger">{{ $errors->first('jenis') }}</span>
                        </div>
                    </div>
                    @if($model->foto != null)
                        <div class="m-3">
                            <img src="{{ \Storage::url($model->foto) }}" alt="" width="100" class="img-thumbnail">
                        </div>
                    @endif
                    <div class="row mt-3">
                        <label for="foto" class="col-sm-2">Upload Bukti</label>
                        <div class="form-input col-sm-10">
                            <span class="text-danger fw-bold">(Format: jpg, jpeg, png, Ukuran Maks: 5MB)</span>
                            {!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        </div>
                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger">
                            <a href="{{ $jenis == 'pemasukan' ? route('pemasukan.index') : route('pengeluaran.index') }}" style="color: white">Batal</a>
                        </button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
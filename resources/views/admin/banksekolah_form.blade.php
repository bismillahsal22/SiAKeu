@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!} 
                    <div class="row">
                        <label for="bank_id" class="col-sm-3">Nama Bank</label>
                        <div class="form-input col-sm-9">
                            {!! Form::select('bank_id', $listBank, null, ['class' => 'form-control select2']) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nama_rekening" class="col-sm-3">Nama Pemilik Rekening</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('nama_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nomor_rekening" class="col-sm-3">Nomor Rekening</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('nomor_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                        </div>
                    </div>                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger"><a href="{{ route('banksekolah.index') }}" style="color: white">Batal</a></button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

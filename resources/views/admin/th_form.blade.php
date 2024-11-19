@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}           
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran <span class="text-danger fw-bold">   (Format Tahun Ajaran .../..)</span></label>
                        {!! Form::text('tahun_ajaran', null, ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="tgl_mulai">Tanggal Mulai Tahun Ajaran</label>
                            {!! Form::date('tgl_mulai', $model->tgl_mulai ? $model->tgl_mulai->format('Y-m-d') : null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tgl_mulai') }}</span>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="tgl_akhir">Tanggal Berakhir Tahun Ajaran</label>
                            {!! Form::date('tgl_akhir', $model->tgl_akhir ? $model->tgl_akhir->format('Y-m-d') : null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tgl_akhir') }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger"><a href="{{ route('tahun_ajaran.index') }}" style="color: white">Batal</a></button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

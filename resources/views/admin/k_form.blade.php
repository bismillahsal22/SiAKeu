@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}           
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        {!! Form::text('kelas', null, ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger"><a href="{{ route('kelas.index') }}" style="color: white">Batal</a></button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

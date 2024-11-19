@extends('layouts.app_admin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header fw-bold"><i class="fa fa-folder"></i> {{ $title }}</h5>
            <div class="card-body">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'cetak_arsip.index', 'method' => 'GET', 'target' => 'blank']) !!}
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label for="tahun_ajaran_id" class="fw-bold">Pilih Tahun Ajaran</label>
                        </div>
                        <div class="col-md-3 custom-select-wrapper">
                            {!! Form::select('tahun_ajaran_id', $tahunAjaran, request('tahun_ajaran_id'), [
                                'class' => 'form-control custom-select',
                                'placeholder' => 'Pilih Tahun Ajaran',
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
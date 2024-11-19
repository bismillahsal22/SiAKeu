@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-book-open"></i> {{ $title }}</h5>
                <div class="container">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="fw-bold"><i class="fa fa-file-invoice"></i> Laporan Kas</h6>
                                {!! Form::open(['route' => 'lap_kas.index', 'method' => 'GET', 'target' => 'blank']) !!}
                                    <div class="row gx-2">                                  
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control custom-select', 'placeholder' => 'Pilih Bulan']) !!}
                                        </div>
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('tahun_ajaran_id', $tahun_ajaran, null, [
                                                'class' => 'form-control custom-select',
                                                'placeholder' => 'Pilih Tahun Ajaran',
                                            ]) !!}
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold"><i class="fa fa-file-invoice"></i> Laporan Tagihan</h6>
                                {!! Form::open(['route' => 'laporan_tag.index', 'method' => 'GET', 'target' => 'blank']) !!}
                                    <div class="row gx-2">
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('kelas', $kelas, null, [
                                                'class' => 'form-control custom-select',
                                                'placeholder' => 'Pilih Kelas',
                                            ]) !!}
                                        </div>
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('status', [
                                                '' => 'Pilih Status',
                                                'Lunas' => 'Lunas',
                                                'Baru' => 'Baru',
                                                'Mengangsur' => 'Mengangsur',
                                            ], 
                                            request('status'), 
                                            [
                                                'class' => 'form-control custom-select',
                                            ]) !!}
                                        </div>                                   
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control custom-select', 'placeholder' => 'Pilih Bulan']) !!}
                                        </div>
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('tahun_ajaran_id', $tahun_ajaran, null, [
                                                'class' => 'form-control custom-select',
                                                'placeholder' => 'Pilih Tahun Ajaran',
                                            ]) !!}
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold"><i class="fa fa-money-bill-1"></i> Laporan Pembayaran</h6>
                                {!! Form::open(['route' => 'laporan_bayar.index', 'method' => 'GET', 'target' => 'blank']) !!}
                                    <div class="row gx-2">
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('status', [
                                                '' => 'Pilih Status',
                                                'Sudah_Konfirmasi' => 'Sudah DiKonfirmasi',
                                                'Belum_Konfirmasi' => 'Belum Dikonfirmasi',
                                            ], 
                                            request('status'), 
                                            [
                                                'class' => 'form-control custom-select',
                                            ]) !!}
                                        </div>
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control custom-select', 'placeholder' => 'Pilih Bulan']) !!}
                                        </div>
                                        <div class="custom-select-wrapper col-md-2 col-sm-12">
                                            {!! Form::select('tahun_ajaran_id', $tahun_ajaran, null, [
                                                'class' => 'form-control custom-select',
                                                'placeholder' => 'Pilih Tahun Ajaran',
                                            ]) !!}
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

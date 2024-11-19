@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-info-circle"></i> {{ $title }}</h5>
                <div class="card-body" style="display: flex;">
                    <div class="col-md-6 mr-10">
                        <table>
                            <thead>
                                <tr>
                                    <td>NIS</td>
                                    <td>: {{ $model->nis }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td>: {{ $model->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>: {{ $model->tahunAjaran->tahun_ajaran}}</td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>: {{ $model->ttl }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>: {{ $model->jk }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP</td>
                                    <td>: {{ $model->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ayah</td>
                                    <td>: {{ $model->ayah }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td>: {{ $model->ibu }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat Lengkap</td>
                                    <td>: {{ $model->alamat }}</td>
                                </tr>
                            </thead>
                        </table>
                        <div class="mt-4 mb-4">
                            <button type="submit" class="btn btn-danger"><a href="{{ route('siswa.index') }}" style="color: white">Kembali</a></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ \Storage::url($model->foto ?? 'image/no-image.png') }}" alt="" width="100" class="align-top">
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

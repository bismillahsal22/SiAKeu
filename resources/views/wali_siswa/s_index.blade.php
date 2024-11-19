@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="fw-bold"><i class="fa fa-info-circle"></i> {{ $title }}</h5>
            <div class="row">
                @foreach ($models as $model)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="foot text-center">
                                    <img src="{{ \Storage::url($model->foto ?? 'image/no-image.png') }}" alt="Foto {{ $model->nama }}" width="100" class="mb-2"> 
                                </div>
                                <div class="fw-bold text-center">
                                    {{ strtoupper($model->nama) }}
                                </div>
                                <table class="table mt-2">
                                    <tbody>
                                        <tr>
                                            <td>NIS</td>
                                            <td>: {{ $model->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>: {{ $model->kelas }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Ajaran</td>
                                            <td>: {{ $model->tahunAjaran->tahun_ajaran }}</td>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


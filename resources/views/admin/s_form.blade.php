@extends('layouts.app_admin')

@section('content')
<style>
    .custom-select-drop {
        position: relative;
      }

      .custom-select-drop::after {
          content: "\f078"; 
          font-family: "Font Awesome 5 Free";
          font-weight: 900;
          position: absolute;
          top: 50%;
          right: 30px;
          transform: translateY(-50%);
          pointer-events: none;
      }

      .custom-select {
          padding-right: 30px; 
      }
</style>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">                 
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!} 
                    <div class="row">
                        <label for="wali_id" class="col-sm-3">Nama Wali Siswa <span class="text-danger fw-bold">(Optional)</span></label>
                        <div class="form-input col-sm-9">
                            {!! Form::select('wali_id', $wali, null, [
                                'class' => 'form-control select2', 
                                'placeholder' => 'Pilih Wali Siswa'
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('wali_id') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nama" class="col-sm-3">Nama</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus']) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nis" class="col-sm-3">NIS</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('nis', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nis') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="kelas" class="col-sm-3">Kelas</label>
                        <div class="form-input col-sm-9 custom-select-drop">
                            {!! Form::select('kelas', $kelas, null, [
                            'class' => 'form-control custom-select',
                            'placeholder' => 'Pilih Kelas',
                            ]) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="tahun_ajaran_id" class="col-sm-3">Tahun Ajaran</label>
                        <div class="form-input col-sm-9 custom-select-drop">
                            {!! Form::select('tahun_ajaran_id', $tahun_ajaran_id, null, [
                                'class' => 'form-control custom-select',
                                'placeholder' => 'Pilih Tahun Ajaran'
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tahun_ajaran_id') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="tempat_lahir" class="col-sm-3">Tempat Lahir</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('tempat_lahir', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tempat_lahir') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="tgl_lahir" class="col-sm-3">Tanggal Lahir</label>
                        <div class="form-input col-sm-9">
                            {!! Form::date('tgl_lahir', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tgl_lahir') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="alamat" class="col-sm-3">Alamat</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="nohp" class="col-sm-3">Nomor Handphone Siswa</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nohp') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="jk" class="col-sm-3">Jenis Kelamin</label>
                        <div class="form-input col-sm-9 custom-select-drop">
                            {!! Form::select(
                                'jk', 
                                [
                                    'placeholder' => 'Pilih Jenis Kelamin',
                                    'Laki-Laki' => 'Laki-Laki',
                                    'Perempuan' => 'Perempuan',
                                ],
                                null,
                                ['class' => 'form-control custom-select'],
                                ) !!}
                            <span class="text-danger">{{ $errors->first('jk') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="ayah" class="col-sm-3">Nama Ayah Kandung</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('ayah', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('ayah') }}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <label for="ibu" class="col-sm-3">Nama Ibu Kandung</label>
                        <div class="form-input col-sm-9">
                            {!! Form::text('ibu', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('ibu') }}</span>
                        </div>
                    </div>
                    @if($model->foto != null)
                        <div class="m-3">
                            <img src="{{ \Storage::url($model->foto) }}" alt="" width="100" class="img-thumbnail">
                        </div>
                    @endif
                    <div class="row mt-3">
                        <label for="foto" class="col-sm-3">Foto Siswa</label>
                        <div class="form-input col-sm-9">
                            <span class="text-danger fw-bold">(Format: jpg, jpeg, png, Ukuran Maks: 5MB)</span>
                            {!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        </div>
                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-danger"><a href="{{ route('siswa.index') }}" style="color: white">Batal</a></button>
                        {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

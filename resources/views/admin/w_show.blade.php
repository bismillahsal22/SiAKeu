@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-info-circle"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td colspan="2"style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI AKUN ORANG TUA</td>
                                </tr>
                                <tr>
                                    <td width="220">Nama Wali</td>
                                    <td>: {{ $models->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $models->email }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor HP</td>
                                    <td>: {{ $models->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Dibuat</td>
                                    <td>: {{ $models->created_at->format('d- F -Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Diubah</td>
                                    <td>: {{ $models->created_at->format('d - F - Y') }}</td>
                                </tr>
                            </thead>
                        </table>
                        <h6 class="mt-4 text-center" style="background-color: #109490; padding:10px; color:white; font-weight:bold">TAMBAH DATA ANAK</h6>
                        {!! Form::open(['route' => 'walisiswa.store', 'method' => 'POST']) !!}
                        {!! Form::hidden('wali_id', $models->id, []) !!}
                        
                        <div class="row">
                            <label for="id_siswa" class="col-md-2" style="font-weight: bold">Pilih Siswa : </label>
                            <div class="col-md-8">
                                {!! Form::select('id_siswa', $siswa, null, ['class' => 'form-control select2', 'placeholder' => '-- Pilih Siswa --']) !!}
                                <span class="text-danger">{{ $errors->first('id_siswa') }}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        
                        
                        {!! Form::close() !!}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-4">
                            <thead style="background-color:#109490; color:white;">
                                <tr>
                                    <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">DATA SISWA/ANAK</td>
                                </tr>
                                    <tr>
                                        <td width="1%">No</td>
                                        <td style="font-weight: bold">NIS</td>
                                        <td style="font-weight: bold">Nama</td>
                                        <td style="font-weight: bold">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models->siswa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                {!! Form::open([
                                                    'route' => ['walisiswa.update', $item->id],
                                                    'method' => 'PUT',
                                                    'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                                ]) !!}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

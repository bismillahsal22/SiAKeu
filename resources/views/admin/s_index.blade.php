@extends('layouts.app_admin')
@section('js')
    <script>
        $(document).ready(function(){
            $("#div-import").hide();
            $("#btn-div").click(function(e){
                $("#div-import").toggle();
            });
        });
    </script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header fw-bold"><i class="fa fa-users"></i> {{ $title }} - ({{ $totalSiswa }})</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a style="border-radius: 50px" href="{{ route($routePrefix . '.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                        <a style="border-radius: 50px" href="#" class="btn btn-success mx-1" id="btn-div"><i class="fa fa-upload"></i> Import Excel</a>
                        <a style="border-radius: 50px" href="{{ route('siswa.naikKelas') }}" class="btn btn-secondary">Naikkan Kelas</a>
                    </div>
                    <div class="col-md-6">
                        {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET']) !!}
                            <div class="row justify-content-end gx-2">
                                <div class="input-search-wrapper col-md-3 col-sm-12">
                                    <input type="text" name="q" class="form-control input-search" placeholder="Nama/NIS" aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                                </div>
                                <div class="custom-select-wrapper col-md-2 col-sm-12">
                                    {!! Form::select('kelas', $kelas, request('kelas'), ['class' => 'form-control custom-select', 'placeholder' => 'Kelas']) !!}
                                </div>
                                <div class="custom-select-wrapper col-md-2 col-sm-12">
                                    {!! Form::select('tahun_ajaran', $tahunAjaran, request('tahun_ajaran'), ['class' => 'form-control custom-select', 'placeholder' => 'Tahun Ajaran']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-alt-circle-right"></i></button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="row mt-2" id="div-import">
                    <div class="col-md-6">
                        {!! Form::open(['route' => 'importsiswa.store', 'method' => 'POST', 'files' => true]) !!}
                        <div class="input-group">
                            <input type="file" name="excel" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                            <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>

                <div class="table-responsive mt-2">
                    <table class="table table-striped table-bordered">
                        <thead style="font-weight: 900; background-color:#109490; color:white">
                            <tr>
                                <td width="1%">No</td>
                                <td>NIS</td>
                                <td>Nama</td>
                                <td>Kelas</td>
                                <td>Tahun Ajaran</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($models as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->status_siswa === 'Lulus' ? 'Lulus' : $item->kelas }}</td>
                                    <td>{{ $item->tahunAjaran->tahun_ajaran }}</td>
                                    <td> 
                                        {!! Form::open([
                                            'route' => [$routePrefix . '.destroy', $item->id],
                                            'method' => 'Delete',
                                            'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                        ]) !!}
                                        <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>    
                                        <a href="{{ route($routePrefix . '.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-info"></i> Detail
                                        </a>        
                                        {!! Form::close() !!}
                                        
                                    </td>
                                </tr>
                            @empty
                                <td colspan="6" class="text-center">Data Tidak Ada</td>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $models->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

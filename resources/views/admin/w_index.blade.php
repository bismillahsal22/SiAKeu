@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-user-friends"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a style="border-radius: 50px" href="{{ route($routePrefix . '.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari Berdasarkan Nama Wali Siswa" aria-label="cari wali" aria-describedby="button-addon2" value="{{ request('q') }}">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>Nomor HP</td>
                                    <td>Akses</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->akses }}</td>
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
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
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

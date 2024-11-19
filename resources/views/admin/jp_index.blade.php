@extends('layouts.app_template')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari Jenis Pembayaran" aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ formatRupiah($item->jumlah) }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td> 
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'Delete',
                                                'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>   
                                            {{--  <a href="{{ route($routePrefix . '.create', ['parent_id' => $item->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-info"></i> Detail
                                            </a>           --}}
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4">Data Tidak Ada</td>
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

@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold">{{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a style="border-radius: 50px" href="{{ route($routePrefix . '.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td width="25%">Nama Bank</td>
                                    <td>Kode Transaksi</td>
                                    <td>Pemilik Rekening</td>
                                    <td>Nomor Rekening</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bank }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama_rekening }}</td>
                                        <td>{{ $item->nomor_rekening }}</td>
                                        <td> 
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'Delete',
                                                'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Edit
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

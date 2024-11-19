@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-sort-amount-up"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <a style="border-radius: 50px" href="{{ route('kas.create', ['jenis' => 'pemasukan']) }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="col-md-10">
                            {!! Form::open(['route' => 'pemasukan.index', 'method' => 'GET']) !!}
                            <div class="row justify-content-end gx-2">
                                <div class="custom-select-wrapper col-md-2 col-sm-12">
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control custom-select', 'placeholder' => 'Pilih Bulan']) !!}
                                </div>
                                <div class="custom-select-wrapper col-md-2 col-sm-12">
                                    {!! Form::select('tahun_ajaran_id', $tahunAjaran, null, [
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

                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>Tanggal</td>
                                    <td>Jumlah</td>
                                    <td>Keterangan</td>
                                    <td>Input Oleh</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemasukan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal->format('d - F - Y') }}</td>
                                        <td>{{ $item->formatRupiah('jumlah') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td> 
                                            {!! Form::open([
                                                'route' => ['kas.destroy', $item->id],
                                                'method' => 'Delete',
                                                'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route('kas.edit', $item->id) }}" class="btn btn-warning btn-sm">
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
                        <div class="mt-3">
                            {!! $pemasukan->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA PEMBAYARAN</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'pembayaran.index', 'method' => 'GET']) !!}
                                <div class="row">
                                    <div class="col">
                                        {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        {!! Form::selectRange('tahun', 2024, date('Y') + 1, request('tahun'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Nama Wali</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nisn }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }}</td>
                                        <td>{{ $item->wali?->name }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>{{ $item->tgl_bayar->format('d-F-Y') }}</td>
                                        <td> 
                                            
                                            <a href="{{ route('wali.pembayaran.show', $item->id) }}" 
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-info"></i> Detail
                                            </a>            
                                            
                                            
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

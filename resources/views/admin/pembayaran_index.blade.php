@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-money-bill-1"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'pembayaran.index', 'method' => 'GET']) !!}
                                <div class="row gx-2">
                                    <div class="input-search-wrapper col-md-3 col-sm-12">
                                        {!! Form::text('q', request('q'), ['class' => 'form-control input-search', 'placeholder' => 'Pencarian Siswa']) !!}
                                    </div>
                                    <div class="custom-select-wrapper col-md-3 col-sm-12">
                                        
                                        {!! Form::select('status', [
                                            '' => 'Pilih Status',
                                            'Sudah_Konfirmasi' => 'Sudah DiKonfirmasi',
                                            'Belum_Konfirmasi' => 'Belum Dikonfirmasi',
                                        ], 
                                        request('status'), 
                                        [
                                            'class' => 'form-control custom-select',
                                        ]) !!}
                                    </div>
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
                                    <td>NIS & Nama Siswa</td>
                                    {{--  <td>Nama Wali</td>  --}}
                                    <td>Metode Pembayaran</td>
                                    <td>Jumlah Bayar</td>
                                    <td>Status Konfirmasi</td>
                                    {{--  <td>Tanggal Konfirmasi</td>  --}}
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->nis }} - {{ $item->tagihan->nama }}</td>
                                        {{--  <td>{{ $item->wali?->name }}</td>  --}}
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                @if($item->tgl_konfirmasi == null)
                                                    Belum Dikonfirmasi    
                                                @else
                                                {{ $item->tgl_konfirmasi->format('d M Y') }}
                                                    
                                                @endif
                                            </span>
                                        </td>
                                        {{--  <td>{{ $item->tgl_bayar->format('d-F-Y') }}</td>  --}}
                                        <td> 
                                            {!! Form::open([
                                                'route' => ['pembayaran.destroy', $item->id],
                                                'method' => 'Delete',
                                                'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route('pembayaran.show', $item->id) }}" 
                                                class="btn btn-info btn-sm">
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

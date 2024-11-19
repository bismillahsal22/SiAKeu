@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header" style="font-weight: 900"><i class="fa fa-info-circle"></i> Detail Siswa</h5>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td rowspan="8" width="100">
                                <img src="{{ \Storage::url($siswa->foto ?? 'image/no-image.png') }}" alt="" width="100" height="120">
                            </td>
                        </tr>
                        <tr>
                            <td width="120">NIS</td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: {{ $siswa->kelas }}</td>
                        </tr>
                        <tr>
                            <td>Tahun Ajaran</td>
                            <td>: {{ $siswa->tahunAjaran->tahun_ajaran }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header pb-2" style="font-weight: 900"><i class="fa fa-file-invoice"></i> Rincian Tagihan</h5>
                <div class="card-body">
                    <table class="table table-striped table-bordered mt-2">
                        <thead>
                            <tr>
                                <td width="1%">No</td>
                                <td width="240">Nama Tagihan</td>
                                <td>Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->detailTagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_bayar }}</td>
                                    <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="background-color: black; color:white"><strong>Total Tagihan</td>
                                <td style="background-color: black; color:white"><strong>{{ formatRupiah($tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-2">
                        <button class="btn btn-outline-dark">
                            <a href="{{ route('invoice.show', $tagihan->id) }}" target="blank">
                                <i class="fa fa-file-pdf"></i> Download Invoice
                            </a>
                        </button>
                        
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <h5 class="card-header" style="font-weight: 900"><i class="fa fa-money-check-dollar"></i> Form Pembayaran</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                    {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
                    <div class="form-group">
                        <label for="tgl_bayar">Tanggal Pembayaran</label>
                        {!! Form::date('tgl_bayar', $model->tgl_bayar ?? \Carbon\Carbon::now(), ['class' => 'form-control ']) !!}
                        <span class="text-danger">{{ $errors->first('tgl_bayar') }}</span>
                    </div>
                    <div class="form-group mt-2">
                        <label for="jumlah_bayar">Jumlah Pembayaran</label>
                        {!! Form::text('jumlah_bayar', null, ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_bayar') }}</span>
                    </div>
                    {!! Form::submit('Simpan', ['class' => 'btn btn-primary mt-2']) !!}
                    {!! Form::close() !!}
                </div>
                <h5 class="card-header pb-2" style="font-weight: 900"><i class="fa fa-save"></i> Rincian Pembayaran</h5>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <td><strong>Tahun Ajaran</td>
                                <td style="vertical-align: top"><strong>Tanggal</td>
                                <td><strong>Metode Pembayaran</td>
                                <td style="vertical-align: top"><strong>Jumlah</td>
                                <td style="vertical-align: top"><strong>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->pembayaran as $item)
                                <tr>
                                    <td>{{ $item->tahunAjaran->tahun_ajaran }}</td>
                                    <td>{{ $item->tgl_bayar->format('d F Y') }}</td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                    <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                    <td>
                                        <a href="{{ route('kuitansipembayaran.show', $item->id) }}" target="blank">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total Pembayaran</td>
                                <td>{{ formatRupiah($tagihan->pembayaran->sum('jumlah_bayar')) }}</td>
                                <td>&nbsp;</td>
                            </tr>
                            @php
                                $totalTagihan = $tagihan->detailTagihan->sum('jumlah_bayar');
                                $totalDibayar = $tagihan->pembayaran->sum('jumlah_bayar');
                                $kekurangan = $totalTagihan - $totalDibayar;
                            @endphp
                            @if ($kekurangan > 0)
                                <tr>
                                    <td colspan="3" style="background-color: red; color:white"><strong>Kekurangan Pembayaran</strong></td>
                                    <td style="background-color: red; color:white; font-weight:600">{{ formatRupiah($kekurangan) }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                    <h5 class="text-danger mt-2 fw-bold">Status Pembayaran : {{ strtoupper($tagihan->status) }}</h5>
                </div>
                
            </div>
        </div>
    </div>
@endsection

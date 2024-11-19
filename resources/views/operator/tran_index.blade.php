@extends('layouts.app_operator')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-money-bill"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="container">
                        <div class="col-md-6 mb-4">
                            {!! Form::open(['route' => 'operator.transaksi.show', 'method' => 'GET']) !!}
                                <h6 class="col-md-6 mb-2">Cari Siswa</h6>
                                <div class="input-group">
                                    {!! Form::select('siswa_id', $siswaList, request('siswa_id'), ['class' => 'form-control select2', 'placeholder' => 'Pilih Siswa']) !!}
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                @if(isset($siswa))
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <img src="{{ \Storage::url($siswa->foto ?? 'image/no-image.png') }}" alt="Foto Siswa" width="70" height="50" class="img-fluid rounded-circle mb-2">
                            <p class="mb-0"><strong>{{ $siswa->nama }}</strong></p>
                        </div>
                        <table class="table no-border-table">
                            <tr>
                                <td>NIS</td>
                                <td>: {{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Ajaran</td>
                                <td>: {{ $tahun_ajaran_terpilih }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header pb-2" style="font-weight: 900"><i class="fa fa-file-invoice"></i> Tagihan Pembayaran Siswa</h5>
                    @if($tagihanList->isNotEmpty()) <!-- Pastikan tagihan tidak kosong -->
                        <div class="card-body">
                            <table class="table table-striped table-bordered mt-2">
                                <thead style="font-weight: 900; background-color:#109490; color:white">
                                    <tr>
                                        <td width="1%">No</td>
                                        <td>Nama</td>
                                        <td>Tanggal</td>
                                        <td>Jumlah</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tagihanList as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_tag }}</td>
                                            <td>{{ $item->tgl_tagihan->format('d-F-Y') }}</td>
                                            <td>{{ formatRupiah($item->jumlah )}}</td>
                                            <td>
                                                <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Form Pembayaran hanya muncul jika ada tagihan -->
                        <h5 class="card-header" style="font-weight: 900"><i class="fa fa-money-check-dollar"></i> Form Pembayaran</h5>
                        <div class="card-body">
                            {!! Form::model($model, ['route' => 'operator.pembayaran.store', 'method' => 'POST']) !!}
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

                        <!-- Rincian Pembayaran hanya muncul jika ada tagihan -->
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
                                            <td style="background-color: red; color:white">{{ formatRupiah($kekurangan) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endif
                                </tfoot>
                            </table>
                            <h5 class="text-danger mt-2 fw-bold">Status Pembayaran : {{ strtoupper($tagihan->status) }}</h5>
                        </div>
                    @else
                        <div class="justify-content-center align-items-center">
                            <p class="text-center" style="font-weight: 600">Tidak Ada Tagihan</p>
                        </div>
                    @endif
                </div> 
            </div>
        @endif
    </div>
@endsection
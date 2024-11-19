@extends('layouts.app_blank')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.laporan_header')
                    <h4 class="text-center mt-4 fw-bold">LAPORAN PEMBAYARAN</h4>
                    <p class="text-center" style="font-weight:bold">Berdasarkan : {{ $title }}</p>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">            
                                <tr>
                                    <td width="1%">No</td>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    {{--  <td>Kelas</td>  --}}
                                    <td>Tanggal Bayar</td>
                                    <td>Metode Pembayaran</td>
                                    <td>Total Pembayaran</td>
                                    <td>Status Konfirmasi</td>
                                    <td>Tanggal Konfirmasi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayaran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->nis }}</td>
                                        <td>{{ $item->tagihan->nama }}</td>
                                        {{--  <td>{{ $item->tagihan->siswa->kelas }}</td>  --}}
                                        <td>{{ $item->tgl_bayar->format('d-F-Y') }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>{{ $item->tgl_konfirmasi->format('d-F-Y') }}</td>
                                    </tr>
                                @empty
                                    <td colspan="8" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <table class="table fw-bold">
                                <tr>
                                    <td width="20%">Total Pembayaran</td>
                                    <td>: {{ formatRupiah($totalPembayaran) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <center style="margin-top: 2%">
                        <a class="btn btn-primary" href="#" onclick="window.print()">Cetak</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection

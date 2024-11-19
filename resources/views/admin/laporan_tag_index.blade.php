@extends('layouts.app_blank')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.laporan_header')
                    <hr class="p-0 m-0">
                    <h4 class="text-center mt-4 fw-bold">LAPORAN TAGIHAN</h4>
                    <p class="text-center" style="font-weight:bold">Berdasarkan : {{ $title }}</p>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">            
                                <tr>
                                    <td width="1%">No</td>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    <td>Kelas</td>
                                    <td>Tanggal Tagihan</td>
                                    <td>Total Tagihan</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->tgl_tagihan->format('d-F-Y') }}</td>
                                        <td>{{ formatRupiah($item->jumlah) }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <table class="table fw-bold">
                                <tr>
                                    <td width="20%">Total Tagihan</td>
                                    <td>: {{ formatRupiah($totalTagihan) }}</td>
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

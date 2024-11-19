@extends('layouts.app_blank')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.laporan_header')
                    <hr class="p-0 m-0">
                    <h4 class="text-center mt-4 fw-bold">LAPORAN KAS</h4>
                    <p class="text-center" style="font-weight:bold">Berdasarkan : {{ $title }}</p>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">            
                                <tr>
                                    <td width="1%">No</td>
                                    <td>Tanggal</td>
                                    <td>Keterangan</td>
                                    <td>Pemasukan</td>
                                    <td>Pengeluaran</td>
                                    <td>Sisa Saldo</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal->format('d/F/Y') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->pemasukan ? formatRupiah($item->pemasukan) : '-' }}</td>
                                        <td>{{ $item->pengeluaran ? formatRupiah($item->pengeluaran) : '-' }}</td>
                                        <td>{{ formatRupiah($item->saldo) }}</td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold;">
                                    <td colspan="3" class="text-center" style="background-color: grey; color:black">Total</td>
                                    <td style="background-color: grey; color:black">{{ formatRupiah($totalPemasukan) }}</td>
                                    <td style="background-color: grey; color:black">{{ formatRupiah($totalPengeluaran) }}</td>
                                    <td style="background-color: grey; color:black">{{ formatRupiah($totalSaldo) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <center style="margin-top: 2%">
                        <a class="btn btn-primary" id="cetakButton" href="#" onclick="window.print()">Cetak</a>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Sembunyikan tombol cetak saat dialog cetak muncul */
        @media print {
            #cetakButton {
                display: none;
            }
        }
    </style>
@endsection
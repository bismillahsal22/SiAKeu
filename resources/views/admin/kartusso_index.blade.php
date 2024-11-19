@extends('layouts.app_blank')

@section('content')
{{--  <script type="text/javascript">
    window.print();
</script>  --}}
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-uppercase">KARTU PEMBAYARAN SUMBANGAN SUKARELA ORANGTUA</h3>
                        <div class="billed"><span class="font-weight-bold">Nama Sekolah : </span><span class="ml-1">SMA NEGERI 1 SEYEGAN</span></div>
                        <div class="billed"><span class="font-weight-bold">Nama Siswa : </span><span class="ml-1">
                            {{ $siswa->nama }}    
                        </span></div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan Tagihan</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Total</th>
                                    <th>Paraf</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tgl_tagihan->format('F Y') }}</td>
                                        <td>
                                            @foreach ($item->detailTagihan as $itemDetail)
                                                <li>
                                                    {{ $itemDetail->nama_bayar }}
                                                    {{ $itemDetail->jumlah_bayar }}
                                                </li>
                                            @endforeach
                                        </td>
                                        <td>{{ formatRupiah($item->detailTagihan->sum('jumlah_bayar')) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>
@endsection

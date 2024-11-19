@extends('layouts.app_blank')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.laporan_header')
                    <div class="text-center">
                        <h5 class="mt-5" style="font-weight:bold;">{{ $title }}</h5>
                    </div>
                    {{-- Tampilkan data rekap dan tabel jika tahun ajaran dipilih --}}
                    @if(request('tahun_ajaran_id'))
                        {{-- REKAP --}}
                        <div class="col-lg-12 col-md-4 order-1">
                            <div class="row">
                                <div class="col-lg-3 col-md-12 col-6 mb-4">
                                    <div class="card" style="border-top: 5px solid #007bff;">
                                        <div class="card-body">
                                            <h6 class="fw-bold d-block mb-2">Total Siswa</h6>
                                            <small class="text-dark fw-bold" style="font-size: 20px">{{ $totalSiswa }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-6 mb-4">
                                    <div class="card" style="border-top: 5px solid #28a745;">
                                        <div class="card-body">
                                            <h6 class="fw-bold d-block mb-2">Siswa Lunas</h6>
                                            <small class="text-success fw-bold" style="font-size: 20px">{{ $jumlahLunas }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-6 mb-4">
                                    <div class="card" style="border-top: 5px solid #ffc107;">
                                        <div class="card-body">
                                            <h6 class="fw-bold d-block mb-2">Siswa Mengangsur</h6>
                                            <small class="text-warning fw-bold" style="font-size: 20px">{{ $jumlahMengangsur }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-6 mb-4">
                                    <div class="card" style="border-top: 5px solid #dc3545;">
                                        <div class="card-body">
                                            <h6 class="fw-bold d-block mb-2">Siswa Belum Membayar</h6>
                                            <small class="text-danger fw-bold" style="font-size: 20px">{{ $belumMembayar }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RINCIAN TABEL SISWA --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead style="font-weight: 900; background-color:#109490; color:white">
                                    <tr>
                                        <td width="1%">No</td>
                                        <td>NIS</td>
                                        <td>Nama</td>
                                        <td>Kelas</td>
                                        {{--  <td>Tahun Ajaran</td>  --}}
                                        <td>Total Tagihan</td>
                                        <td>Jumlah Bayar</td>
                                        <td>Kekurangan</td>
                                        <td>Status</td>
                                        {{--  <td>Aksi</td>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($models as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->kelas }}</td>
                                            {{--  <td>{{ $item->tahunAjaran->tahun_ajaran }}</td>  --}}
                                            <td>{{ formatRupiah($item->jumlah_tag) }}</td>
                                            <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                            <td>{{ formatRupiah($item->kekurangan) }}</td>
                                            <td>
                                                <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            {{--  <td>
                                                {!! Form::open([
                                                    'route' => [$routePrefix . '.destroy', $item->id],
                                                    'method' => 'Delete',
                                                    'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                                ]) !!}
                                                <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ route($routePrefix . '.show', $item->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-info"></i> Detail
                                                </a>
                                                {!! Form::close() !!}
                                            </td>  --}}
                                        </tr>
                                    @empty
                                        <td colspan="9" class="text-center">Data Tidak Ada</td>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- {!! $models->links() !!} --}}
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <strong>Total Tagihan : {{ formatRupiah($totalTagihan) }}</strong><br>
                                <strong class="text-success">Total Pembayaran : {{ formatRupiah($totalPembayaran) }}</strong><br>
                                <strong class="text-danger">Total Kekurangan : {{ formatRupiah($totalKekurangan) }}</strong>
                            </div>
                        </div>
                    @endif
                    
                    <center style="margin-top: 2%">
                        <a class="btn btn-primary" id="cetakButton" href="#" onclick="window.print()"><i class="fa fa-print"></i> Cetak</a>
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

@extends('layouts.app_admin')

@section('content')
    <div class="row mb-4">
        <!-- Rekap Data -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="border-top: 4px solid #007bff;">
                <div class="card-body">
                    <h6 class="fw-bold d-block mb-1"><i class="fa fa-users"></i> Total Siswa</h6>
                    <h4 class="card-title mb-2 fw-bold">{{ $siswa}}</h4>
                    <small class="fw-semibold"><a href="{{ route('siswa.index') }}">Data Siswa</a></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="border-top: 5px solid #28a745;">
                <div class="card-body">
                    <h6 class="fw-bold d-block mb-2"><i class="fa fa-circle-up"></i> Total Pemasukan</h6>
                    <h4 class="text-success mb-2 fw-bold">{{ formatRupiah($totalPemasukan) }}</h4>
                    <small class="fw-semibold"><a href="{{ route('pemasukan.index') }}">Rincian Pemasukan</a></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="border-top: 5px solid #dc3545;">
                <div class="card-body">
                    <h6 class="fw-bold d-block mb-2"><i class="fa fa-circle-down"></i> Total Pengeluaran</h6>
                    <h4 class="text-danger mb-2 fw-bold">{{ formatRupiah($totalPengeluaran) }}</h4>
                    <small class="fw-semibold"><a href="{{ route('pengeluaran.index') }}">Rincian Pengeluaran</a></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="border-top: 5px solid #ffc107;">
                <div class="card-body">
                    <h6 class="fw-bold d-block mb-2"><i class="fa fa-money-bill"></i> Sisa Saldo</h6>
                    <h4 class="mb-2 fw-bold">{{ formatRupiah($sisaSaldo) }}</h4>
                    <small class="fw-semibold"><a href="{{ route('lap_kas.index') }}" target="blank">Laporan Kas</a></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Bagian Chart -->
        <div class="col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 fw-bold">Rekapitulasi Tagihan {{ $tahun_ajaran_aktif }}</h5>
                        <!-- $tahun_ajaran_aktif->tahun_ajaran -->
                        <small class="text-muted">{{ date('d F Y H:i:s') }}</small>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div>{!! $dashboardChart->container() !!}</div>
                </div>
                <ul class="mt-2">
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-primary"></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Total Tagihan Siswa {{ $totalTagihan }}</h6>
                                <small class="text-muted">Lunas/Belum Lunas <a href="{{ route('tagihan.index') }}" style="text-decoration: underline">Rincian</a></small>
                            </div>
                            <div class="me-5">
                                <small class="fw-bold" style="font-size: 15px">{{ $tagihanLunas }}/{{ $tagihanBelumLunas }}</small>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-success"></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="mb-0">Lunas</h6>
                                <small class="text-muted">Jumlah Siswa Lunas</small>
                            </div>
                            <div class="me-5">
                                <small class="fw-bold" style="font-size: 15px">{{ $tagihanLunas }}</small>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-warning"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="mb-0">Mengangsur</h6>
                                <small class="text-muted">Jumlah Siswa Mengangsur</small>
                            </div>
                            <div class="me-5">
                                <small class="fw-bold" style="font-size: 15px">{{ $tagihanMengangsur }}</small>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-danger"></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="mb-0">Belum Membayar</h6>
                                <small class="text-muted">Jumlah Siswa Belum Membayar</small>
                            </div>
                            <div class="me-5">
                                <small class="fw-bold" style="font-size: 15px">{{ $tagihanBaru }}</small>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        <!-- Bagian Pembayaran Belum Dikonfirmasi -->
        <div class="col-md-6  col-lg-6mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2 text-danger fw-bold">Pembayaran Belum Dikonfirmasi</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($dataBayarBelumKonfirmasi as $item)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">{{ $item->tagihan->siswa->nama }}</h6>
                                    <small class="text-muted d-block mb-1">{{ $item->tgl_bayar->diffForHumans() }}</small>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">
                                        <span class="text-muted">
                                            <a href="{{ route('pembayaran.show', $item->id) }}">
                                                <i class="fa fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </span>
                                    </h6>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ $dashboardChart->cdn() }}"></script>
{{ $dashboardChart->script() }}
@endsection
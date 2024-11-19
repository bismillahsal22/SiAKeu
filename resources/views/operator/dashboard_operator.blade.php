@extends('layouts.app_operator')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-4 order-1">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card" style="border-top: 4px solid #007bff;">
            <div class="card-body">
              <h6 class="fw-bold d-block mb-1"><i class="fa fa-users"></i> Total Siswa</h6>
              <h4 class="card-title mb-2 fw-bold">{{ $siswa}}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card" style="border-top: 5px solid #28a745;">
            <div class="card-body">
              <h6 class="fw-bold d-block mb-2"><i class="fa fa-circle-up"></i> Total Pemasukan</h6>
              <h4 class="text-success mb-2 fw-bold">{{ formatRupiah($totalPemasukan) }}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card" style="border-top: 5px solid #dc3545;">
            <div class="card-body">
              <h6 class="fw-bold d-block mb-2"><i class="fa fa-circle-down"></i> Total Pengeluaran</h6>
              <h4 class="text-danger mb-2 fw-bold">{{ formatRupiah($totalPengeluaran) }}</h4>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card" style="border-top: 5px solid #ffc107;">
            <div class="card-body">
              <h6 class="fw-bold d-block mb-2"><i class="fa fa-money-bill"></i> Sisa Saldo</h6>
              <h4 class="mb-2 fw-bold">{{ formatRupiah($sisaSaldo) }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>
  <div class="row">
  </div>
@endsection

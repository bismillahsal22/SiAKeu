@extends('layouts.app_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-info-circle"></i> Detail Pembayaran</h5>
                <div class="card-body">
                    
                        <table class="table">
                            <tr>
                                <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI SISWA</td>
                            </tr>
                            <tr>
                                <td width="200"><strong>NIS</td>
                                <td>: {{ $model->tagihan->siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama</td>
                                <td>: {{ $model->tagihan->siswa->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kelas</td>
                                <td>: {{ $model->tagihan->siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Ajaran</td>
                                <td>: {{ $model->tagihan->siswa->tahunAjaran->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Wali Siswa</td>
                                <td>: {{ $model->wali->name ?? 'Belum menambahkan wali siswa ini' }}</td>
                            </tr>
                        </table>

                        <table class="table mt-4">
                            <tr>
                                <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI TAGIHAN</td>
                            </tr>
                            <tr>
                                <td width="200"><strong>ID Tagihan</td>
                                <td>: {{ $model->tagihan_id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Tagihan</td>
                                <td>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <td>No</td>
                                            <td>Jenis Tagihan</td>
                                            <td>Jumlah</td>
                                        </thead>
                                        <tbody>
                                            @foreach ($model->tagihan->detailTagihan as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_bayar }}</td>
                                                    <td>{{ formatRupiah($item->jumlah_bayar) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total Tagihan</td>
                                <td>: {{ formatRupiah($model->tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
                            </tr>
                        </table>
                        <div class="row" style="display: flex">
                            <div class="col-md-6 mt-4">
                                <table class="table table-success">
                                    <thead>
                                        <tr>
                                            <td colspan="2" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI TRANSAKSI</td>
                                        </tr>
                                        <tr>
                                            <td>Metode Pembayaran</td>
                                            <td>: {{ $model->metode_pembayaran }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pembayaran</td>
                                            <td>: {{ optional($model->tgl_bayar)->format('d - F - Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Tagihan</td>
                                            <td><strong>: {{ formatRupiah($model->tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah Pembayaran</td>
                                            <td><strong>: {{ formatRupiah($model->jumlah_bayar) }}</td>
                                        </tr>
                                        
                                        @php
                                            $totalTagihan = $model->tagihan->detailTagihan->sum('jumlah_bayar');
                                            $totalDibayar = $model->tagihan->pembayaran->sum('jumlah_bayar');
                                            $kekurangan = $totalTagihan - $totalDibayar;
                                        @endphp
                                    @if ($kekurangan > 0)
                                        <tr>
                                            <td><strong>Kekurangan Pembayaran</strong></td>
                                            <td><strong>: {{ formatRupiah($kekurangan) }}</td>
                                        </tr>
                                    @endif
                                        <tr>
                                            <td>Bukti Pembayaran</td>
                                            <td>
                                                @if($model->metode_pembayaran == 'Transfer')
                                                    <a href="{{ \Storage::url($model->bukti_bayar) }}" target="_blank"><u class="text-danger">Lihat Bukti Pembayaran</u></a>
                                                @else
                                                    <span>: Tidak ada bukti pembayaran</span> <!-- Pesan jika bukan metode transfer -->
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status Konfirmasi</td>
                                            <td>: {{ $model->status_konfirmasi }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status Pembayaran</td>
                                            <td><strong>: {{ $model->tagihan->getStatusTagihanWali() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Konfirmasi Pembayaran</td>
                                            <td>: {{ optional($model->tgl_konfirmasi)->format('d F Y H:1') }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-success mt-4">
                                    @if($model->metode_pembayaran != "Manual")
                                    <tr>
                                        <td colspan="2" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI BANK</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Pengirim</td>
                                        <td>: {{ $model->waliBank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pemilik Rekening</td>
                                        <td>: {{ $model->waliBank->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->waliBank->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Tujuan Transfer</td>
                                        <td>: {{ $model->bankSekolah->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>: {{ $model->bankSekolah->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->bankSekolah->nomor_rekening }}</td>
                                    </tr>
                                    @endif
                                </table>    
                            </div>
                            
                        </div>
                        @if ($model->tgl_konfirmasi == null)
                            {!! Form::open([
                                'route' => $route,
                                'method' => 'PUT',
                                'onsubmit' => 'return confirm("Apakah Data Sudah Benar?")',
                            ]) !!}
                            
                            {!! Form::hidden('pembayaran_id', $model->id, []) !!}
                                <div class="text-center mt-3">
                                    <!-- Tombol Gagal Konfirmasi -->
                                    <button type="button" class="btn btn-danger d-inline-block mx-2" data-bs-toggle="modal" data-bs-target="#gagalKonfirmasiModal">
                                        Gagal Konfirmasi
                                    </button>

                                    <!-- Tombol Konfirmasi Pembayaran -->
                                    {!! Form::submit('Konfirmasi Pembayaran', ['class' => 'btn btn-primary']) !!}
                                </div>    
                            {!! Form::close() !!}
                        @else
                            <div class="mt-4">
                                @if ($kekurangan > 0)
                                    <div class="alert alert-danger">
                                        <h6 class="text-center">Tagihan belum lunas dan memiliki <strong> Kekurangan sebesar {{ formatRupiah($kekurangan) }}</h6>
                                    </div>
                                    
                                @else
                                    <div class="alert alert-primary">
                                        <h6 class="text-center">Tagihan <strong>LUNAS</h6>
                                    </div>
                                @endif
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Gagal Konfirmasi -->
    <div class="modal fade" id="gagalKonfirmasiModal" tabindex="-1" aria-labelledby="gagalKonfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gagalKonfirmasiModalLabel">Gagal Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['pembayaran.gagal', $model->id], 'method' => 'POST']) !!}
                    <div class="form-group">
                        {!! Form::label('pesan', 'Pesan untuk Wali Siswa:') !!}
                        {!! Form::textarea('pesan', null, ['class' => 'form-control', 'rows' => 3, 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Kirim Pesan', ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk mengaktifkan Bootstrap Modal -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
@endsection

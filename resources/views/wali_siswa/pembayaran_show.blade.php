@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-info-circle"></i> Detail Pembayaran Transfer</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI SISWA</td>
                                </tr>
                                <tr>
                                    <td><strong>NIS</td>
                                    <td>: {{ $model->tagihan->siswa->nis }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Siswa</td>
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
                                    <td>: {{ $model->wali->name }}</td>
                                </tr>
                                @if($model->metode_pembayaran != "Manual")
                                    <tr>
                                        <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI BANK</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bank Pengirim</td>
                                        <td>: {{ $model->waliBank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pemilik Rekening</td>
                                        <td>: {{ $model->waliBank->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Rekening</td>
                                        <td>: {{ $model->waliBank->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bank Tujuan Transfer</td>
                                        <td>: {{ $model->bankSekolah->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Atas Nama</td>
                                        <td>: {{ $model->bankSekolah->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Rekening</td>
                                        <td>: {{ $model->bankSekolah->nomor_rekening }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4" style="background-color:#109490; color:white; font-weight:bold" class="text-center">INFORMASI TRANSAKSI</td>
                                </tr>
                                <tr>
                                    <td><strong>Metode Pembayaran</td>
                                    <td>: {{ $model->metode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Pembayaran</td>
                                    <td>: {{ optional($model->tgl_bayar)->format('d F Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Pembayaran</td>
                                    <td>: {{ formatRupiah($model->jumlah_bayar) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bukti Pembayaran</td>
                                    <td>
                                        <a href="javascript:void[0]"
                                        onclick="popupCenter({url: '{{ \Storage::url($model->bukti_bayar) }}', 
                                        title: 'Bukti Pembayaran Transfer', w: 900, h: 600}); "><u class="text-danger">Lihat Bukti Pembayaran</u></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status Konfirmasi</td>
                                    <td>: {{ $model->status_konfirmasi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status Pembayaran</td>
                                    <td>: {{ $model->tagihan->getStatusTagihanWali() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Konfirmasi Pembayaran</td>
                                    <td>: {{ optional($model->tgl_konfirmasi)->format('d F Y H:1') }}</td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->tgl_konfirmasi != null)
                            <div class="alert alert-info">
                                <h4>TAGIHAN INI SUDAH DIBAYARKAN. LUNAS</h4>
                            </div>
                            <div class="text-center mt-2">
                                <button class="btn btn-outline-dark">
                                    <a href="{{ route('kuitansipembayaran.show', $model->id) }}" target="blank">
                                        <i class="fa fa-file-pdf"></i> Download Kuitansi Pembayaran
                                    </a>
                                </button>
                                
                            </div> 
                        @else
                            {!! Form::open([
                                'route' => ['wali.pembayaran.destroy', $model->id],
                                'method' => 'Delete',
                                'onsubmit' => 'return confirm("Yakin akan membatalkan data ini?")',
                            ]) !!}
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-danger mt-2">
                                    <i class="fa fa-trash"></i> Batal Konfirmasi Pembayaran
                                </button>
                            </div>          
                            
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

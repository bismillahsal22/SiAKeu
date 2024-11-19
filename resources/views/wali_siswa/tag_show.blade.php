@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="divider">
                        <div class="divider-text" style="color: #007bff; font-size:18px; font-weight:bold">
                            <i class="fa fa-info-circle"></i> TAGIHAN SSO {{ strtoupper($siswa->nama) }}</h5>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6 col-sm-12">
                            <table class="table table-sm">
                                <tr>
                                    <td width="25%">NIS</td>
                                    <td>: {{ $siswa->nis }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $siswa->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>: {{ $siswa->tahunAjaran->tahun_ajaran }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <table>
                                <tr>
                                    <td>Nomor Tagihan</td>
                                    <td>: #TAG- {{ $tagihan->id }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Tagihan</td>
                                    <td>: {{ $tagihan->tgl_tagihan->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: {{ $tagihan->getStatusTagihanWali() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="{{ route('invoice.show', $tagihan->id) }}" target="blank">
                                            <i class="fa fa-file-pdf"></i> Cetak Rincian Tagihan
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered mt-1">
                        <thead style="font-weight: 900; background-color:#109490; color:white">
                            <tr>
                                <td widtd="1%">No</td>
                                <td>Nama Tagihan</td>
                                <td class="text-end">Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->detailTagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_bayar }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_bayar) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total Bayar</td>
                                <td class="text-end fw-bold" >{{ formatRupiah($tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert" style="color: black">
                        Pembayaran dapat dilakukan dengan membayarkan langsung ke Sekolah atau Transfer melalui Nomor Rekening Sekolah dibawah ini. <br>
                        <u><i>Jangan melakukan transfer ke Rekening selain dari Rekening dibawah ini:</i></u> <br>
                        Silahkan lihat tata cara melakukan pembayaran melalui <u>
                            <a href="{{ route('panduan.pembayaran', 'atm') }}" target="blank">ATM</a></u> atau <u>
                            <a href="{{ route('panduan.pembayaran', 'mbanking') }}" target="blank">Mobile Banking</a></u>. <br>
                        Setelah melakukan pembayaran, silahkan UPLOAD BUKTI PEMBAYARAN melalui tombol konfirmasi pembayaran di bawah ini:
                    </div>
                    <ul>
                        <li><a href="{{ route('panduan.pembayaran', 'atm') }}" target="blank">Cara Pembayaran melalui ATM</a></li>
                        <li><a href="{{ route('panduan.pembayaran', 'mbanking') }}" target="blank">Cara Pembayaran melalui Mobile Banking</a></li>
                    </ul>
                    
                    <div class="row">
                        @foreach ($bankSekolah as $itemBank)
                            <div class="col-md-6">
                                <div class="alert alert-dark" role="alert">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="30%">Bank Tujuan</td>
                                                <td>: {{ $itemBank->nama_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>: {{ $itemBank->nomor_rekening }}</td>
                                            </tr>
                                            <tr>
                                                <td>Atas Nama</td>
                                                <td>: {{ $itemBank->nama_rekening }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('wali.pembayaran.create', [
                                        'tagihan_id' => $tagihan->id,
                                        'bank_sekolah_id' => $itemBank->id,
                                    ]) }}" 
                                        class="btn btn-primary mt-2">Konfirmasi Pembayaran</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

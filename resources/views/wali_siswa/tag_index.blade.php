@extends('layouts.app_template_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-file-invoice"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>Nama</td>
                                    <td>Tahun Ajaran</td>
                                    <td>Kelas</td>
                                    <td>Tanggal Tagihan</td>
                                    <td>Status Pembayaran</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->siswa->tahunAjaran->tahun_ajaran }}</td>
                                        <td>{{ $item->siswa->kelas }}</td>
                                        <td>{{ $item->tgl_tagihan->format('F Y') }}</td>
                                        <td>
                                            @if ($item->pembayaran->count() >= 1)
                                                <a href="{{ route('wali.pembayaran.show', $item->pembayaran->first()->id) }}"
                                                    class="btn btn-outline-success btn-sm">
                                                    {{ $item->getStatusTagihanWali() }}
                                                </a>
                                            @else
                                                {{ $item->getStatusTagihanWali() }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 'Baru' || $item->status == 'Mengangsur')
                                                <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-danger btn-sm">Lakukan Pembayaran</a>
                                            @else
                                                <a href="" class="btn btn-success btn-sm">Pembayaran Lunas</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

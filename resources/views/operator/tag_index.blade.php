@extends('layouts.app_operator')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-file-invoice"></i> {{ $title }} - {{ $tahun_ajaran_terpilih }}</h5>
                <div class="card-body">
                    <div class="row">
                        {{--  <div class="col-md-2">
                            <a style="border-radius: 50px" href="{{ route('operator.' . $routePrefix . '.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                        </div>  --}}
                        {{--  <div class="col-md-10">
                            {!! Form::open(['route' => 'operator.' . $routePrefix. '.index', 'method' => 'GET']) !!}
                                <div class="row justify-content-end gx-2">
                                    <div class="col-md-3 col-sm-12">
                                        {!! Form::text('q', request('q'), ['class' => 'form-control', 'placeholder' => 'Pencarian Siswa']) !!}
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        
                                        {!! Form::select('status', [
                                            '' => 'Pilih Status',
                                            'Lunas' => 'Lunas',
                                            'Baru' => 'Baru',
                                            'Mengangsur' => 'Mengangsur',
                                        ], 
                                        request('status'), 
                                        [
                                            'class' => 'form-control',
                                        ]) !!}
                                        
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control', 'placeholder' => 'Pilih Bulan']) !!}
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        {!! Form::selectRange('tahun', 2024, date('Y') + 1, request('tahun'), ['class' => 'form-control', 'placeholder' => 'Pilih Tahun']) !!}
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>  --}}
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>Tahun Ajaran</td>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    <td>Kelas</td>
                                    <td>Tgl Tagihan</td>
                                    <td>Total Tagihan</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->Tahun_Ajaran->tahun_ajaran }}</td>
                                        <td>{{ $item->siswa->nis }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->tgl_tagihan->format('d-F-Y') }}</td>
                                        <td>{{ formatRupiah($item->jumlah) }}</td>
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
                                            <a href="{{ route($routePrefix . '.show', [
                                                $item->siswa_id,
                                                'siswa_id' => $item->siswa_id,
                                                'bulan' => $item->tgl_tagihan->format('m'),
                                                'tahun'=> $item->tgl_tagihan->format('Y'),
                                            ]) }}" 
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-info"></i> Detail
                                            </a>            
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                            
                                        </td>  --}}
                                    </tr>
                                @empty
                                    <td colspan="6" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $tagihan->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

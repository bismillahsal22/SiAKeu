@extends('layouts.app_admin')
@section('js')
    <script>
        $(document).ready(function(){
            $("#div-import").hide();
            $("#btn-div").click(function(e){
                $("#div-import").toggle();
            });
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-file-invoice"></i> {{ $title }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a style="border-radius: 50px" href="{{ route($routePrefix . '.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                            <a style="border-radius: 50px" href="#" class="btn btn-success mx-1" id="btn-div"><i class="fa fa-upload"></i> Import Excel</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET']) !!}
                                <div class="row justify-content-end gx-2">
                                    <div class="input-search-wrapper col-md-3 col-sm-12">
                                        {!! Form::text('q', request('q'), ['class' => 'form-control input-search', 'placeholder' => 'Pencarian Siswa']) !!}
                                    </div>
                                    <div class="custom-select-wrapper col-md-3 col-sm-12">                                       
                                        {!! Form::select('status', [
                                            '' => 'Pilih Status',
                                            'Lunas' => 'Lunas',
                                            'Baru' => 'Baru',
                                            'Mengangsur' => 'Mengangsur',
                                        ], 
                                        request('status'), 
                                        [
                                            'class' => 'form-control custom-select',
                                        ]) !!}
                                        
                                    </div>
                                    <div class="custom-select-wrapper col-md-3 col-sm-12">
                                        {!! Form::select('kelas', $kelas, request('kelas'), ['class' => 'form-control custom-select', 'placeholder' => 'Kelas']) !!}
                                    </div>
                                    {{--  <div class="custom-select-wrapper col-md-3 col-sm-12">
                                        {!! Form::select('tahun_ajaran', $tahunAjaran, request('tahun_ajaran'), ['class' => 'form-control custom-select', 'placeholder' => 'Pilih Tahun Ajaran']) !!}
                                    </div>  --}}
                                    <div class="col-md-2 col-sm-12">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-alt-circle-right"></i></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="row mt-2" id="div-import">
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'import_tag.store', 'method' => 'POST', 'files' => true]) !!}
                            <div class="input-group">
                                <input type="file" name="excel" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-bordered">
                            <thead style="font-weight: 900; background-color:#109490; color:white">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    <td>Tgl Tagihan</td>
                                    <td>Total Tagihan</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->tgl_tagihan->format('d - F - Y') }}</td>
                                        <td>{{ formatRupiah($item->jumlah) }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td> 
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'Delete',
                                                'onsubmit' => 'return confirm("Yakin akan menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.show', [
                                                $item->id,
                                                'siswa_id' => $item->siswa_id,
                                                'bulan' => $item->tgl_tagihan->format('m'),
                                                'tahun' => $item->tgl_tagihan->format('Y',)
                                            ]) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-dollar"></i> Bayar
                                            </a>          
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">Data Tidak Ada</td>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

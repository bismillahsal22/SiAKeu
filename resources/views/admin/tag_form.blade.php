@extends('layouts.app_admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header fw-bold">{{ $title }}</h5>
            <div class="card-body">                 
                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                <div class="row">
                    <label for="nama" class="col-sm-3">Nama Siswa</label>
                    <div class="form-input col-sm-9">
                        {!! Form::select('nama', $nama, null, [
                            'class' => 'form-control select2', 
                            'placeholder' => 'Pilih Siswa',
                            'id' => 'nama'
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                </div>

                <div class="row mt-3">
                    <label for="nis" class="col-sm-3">NIS</label>
                    <div class="form-input col-sm-9">
                        {!! Form::text('nis', null, [
                            'class' => 'form-control',
                            'id' => 'nis',
                            'readonly' => 'readonly'
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('nis') }}</span>
                    </div>
                </div>
               
                <div class="row mt-3">
                    <label for="tahun_ajaran" class="col-sm-3">Tahun Ajaran</label>
                    <div class="form-input col-sm-9">
                        <!-- Menampilkan nama tahun ajaran -->
                        {!! Form::text('tahun_ajaran', $model->tahunAjaran ? $model->tahunAjaran->tahun_ajaran : null, [
                            'class' => 'form-control',
                            'id' => 'tahun_ajaran',
                            'readonly' => 'readonly'
                        ]) !!}
                        <!-- Simpan ID tahun ajaran secara tersembunyi -->
                        {!! Form::hidden('tahun_ajaran_id', $model->tahun_ajaran_id, ['id' => 'tahun_ajaran_id']) !!}
                        <span class="text-danger">{{ $errors->first('tahun_ajaran_id') }}</span>
                    </div>
                </div>

                <div class="row mt-3">
                    <label for="kelas" class="col-sm-3">Kelas</label>
                    <div class="form-input col-sm-9">
                        {!! Form::text('kelas', null, [
                            'class' => 'form-control',
                            'id' => 'kelas',
                            'readonly' => 'readonly'
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <label for="nama_tag" class="col-sm-3">Nama Tagihan</label>
                    <div class="form-input col-sm-9">
                        {!! Form::text('nama_tag', $nama_tag, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        <span class="text-danger">{{ $errors->first('nama_tag') }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <label for="jumlah" class="col-sm-3">Nominal Tagihan SSO</label>
                    <div class="form-input col-sm-9">
                        {!! Form::text('jumlah', null, ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <label for="tgl_tagihan" class="col-sm-3">Tanggal Tagihan</label>
                    <div class="form-input col-sm-9">
                        {!! Form::date('tgl_tagihan', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('tgl_tagihan') }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <label for="keterangan" class="col-sm-3">Keterangan</label>
                    <div class="form-input col-sm-9">
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger"><a href="{{ route('tagihan.index') }}" style="color: white">Batal</a></button>
                    {!! Form::submit($button, ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nama').on('change', function() {
            var namaSiswa = $(this).val();
        
            if (namaSiswa) {
                $.ajax({
                    url: '{{ route('get.siswa.details') }}',
                    type: 'GET',
                    data: { nama: namaSiswa },
                    success: function(data) {
                        if (data) {
                            $('#nis').val(data.nis);
                            $('#kelas').val(data.kelas);
                            $('#tahun_ajaran').val(data.tahun_ajaran); // Tampilkan nama tahun ajaran
                            $('#tahun_ajaran_id').val(data.tahun_ajaran_id); // Simpan ID tahun ajaran
                        } else {
                            $('#nis').val('');
                            $('#kelas').val('');
                            $('#tahun_ajaran').val('');
                            $('#tahun_ajaran_id').val('');
                        }
                    },
                    error: function() {
                        console.log('Error fetching data');
                    }
                });
            } else {
                $('#nis').val('');
                $('#kelas').val('');
                $('#tahun_ajaran').val('');
                $('#tahun_ajaran_id').val('');
            }
        });
    });
</script>
@endsection
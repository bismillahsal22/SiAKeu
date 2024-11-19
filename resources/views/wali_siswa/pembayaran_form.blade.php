@extends('layouts.app_template_wali')
@section('js')
    <script>
        $(function(){
            $("#checkboxtoggle").click(function(){
                if($(this).is(":checked")){
                    $("#pilihan_bank").hide();
                    $("#form_bank_pengirim").show();
                } else {
                    $("#pilihan_bank").show();
                    $("#form_bank_pengirim").hide();
                }
            });
        });

        $(document).ready(function(){
            @if (count($listwalibank) >= 1)
                $("#form_bank_pengirim").hide();
            @else{
                $("#form_bank_pengirim").show();
            }
            @endif
            $("#pilih_bank").change(function(e){
                var bankId = $(this).find(":selected").val();
                window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;
            });
        })
    </script>
@endsection()
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold"><i class="fa fa-file-circle-check"></i> Konfirmasi Pembayaran Transfer</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => '$method', 'files' => true]) !!}
                    {!! Form::hidden('tagihan_id', request('tagihan_id'), []) !!}
                    <div class="divider text">
                        <div class="divider-text" style="color: #109490; font-size:15px; font-weight:bold">
                            <i class="fa fa-info-circle"></i>  INFORMASI REKENING PENGIRIM</h6>
                        </div>
                    </div>
                    @if (count($listwalibank) >= 1)
                        <div class="form-group" id="pilihan_bank">
                            <label for="wali_bank_id">Pilih Bank Pengirim</label>
                            {!! Form::select('wali_bank_id', $listwalibank, null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Pilih Nomor Rekening Pengirim'
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                        </div>
                        <div class="form-check mt-2">
                            {!! Form::checkbox('pilihan_bank', 1, false, ['class' => 'form-check-input', 'id' => 'checkboxtoggle']) !!}
                            <label for="form-check-label">
                                Saya memiliki rekening baru
                            </label>
                        </div>
                    @endif
                    
                    <div class="informasi-pengirim" id="form_bank_pengirim">
                        <div class="container">
                            <div class="row">
                                <label for="nama_bank_pengirim" class="col-md-3"><strong> Bank Pengirim</strong></label>
                                <div class="col-md-9">
                                    {!! Form::select('bank_id', $listBank, null, ['class' => 'form-control select2']) !!}
                                    <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="nama_rekening" class="col-md-3"><strong>Nama Rekening</strong></label>
                                <div class="col-md-9">
                                    {!! Form::text('nama_rekening', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="nomor_rekening" class="col-md-3"><strong>Nomor Rekening Pengirim</strong></label>
                                <div class="col-md-9">
                                    {!! Form::text('nomor_rekening', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                                </div>
                            </div>
                            <div class="form-check mt-3">
                                {!! Form::checkbox('simpan_data_rekening', 1, true, ['class' => 'form-check-input', 'id' => 'defaultCheck3']) !!}
                                <label for="form-check-label">
                                    Simpan data untuk melakukan pembayaran selanjutnya
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divider text">
                        <div class="divider-text" style="color: #109490; font-size:15px; font-weight:bold">
                            <i class="fa fa-info-circle"></i>  INFORMASI REKENING TUJUAN</h6>
                        </div>
                    </div>
                    <div class="informasi-bank-tujuan">
                        <div class="container">
                            <div class="row mt-2">
                                <label for="bank_sekolah_id" class="col-md-3"><strong>Bank Tujuan Pembayaran</strong></label>
                                <div class="col-md-9">
                                    {!! Form::select('bank_sekolah_id', $listBankSekolah, request('bank_sekolah_id'), [
                                        'class' => 'form-control', 
                                        'placeholder' => 'Pilih Bank Tujuan',
                                        'id' => 'pilih_bank'
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('bank_sekolah_id') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    @if(request('bank_sekolah_id') != '')
                                        <div class="alert alert-primary mt-1" role="alert">
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td width="25%">Bank Tujuan</td>
                                                        <td>: {{ $bankPilih->nama_bank }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Rekening</td>
                                                        <td>: {{ $bankPilih->nomor_rekening }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Atas Nama</td>
                                                        <td>: {{ $bankPilih->nama_rekening }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                     @endif
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <label for="tgl_bayar" class="col-md-3"><strong>Tanggal Pembayaran</strong></label>
                                <div class="col-md-9">  
                                    {!! Form::date('tgl_bayar', $model->tgl_bayar ?? date('Y-m-d'), ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('tgl_bayar') }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="jumlah_bayar" class="col-md-3"><strong>Total yang Dibayarkan</strong></label>
                                <div class="col-md-9">
                                    {!! Form::text('jumlah_bayar', $tagihan->detailTagihan->sum('jumlah_bayar'), ['class' => 'form-control rupiah']) !!}
                                    <span class="text-danger">{{ $errors->first('jumlah_bayar') }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="bukti_bayar" class="col-md-3"><strong>Bukti Pembayaran</strong></label>
    
                                <div class="col-md-9">
                                    <span class="text-danger fw-bold">(Format: jpg, jpeg, png, Ukuran Maks: 5MB)</span>
                                    {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-danger mx-2"><a href="{{ route('wali.tagihan.index') }}" style="color: white">Batal</a></button>
                            {!! Form::submit('Kirim', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

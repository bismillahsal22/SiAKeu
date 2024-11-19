<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
        <title>
            {{ @$title != '' ? "$title |" : '' }}
            {{ settings()->get('nama_sistem', 'SiAKeu') }}
        </title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: left;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            table tr td{
                border-bottom: 1px solid black;
            }
            
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr>
                    <td width="80">
                        @if(request('output') == 'pdf')
                                <img src="{{ public_path() . '/img/logo-sma.png' }}" alt="" width="70">
                        @else
                                <img src="{{ asset('img/logo-sma.png') }}" alt="" width="80">
                        @endif
                    </td>
                    <td style="text-align: left; vertical-align: middle">
                        <div style="font-size: 20px; font-weight:bold">{{ settings()->get('nama_app', 'SiAKeu') }}</div>
                        <div>{{ settings()->get('alamat_app') }}</div>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>No. </td>
                    <td>: #{{ $pembayaran->id }}</td>
				</tr>
                <tr>
                    <td>Telah terima dari </td>
                    <td>: {{ $pembayaran->tagihan->siswa->nama }}</td>
                </tr>
                <tr>
                    <td>Uang Sejumlah</td>
                    <td><i>: {{ ucwords(terbilang($pembayaran->jumlah_bayar)) }} Rupiah</i></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>: {{ $pembayaran->tagihan->nama_tag }}</td>
                </tr>
                {{--  <tr>
                    <td colspan="2">
                        <br><br>
                    </td>
                </tr>  --}}
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td colspan="2"  style="vertical-align: bottom" width="400">
                                    <div style="background: #eee; width:100px; padding:10px; font-weight:bold">
                                        {{ formatRupiah($pembayaran->jumlah_bayar) }}
                                    </div>
                                </td>
                                <td>
                                    Seyegan, {{ now()->format('d F Y') }} <br />
                                    Mengetahui, <br />
                                    <br />
                                    <br />
                                    Bendahara Sekolah
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            

				{{--  <tr class="information">
					<td colspan="3">
						<table>
							<tr>
								<td>
								    <span style="font-weight: bold">Tagihan Untuk<br /></span>
									NISN/Nama : {{ $tagihan->siswa->nisn }}/{{ $tagihan->siswa->nama }}<br />
									Kelas : {{ $tagihan->siswa->kelas }}
								</td>
								<td>
                                    <br>
									Invoice #: {{ $tagihan->id }}<br />
									Tgl Tagihan: {{ $tagihan->tgl_tagihan->format('d F Y') }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>  --}}

				
                {{--  @foreach ($tagihan->detailTagihan as $item)
                    <tr class="item">
                        <td width="1%" style="text-align: center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_bayar }}</td>
                        <td style="text-align: end">{{ formatRupiah($item->jumlah_bayar) }}</td>
                    </tr>
                @endforeach  --}}
				{{--  <tr class="total" style="background: #eee">
					<td colspan="2" style="text-align: center; font-weight: bold">Total Pembayaran</td>
                    <td style="text-align: end">{{ formatRupiah($tagihan->detailTagihan->sum('jumlah_bayar')) }}</td>
				</tr>
                <tr>
                    <td colspan="3">
                        <div>
                            Terbilang : <i>{{ ucwords(terbilang($tagihan->detailTagihan->sum('jumlah_bayar'))) }}</i>
                        </div>    
                    </td>
                </tr>  --}}
                
			</table>
            <center style="margin-top: 5%">
                <a class="btn btn-primary" href="{{ url()->current() . '?output=pdf' }}">Download PDF</a>
                &nbsp;&nbsp;
                <a class="btn btn-primary" href="#" onclick="window.print()">Cetak</a>
            </center>
		</div>
        <style>
            a {
                text-decoration: none;
            }

            .btn {
                appearance: none;
                background-color: lightskyblue;
                padding: 10px;
            }
        </style>
	</body>
</html>

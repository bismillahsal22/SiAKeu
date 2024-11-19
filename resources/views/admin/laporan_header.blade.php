<div class="row">
    <table>
        <tr>
            <td width="100" style="text-align: center; vertical-align: middle; padding-left:10%">
                @if(request('output') == 'pdf')
                    <img src="{{ public_path() . '/img/logo-sma.png' }}" alt="" width="100">
                @else
                    <img src="{{ asset('img/logo-sma.png') }}" alt="" width="100">
                @endif
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <div style="font-size: 20px; font-weight:bold;">{{ settings()->get('nama_app', 'SiAKeu') }}</div>
                <div style="font-size: 15px; font-weight:bold;">TERAKREDITASI {{ settings()->get('akreditasi', 'SiAKeu') }}</div>
                <div>Alamat : {{ settings()->get('alamat_app') }}</div>
                <div>
                    <span><i class="fa fa-globe"></i> Website: {{ settings()->get('web') }}</span>
                    |
                    <span class="mx-2"><i class="fa fa-envelope"></i> Email: {{ settings()->get('email') }}</span>
                    |
                    <span><i class="fa fa-phone"></i> Telp: {{ settings()->get('hp_app') }}</span>
                </div>
            </td>
        </tr>
    </table>
</div>
<hr class="p-0 m-0">
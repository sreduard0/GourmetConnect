@php
$tools = new App\Classes\Tools();
use App\Models\AppSettingsModel;
$app_settings = AppSettingsModel::all()->first();
@endphp
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $app_settings->establishment_name  }} - Imprimir pedido</title>
    <link rel="shortcut icon" href="{{ asset($app_settings->logo_url) }}" type="image/x-icon">
    {{-- ====================================/ CSS/JS ===================================== --}}
    <style>
        @media print {
            @page {
                size: auto;
                margin: 10px;
            }

            body {
                padding-top: 10px;
                padding-bottom: 50px;
            }
        }

        .text-center {
            text-align: center;
        }

        .printer-ticket {
            display: table !important;
            width: 100%;
            font-weight: light;
            line-height: 1.3em;
        }

        .printer-ticket th:nth-child(2),
        .printer-ticket td:nth-child(2) {
            width: 50px;
        }

        .printer-ticket th:nth-child(3),
        .printer-ticket td:nth-child(3) {
            width: 90px;
            text-align: right;
        }

        .printer-ticket th {
            font-weight: inherit;
            text-align: center;
            border-bottom: 1px dashed #BCBCBC;
            padding: 10px 0;
        }

        .printer-ticket tbody tr:last-child td {
            padding-bottom: 10px;
        }

        .printer-ticket tfoot .sup td {
            padding: 10px 0;
            border-top: 1px dashed #BCBCBC;
        }

        .printer-ticket tfoot .sup.p--0 td {
            padding-bottom: 0;
        }

        .printer-ticket .title {
            font-size: 2.5em;
            padding: 15px 0;
        }

        .printer-ticket .table {
            font-size: 1.3em;
        }

        .printer-ticket .client {
            font-size: 1.3em;
        }

        .printer-ticket .address {
            font-size: 1.3em;
        }

        .printer-ticket .ttu {
            font-size: 1.4em;
            text-transform: uppercase;

        }


        .printer-ticket .top td {
            font-size: 1em;
            padding-top: 10px;
        }

        .printer-ticket .last td {
            padding-bottom: 10px;
        }

        .printer-ticket,
        .printer-ticket * {
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 10px;
        }

    </style>
</head>
<body>
    <table class="printer-ticket">
        <thead>
            <tr>
                <th colspan="3">
                    <p class="title">{{ $app_settings->establishment_name  }}</p>
                    <address class="address">
                        {{ $app_settings->city }} <br>
                        {{ $app_settings->address.', Nº '.$app_settings->number.', '.$app_settings->neighborhood }} <br>
                        CEP {{ $tools->mask('##.###-###',$app_settings->cep) }}



                    </address>
                </th>
            </tr>
            <tr>
                <th colspan="3" class="table">MESA #{{ $command->table }}</th>
            </tr>
            <tr>
                <th colspan="3" class="client">
                    {{ $command->client_name }} <br />
                    {{-- CPF SE EXISTIR --}}
                </th>
            </tr>
            <tr>
                <th colspan="3">
                    <strong class="ttu">Cupom não fiscal</strong>

                    {{-- <b>Cupom fiscal</b> --}}
                    {{-- CASO O ESTABELECIMENTE ESTEJA CORRETO --}}
                </th>
            </tr>
        </thead>
    </table>
    <table class="printer-ticket">
        <tbody>
            {{-- cabeçalho --}}
            <tr>
                <td><strong style="font-size: 1.1em">ITEM - VALOR UN.</strong> </td>
                <td><strong style="font-size: 1.1em">QTD.</strong></td>
                <td><strong style="font-size: 1.1em">VALOR</strong></td>

                {{-- / --}}
            </tr>


            @foreach ($items as $item)
            <tr class="top">
                <td colspan="3">{{ $item['name'] }}</td>
            </tr>
            <tr>
                <td style="font-size: 1em">{{ $item['val_un'] }}</td>
                <td style="font-size: 1em">{{ $item['amount'] }}</td>
                <td style="font-size: 1em">{{ $item['val_total'] }}</td>
            </tr>
            @if ($item['additionals'])
            @foreach ($item['additionals'] as $additional)
            <tr>
                <td colspan="3">Adicional opcional: {{ $additional->info->name }}</td>
            </tr>
            <tr>
                <td>R$ {{ $additional->info->value}}</td>
                <td>1</td>
                <td>R$ {{ $additional->info->value}}</td>
            </tr>
            @endforeach
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="sup ttu p--0">
                <td colspan="3">
                </td>
            </tr>
            <tr class="ttu">
                <td style="padding-bottom: 10px" colspan="2"><strong>Total</strong></td>
                <td align="right">{{ $total }}</td>
            </tr>
            <tr class="sup ttu p--0">
                <td colspan="3">
                    <b>Pagamentos</b>
                </td>
            </tr>
            <tr class="ttu">
                <td colspan="2">{{ $method->name }}</td>
                <td align="right">{{ $total }}</td>

            </tr>
            <tr class="sup">
                <td style="padding-top:30px" colspan="3" align="center">
                    por: <b> GourmetConnect</b>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

<script>
    window.print()
    window.close()

</script>

</html>

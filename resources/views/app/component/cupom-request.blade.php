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
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.css') }}">
    <style>
        @media print {
            @page {
                size: auto;
                margin: 10px;
            }

            body {
                padding-top: 50px;
                padding-bottom: 50px;
            }
        }

        .cut-line {
            display: flex;
            align-items: center;
            padding-top: 70px;
            padding-bottom: 70px;
        }

        .cut-line hr {
            flex-grow: 1;
            height: 1px;
            background-color: black;
            margin: 0 10px;
            border: 1px dashed;
        }

        .cut-line i {
            font-size: 15pt;
        }


        .address {
            padding-top: 20px;
            font-size: 15px !important;
            padding: @printer-padding-base*1.5 0;
        }

        .title {
            font-size: 30px !important;
            padding: @printer-padding-base*1.5 0;
        }


        .table {
            font-size: 20px !important;
            padding: @printer-padding-base*1.5 0;
            padding-bottom: 10px;
        }

        .client {
            font-size: 22px !important;
            padding: @printer-padding-base*1.5 0;
        }

        .additional {
            font-size: 15px !important;
            padding: @printer-padding-base*1.5 0;
        }


        @color-gray: #BCBCBC;

        .text {
            &-center {
                text-align: center;
            }
        }

        .ttu {
            text-transform: uppercase;
            padding: 20px 20px;
            font-size: 20px
        }

        th {
            font-weight: inherit;
            padding: @printer-padding-base 0;
            text-align: center;
            border-bottom: 1px dashed @color-gray;
        }

        .printer-ticket {
            display: table !important;
            width: 100%;
            /* max-width: 400px; */
            font-weight: light;
            line-height: 1.3em;
            @printer-padding-base: 10px;

            &,
            & * {
                font-family: Tahoma, Geneva, sans-serif;
                font-size: 10px;
            }



            tbody {
                tr:last-child td {
                    padding-bottom: @printer-padding-base;
                }
            }

            .top {
                td {
                    padding-top: @printer-padding-base;
                }
            }

            .last td {
                padding-bottom: @printer-padding-base;
            }



        }

        @media print {
            thead {
                display: table-header-group;
            }
        }

    </style>
</head>
<body>
    @if (isset($command))
    @if($command->delivery == 1)
    <table class="printer-ticket">
        <thead>
            <tr>
                <th class="title" colspan="3">{{ $app_settings->establishment_name  }}
                </th>
            </tr>
            <tr>
                <th class="table" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    DELIVERY</th>
            </tr>
            <tr>
                <th class="client" colspan="3">
                    {{ $command->client_name }}
                </th>
            </tr>
            <tr>
                <th class="address" colspan="3">
                    {{ $command->address->street_address }}, {{ $command->address->number }} - {{ $command->address->neighborhood }} <br>
                    {{ $command->address->reference }}
                </th>
            </tr>
            <tr>
                <th class="address" colspan="3">
                    PAGAMENTO: {{ strtoupper($command->payment->name) }}
                </th>
            </tr>

            <tr>
                <th class="ttu" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    <b>PEDIDO(S)</b>
                </th>
            </tr>
        </thead>
    </table>
    @else
    <table class="printer-ticket">
        <thead>
            <tr>
                <th class="title" colspan="3">{{ $app_settings->establishment_name  }}
                </th>
            </tr>
            <tr>
                <th class="table" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    MESA #{{ $command->table }}</th>
            </tr>
            <tr>
                <th class="client" colspan="3">
                    {{ $command->client_name }}
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    <b>PEDIDO(S)</b>
                </th>
            </tr>
        </thead>
    </table>
    @endif
    <table class="printer-ticket">
        <tbody>
            <tr> <strong>ITEM - QTD</strong> </tr>
            <hr size="1" style="border:1px dashed">
            @foreach ($requests as $request )
            <tr class="top">
                <td colspan="3">
                    <strong>{{ $request['name'] }}</strong> {!! $request['amount']?' - x<strong>'.$request['amount'].'</strong>' :'' !!}
                    <ul>
                        @foreach ($request['additionals'] as $additional)
                        <li class="additional">{{ $additional->info->name }}</li>
                        @endforeach
                    </ul>

                    @if($request['observation'])
                    <strong class="observation">Observação:</strong>
                    {!! $request['observation'] !!}
                    @endif
                    <hr>
                </td>
            </tr>
            @endforeach

            <tr class="sup">
                <td colspan="3" align="center">
                    {{ config('app.name') }}
                </td>
            </tr>

        </tbody>
    </table>
    @else
    @foreach ($requests as $item)
    @if($item['command']->delivery == 1)
    <table class="printer-ticket">
        <thead>
            <tr>
                <th class="title" colspan="3">{{ $app_settings->establishment_name  }}
                </th>
            </tr>
            <tr>
                <th class="table" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    DELIVERY</th>
            </tr>
            <tr>
                <th class="client" colspan="3">
                    {{ $item['command']->client_name }}

                </th>
            </tr>
            <tr>
                <th class="address" colspan="3">
                    {{ $item['command']->address->street_address }}, {{ $item['command']->address->number }} - {{ $item['command']->address->neighborhood }} <br>
                    {{ $item['command']->address->reference }}
                </th>
            </tr>
            <tr>
                <th class="address" colspan="3">
                    PAGAMENTO: {{ strtoupper($item['command']->payment->name) }}
                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    <b>PEDIDO(S)</b>
                </th>
            </tr>
        </thead>
    </table>
    @else
    <table class="printer-ticket">
        <thead>
            <tr>
                <th class="title" colspan="3">{{ $app_settings->establishment_name  }}
                </th>
            </tr>
            <tr>
                <th class="table" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    MESA #{{ $item['command']->table }}</th>

            </tr>
            <tr>
                <th class="client" colspan="3">
                    {{ $item['command']->client_name }}


                </th>
            </tr>
            <tr>
                <th class="ttu" colspan="3">
                    <hr size="1" style="border:1px dashed">
                    <b>PEDIDO(S)</b>
                </th>
            </tr>
        </thead>
    </table>

    @endif
    <table class="printer-ticket">
        <tbody>
            <tr> <strong>ITEM - QTD</strong> </tr>
            <hr size="1" style="border:1px dashed">
            @foreach ($item as $request )

            <tr class="top">
                <td colspan="3">
                    <strong>{{ $request['name'] }}</strong> {!! $request['amount']?' - x<strong>'.$request['amount'].'</strong>' :'' !!}
                    <ul>
                        @if($request['additionals'])
                        @foreach ($request['additionals'] as $additional)
                        <li class="additional">{{ $additional->info->name }}</li>
                        @endforeach
                        @endif
                    </ul>

                    @if($request['observation'])
                    <strong class="observation">Observação:</strong>
                    {!! $request['observation'] !!}
                    @endif
                    <hr>
                </td>
            </tr>
            @endforeach

            <tr class="sup">
                <td colspan="3" align="center">
                    {{ config('app.name') }}
                </td>
            </tr>

        </tbody>
    </table>
    <div class="cut-line">
        <i class="fas fa-cut"></i>
        <hr>
        <i class="fas fa-cut"></i>
    </div>

    @endforeach
    @endif
    <script>
        window.print()
        window.close()

    </script>
</body>
</html>

@extends('app.layout')
@section('title', 'Mesas')
@section('tables', 'active')
@section('title-header', 'Mesas')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @for($i = 1; $i <= $app_settings->number_tables; ++$i )
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header border-bottom-0 row">
                                <h4 class="col"><strong>MESA #{{ $tables[$i]['table'] }}</strong></h4>
                                <div class="text-right col">
                                    @if($tables[$i]['pendent'])
                                    <div class="btn btn-sm btn-success rounded-pill"><strong>Há pedidos</strong></div>
                                    @endif
                                </div>

                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-md"><strong>Clientes: </strong> {{ $tables[$i]['client'] }} </p>
                                        <ul class="ml-4 mb-0 fa-ul">
                                            <li><span class="fa-li"><i class="text-success fa-duotone fa-money-bill"></i></span><strong> Valor:</strong> {{ $tables[$i]['value'] }}</li>
                                            <li><span class="fa-li"><i class="text-warning fa-duotone fa-burger-soda"></i></span><strong> Pedido via:</strong> {{ $tables[$i]['request'] }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button onclick="qr_code('{{  $tables[$i]['qr_value'] }}',{{ $i }})" class="btn btn-sm bg-secondary">
                                        <i class="fa-duotone fa-qrcode"></i>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-accent">
                                        <i class="fa-duotone fa-burger-soda"></i> <strong>PEDIDOS</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endfor
            </div>
        </div>
    </div>
</div>
@include('app.component.modal-qrcode')
@endsection
@section('plugins')
<script src="{{ asset('plugins\qr-generator\qr_generator.js') }}"></script>

@endsection

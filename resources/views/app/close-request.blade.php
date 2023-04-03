@php
$tools = new App\Classes\Tools;
@endphp
@extends('app.layout')
@section('title', 'Encerrar comanda')
@section('menu-requests', 'menu-open')
@section('requests', 'active')
@section('title-header', 'Encerrar de comanda')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<input type="hidden" id="print_id" value="{{ $tools->hash($command->id, 'encrypt') }}">
<div class="col-md-12">
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fa-duotone fa-store"></i> {{ $app_settings->establishment_name }}
                    <img class="float-right" src="{{ asset($app_settings->logo_url) }}" width="80" alt="{{ $app_settings->establishment_name }}">
                </h4>

            </div>
            <!-- /.col -->
        </div>
        <div class="col-sm-4 fs-18 p-b-20">
            <strong> {{ $command->client_name }}</strong><br>
            <b>Cod: #{{ $command->id }}</b><br>
            <b>Aberta:</b> {{ date('d/m/Y h:i',strtotime($command->created_at)) }}<br>
            <b>Mesa:</b> #{{ $command->table }}<br>

        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table id="client-requests-payment-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="30px">Cod.</th>
                            <th width="40px">Foto</th>
                            <th>Item</th>
                            <th width="50px">Qtd.</th>
                            <th width="100px">Valor</th>
                            <th width="30px">Ver</th>

                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">Modo de pagamento:</p>
                <img src="/img/credit/visa.png" alt="Visa">
                <img src="/img/credit/mastercard.png" alt="Mastercard">
                <img src="/img/credit/american-express.png" alt="American Express">
                <img src="/img/credit/paypal2.png" alt="Paypal">
                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Tome cuidado na hora de receber pix ou blablabla
                </p>

            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">{{ $command->client_name }} - {{ date('d/m/Y') }}</p>
                <div class="table-responsive">
                    <table class="table fs-17">
                        <th>TOTAL:</th>
                        <td class="value-total"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <div class="float-right">
                    <button type="button" class="btn btn-primary"><i class="fa-duotone fa-users"></i> DIVIDIR</button>
                    <button type="button" class="btn btn-accent" onclick="payment_type_modal()"><i class="fa-duotone fa-credit-card"></i> FINALIZAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('app.component.view-item')
@endsection
@section('modal')
{{-- FORMA  DE PAGAMENTO --}}
<div class="modal fade" id="payment-type-modal" role="dialog" tabindex="-1" aria-labelledby="payment-type-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Qual a forma de pagamento? </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col">
                    <select id="payment-type" name="payment-type" class="form-control" style="width:100%">
                        <optgroup label="Cartões de crédito">
                            @foreach ($payment_methods as $method)
                            @if ($method->group_payment == 'credit_card')
                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Cartões de débito">
                            @foreach ($payment_methods as $method)
                            @if ($method->group_payment == 'debit_card')
                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Outras formas de pagamento">
                            @foreach ($payment_methods as $method)
                            @if ($method->group_payment == 'other_forms')
                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                            @endif
                            @endforeach
                        </optgroup>
                        <option selected disabled value="">SELECIONE</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-accent"><i class="fa-solid fa-arrow-right fa-xl"></i></button>
            </div>
        </div>
    </div>
</div>
{{-- LISTA DE ITEM DO MESMO TIPO DO PEDIDO --}}
<div class="modal fade" id="list-items-equals-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product_name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width:100%" id="list-items-equals-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25px">Foto</th>
                            <th>Item</th>
                            <th width="110px">Garçom</th>
                            <th width="80px">Valor</th>
                            <th width="60px">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<script src="{{ asset('js/request.js') }}"></script>
<script>
    $(window).on("load", function() {
        sum_requests_client($('#print_id').val())
    });

</script>
@endsection

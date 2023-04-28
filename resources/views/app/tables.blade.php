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
        @can('create_order')
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-accent rounded-pill btnres" onclick="modal_new_request()"><strong>NOVO PEDIDO</strong></button>
            </div>
        </div>
        @endcan
        <div class="card-body pb-0">
            <div class="row" id='tables-list'>
                @for($i = 1; $i <= $app_settings->number_tables; ++$i )
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header border-bottom-0 row">
                                <h4 class="col"><strong>MESA #{{ $tables[$i]['table'] }}</strong></h4>
                                <div class="text-right col">
                                    @if($tables[$i]['pendent'] == true)
                                    <div class="request{{ $i }} btn btn-sm btn-success rounded-pill"><strong>Há pedidos</strong></div>
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
                            @canany(['view_orders','qr_code_actions'])
                            <div class="card-footer">
                                <div class="text-right">
                                    @can('qr_code_actions')
                                    <button onclick="qr_code('{{  $tables[$i]['qr_value'] }}',{{ $i }})" class="btn btn-sm bg-secondary">
                                        <i class="fa-duotone fa-qrcode"></i>
                                    </button>
                                    @endcan
                                    @can('view_orders')
                                    <button onclick="view_requests_table({{ $i }})" class="btn btn-sm btn-accent">
                                        <i class="fa-duotone fa-burger-soda"></i> <strong>PEDIDOS</strong>
                                    </button>
                                    @endcan
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @endfor
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
@can('create_order')
{{-- NOVO PEDIDO --}}
<div class="modal fade" id="new-request-modal" role="dialog" tabindex="-1" aria-labelledby="newReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="type-itemLabel">COMANDA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div-select-client" class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <select class="text-center col select-rounded m-b-10" id="table-select">
                            <option disabled selected value="">SELECIONE UMA MESA</option>
                            @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                                <option value="{{ $t }}">MESA #{{ $t }}</option>
                                @endfor
                        </select>
                        <input minlength="2" maxlength="200" id="client-name" value="" type="text" class="form-control rounded-pill text-center col m-b-10" placeholder="Nome do Cliente ou Nº da comanda">
                        <div class="d-flex justify-content-center">
                            <button id="btn-select-order" style="width:100px" class="btn btn-accent rounded-pill"><i class="fa-solid fa-circle-chevron-right fs-35"></i></button>
                        </div>
                    </div>

                </div>
                <div style="display:none" id="div-add-request">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between row">
                                <h3 class="card-title ">CARDÁPIO</h3>
                                <select class=" text-center select-rounded res" id="filter-type-item" name="filter-type-item">
                                    <option disabled selected>BUSQUE POR UM TIPO</option>
                                    <option value="">TODOS</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width:100%" id="menu-table" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th width='25px'>Foto</th>
                                        <th>Item</th>
                                        <th width='100px'>Valor</th>
                                        <th width='70px'>Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between row">
                                <h3 id="title-requests" class="card-title "></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width:100%" id="order-requests-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25px">Foto</th>
                                        <th>Item</th>
                                        <th width="60px">Valor</th>
                                        <th width="70px">Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" id="modal-footer" style="display:none">
                <button id="send-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>ENVIAR PEDIDO</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- ADICIONAIS E OBS --}}
<div class="modal fade" id="observation-item-modal" role="dialog" tabindex="-1" aria-labelledby="observation-item-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observation-item-modalLabel">ADICIONAIS E OBSERVAÇÕES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="request_id">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title "><strong>Adicionais</strong></h5>
                    </div>
                    <form id="form-add-additional">
                        <div id="checkbox-container" class="card-body">
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> <strong>Observações</strong> </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="obs-additional" id="obs-additional" rows="8" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save-obs-item-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>SALVAR</strong></button>
            </div>
        </div>
    </div>
</div>
@endcan
@can('view_orders')
{{-- PEDIDOS DO CLIENTE --}}
<div class="modal fade" id="requests-client-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reqClienttitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills">
                    <li class="nav-item" onclick="requests_client_view_table(false)"><a class="requests nav-link rounded-pill" href="#requests" data-toggle="tab">Pedidos</a></li>
                    <li class="nav-item" onclick="requests_client_view_table(true)"><a class="pending nav-link rounded-pill" href="#pending" data-toggle="tab">Pendentes</a></li>
                </ul>
                <table style="width:100%" id="client-requests-view-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25px">Foto</th>
                            <th>Item</th>
                            <th width="30px">Qtd.</th>
                            <th width="80px">Valor</th>
                            <th width="30px">Ver</th>
                        </tr>
                    </thead>
                </table>
                <div class="tab-content">
                    <div class="requests tab-pane" id="requests">
                        <div class="col-md-5 m-t-10">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">TOTAL:</th>
                                            <td class="value-total"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="pending tab-pane" id="pending">
                        <input type="hidden" id="print_id">
                        <button type="button" onclick='print_request()' class="btn btn-accent rounded-pill float-right m-t-10"><strong>IMPRIMIR PEDIDO</strong></button>
                    </div>

                </div>

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
@endcan
@can('qr_code_actions')
@include('app.component.modal-qrcode')
@endcan
@can('view_orders')
@include('app.component.view-item')
@endcan
@endsection
@section('plugins')
<script src="{{ asset('assets/app/plugins/qr-generator/qr_generator.js') }}"></script>
<script src="{{ asset('assets/app/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('private/assets/js/request.js') }}"></script>
<script src="{{ asset('private/assets/js/tables.js') }}"></script>
@endsection

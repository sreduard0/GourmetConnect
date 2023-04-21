@extends('app.layout')
@section('title', 'Minhas entregas')
@section('menu-requests', 'menu-open')
@section('delivery', 'active')
@section('title-header', 'Minhas entregas')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <select class="text-center w-250 select-rounded  res col-md-3 m-r-5" id="filter-delivery" class="form-control" onchange="return filter_delivery()">
                    <option value='' selected>TODAS LOCAIS</option>
                    @foreach($locations as $location)
                    <option value='{{ $location->id }}'>{{ $location->neighborhood }} - {{ $location->reference }}</option>
                    @endforeach
                </select>
                <button class="btn btn-accent rounded-pill btnres" onclick="modal_new_delivery()"><strong>NOVO DELIVERY</strong></button>
            </div>
        </div>
        <div class="card-body">
            <table id="delivery-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30px">Ord.</th>
                        <th>Cliente</th>
                        <th width="30px">Bairro</th>
                        <th width='130px'>Status</th>
                        <th width="130px">Valor</th>
                        <th width="110px">Ações</th>

                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end row">
                <button class="btn btn-accent rounded-pill btnres" onclick="print_request('all')"><strong>IMPRIMIR PENDENTES</strong></button>

            </div>
        </div>

    </div>
</div>
@endsection
@section('modal')
{{-- NOVO PEDIDO / EDIDAR PEDIDO--}}
<div class="modal fade" id="new-delivery-modal" role="dialog" tabindex="-1" aria-labelledby="newReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDeliveryLabel">DELIVERY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div-select-client">
                    <form id="form-new-delivery" class="d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="border-bottom border-default m-b-20 col-md-3">
                                <h5>CLIENTE</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="delivery-client">Nome<span style="color:red">*</span></label>
                                    <input id="delivery-client" name="delivery-client" type="text" class="form-control" placeholder="EX: Pedro">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="delivery-client-phone">Telefone<span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="delivery-client-phone" name="delivery-client-phone" data-inputmask="'mask':'(99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="EX: (51) 9 9999-9999">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="border-bottom border-default m-b-20 col-md-3">
                                <h5>ENDEREÇO</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="delivery-location">Região <span style="color:red">*</span></label>
                                    <select class="text-center select-rounded form-control" id="delivery-location" name="delivery-location" class="form-control">
                                        <option value='' disabled selected>Selecione uma região</option>
                                        @foreach($locations as $location)
                                        <option value='{{ $location->id }}'>{{ $location->neighborhood }} - {{ $location->reference }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="delivery-address">Logradouro <span style="color:red">*</span></label>
                                    <input id="delivery-address" name="delivery-address" type="text" class="form-control" placeholder="EX: Rua do Açai">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="delivery-number">Nº <span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="delivery-number" name="delivery-number" data-inputmask="'mask':'9999'" data-mask="" inputmode="text" placeholder="EX: 1800">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="delivery-neighborhood">Bairro <span style="color:red">*</span></label>
                                    <input id="delivery-neighborhood" name="delivery-neighborhood" type="text" class="form-control" placeholder="EX: Centro">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="delivery-reference">Referência <span style="color:red">*</span></label>
                                    <input id="delivery-reference" name="delivery-reference" type="text" class="form-control" placeholder="EX: Casa azul">
                                </div>
                            </div>
                            <hr>
                            <div class="border-bottom border-default m-b-20 col-md-3">
                                <h5>PAGAMENTO</h5>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="payment-method">Método <span style="color:red">*</span></label>
                                    <select class="text-center select-rounded form-control " id="payment-method" name="payment-method" class="form-control">
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
                                        <option selected disabled value="">Selecione um método de pagamento</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col m-t-20">
                        <input type="hidden" id="client">
                        <div id="btn-act-form" class="d-flex justify-content-center">

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
                            <table style="width:100%" id="client-requests-table" class="table table-bordered table-striped">
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
            <div id="modal-footer" class="modal-footer" style="display:none">
                <button id="send-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>ENVIAR PEDIDO</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- PEDIDOS DO CLIENTE --}}
<div class="modal fade" id="delivery-client-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="DeliveryViewtitle"></div>
                <div class="row float-right">
                    <div id="edit-delivery-btn"></div>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn"><i class="fs-18 fa-solid fa-times"></i></button>
                </div>

            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-end" id="edit_request_btn">
                </div>
                <table style="width:100%" id="client-delivery-view-table" class="table table-bordered table-striped">
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
            </div>
            <div class="modal-footer d-flex justify-content-between row">
                <div class="col-md-3">
                    <table>
                        <tbody>
                            <tr>
                                <th style="width:50%">TOTAL:</th>
                                <td class="value-total"> R$00,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <input type="hidden" id="print_id">
                <div id="btn-act"></div>
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
                            <th width="110px">Adic. por</th>
                            <th width="80px">Valor</th>
                            <th width="60px">Ações</th>
                        </tr>
                    </thead>
                </table>
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
@include('app.component.view-item')
@endsection
@section('plugins')
<script src="{{ asset('assets/app/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('private/assets/js/delivery.js') }}"></script>
@endsection

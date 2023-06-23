@php
use App\Classes\Calculate;
use App\Classes\Tools;
@endphp
@extends('site.layout')
@section('title', 'Carrinho')
@section('content')
<!-- cart-start -->
<div class="m-t-70 cart-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <h5 class="title p-b-20"><i class="fa-duotone fa-cart-shopping"></i> CARRINHO</h5>
                    <div class="col">
                        <button id="clear-cart" class="btn btn-sm btn-danger rounded-pill float-right"><strong>LIMPAR CARRINHO</strong></button>
                    </div>
                </div>
                <table class="table table-striped" id="client-cart-table">
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
                <div class="col">
                    <button id="set_address" class="btn btn-accent rounded-pill float-right"><strong>FAZER PEDIDO</strong></button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- PEDIDOS PENDENTES/ANDAMENTOO/FINALIZADO  --}}
<div class="cart-page m-t-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-b-30">
                <h5 class="title p-b-20"><i class="fa-duotone fa-burger-soda"></i> SEUS PEDIDOS</h5>
                <ul class="nav nav-pills table-responsive">
                    <li class="nav-item p-r-5" onclick="orders_table('pending')"><a class="nav-link rounded-pill" id="pending" data-toggle="tab">Pendentes</a></li>
                    <li class="nav-item p-r-5" onclick="orders_table('production')"><a class="nav-link rounded-pill" id="production" data-toggle="tab">Em andamento</a></li>
                    <li class="nav-item p-r-5" onclick="orders_table('send-delivery')"><a class="nav-link rounded-pill" id="send-delivery" data-toggle="tab">Saiu para entrega</a></li>
                    <li class="nav-item p-r-5" onclick="orders_table('finished')"><a class="nav-link rounded-pill" id="finished" data-toggle="tab">Finalizados</a></li>
                </ul>
                <table id="orders-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="30px">Ord.</th>
                            <th width="100px">Pagamento</th>
                            <th width='200px'>Data/Hora</th>
                            <th>Endereço</th>
                            <th width="130px">Valor</th>
                            <th width="110px">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- product -->
<div class="product-area p-b-10 p-t-40">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="title p-b-20"><i class="fa-solid fa-cart-shopping"></i> VOCÊ PEDIU OUTRAS VEZES</h5>
                <div class="suggestion-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            {{-- ITEMS --}}
                            @foreach ($items as $item)
                            <div class="owl-item {{ Tools::hash($item->id,'encrypt') }}">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="javascript:void(0)" onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')" class="image">
                                            <img class="pic-1" src="{{ $item->photo_url }}" alt="product">
                                        </a>
                                        @if ($item->old_value > $item->value)
                                        <span class="product-discount-label">-{{ Calculate::discountPercentage($item->old_value,$item->value,true) }}</span>
                                        @endif
                                        @if ($item->like)
                                        <span class="product-likes-label"><i class="fas fa-heart text-danger"></i> <strong>{{$item->likes}}</strong></span>
                                        @else
                                        <span class="product-likes-label"><i class="far fa-heart text-danger"></i> <strong>{{$item->likes}}</strong></span>
                                        @endif
                                    </div>
                                    <div class="product-content">
                                        <span class="text-accent fs-12">{{ $item->type->name }}</span>
                                        <h3 class="title">{{ $item->name }}</h3>
                                        <div class="price">R${{ number_format($item->value, 2, ',', '.') }}@if($item->old_value > $item->value) <span>R${{ number_format($item->old_value, 2, ',', '.') }}</span>@endif</div>
                                        <ul class="social">
                                            @auth('client')
                                            <li><button class="btn btn-accent" onclick="return add_cart_modal('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                            @if ($item->like)
                                            <li><button class="btn btn-accent" onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                            @else
                                            <li><button class=" btn btn-accent" onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                            @endif
                                            @endauth
                                            <li><button class="btn btn-accent" onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- ITEMS --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
{{-- SET ADDRESS DELIVERY --}}
<div class="modal fade" id="set-address-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ENDEREÇO/PAGAMENTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>PAGAMENTO</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="payment-method">Qual será sua forma de pagamento? <span style="color:red">*</span></label>
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
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-md-8">
                        <hr>
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>ENDEREÇO</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="select-address">Aonde devemos entregar este pedido? <span style="color:red">*</span></label>
                                <select class="text-center select-rounded form-control " id="select-address" class="form-control">
                                    <option selected disabled value="">Selecione um endereço</option>
                                    <option value="saved-address">{{ $user->street_address.', Nº'.$user->number.' - '.$user->neighborhood.' | R$' . number_format( $user->location->value_delivery, 2, ',', '.') }}</option>
                                    <option value="other-address">Outro endereço</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="address-form" class="d-none">
                    <form id="form-set-address" class="d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="delivery-client-phone">Telefone<span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="delivery-client-phone" name="delivery-client-phone" data-inputmask="'mask':'(99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="EX: (51) 9 9999-9999">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="delivery-location">Região <span style="color:red">*</span></label>
                                    <select class="text-center select-rounded form-control" id="delivery-location" name="delivery-location" class="form-control">
                                        <option value='' disabled selected>Selecione uma região</option>
                                        @foreach($locations as $location)
                                        <option value='{{ $location->id }}'>{{ $location->neighborhood }} @if ($location->reference)- {{ $location->reference }}@endif | {{ 'R$' . number_format( $location->value_delivery, 2, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="delivery-address">Logradouro <span style="color:red">*</span></label>
                                    <input id="delivery-address" type="text" class="form-control" placeholder="EX: Rua do Açai">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="delivery-number">Nº <span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="delivery-number" data-inputmask="'mask':'9999'" data-mask="" inputmode="text" placeholder="EX: 1800">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="delivery-neighborhood">Bairro <span style="color:red">*</span></label>
                                    <input id="delivery-neighborhood" type="text" class="form-control" placeholder="EX: Centro">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="delivery-reference">Referência <span style="color:red">*</span></label>
                                    <input id="delivery-reference" type="text" class="form-control" placeholder="EX: Casa azul">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="send-cart" type="button" class="btn btn-accent rounded-pill"><strong>FINALIZAR</strong></button>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- UPDATE ADDRESS DELIVERY --}}
<div class="modal fade" id="update-address-modal" role="dialog" tabindex="-1" aria-labelledby="AddressClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDITAR ENDEREÇO/PAGAMENTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>PAGAMENTO</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="new-payment-method">Qual será sua forma de pagamento? <span style="color:red">*</span></label>
                                <select class="text-center select-rounded form-control " id="new-payment-method" name="new-payment-method" class="form-control">
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
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-md-8">
                        <hr>
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>ENDEREÇO</h5>
                        </div>
                        <div class="row">
                            <form id="form-set-address" class="d-flex justify-content-center">
                                <div class="col">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="new-delivery-client-phone">Telefone<span style="color:red">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="new-delivery-client-phone" name="new-delivery-client-phone" data-inputmask="'mask':'(99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="EX: (51) 9 9999-9999">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="new-delivery-location">Região <span style="color:red">*</span></label>
                                            <select class="text-center select-rounded form-control" id="new-delivery-location" name="new-delivery-location" class="form-control">
                                                <option value='' disabled selected>Selecione uma região</option>
                                                @foreach($locations as $location)
                                                <option value='{{ $location->id }}'>{{ $location->neighborhood }} @if ($location->reference)- {{ $location->reference }}@endif | {{ 'R$' . number_format( $location->value_delivery, 2, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="new-delivery-address">Logradouro <span style="color:red">*</span></label>
                                            <input id="new-delivery-address" type="text" class="form-control" placeholder="EX: Rua do Açai">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="new-delivery-number">Nº <span style="color:red">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="new-delivery-number" data-inputmask="'mask':'9999'" data-mask="" inputmode="text" placeholder="EX: 1800">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="new-delivery-neighborhood">Bairro <span style="color:red">*</span></label>
                                            <input id="new-delivery-neighborhood" type="text" class="form-control" placeholder="EX: Centro">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="new-delivery-reference">Referência <span style="color:red">*</span></label>
                                            <input id="new-delivery-reference" type="text" class="form-control" placeholder="EX: Casa azul">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button id="update-address" type="button" class="btn btn-accent rounded-pill"><strong>SALVAR</strong></button>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- ITEMS DO CLIENTE --}}
<div class="modal fade" id="items-request-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
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
                <table style="width:100%" id="items-request-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25px">Foto</th>
                            <th>Item</th>
                            <th width="30px">Qtd.</th>
                            <th width="80px">Valor</th>
                            <th>Ver</th>
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
                                <td class="order-total-value"> R$00,00</td>
                            </tr>
                        </tbody>
                    </table>
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
{{-- EDITAR ITEM   --}}
<div class="modal fade" id="edit-item" role="dialog" tabindex="-1" aria-labelledby="edit-item-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDITAR ITEM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title "><strong>Adicionais</strong></h5>
                    </div>
                    <form id="form-add-additional-edit">
                        <div id="checkbox-container-edit-item" class="card-body">
                        </div>
                    </form>
                </div>
                <div class="card m-t-20">
                    <div class="card-header">
                        <h5 class="card-title"> <strong>Observações</strong> </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea id="edit-obs-item-request" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="item_id">
                <button onclick="save_edit_item()" type="button" class="btn btn-accent rounded-pill"><strong>SALVAR</strong></button>

            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<script src="{{ asset('assets/site/js/cart.js') }}"></script>
<script src="{{ asset('assets/site/js/inputmask.js') }}"></script>
@endsection

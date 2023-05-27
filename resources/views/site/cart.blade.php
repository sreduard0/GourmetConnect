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
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill float-right"><strong>LIMPAR CARRINHO</strong></button>
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
                    <button type="submit" class="btn btn-accent rounded-pill float-right"><strong>ENVIAR PEDIDO</strong></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart -->
<div class="cart-page m-t-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-b-30">
                <h5 class="title p-b-20"><i class="fa-duotone fa-burger-soda"></i> PEDIDOS</h5>
                <ul class="nav nav-pills table-responsive">
                    <li class="nav-item" onclick="cart_table('pending')"><a class="pending nav-link rounded-pill" href="#pending" data-toggle="tab">Pendentes</a></li>
                    <li class="nav-item" onclick="cart_table('production')"><a class="pending nav-link rounded-pill" href="#production" data-toggle="tab">Em andamento</a></li>
                    <li class="nav-item" onclick="cart_table('send-delivery')"><a class="pending nav-link rounded-pill" href="#send-delivery" data-toggle="tab">Saiu para entrega</a></li>
                </ul>
                <table id="orders-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="30px">Ord.</th>
                            <th>Cliente</th>
                            <th width='200px'>Contato</th>
                            <th width="150px">Bairro</th>
                            <th width='130px'>Status</th>
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

@endsection
@section('plugins')
<script src="{{ asset('assets/site/js/cart.js') }}"></script>
@endsection

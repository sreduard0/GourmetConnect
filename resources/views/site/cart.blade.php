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
                <div class="pb-20 float-right">
                    <button type="submit" class="btn btn-accent rounded-pill ">Limpar carrinho</button>
                </div>
                <ul class="nav nav-pills">
                    <li class="nav-item" onclick="cart_table(false)"><a class="requests nav-link rounded-pill active" href="#requests" data-toggle="tab">Pedidos</a></li>
                    <li class="nav-item" onclick="cart_table(true)"><a class="pending nav-link rounded-pill" href="#pending" data-toggle="tab">Pendentes</a></li>
                </ul>

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

                <div class="tab-content">
                    <div class="requests tab-panel" id="requests">
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
                <div class="pt-50 float-right">
                    <button type="submit" class="btn btn rounded-pill">Enviar pedido</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product -->
<section class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>PEÇA TAMBÉM</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="col-md-12">
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
</section>
@endsection
@section('model')

@endsection
@section('plugins')
<script src="{{ asset('assets/site/js/cart.js') }}"></script>
@endsection

@php
use App\Classes\Calculate;
use App\Classes\Tools;
@endphp
@extends('site.layout')
@section('title', 'Início')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
<script src="{{ asset('assets/site/js/likes.js') }}"></script>
<script src="{{ asset('assets/site/js/items.js') }}"></script>
@endsection
@section('content')
<section class="banner-slider-area">
    <div class="slider-area-full owl-carousel owl-theme owl-loaded owl-drag">
        <div class="owl-stage-outer">
            <div class="owl-stage">
                {{-- BANNER --}}
                @foreach ($banners as $banner)
                <div class="owl-item">
                    <div class="silder-single silder-single-img" style="background:url('{{ asset($banner['url_banner']) }}')">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 col-md-12 col-sm-12">
                                    <div class="slider-single-full">
                                        <h2>{{ $banner['title'] }}</h2>
                                        <p>{!! $banner['description'] !!}</p>
                                        <div class="button-bar pt-20 rounded-pill">
                                            <a href="#" class="btn btn-lg">
                                                <span>Ver</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <div class="hero-slider-img">
                                        <img class="image-1" src="{{ asset($banner['url_img1']) }}">
                                        <img class="image-2" src="{{ asset($banner['url_img2']) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- BANNER --}}
            </div>
        </div>
    </div>
</section>
{{-- <!-- shop -->
<div class="shop-now section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="shop-box">
                    <img src="img/shop4.jpg" alt="shop">
                    <div class="box-content">
                        <ul class="icon">
                            <li><a href="#">Shop Now</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="shop-box">
                    <img src="img/shop5.jpg" alt="shop">
                    <div class="box-content">
                        <ul class="icon">
                            <li><a href="#">Shop Now</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- categorys -->
<section class="category-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading section-heading2">
                    <h2>CATEGORIAS</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="category-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage">

                        {{-- CATEGORIA --}}
                        @foreach ($types as $type)
                        <div class="owl-item">
                            <div class="shop-box category-box">
                                <img src="{{ asset($type->photo_url) }}">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">{{ $type->name }}</a></li>
                                    </ul>
                                </div>
                                <div class="cat-title-content">
                                    <span class="cat-title">{{ $type->name }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- CATEGORIA --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product -->
<section class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>CARDÁPIO</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage">
                        {{-- ITEMS --}}
                        @foreach ($items as $item)
                        <div class="owl-item {{ Tools::hash($item->id,'encrypt') }}">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
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
                                    <span class="text-danger fs-10">{{ $item->type->name }}</span>
                                    <h3 class="title"><a href="">{{ $item->name }}</a></h3>
                                    <div class="price">R${{ number_format($item->value, 2, ',', '.') }}@if($item->old_value > $item->value) <span>R${{ number_format($item->old_value, 2, ',', '.') }}</span>@endif</div>
                                    <ul class="social">
                                        <li><button onclick="return add_cart('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                        @auth('client')
                                        @if ($item->like)
                                        <li><button onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                        @else
                                        <li><button onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                        @endif
                                        @endauth
                                        <li><button onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>
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
</section>
<!-- promoções -->
<section class="promo-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>PROMOÇÕES</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="promo-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage">
                        {{-- ITEMS NA PROMO--}}
                        @foreach ($promo as $item)
                        <div class="owl-item {{ Tools::hash($item->id,'encrypt') }}">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="{{ $item->photo_url }}" alt="product">
                                    </a>
                                    <span class="product-discount-label">-{{ Calculate::discountPercentage($item->old_value,$item->value,true) }}</span>
                                    @if ($item->like)
                                    <span class="product-likes-label"><i class="fas fa-heart text-danger"></i> <strong>{{$item->likes}}</strong></span>
                                    @else
                                    <span class="product-likes-label"><i class="far fa-heart text-danger"></i> <strong>{{$item->likes}}</strong></span>
                                    @endif
                                </div>
                                <div class="product-content">
                                    <span class="text-danger fs-10">{{ $item->type->name }}</span>
                                    <h3 class="title"><a href="">{{ $item->name }}</a></h3>
                                    <div class="price">R${{ number_format($item->value, 2, ',', '.') }}<span>R${{ number_format($item->old_value, 2, ',', '.') }}</span></div>
                                    <ul class="social">
                                        <li><button onclick="return new_order('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                        @auth('client')
                                        @if ($item->like)
                                        <li><button onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                        @else
                                        <li><button onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                        @endif
                                        @endauth
                                        <li><button onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- ITEMS NA PROMO --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- mais pedidos -->
<section class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>MAIS PEDIDOS</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-2612px, 0px, 0px); transition: all 0.25s ease 0s; width: 4571px;">
                        {{-- MAIS PEDIDOS --}}
                        @foreach ($more_requests as $item)
                        <div class="owl-item {{ Tools::hash($item->product->id,'encrypt') }}">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="{{ $item->product->photo_url }}" alt="product">
                                    </a>
                                    @if ($item->product->old_value > $item->product->value)
                                    <span class="product-discount-label">-{{ Calculate::discountPercentage($item->product->old_value,$item->product->value,true) }}</span>
                                    @endif
                                    @if ($item->product->like)
                                    <span class="product-likes-label"><i class="fas fa-heart text-danger"></i> <strong>{{$item->product->likes}}</strong></span>
                                    @else
                                    <span class="product-likes-label"><i class="far fa-heart text-danger"></i> <strong>{{$item->product->likes}}</strong></span>
                                    @endif
                                </div>
                                <div class="product-content">
                                    <span class="text-danger fs-10">{{ $item->product->type->name }}</span>
                                    <h3 class="title"><a href="">{{ $item->product->name }}</a></h3>
                                    <div class="price">R${{ number_format($item->product->value, 2, ',', '.') }}@if($item->product->old_value > $item->product->value) <span>R${{ number_format($item->product->old_value, 2, ',', '.') }}</span>@endif</div>
                                    <ul class="social">
                                        <li><button onclick="return new_order('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                        @auth('client')
                                        @if ($item->product->like)
                                        <li><button onclick="return like_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                        @else
                                        <li><button onclick="return like_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                        @endif
                                        @endauth
                                        <li><button onclick="return view_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- MAIS PEDIDOS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- review-area -->
<section class="client-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading section-heading2">
                    <h2>COMENTARIOS</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="client-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            {{-- COMENTARIOS --}}
                            <div class="owl-item">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/3_002.jpg" alt="1">
                                    </div>
                                    <div class="testimonial-content">
                                        <ul>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                        </ul>
                                        <p class="description">
                                            Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Vivamus sed accumsan diam. Suspendisse molestie nibh at
                                            tempor mollis. Integer aliquet facilisis felis, ac porta est cursus et.
                                        </p>
                                        <h3 class="testimonial-title">Sajib Rahman</h3>

                                    </div>
                                </div>
                            </div>
                            {{-- COMENTARIOS --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ///blog-area -->
@auth('client')
<section class="blog-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>DEIXE SEU COMENTARIO</h2>
                </div>
            </div>
        </div>
        <div class="col pt-40">
            <div class="d-flex justify-content-center">
                <form id="commit-form" class="col-md-8">
                    <div class="form-group col">
                        <label>Classificação<span class="text-danger">*</span>
                        </label>
                        <select class="form-control" style="background-color: #000" name="rating" id="rating">
                            <option value="">Selecione</option>
                            <option value="1">Ruim</option>
                            <option value="2">Regular</option>
                            <option value="3">Bom</option>
                            <option value="4">Muito bom</option>
                            <option value="5">Ótimo</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label>Comentario<span class="text-danger">*</span>
                        </label>
                        <textarea name="message" class="form-control" cols="10" rows="6"></textarea>
                    </div>
                    <div class="button-bar">
                        <button type="submit" class="btn btn-lg">Enviar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@endauth

@endsection
@section('modal')
{{-- VER ITEM --}}
<div class="modal fade" id="view-item" tabindex="-1" aria-labelledby="view-itemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h3 class="text-light modal-title" id="item-name"></h3>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="modal-img">
                                <img style="border-radius:20px" id="item-img" src="" alt="1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="details-info">
                                <div class="detail-rating">
                                    <ul>
                                        <li><i class="fas fa-heart"></i><span id="item-likes" class="text-light">0</span></li>
                                    </ul>
                                </div>
                                <div class="product-price">
                                    <span id="item-value" class="money-price"></span>
                                    <span id="item-old-value" class="old-price"></span>
                                </div>
                                <div id="item-description" class="detail-description">
                                </div>
                                <div class="product-qty">
                                    <span class="qtys">Quantidade:</span>
                                    <div class="counter-qty">
                                        <span class="down" onclick="decreaseCount(event, this)">-</span>
                                        <input type="text" value="1">
                                        <span class="up" onclick="increaseCount(event, this)">+</span>
                                    </div>
                                </div>
                                <div class="pro-detail-button">
                                    <ul>
                                        <li><a href="#" title="wish list"><i class="far fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa-solid fa-cart-circle-plus"></i> Adicionar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- NOVO PEDIDO --}}
<div class="modal fade" id="new-order" role="dialog" tabindex="-1" aria-labelledby="newReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title text-light">PEDIDOS</h5>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer" id="modal-footer" style="display:none">
                <button id="send-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>ENVIAR PEDIDO</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- ADICIONAIS E OBS --}}
<div class="modal fade" id="observation-item" role="dialog" tabindex="-1" aria-labelledby="observation-item-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title text-light">ADICIONAIS E OBSERVAÇÕES</h5>
                <button type="button" class="btn btn-sm btn-danger close" data-dismiss="modal" aria-label="Close">
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
                <div class="card m-t-20">
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
            <div class="modal-footer  d-flex justify-content-between">
                <div class="counter-qty">
                    <span class="down" onclick="decreaseCount(event, this)">-</span>
                    <input id="qty-item-request" type="text" value="1">
                    <span class="up" onclick="increaseCount(event, this)">+</span>
                </div>
                <button id="save-obs-item-request" type="button" class="btn btn-danger rounded-pill float-right"><strong>ADICIONAR</strong></button>
            </div>
        </div>
    </div>
</div>
@endsection

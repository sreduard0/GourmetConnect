@php
use App\Classes\Calculate;
use App\Classes\Tools;
@endphp
@extends('site.layout')
@section('title', 'Início')
@section('home_tab', 'active')
@section('script')
@auth('client')
<script src="{{ asset('assets/site/js/comments.js') }}"></script>
@endauth
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
                                        <div class="button-bar pt-20">
                                            <a href="#" class="rounded-pill btn btn-lg">

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
        <div class="row pt-70">
            <div class="col-md-12">
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
                                            <li><a href="{{ route('menu_client').'#'.strtolower($type->name) }}-tab">{{ $type->name }}</a></li>

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
            <div class="col-md-12">
                <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">
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
@if (count($promo)>0)
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
            <div class="col-md-12">
                <div class="promo-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            {{-- ITEMS NA PROMO--}}
                            @foreach ($promo as $item)
                            <div class="owl-item {{ Tools::hash($item->id,'encrypt') }}">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="javascript:void(0)" onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')" class="image">
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
                                        <span class="text-accent fs-12">{{ $item->type->name }}</span>
                                        <h3 class="title">{{ $item->name }}</h3>
                                        <div class="price">R${{ number_format($item->value, 2, ',', '.') }}<span>R${{ number_format($item->old_value, 2, ',', '.') }}</span></div>
                                        <ul class="social">
                                            @auth('client')
                                            <li><button class="btn btn-accent" onclick="return add_cart_modal('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                            @if ($item->like)
                                            <li><button class="btn btn-accent" onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                            @else
                                            <li><button class="btn btn-accent" onclick="return like_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                            @endif
                                            @endauth
                                            <li><button class="btn btn-accent" onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>
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
    </div>
</section>
@endif
@if (count($more_requests)>0)
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
            <div class="col-md-12">
                {{-- MAIS PEDIDOS --}}

                <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(-2612px, 0px, 0px); transition: all 0.25s ease 0s; width: 4571px;">
                            @foreach ($more_requests as $item)
                            <div class="owl-item {{ Tools::hash($item->product->id,'encrypt') }}">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="javascript:void(0)" onclick="return view_item('{{ Tools::hash($item->id,'encrypt') }}')" class="image">
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
                                        <span class="text-accent fs-12">{{ $item->product->type->name }}</span>
                                        <h3 class="title">{{ $item->product->name }}</h3>
                                        <div class="price">R${{ number_format($item->product->value, 2, ',', '.') }}@if($item->product->old_value > $item->product->value) <span>R${{ number_format($item->product->old_value, 2, ',', '.') }}</span>@endif</div>
                                        <ul class="social">
                                            @auth('client')
                                            <li><button class="btn btn-accent" onclick="return add_cart_modal('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fa-solid fa-cart-circle-plus"></i></button></li>
                                            @if ($item->product->like)
                                            <li><button class="btn btn-accent" onclick="return like_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fas fa-heart"></i></button></li>
                                            @else
                                            <li><button class="btn btn-accent" onclick="return like_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="far fa-heart"></i></button></li>
                                            @endif
                                            @endauth
                                            <li><button class="btn btn-accent" onclick="return view_item('{{ Tools::hash($item->product->id,'encrypt') }}')"><i class="fa fa-eye"></i></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- MAIS PEDIDOS --}}
            </div>
        </div>
    </div>
</section>
@endif
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
                @if (count($comments)>0)
                <div class="client-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            {{-- COMENTARIOS --}}
                            @foreach ($comments as $comment)
                            <div class="owl-item">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="{{ asset($comment->client->photo_url) }}" alt="1">
                                    </div>
                                    <div class="testimonial-content">
                                        <h3 class="testimonial-title">{{ $comment->client->first_name }} </h3>
                                        <h5><i class="text-warning fa-solid fa-star"></i> {{ $comment->rating }}</h5>
                                        <p class="description">{{ $comment->comments }}</p>
                                    </div>
                                    <span class="date"><i class="fa-duotone fa-calendar"></i> {{ date('d/m/Y',strtotime($comment->created_at)) }} às {{ date('h:i',strtotime($comment->created_at)) }}</span>
                                </div>

                            </div>
                            @endforeach
                            {{-- COMENTARIOS --}}
                        </div>
                    </div>
                </div>
                @else
                <div class="client-slider owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <span class="no-data fs-18">Ainda não há comentários.</span>
                        </div>
                    </div>
                </div>
                @endif
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
                    <h2>DEIXE SEU COMENTÁRIO</h2>
                </div>
            </div>
        </div>
        <div class="col pt-40">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <form id="commit-form">
                        <div class="form-group col">
                            <label>Avaliação<span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="rating" id="rating">
                                <option value="">Selecione</option>
                                <option value="1">Ruim</option>
                                <option value="2">Regular</option>
                                <option value="3">Bom</option>
                                <option value="4">Muito bom</option>
                                <option value="5">Ótimo</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>Comentário<span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" id="comment" class="form-control" cols="10" rows="6"></textarea>
                        </div>
                    </form>

                    <div class="button-bar col">
                        <button onclick="comment()" class="btn rounded-pill">Enviar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endauth
@endsection

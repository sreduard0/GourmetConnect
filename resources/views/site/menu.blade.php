@php
use App\Classes\Calculate;
use App\Classes\Tools;
@endphp
@extends('site.layout')
@section('title', 'Cardápio')
@section('menu_tab', 'active')
@section('plugins')
<script src="{{ asset('assets/site/js/menu.js') }}"></script>
@endsection
@section('content')
<!-- categorys -->
<section class="category-area section-padding m-t-100">
    <div class="container">
        <div class="row pt-40">
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
                                            <li><a href="#{{ strtolower($type->name) }}-tab">{{ $type->name }}</a></li>
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
@foreach ($types as $type)
<!-- product -->
<section id="{{ strtolower($type->name) }}-tab" class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>{{ $type->name }}</h2>
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
                            @if ($type->id == $item->type_id)
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
                            @endif
                            @endforeach
                            {{-- ITEMS --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endforeach
@endsection

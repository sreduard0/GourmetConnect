@extends('site.layout')
@section('title', 'Início')
@section('content')
<section class="banner-slider-area">
    <div class="slider-area-full owl-carousel owl-theme owl-loaded owl-drag">
        <div class="owl-stage-outer">
            <div class="owl-stage" style="transition: all 0.25s ease 0s; width: 13440px; transform: translate3d(-5760px, 0px, 0px);">
                {{-- BANNER --}}
                @foreach ($banners as $banner)
                <div class="owl-item" style="width: 1920px;">
                    <div class="silder-single silder-single-img" style="background:url('{{ asset($banner['url_banner']) }}')">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 col-md-12 col-sm-12">
                                    <div class="slider-single-full">
                                        <h2>{{ $banner['title'] }}</h2>
                                        <p>{{ $banner['description'] }}</p>
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
<!-- shop -->
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
</div>
<!-- product -->
<section class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Featured products</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-2612px, 0px, 0px); transition: all 0.25s ease 0s; width: 4571px;">
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Vegetable</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/8_002.jpg" alt="product">
                                        <img class="pic-2" src="img/9.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-23%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta With Red Sauce</a></h3>
                                    <div class="price">$15.00<span>$20.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/10.jpg" alt="product">
                                        <img class="pic-2" src="img/11.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Person Holding Pizza</a></h3>
                                    <div class="price">$25.00<span>$35.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/1_002.jpg" alt="shop">
                                        <img class="pic-2" src="img/2_004.jpg" alt="shop">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Lettuce</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/17.jpg" alt="product">
                                        <img class="pic-2" src="img/18.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-20%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta on Brown Surface</a></h3>
                                    <div class="price">$24.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Vegetable</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/8_002.jpg" alt="product">
                                        <img class="pic-2" src="img/9.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-23%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta With Red Sauce</a></h3>
                                    <div class="price">$15.00<span>$20.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/10.jpg" alt="product">
                                        <img class="pic-2" src="img/11.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Person Holding Pizza</a></h3>
                                    <div class="price">$25.00<span>$35.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/1_002.jpg" alt="shop">
                                        <img class="pic-2" src="img/2_004.jpg" alt="shop">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Lettuce</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/17.jpg" alt="product">
                                        <img class="pic-2" src="img/18.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-20%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta on Brown Surface</a></h3>
                                    <div class="price">$24.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Vegetable</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- categorys -->
<section class="category-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading section-heading2">
                    <h2>Shop By Category</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="category-slider owl-carousel owl-theme owl-loaded owl-drag">
                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-1306px, 0px, 0px); transition: all 0s ease 0s; width: 4245px;">
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/2_003.jpg" alt="prd">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">French Fries</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/3_003.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pizza</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/4_004.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pasta</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/3_003.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pizza</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/1_004.jpg" alt="cate">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Burgers</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/2_003.jpg" alt="prd">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">French Fries</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/3_003.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pizza</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/4_004.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pasta</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/3_003.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pizza</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/1_004.jpg" alt="cate">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Burgers</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/2_003.jpg" alt="prd">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">French Fries</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/3_003.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pizza</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="shop-box category-box">
                                <img src="img/4_004.jpg" alt="product">
                                <div class="box-content">
                                    <ul class="icon">
                                        <li><a href="#">Pasta</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Our Products</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="product-slider owl-carousel owl-theme owl-loaded owl-drag">






                <div class="owl-stage-outer">
                    <div class="owl-stage" style="transform: translate3d(-2612px, 0px, 0px); transition: all 0.25s ease 0s; width: 4571px;">
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Leafy</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/8_002.jpg" alt="product">
                                        <img class="pic-2" src="img/9.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-23%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta With Red Sauce</a></h3>
                                    <div class="price">$15.00<span>$20.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/10.jpg" alt="product">
                                        <img class="pic-2" src="img/11.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Person Holding Pizza</a></h3>
                                    <div class="price">$25.00<span>$35.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/1_002.jpg" alt="product">
                                        <img class="pic-2" src="img/2_004.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Tomatoes</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/17.jpg" alt="product">
                                        <img class="pic-2" src="img/18.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-20%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta on Brown Surface</a></h3>
                                    <div class="price">$24.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Leafy</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/8_002.jpg" alt="product">
                                        <img class="pic-2" src="img/9.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-23%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta With Red Sauce</a></h3>
                                    <div class="price">$15.00<span>$20.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/10.jpg" alt="product">
                                        <img class="pic-2" src="img/11.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Person Holding Pizza</a></h3>
                                    <div class="price">$25.00<span>$35.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/1_002.jpg" alt="product">
                                        <img class="pic-2" src="img/2_004.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Tomatoes</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned active" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/17.jpg" alt="product">
                                        <img class="pic-2" src="img/18.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">-20%</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta on Brown Surface</a></h3>
                                    <div class="price">$24.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/6_002.jpg" alt="product">
                                        <img class="pic-2" src="img/5.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">Sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">Burger With Leafy</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="owl-item cloned" style="width: 316.5px; margin-right: 10px;">
                            <div class="product-grid">
                                <div class="product-image">
                                    <a href="#" class="image">
                                        <img class="pic-1" src="img/7.jpg" alt="product">
                                        <img class="pic-2" src="img/15.jpg" alt="product">
                                    </a>
                                    <span class="product-discount-label">sale</span>
                                </div>
                                <div class="product-content">
                                    <ul class="rating">
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star"></li>
                                        <li class="fas fa-star disable"></li>
                                    </ul>
                                    <h3 class="title"><a href="https://preetheme.com/liton/foodbar/product-details.html">BPerson Holding a Burger</a></h3>
                                    <div class="price">$20.00<span>$30.00</span></div>
                                    <ul class="social">
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#"><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- offer -->
<section class="offer-area " style="background:url('assets/img/shop/timmer.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="book-deal">
                    <div class="timer counter">
                        <h4>We offer a hot deal offer every festival</h4>
                        <h1 id="head">Deal off the day</h1>
                        <ul>
                            <li><span id="days">-266</span>days</li>
                            <li><span id="hours">-23</span>Hours</li>
                            <li><span id="minutes">-55</span>Minutes</li>
                            <li><span id="seconds">-19</span>Seconds</li>
                        </ul>
                    </div>
                    <div class="button-bar pt-20">
                        <a href="#" class="btn btn-lg">
                            <span>Shop Now</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-item-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="item-title">
                    <h3>Offer Products</h3>
                </div>
                <div class="offer-single" style="background:url('assets/img/single/side.jpg')">
                    <div class="offer-text">
                        <h2>Discount Offer For You</h2>
                        <div class="button-bar pt-20">
                            <a href="#" class="btn btn-lg">
                                <span>Shop Now</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="single-prd-item">
                    <div class="item-title">
                        <h3>Sale Products</h3>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/1_003.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Bacon Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/2_005.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Freanch Frie</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/3_004.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Bacon Pizza</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$20</del>
                                <span>$18</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/4_003.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Vegetable Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="single-prd-item">
                    <div class="item-title">
                        <h3>Trendy Product</h3>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/5_002.jpg" alt="5.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Cream Burger </a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/6.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Freanch Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/7_002.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Chicken Pizza</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html"><img src="img/8.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="#">Tomato Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$30</del>
                                <span>$15</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="single-prd-item single-itm-pr">
                    <div class="item-title">
                        <h3>Recent Products</h3>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/9_002.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Japani Pizza</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/10_002.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Tatka Friench</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/11_002.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Meaf Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$15</del>
                                <span>$12</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-single">
                        <div class="item-img">
                            <a href="#"><img src="img/12.jpg" alt="1.jpg"></a>
                        </div>
                        <div class="item-text">
                            <a href="https://preetheme.com/liton/foodbar/product-details.html">Chains Burger</a>
                            <ul class="mt-stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <div class="item-price">
                                <del>$25</del>
                                <span>$22</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- phone-contact -->
<section class="phone-contact" style="background:url('assets/img/about/time.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="call-now">
                    <h4>Any Have a Quesitons</h4>
                    <h3>+7645242368</h3>
                    <div class="button-bar pt-20">
                        <a href="#" class="btn btn-lg btn-1">
                            <span>Make A Call</span>
                        </a>
                        <a href="#" class="btn btn-lg">
                            <span>Contact Us</span>
                        </a>
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
                    <h2>Clients Says</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="client-slider owl-carousel owl-theme owl-loaded owl-drag">




                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(-1944px, 0px, 0px); transition: all 0.25s ease 0s; width: 5184px;">
                            <div class="owl-item cloned" style="width: 648px;">
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
                            <div class="owl-item cloned" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/4.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Armin Rahman</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/1_005.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Abdur Rajjak</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item active" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/2_002.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Noman Bin</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item active" style="width: 648px;">
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
                            <div class="owl-item" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/4.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Armin Rahman</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item cloned" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/1_005.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Abdur Rajjak</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item cloned" style="width: 648px;">
                                <div class="testimonial-client">
                                    <div class="pic">
                                        <img src="img/2_002.jpg" alt="1">
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
                                        <h3 class="testimonial-title">Noman Bin</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ///blog-area -->
<section class="blog-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Our Food Stories</h2>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="col-md-12">
                <div id="news-slider" class="owl-carousel owl-theme owl-loaded owl-drag">





                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2592px;">
                            <div class="owl-item active" style="width: 648px;">
                                <div class="post-slide">
                                    <div class="post-img">
                                        <img src="img/1.jpg" alt="1">
                                        <div class="over-layer">
                                            <ul class="post-link">
                                                <li><a href="#" class="fa fa-search"></a></li>
                                                <li><a href="#" class="fa fa-link"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post-review">
                                        <h3 class="post-title"><a href="#">Person Holding a Slice of Pizza</a></h3>
                                        <ul class="post-info">
                                            <li>Comment: 2</li>
                                            <li>Date: march 21, 2022</li>
                                            <li>Author:Rahim</li>
                                        </ul>
                                        <ul class="tag-info">
                                            <li>Tags:</li>
                                            <li><a href="">Pizza,</a></li>
                                            <li><a href="">Pasta,</a></li>
                                            <li><a href="">Burgers</a></li>
                                        </ul>
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Curabitur eleifend a massa rhoncus gravida. Nullam in
                                            viverra sapien. Nunc bibendum nec lectus et vulputate. Nam.
                                        </p>
                                        <a href="#" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item active" style="width: 648px;">
                                <div class="post-slide">
                                    <div class="post-img">
                                        <img src="img/2.jpg" alt="2">
                                        <div class="over-layer">
                                            <ul class="post-link">
                                                <li><a href="#" class="fa fa-search"></a></li>
                                                <li><a href="#" class="fa fa-link"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post-review">
                                        <h3 class="post-title"><a href="#">Person Holding a Slice of Pizza</a></h3>
                                        <ul class="post-info">
                                            <li>Comment: 5</li>
                                            <li>Date: march 21, 2022</li>
                                            <li>Author:Rajjak</li>
                                        </ul>
                                        <ul class="tag-info">
                                            <li>Tags:</li>
                                            <li><a href="">Friench,</a></li>
                                            <li><a href="">Pasta,</a></li>
                                            <li><a href="">Burgers</a></li>
                                        </ul>
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Curabitur eleifend a massa rhoncus gravida. Nullam in
                                            viverra sapien. Nunc bibendum nec lectus et vulputate. Nam.
                                        </p>
                                        <a href="#" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item" style="width: 648px;">
                                <div class="post-slide">
                                    <div class="post-img">
                                        <img src="img/3.jpg" alt="3">
                                        <div class="over-layer">
                                            <ul class="post-link">
                                                <li><a href="#" class="fa fa-search"></a></li>
                                                <li><a href="#" class="fa fa-link"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post-review">
                                        <h3 class="post-title"><a href="#">Person Holding a Slice of Pizza</a></h3>
                                        <ul class="post-info">
                                            <li>Comment: 2</li>
                                            <li>Date: April 21, 2022</li>
                                            <li>Author:Minar Rahman</li>
                                        </ul>
                                        <ul class="tag-info">
                                            <li>Tags:</li>
                                            <li><a href="">Pizza,</a></li>
                                            <li><a href="">Pasta,</a></li>
                                            <li><a href="">Burgers</a></li>
                                        </ul>
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Curabitur eleifend a massa rhoncus gravida. Nullam in
                                            viverra sapien. Nunc bibendum nec lectus et vulputate. Nam.
                                        </p>
                                        <a href="#" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item" style="width: 648px;">
                                <div class="post-slide">
                                    <div class="post-img">
                                        <img src="img/4_002.jpg" alt="4">
                                        <div class="over-layer">
                                            <ul class="post-link">
                                                <li><a href="#" class="fa fa-search"></a></li>
                                                <li><a href="#" class="fa fa-link"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post-review">
                                        <h3 class="post-title"><a href="#">Person Holding a Slice of Pizza</a></h3>
                                        <ul class="post-info">
                                            <li>Comment: 2</li>
                                            <li>Date: April 26, 2022</li>
                                            <li>Author:Nurul</li>
                                        </ul>
                                        <ul class="tag-info">
                                            <li>Tags:</li>
                                            <li><a href="">Pizza,</a></li>
                                            <li><a href="">Pasta,</a></li>
                                            <li><a href="">Burgers</a></li>
                                        </ul>
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit. Curabitur eleifend a massa rhoncus gravida. Nullam in
                                            viverra sapien. Nunc bibendum nec lectus et vulputate. Nam.
                                        </p>
                                        <a href="#" class="read-more">read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- newsletters -->
<section class="Newsletter-area" style="background:url('assets/img/blog/news.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="subcribe-content">
                    <h3>Subscribe to our weakly Newsletter</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur, adipisicing elit.</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 align-self-center">
                <div class="subscribe">
                    <input type="search" placeholder="Enter Email">
                    <input type="submit" value="subscribe">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="modal-img">
                                <img src="img/1_002.jpg" alt="1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="details-info">
                                <div class="detail-title">
                                    <h3>Barcon Pizza</h3>
                                </div>
                                <div class="detail-rating">
                                    <ul>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                    </ul>
                                </div>
                                <div class="detail-stock">
                                    <h4>
                                        <span>Stock:</span>
                                        <span>In Stock</span>
                                    </h4>
                                </div>
                                <div class="product-price">
                                    <span class="money-price">$400</span>
                                    <span class="old-price">$300</span>
                                </div>
                                <div class="detail-description">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam
                                        dicta modi aut eum, libero. Consequatur eligendi, tempora voluptatum
                                        obcaecati nulla veniam minima magni odio nobis dolore ea animi, esse!
                                        Magnam?</p>
                                </div>
                                <div class="product-qty">
                                    <span class="qtys">Quantity:</span>
                                    <div class="counter-qty">
                                        <span class="down" onclick="decreaseCount(event, this)">-</span>
                                        <input type="text" value="1">
                                        <span class="up" onclick="increaseCount(event, this)">+</span>
                                    </div>
                                </div>
                                <div class="pro-detail-button">
                                    <ul>
                                        <li><a href="#" title="wish list"><i class="far fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fas fa-shopping-cart"></i>Add Cart</a></li>
                                        <li><a href="#">Buy Now</a></li>
                                    </ul>
                                </div>
                                <div class="share-social">
                                    <ul>
                                        <li class="text">Share:</li>
                                        <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
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
@endsection

@extends('site.layout')
@section('title', 'Blog')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/site/css/slick.css')}}">
<link rel="stylesheet" href="{{ asset('assets/site/css/slick-theme.css')}}">
<link rel="stylesheet" href="{{ asset('assets/site/css/magnific-popup.css')}}">
@endsection
@section('content')
<section class="home-page home-img" style="background: url('assets/img/banner/page.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-content">
                    <div class="page-text">
                        <h4>Wellcome to Our Resturent</h4>
                        <h2>blog</h2>
                    </div>
                    <div class="page-add">
                        <ul>
                            <li><a class="page-active" href="https://preetheme.com/liton/foodbar/index.html">Home</a></li>
                            <li><a href="https://preetheme.com/liton/foodbar/product-details.html">blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="bolg-page section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <!--single-blog-->
                <div class="blog-single2">
                    <div class="blog-img">
                        <img src="blog_arquivos/1.jpg" alt="blog">
                        <div class="wt-post-meta">
                            <ul>
                                <li class="post-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <strong>23 june 2021</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="blog-text blog-text2">
                        <h4><a href="#">Sed ut perspiciatis unde omnis iste natus</a></h4>
                        <ul>
                            <li><i class="fas fa-user"></i>By Johan /</li>
                            <li><i class="fas fa-comment-dots"></i>55</li>
                            <li><i class="fas fa-eye"></i>12</li>
                        </ul>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Accusantium vitae, consequuntur minima tempora cupiditate ratione est,
                            ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores
                            voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet,
                            consecteturLorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Accusantium vitae, consequuntur minima tempora cupiditate ratione est,
                            ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores
                            voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet,
                            consectetu.</p>
                    </div>
                    <div class="button-bar pt-20">
                        <a href="#" class="btn btn-lg">
                            <span>Read More</span>
                        </a>
                    </div>
                </div>
                <!--single-blog-->

                <!--single-blog-->
                <div class="blog-single2">
                    <div class="blog-img">
                        <img src="blog_arquivos/4.jpg" alt="">
                        <div class="wt-post-meta">
                            <ul>
                                <li class="post-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <strong>23 june 2021</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="blog-text blog-text2">
                        <h4><a href="#"> doloremque porro hic exercitationem distinctio sequi adipisci Nulla, fuga perferendis </a></h4>
                        <ul>
                            <li><i class="fas fa-user"></i>By Johan /</li>
                            <li><i class="fas fa-comment-dots"></i>55</li>
                            <li><i class="fas fa-eye"></i>12</li>
                        </ul>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Accusantium vitae, consequuntur minima tempora cupiditate ratione est,
                            ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores
                            voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet,
                            consectetur.</p>
                    </div>
                    <div class="button-bar pt-20">
                        <a href="#" class="btn btn-lg">
                            <span>Read More</span>
                        </a>
                    </div>
                </div>
                <!--single-blog-->
                <div class="blog-single2">
                    <div class="blog-img">
                        <img src="blog_arquivos/3.jpg" alt="">
                        <div class="wt-post-meta">
                            <ul>
                                <li class="post-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <strong>23 june 2021</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="blog-text blog-text2">
                        <h4><a href="#"> doloremque porro hic exercitationem distinctio sequi adipisci Nulla, fuga perferendis </a></h4>
                        <ul>
                            <li><i class="fas fa-user"></i>By Johan /</li>
                            <li><i class="fas fa-comment-dots"></i>55</li>
                            <li><i class="fas fa-eye"></i>12</li>
                        </ul>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Accusantium vitae, consequuntur minima tempora cupiditate ratione est,
                            ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores
                            voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet,
                            consectetur.</p>
                    </div>
                    <div class="button-bar pt-20">
                        <a href="#" class="btn btn-lg">
                            <span>Read More</span>
                        </a>
                    </div>
                </div>
                <div class="wt-pagintion">
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li><a class="active" href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="widget-side-bar">
                    <div class="serch-content">
                        <div class="content-heading">
                            <h3>Search</h3>
                        </div>
                        <div class="subscribes">
                            <input type="search" placeholder="Search...">
                            <input type="submit" value="Subscribe">
                        </div>
                    </div>
                    <div class="blog-widget">
                        <div class="content-heading">
                            <h3>Recent Posts</h3>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/1.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">Successful project we done all time</a>
                                <p>Jan 9, 2021</p>
                            </div>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/2.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">Construction Honored with AGC Builders</a>
                                <p>Jan 9, 2021</p>
                            </div>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/3.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">11 Times Old Furniture Gained New Life</a>
                                <p>Jan 9, 2021</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-widget">
                        <div class="content-heading">
                            <h3>Categories</h3>
                        </div>
                        <div class="tagcloud">
                            <a class="tag-cloud-link" href="#">Pizza</a>
                            <a class="tag-cloud-link" href="#">Freanch Fries</a>
                            <a class="tag-cloud-link" href="#">Drinks</a>
                            <a class="tag-cloud-link" href="#">Pasta</a>
                            <a class="tag-cloud-link" href="#">Burgers</a>
                        </div>
                    </div>
                    <div class="blog-widget">
                        <div class="content-heading">
                            <h3>Popular Posts</h3>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/1.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">Brown and Red Pepperoni Burger</a>
                                <p>March 9, 2022</p>
                            </div>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/2.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">Sliced Pizza on Vegitable</a>
                                <p>March 20, 2022</p>
                            </div>
                        </div>
                        <div class="f-single-item">
                            <img src="blog_arquivos/3.jpg" alt="blog image">
                            <div class="f-blog-content">
                                <a href="#">Top View Photo Of Sliced Burger</a>
                                <p>March 67, 2022</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-widget">
                        <div class="content-heading">
                            <h3>popular tags</h3>
                        </div>
                        <div class="tagcloud">
                            <a class="tag-cloud-link" href="#">Food</a>
                            <a class="tag-cloud-link" href="#">Healthy</a>
                            <a class="tag-cloud-link" href="#">Teasty</a>
                            <a class="tag-cloud-link" href="#">Delicius</a>
                            <a class="tag-cloud-link" href="#">Pasta</a>
                            <a class="tag-cloud-link" href="#">Burgers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins')
<script src="{{ asset('assets/site/js/wow.min.js')}}"></script>
<script src="{{ asset('assets/site/js/slick.min.js')}}"></script>
<script src="{{ asset('assets/site/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('assets/site/js/ratin.js')}}"></script>
<script src="{{ asset('assets/site/js/jquery-ui.min.js')}}"></script>
@endsection

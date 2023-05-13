@php
use App\Models\AppSettingsModel;
$app_settings = AppSettingsModel::all()->first();
@endphp
<!DOCTYPE html>
<html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset($app_settings->logo_url) }}" type="image/x-icon">
    <title>{{ $app_settings->establishment_name }} - @yield('title')</title>
    <script src="{{ asset('assets/site/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/bootbox.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/site/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/defult.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/js/summernote/summernote-bs4.min.css') }}">


    {{-- JS/CSS --}}
    @yield('script')
    @yield('css')
    {{-- /JS/CSS --}}

</head>
<body>
    <div id="preloader">
        <div class="loader">
            <i class="fa-duotone fa-burger-soda fa-beat-fade"></i>

        </div>
    </div>
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 align-self-center">
                        <div class="logo logo-d-none">
                            <a href="{{ route('home_page') }}"><img src="{{ asset($app_settings->logo_url) }}" class="rounded-pill" width="55" alt="{{ $app_settings->establishment_name }}"></a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-8 col-sm-6 col-2 align-self-center">
                        {{-- BARRA PC --}}
                        <div class="d-none d-lg-block">
                            <div class="header-menu">
                                <div class="header-horizontal-menu">
                                    <ul class="menu-content">
                                        <li><a href="{{ route('home_page') }}">Início </a></li>
                                        <li class="position-static"><a href="#">Cardápio<i class="fas fa-angle-down"></i></a>
                                            <ul class="mega-sub-menu d-flex flex-wrap">
                                                <li>
                                                    <a class="menu-title" href="#">Shop Grid</a>
                                                    <ul class="submenu-item">
                                                        <li><a href="https://preetheme.com/liton/foodbar/shop.html">Shop Grid Column 3</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/shop_left_side.html">Shop left Column 3</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/shop_left_side.html">Shop left sidebar</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="menu-title" href="#">Categoris</a>
                                                    <ul class="submenu-item">
                                                        <li><a href="https://preetheme.com/liton/foodbar/product-details.html">Pizza</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/product-details.html">Burgers</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/product-details.html">Pasta</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="menu-title" href="#">Service</a>
                                                    <ul class="submenu-item">
                                                        <li><a href="https://preetheme.com/liton/foodbar/service.html">Service</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/service_details.html">Service Details</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/service_details.html">Service left</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="menu-title" href="#">Shop Gallery</a>
                                                    <ul class="submenu-item">
                                                        <li><a href="https://preetheme.com/liton/foodbar/gallery.html">Shop Gallery</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/gallery.html">Shop Gallery Left sidebar</a></li>
                                                        <li><a href="https://preetheme.com/liton/foodbar/gallery.html">Shop Gallery Right sidebar</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('agenda') }}">Agenda</a></li>
                                        <li><a href="{{ route('contact') }}">Contato</a></li>
                                        <li><a href="{{ route('about') }}">Sobre nós</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- BARRA PC--}}
                        {{-- BARRA MOBILE --}}
                        <div class="d-lg-none">
                            <div class="mobile-toggle">
                                <a class="mobile-menu-open" href="javascript:;"><i class="fas fa-bars"></i></a>
                            </div>
                            <div class="mobile-off-canvas-menu">
                                <div class="logo">
                                    <a href="{{ route('home_page') }}"><img src="{{ asset($app_settings->logo_url) }}" class="rounded-pill" width="55" alt="{{ $app_settings->establishment_name }}"></a><span class="m-l-10"><strong>{{ $app_settings->establishment_name }}</strong></span>
                                </div>
                                <div class="mobile-main-menu">
                                    <ul class="menu-content">
                                        <li><a href="{{ route('home_page') }}"><i class="fa-duotone fa-house"></i> Início</a></li>
                                        <li><a href="{{ route('agenda') }}"><i class="fa-duotone fa-calendar-days"></i> Agenda</a></li>
                                        <li class="menu-item-has-children"><span class="mobile-menu-expand"></span><a href="#"><i class="fa-duotone fa-burger-soda"></i> Cardápio</a>
                                            <ul class="sub-menu" style="display: none;">
                                                <li class="menu-item-has-children"><span class="mobile-menu-expand"></span><a href="https://preetheme.com/liton/foodbar/blog.html">Blog Grid <i class="fal fa-chevron-right"></i></a>
                                                    <ul class="sub-menu" style="display: none;">
                                                        <li><a href="#">Blog Grid Left Slider</a></li>
                                                        <li><a href="#">Blog Grid Right Slider</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children"><span class="mobile-menu-expand"></span><a href="#">Blog List <i class="fal fa-chevron-right"></i></a>
                                                    <ul class="sub-menu" style="display: none;">
                                                        <li><a href="#">Blog List Left Slider</a></li>
                                                        <li><a href="#">Blog List Right Slider</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item-has-children"><span class="mobile-menu-expand"></span><a href="#">Blog Single <i class="fal fa-chevron-right"></i></a>
                                                    <ul class="sub-menu" style="display: none;">
                                                        <li><a href="#">Blog Single Left Slider</a></li>
                                                        <li><a href="#">Blog Single Right Slider</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('contact') }}"><i class="fa-duotone fa-address-card"></i> Contato</a></li>
                                        <li><a href="{{ route('about') }}"><i class="fa-duotone fa-square-info"></i> Sobre nós</a></li>
                                    </ul>

                                </div> <!-- mobile main menu -->
                            </div> <!-- mobile off canvas menu -->

                            <div class="overlay"></div>

                        </div>
                        {{-- BARRA MOBILE --}}
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-10  align-self-center">
                        <div class="list-area-cart-user d-flex justify-content-end">
                            @auth('client')
                            <ul>
                                <li><button class="btn"><i class="fas fa-heart"></i></button></li>{{-- ou fas depois de coutido para preencher --}}
                                <li><a href="javascript:void(0)" class="btn" id="cart-btn"><i class="fa-solid fa-cart-shopping"></i> <span>5</span></a>
                                </li>
                                <li><a href="javascript:void(0)" class="btn" id="login-btn"><i class="fas fa-user"></i></a></li>
                            </ul>
                            @else
                            <a href="" class="btn btn-danger"><i class="fas fa-user"></i> FAZER LOGIN</a>
                            @endauth
                        </div>
                        <div class="mini-cart-side">
                            <div class="cart-header">
                                <h4>Shopping Cart</h4>
                                <div class="clse">
                                    <a href="javascript:void(0)" id="close-btn"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="shopping-box ">
                                <img src="img/1.png" alt="png">
                                <div class="box-content">
                                    <h5>Italian cuisine</h5>
                                    <span>$600X2</span>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="shopping-box ">
                                <img src="img/2.png" alt="png">
                                <div class="box-content">
                                    <h5>Japani Pizza</h5>
                                    <span>$600X2</span>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="shopping-box ">
                                <img src="img/3.png" alt="png">
                                <div class="box-content">
                                    <h5>Barcon Pizza</h5>
                                    <span>$600X2</span>
                                </div>
                                <div class="remove">
                                    <a href="#"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                            <div class="min-price">
                                <h4>subtotal:</h4>
                                <span>$5550</span>
                            </div>
                            <div class="button-bar pt-20 text-center">
                                <a href="#" class="btn btn-lg">
                                    <span>View Cart</span>
                                </a>
                            </div>
                        </div>
                        <div class="login-form">
                            <div class="form-container">
                                <div class="close-lgn">
                                    <a href="javascript:void(0)" id="close-login"><i class="fas fa-times"></i></a>
                                </div>
                                <div class="form-icon"><i class="fa fa-user"></i></div>
                                <h3 class="title">Login</h3>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label>email</label>
                                        <input class="form-control" type="email" placeholder="email address">
                                    </div>
                                    <div class="form-group">
                                        <label>password</label>
                                        <input class="form-control" type="password" placeholder="password">
                                    </div>
                                    <button type="button" class="btn btn-default">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTEUDO --}}
    @yield('content')
    {{-- / CONTEUDO --}}

    <!-- footer-area -->
    <footer id="footer" class="footer-area">
        <div class="container">
            <div class="row pt-20">
                <div class="col-lg-5 col-md-6 col-sm-6">
                    <div class="footer-single">
                        <div class="ft-head">
                            <div class="logo">
                                <a href="{{ route('home_page') }}"><img src="{{ asset($app_settings->logo_url) }}" width="100" alt="{{ $app_settings->establishment_name }}"></a>
                            </div>
                        </div>
                        <div class="ft-description">
                            <p>Frase slogam</p>

                        </div>
                        <div class="scoial-area">
                            <h4>REDES SOCIAIS:</h4>
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f "></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="problem ">
                        <div class="ft-head">
                            <h3>Menu</h3>
                        </div>
                        <div class="footer-iteam">
                            <ul>
                                <li><a href="#">Cardápio</a></li>
                                <li><a href="{{ route('agenda') }}">Agenda</a></li>
                                <li><a href="{{ route('contact') }}">Contato</a></li>
                                <li><a href="{{ route('about') }}">Sobre nós</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-2 col-md-6 col-sm-6">
                    <div class="problem ">
                        <div class="ft-head">
                            <h3>Categorias</h3>
                        </div>
                        <div class="footer-iteam">
                            <ul>
                                <li><a href="#">Pizza</a></li>
                                <li><a href="#">Pasta</a></li>
                                <li><a href="#">Burgers</a></li>
                                <li><a href="#">French Fries</a></li>
                                <li><a href="#">bread</a></li>
                                <li><a href="#">Macaroni</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="ft-head">
                        <h3>Endereço</h3>
                    </div>
                    <div class="footer-iteam">
                        <ul>
                            <li><a href="#">House no 35, Palmall street,London, England</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="row row2">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="ft-bottom-left">
                        <p>Copyright ©{{ date('Y') }} {{ $app_settings->establishment_name }}. Todos direitos reservados.</p>

                    </div>
                </div>
                {{-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="ft-bottom-left">
                        <img src="img/index.png" alt="">
                    </div>
                </div> --}}
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="ft-bottom-right">
                        <p>Termos e condições de uso.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-area -->
    <!-- scroll -->
    <div class="scroll-area">
        <i class="fa fa-angle-up"></i>
    </div>

    {{-- MODALS --}}
    @yield('modal')
    {{-- /MODALS --}}

    <!-- scroll -->
    <!-- Js File -->
    <script src="{{ asset('assets/site/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/site/js/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/jquery.nav.min.js') }}"></script>
    <script src="{{ asset('assets/site/js/script.js') }}"></script>

    {{-- JS  --}}
    @yield('plugins')
    {{-- /JS --}}

    <script>
        function increaseCount(a, b) {
            var input = b.previousElementSibling;
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            input.value = value;
        }

        function decreaseCount(a, b) {
            var input = b.nextElementSibling;
            var value = parseInt(input.value, 10);
            if (value > 1) {
                value = isNaN(value) ? 0 : value;
                value--;
                input.value = value;
            }
        }

    </script>

</body>
</html>

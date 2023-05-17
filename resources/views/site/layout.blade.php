@php
use App\Models\AppSettingsModel;
$app_settings = AppSettingsModel::all()->first();
@endphp
<!DOCTYPE html>
<html lang="pt-br">
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
    <link rel="stylesheet" href="{{ asset('assets/site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/defult.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/js/summernote/summernote-bs4.min.css') }}">
    {{-- JS/CSS --}}
    @yield('script')
    @yield('css')
    {{-- /JS/CSS --}}

</head>
<body class="accent-orange">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{  asset($app_settings->logo_url) }}" height="200" width="200">
        <span class="fs-30"><strong>{{ $app_settings->establishment_name }}</strong> </span>
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
                                        <li class="@yield('home_tab')"><a href="{{ route('home_page') }}">Início </a></li>
                                        <li><a href="#">Cardápio</a></li>
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
                                @auth('client')
                                <div class="logo d-flex justify-content-between">
                                    <a href="{{ route('home_page') }}"><img src="{{ asset(session('user')['photo']) }}" class="rounded-pill text-light" width="55"><span class="m-l-10"><strong>{{ session('user')['name'] }}</strong></span></a>
                                    <a href="{{ route('logout_client') }}" class="btn"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                                </div>
                                @else
                                <div class="logo">
                                    <a href="{{ route('home_page') }}"><img src="{{ $app_settings->logo_url }}" class="rounded-pill" width="55"></a><span class="m-l-10"><strong>{{ $app_settings->establishment_name }}</strong></span>
                                </div>
                                @endauth
                                <div class="mobile-main-menu">
                                    <ul class="menu-content">
                                        <li><a href="{{ route('home_page') }}"><i class="fa-duotone fa-house"></i> Início</a></li>
                                        <li><a href="{{ route('agenda') }}"><i class="fa-duotone fa-calendar-days"></i> Agenda</a></li>
                                        <li><a href="#"><i class="fa-duotone fa-burger-soda"></i> Cardápio</a></li>
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
                        @auth('client')
                        <div class="list-area-cart-user d-flex justify-content-end">
                            <ul>
                                <li><button class="btn btn-accent"><i class="fas fa-heart"></i></button></li>{{-- ou fas depois de coutido para preencher --}}
                                <li><a href="javascript:void(0)" class="btn btn-accent" id="cart-btn"><i class="fa-solid fa-cart-shopping"></i> <span>{{ }}</span></a></li>
                                <li><button href="javascript:void(0)" onclick="login_btn()" class="d-none d-lg-block btn btn-accent"><i class="fas fa-user"></i></button></li>
                            </ul>
                            <div class="login-form">
                                <div class="form-container">
                                    <div class="close-lgn">
                                        <a href="javascript:void(0)" onclick="login_btn()"><i class="fas fa-times"></i></a>
                                    </div>
                                    <img class="form-icon" src="{{ asset(session('user')['photo']) }}" alt="">
                                    <h3 class="title">{{ session('user')['name'] }}</h3>
                                    <div class="d-flex justify-content-center row">
                                        <button class="m-b-10 btn btn-danger rounded-pill">PERFIL</button>
                                        <a href="{{ route('logout_client') }}" class="btn btn-danger rounded-pill">SAIR <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                                    </div>

                                </div>
                            </div>

                        </div>
                        @else
                        <div class="list-area-cart-user d-flex justify-content-end">
                            <a href="{{ route('site_login_form') }}" class="btn btn-accent"><i class="fas fa-user"></i> FAZER LOGIN</a>
                        </div>
                        @endauth
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
                            <p> <strong>{{ $app_settings->establishment_name }}</strong><br>
                                - Slogan</p>
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
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>{{ $app_settings->establishment_name }} - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset($app_settings->logo_url) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app/plugins/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app/css/util.css') }}">
    <script src="{{ asset('assets/app/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/bootbox.min.js') }}"></script>
</head>
<body style="background-image: url('{{ asset('img/background/desktop-wallpaper-fast-food-junk-food.jpg') }}');">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <span class="login100-form-title p-b-26">
                    {{ $app_settings->establishment_name }}
                </span>
                <span class="login100-form-title p-b-48">
                    <img src="{{ asset($app_settings->logo_url) }}" width="100">
                </span>
                <div id="form">
                    <form id="form-login" class="login100-form validate-form">
                        <div class="wrap-input100 validate-input" data-validate="Digite um e-mail válido">
                            <input class="input100" type="email" id="email">
                            <span class="focus-input100" data-placeholder="Email"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Digite sua senha">
                            <span class="btn-show-pass">
                                <i class="fa-duotone fa-eye"></i>
                            </span>
                            <input class="input100" type="password" id="password">
                            <span class="focus-input100" data-placeholder="Senha"></span>
                        </div>
                    </form>
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn m-b-5">
                            <div class="login100-form-bgbtn"></div>
                            <button id="btn-submit-form" class="login100-form-btn">
                                Login
                            </button>
                        </div>
                        <a href="{{ route('auth_google') }}" class="btn-google m-t-10 rounded-pill">
                            <img width="20" src="{{ asset('img/payment_method/icon-google.png') }}" class="m-r-5" alt="GOOGLE">
                            GOOGLE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/app/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/main.js') }}"></script>
</body>
</html>

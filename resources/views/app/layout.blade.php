@php
use App\Models\AppSettingsModel;
$app_settings = AppSettingsModel::all()->first();
@endphp
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <link rel="shortcut icon" href="{{ asset($app_settings->logo_url) }}" type="image/x-icon">
    <title>{{ $app_settings->establishment_name }} - @yield('title')</title>
    {{-- ==================================== CSS/JS ===================================== --}}
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@200..900&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/fontawesome/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
    {{-- CSS ESPECIFICO --}}
    @yield('css')
    {{-- CSS ESPECIFICO --}}
    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/toastr/toastr.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/app/css/adminlte.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('assets/app/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/mask-jquery.js') }}"></script>
    <script src="{{ asset('assets/app/js/bootbox.min.js') }}"></script>


    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    @can('print_requests')
    {{-- NOTIFICAÇÕES --}}
    <script type="module" src="{{ asset('private/assets/js/notification.js') }}"></script>
    @endcan
    {{-- CORTE DE IMAGEM --}}
    <link rel="stylesheet" href="{{ asset('assets/app/css/croppie.css') }}" />
    <script src="{{ asset('assets/app/js/croppie.js') }}"></script>

    @yield('script')



    {{-- ====================================/ CSS/JS ===================================== --}}

</head>

<body class="{{ $app_settings->theme_background }} {{ $app_settings->theme_accent }} hold-transition sidebar-mini layout-fixed">


    <div class="wrapper">
        @if (session('animation') == 0)
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{  asset($app_settings->logo_url) }}" height="200" width="200">
            <span class="fs-30"><strong>{{ $app_settings->establishment_name }}</strong> </span>
        </div>
        @php
        session()->put('animation', 1);
        @endphp
        @endif
        <aside class="main-sidebar {{ $app_settings->theme_sidebar }} elevation-5">
            <div class="brand-link">
                <img src="{{  asset($app_settings->logo_url) }}" alt="{{ $app_settings->establishment_name }}" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $app_settings->establishment_name }}</span>
            </div>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img id="profile-image" src="{{ asset(session('user')['photo']) }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info col">
                        <span id="username" class="user-name bold">{{ session('user')['name'] }}</span>
                        <button class="float-right btn btn-sm user-name bold" onclick="profile_show()">
                            <i class="fs-16 fa-duotone fa-user-gear"></i>
                        </button>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @can('dashboard')
                        <li class="nav-item ">
                            <a href="{{ route('control_panel') }}" class="rounded-pill nav-link @yield('control-panel')">
                                <i class="nav-icon fa-duotone fa-chart-bar"></i>
                                <p>
                                    Painel de controle
                                </p>
                            </a>
                        </li>
                        @endcan
                        @canany(['view_orders','view_delivery'])
                        <li class="nav-item @yield('menu-requests')">
                            <a href="#" class="rounded-pill nav-link @yield('requests') @yield('delivery')">
                                <i class="nav-icon fa-duotone fa-burger-soda"></i>
                                <p>
                                    Pedidos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view_orders')
                                <li class="nav-item">
                                    <a href="{{ route('requests') }}" class="rounded-pill nav-link @yield('requests')">
                                        <i class="fa-duotone fa-home nav-icon"></i>
                                        <p>Local</p>
                                    </a>
                                </li>
                                @endcan
                                @can('view_delivery')
                                <li class="nav-item">
                                    <a href="{{ route('delivery') }}" class="rounded-pill nav-link  @yield('delivery')">
                                        <i class="fa-duotone fa-moped nav-icon"></i>
                                        <p>Delivery</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('view_tables')
                        <li class="nav-item ">
                            <a href="{{ route('tables') }}" class="rounded-pill nav-link @yield('tables')">
                                <i class="nav-icon fa-duotone fa-table-picnic"></i>
                                <p>
                                    Mesas
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('view_menu')
                        <li class="nav-item ">
                            <a href="{{ route('menu') }}" class="rounded-pill nav-link @yield('menu')">
                                <i class="nav-icon fa-duotone fa-list-radio"></i>
                                <p>
                                    Cardápio
                                </p>
                            </a>
                        </li>
                        @endcan
                        @canany(['config_app_data','config_app_delivery','config_app_email','config_app_theme','create_user','edit_user','delete_user','permissions_user','config_site'])

                        <li class="nav-item @yield('config')">
                            <a href="#" class="rounded-pill nav-link @yield('users')@yield('app-settings')@yield('site-settings')">
                                <i class="nav-icon fa-duotone fa-gears"></i>
                                <p>
                                    Configurações
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can(['create_user','edit_user','delete_user','permissions_user'])
                                <li class="nav-item">
                                    <a href="{{ route('users') }}" class="rounded-pill nav-link  @yield('users')">
                                        <i class="fa-duotone fa-users nav-icon"></i>
                                        <p>Usuários</p>
                                    </a>
                                </li>
                                @endcan
                                @canany(['config_app_data','config_app_delivery','config_app_email','config_app_theme'])
                                <li class="nav-item">
                                    <a href="{{ route('app_settings') }}" class="rounded-pill nav-link @yield('app-settings')">
                                        <i class="fa-duotone fa-sliders nav-icon"></i>
                                        <p>Aplicativo</p>
                                    </a>
                                </li>
                                @endcan
                                @can('config_site')
                                <li class="nav-item">
                                    <a href="{{ route('site_settings') }}" class="rounded-pill nav-link @yield('site-settings')">
                                        <i class="fa-duotone fa-globe nav-icon"></i>
                                        <p>Site</p>
                                    </a>
                                </li>
                                @endcan

                            </ul>
                        </li>
                        @endcan

                        <li class="nav-item ">
                            <a href="{{ route('logout') }}" class="rounded-pill nav-link">
                                <i class="nav-icon fa-duotone fa-sign-out-alt"></i>
                                <p>
                                    Sair
                                </p>
                            </a>
                        </li>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></div>
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title-header')</h1>
                        </div>
                        @yield('btn-print')
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid ">
                    {{-- Conteudo --}}
                    @yield('content')
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <footer class="main-footer align-items-center ">
            <footer>
                <div class="text-center">
                    &copy;{{ config('app.name') . ' ' . date('Y') }} ({{ config('app.version') }})
                    <br>
                    Desenvolvido por: <a href="https://www.linkedin.com/in/eduardo-martins-a100b6211/" target="_blank" rel="noopener noreferrer">Eduardo Martins</a>
                </div>
            </footer>
        </footer>
    </div>
    {{-- ========================== MODAL ========================== --}}
    @yield('modal')
    {{-- PERFIL USUÁRIO --}}
    <div class="modal fade" id="user-profile-modal" role="dialog" aria-labelledby="userProfileLaber" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userProfileTitleLabel">MEU PERFIL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="profile-user-view">
                        <div class="card card-success card-outline">
                            <div style="margin: 10px 10px 0px 0px;" class="d-flex justify-content-end">
                                <button onclick="profile_edit()" class="btn btn-sm btn-accent rounded-pill"><strong>EDITAR</strong></button>
                            </div>
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img width="200" id="profile-user-img" class="profile-user-img img-fluid img-circle" src="" alt="Imagem de perfil">
                                </div>
                                <h2 id="profile-username" class="profile-username text-center"></h2>
                                <p id="profile-user-job" class="text-muted text-center"></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informações</h3>
                            </div>
                            <div class="card-body">
                                <strong><i class="fa-duotone fa-phone mr-1"></i> Telefone</strong>
                                <p id="profile-user-phone" class="text-muted"></p>
                                <hr>
                                <strong><i class="fa-duotone fa-envelope mr-1"></i></i> Email</strong>
                                <p id="profile-user-email" class="text-muted"></p>
                                <hr>
                                <strong><i class="fa-duotone fa-user-shield mr-1 m-b-15"></i> Permissões</strong>
                                <p id="profile-user-permissions" class="text-muted"></p>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary rounded-pill" onclick="profile_reset_password()"><strong>Alterar senha</strong></button>
                    </div>
                    <div id="profile-user-edit" style="display:none">
                        <div class="col">
                            <div class="d-flex justify-content-sm-end">
                                <p class="f-s-13">(Os campos com <span style="color:red">*</span>
                                    são obrigatórios)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mx-auto">
                                <img id="profile-adjusted-image" width="200" class="img-circle" src="{{ asset('img/avatar/user.png') }} " alt="Imagem do usuário">
                                <div class="d-flex justify-content-sm-end">
                                    <label for="chenge-profile-user-image" class="btn btn-accent rounded-pill"><i class="fa-solid fa-folder-image"></i></label>
                                    <input type="file" class="input-img-profile" name="chenge-profile-user-image" id="chenge-profile-user-image" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                                </div>
                            </div>
                        </div>
                        <form id="form-profile-user">
                            <input type="hidden" name="profile-user-id" id="profile-user-id">
                            <input type="hidden" name="profile-img-user" id="profile-img-adjusted-user">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="profile-first-name">Nome <span style="color:red">*</span></label>
                                    <input minlength="2" maxlength="200" id="profile-first-name" name="profile-first-name" type="text" class="form-control" placeholder="Nome">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="profile-last-name">Sobrenome <span style="color:red">*</span></label>
                                    <input minlength="2" maxlength="200" id="profile-last-name" name="profile-last-name" type="text" class="form-control" placeholder="Sobrenome">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="profile-phone">Telefone <span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="profile-phone" name="profile-phone" data-inputmask="'mask':'(99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="Telefone">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="profile-email">Email <span style="color:red">*</span></label>
                                    <input minlength="2" maxlength="200" id="profile-email" name="profile-email" type="email" class="form-control" placeholder="exemplo@exemple.com">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="btn-profile-save" class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal"><strong>FECHAR</strong></button>
                </div>
            </div>
        </div>
    </div>

    {{-- AJUSTE DE IMAGEM --}}
    <div id="changeprofileimage" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajustar imagem</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="square" id="profile_image_demo"></div>
                </div>
                <div id="crop_image" class="modal-footer">
                    <button onclick="return adjust_image_profile()" class="btn btn-accent rounded-pill "><strong>CORTAR</strong></button>
                </div>
            </div>
        </div>
    </div>
    {{-- ==================================== PLUGINS ===================================== --}}

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/app/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/app/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/app/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/moment/locales.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/app/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/toastr/toastr.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.j') }}s"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/app/js/adminlte.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/app/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/app/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/app/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables/numeric-comma.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-buttons/js/buttons.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/inputmask.js') }}"></script>
    <script src="{{ asset('/private/assets/js/user_profile.js') }}"></script>
    @yield('plugins')
    {{-- ====================================/ PLUGINS ===================================== --}}
</body>
</html>

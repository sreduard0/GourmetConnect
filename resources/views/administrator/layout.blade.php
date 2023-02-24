@php
    $perm = ['Cmt da Guarda', 'Pel Manut e Transp', 'Adjunto', 'COST', 'Fisc Adm', 'Auditor', 'Administrador'];
@endphp
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    {{-- ==================================== CSS/JS ===================================== --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('css/gfonts.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">

    {{-- CSS ESPECIFICO --}}
    @yield('css')
    {{-- CSS ESPECIFICO --}}
    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/util.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/mask-jquery.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    @yield('script')

    {{-- ====================================/ CSS/JS ===================================== --}}

</head>

<body class=" @if (session('theme') == 1) dark-mode @endif hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @if (session('animation') == 0)
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="{{ asset('img/logo.png') }}" height="200" width="200">
                <span class="fs-30"><strong>{{ config('app.name') }}</strong> </span>
            </div>
            @php
                session()->put('animation', 1);
            @endphp
        @endif
        <aside class="main-sidebar sidebar-dark-primary elevation-5">
            <div class="brand-link info">
                <img src="{{ asset('img/logo.png') }}" alt="CESV" class="brand-image img-circle">
                <span class="m-l-12 bold">CES Vtr</span>

            </div>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/AdminLTELogo.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <span class="bold">{{ config('app.establishment_name') }}</span><br>
                        <span style="color:darkgray">{{ $perm[session('CESV')['profileType']] }}</span>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item ">
                            <a href="" class="nav-link @yield('home')">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Início
                                </p>
                            </a>
                        </li>

                        {{-- @if (session('CESV')['profileType'] == 1 || session('CESV')['profileType'] == 5 || session('CESV')['profileType'] == 6)
                            <li class="nav-item @yield('vtrmenu')">
                                <a href="#" class="rvtr nav-link @yield('vtr')">
                                    <i class="nav-icon fas fa-car"></i>
                                    <p>
                                        Viatura
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ">
                                        <a href="{{ route('vtr') }}" class="nav-link @yield('vtrlist')">
                                            <i class="nav-icon fas fa-car"></i>
                                            <p>Todas viaturas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('request-vtr-list') }}" class="nav-link @yield('requestVtr')">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p id="r-v-c">Solicitações</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item ">
                                <a href="{{ route('drivers') }}" class="nav-link @yield('mot')">
                                    <i class="nav-icon fas fa-tire"></i>
                                    <p>
                                        Motoristas
                                    </p>
                                </a>
                            </li>
                        @endif --}}

                        <li class="nav-item ">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
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
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title-header')</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid ">
                    <div class="row">
                        {{-- Conteudo --}}
                        @yield('content')

                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <footer class="main-footer align-items-center ">
            <footer>
                <div class="text-center">
                    &copy;{{ config('app.name') . ' ' . date('Y') }} ({{ config('app.version') }})
                    {{ date('Y') }} (v1.5)
                    <br>
                    Desenvolvido por: <a href="https://www.linkedin.com/in/eduardo-martins-a100b6211/" target="_blank"
                        rel="noopener noreferrer">Eduardo Martins</a>
                </div>
            </footer>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    {{-- ========================== MODAL ========================== --}}
    @yield('modal')
    {{-- ==================================== PLUGINS ===================================== --}}
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <script>
        // setInterval(() => {
        //     $.get("{{ route('getSession') }}", function(result) {
        //         if (result == false) {
        //             document.location.reload(true);
        //         }
        //     })
        // }, 60000);

        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/locales.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('js/mask-jquery.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        // setInterval(() => {
        //     $.get("{{ route('getSession') }}", function(result) {
        //         if (result == false) {
        //             document.location.reload(true);
        //         }
        //     })
        // }, 60000);

        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/locales.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/mask-jquery.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        // setInterval(() => {
        //     $.get("{{ route('getSession') }}", function(result) {
        //         if (result == false) {
        //             document.location.reload(true);
        //         }
        //     })
        // }, 60000);

        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/locales.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    @yield('plugins')
    {{--
    @if (session('CESV')['profileType'] < 3 || session('CESV')['profileType'] == 4)
        <script>
            $("#fichas_layout").DataTable({

                "paging": true,
                'pagingType': 'simple',
                "responsive": true,
                "lengthChange": true,
                "iDisplayLength": 5,
                "autoWidth": false,
                "dom": '<"top">rt<"bottom"ip><"clear">',
                "language": {
                    "url": "{{ asset('plugins/datatables/Portuguese3.json') }}"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('fichas_layout') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },

                }
            });
        </script>
    @endif
    @if (session('CESV')['profileType'] == 3)
        <script>
            var $missionsCost = $('#graphicMission')
            $(function() {
                'use strict'

                var ticksStyle = {
                    fontColor: '#495057',
                    fontStyle: 'bold'
                }

                var mode = 'index'
                var intersect = true

                var $missionsOmOp = $('#missionsOmOp')
                $.get("{{ route('getGraphicMissionsOp') }}", function(result) {
                    $('#TotalMissionsOp').text(result.TotalMissionsOp);
                    var missionsCost = new Chart($missionsCost, {
                        data: {
                            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                                'Out', 'Nov',
                                'Dez'
                            ],
                            datasets: result.statisticsMission
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: mode,
                                intersect: intersect
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false,
                            },
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '2px',
                                        color: 'rgba(0, 0, 0, .2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,
                                        suggestedMax: 50
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    })
                })
            })
        </script>
    @endif
     @if (session('CESV')['profileType'] == 4)
        <script>
            window.onload = countFicha();
            window.onload = countRequestFuel();
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
            })
            var count = 0
            var countRequest = 0

            function countFicha() {
                $.get("{{ route('getNewFichas') }}", function(result) {
                    result == 0 ? '' : $('#f-c').html('Fichas <span class="badge badge-success right">' + result +
                        '</span>')
                })
            }

            function countRequestFuel() {
                $.get("{{ route('getNewRequestFuel') }}", function(result) {
                    result == 0 ? '' : $('#f-a').html('Combustível <span class="badge badge-success right">' + result +
                        '</span>')

                })
            }
            setInterval(() => {
                countFicha()
                countRequestFuel()
            }, 30000);
        </script>
    @endif
    @if (session('CESV')['profileType'] == 1)
        <script>
            window.onload = countReqVtr();
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
            })

            function countReqVtr() {
                $.get("{{ route('getNewReqVtr') }}", function(result) {
                    if (result > 0) {
                        $('#r-v-c').html('Solicitações <span class="badge badge-success right">' + result + '</span>')
                        $('.rvtr').addClass('active')
                    } else {
                        $('#r-v-c').html('Solicitações')
                        $('.rvtr').removeClass('active')
                    }

                })
            }
            setInterval(() => {
                countReqVtr()
            }, 30000);
        </script>
    @endif
     --}}
    {{-- ====================================/ PLUGINS ===================================== --}}
</body>


</html>

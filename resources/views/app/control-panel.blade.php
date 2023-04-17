@extends('app.layout')
@section('title', 'Painel de Controle')
@section('control-panel', 'active')
@section('title-header', 'Painel de controle')
@section('btn-print')
<div class="col d-flex justify-content-end">
    <button class="btn btn-accent rounded-pill" onclick="window.print()"><i class="fa-duotone fa-print"></i></button>
</div>
@endsection
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fa-duotone fa-moped"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">DELIVERY</span>
                <span class="info-box-number">
                    10
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fa-duotone fa-person-to-door"></i></i></span>
            <div class="info-box-content">
                <span class="info-box-text">VISITAS</span>
                <span class="info-box-number">800</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-heart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">CURTIDAS</span>
                <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa-duotone fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">USUÁRIOS</span>
                <span class="info-box-number">150</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Relatório de vendas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>1 DE JANEIRO ATÉ 31 DE DEZEMBRO DE {{ date('Y') }} </strong>
                        </p>
                        <div class="chart">
                            <canvas id="sale-chart" height="180" style="height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>TIPO</strong>
                        </p>

                        <div class="progress-group">
                            <span class="progress-text">Hamburguer</span>
                            <span class="float-right"><b>480</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="progress-group">
                            <span class="progress-text">Refrigerante</span>
                            <span class="float-right"><b>480</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="progress-group">
                            <span class="progress-text">Cerveja</span>
                            <span class="float-right"><b>480</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="progress-group">
                            <span class="progress-text">Chopp</span>
                            <span class="float-right"><b>480</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header">ABRIL</h5>
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                            <h5 class="description-header">R$2.000,00</h5>
                            <span class="description-text">
                                TOTAL DE VENDAS
                                <p class="text-muted">LOCAL</p>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header">ABRIL</h5>
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                            <h5 class="description-header">R$1.500,00</h5>
                            <span class="description-text">
                                TOTAL DE VENDAS
                                <p class="text-muted">DELIVERY</p>

                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">{{ date('Y') }}</h5>
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                            <h5 class="description-header">R$1.500,00</h5>
                            <span class="description-text">
                                TOTAL DE VENDAS
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> <i class="fa-duotone fa-moped"></i> Áreas delivery</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="javascript:">VER ÁREAS</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-duotone fa-users"></i> Usuários recentes</h3>
            </div>
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Alexander</strong></a>
                        <span class="users-list-date">Yesterday</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Jena</strong></a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Jhon</strong></a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Pedro</strong></a>
                        <span class="users-list-date">13 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Sara</strong></a>
                        <span class="users-list-date">14 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Cleber</strong></a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Cleber</strong></a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                        <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="User Image">
                        <a class="users-list-name" href="#"><strong>Cleber</strong></a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="javascript:">VER TODOS</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-burger-soda"></i> Items recém adicionados</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Chadder Becon
                                <span class="badge badge-dark float-right">R$35,00</span></a>
                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="Product Image" class="img-size-50">

                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Bicycle
                                <span class="badge badge-dark float-right">R$35,00</span></a>



                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="Product Image" class="img-size-50">

                        </div>
                        <div class="product-info">
                            <a href="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" class="product-title">
                                Xbox One
                                <span class="badge badge-dark float-right">R$35,00</span></a>
                            </span>
                            </a>

                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-img">
                            <img src="{{ asset('img/gourmetconnect-logo/g-c-.png') }}" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">PlayStation 4
                                <span class="badge badge-dark float-right">$399</span></a>
                        </div>
                    </li>
                    <!-- /.item -->
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">VER CARDÁPIO</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Top 10 usuários mais ativos</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th width="30px">ID</th>
                                <th>Nome</th>
                                <th width="200px">Última atividade</th>
                                <th width="200px">Último pedido</th>
                                <th width="200px">Ítem mais pedido</th>
                                <th width="130px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td>10/04/2023</td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                </td>
                                <td>
                                    botoes de ação
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>

    </div>
</div>
@endsection
@section('plugins')
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/control-panel.js') }}"></script>
@endsection

@extends('administrator.layout')
@section('title', 'Painel de Controle')
@section('home', 'active')
@section('title-header', 'Painel de controle')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Grafíco de missões OP no ano de {{ date('Y') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span>Total: <span id="TotalMissionsOp" class="text-bold text-lg"></span></span>


                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-muted">Responsável: COST</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="missions-op" height="250"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-success"></i> I
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> II
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-square text-secondary"></i> III
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-square text-warning"></i> IV
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-square text-info"></i> V-a
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-square text-danger"></i> V-m
                    </span>
                    <span class="mr-2">
                        <i style='color:blueviolet' class="fas fa-square"></i> VI
                    </span>
                    <span class="mr-2">
                        <i style='color:rgb(250, 4, 151)' class="fas fa-square"></i> VII
                    </span>
                    <span class="mr-2">
                        <i style='color:rgb(11, 2, 112)' class="fas fa-square"></i> VIII
                    </span>
                    <span class="mr-2">
                        <i style='color:rgb(7, 42, 20)' class="fas fa-square"></i> IX
                    </span>
                    <span class="mr-2">
                        <i style='color:rgb(25, 8, 41)' class="fas fa-square"></i> X
                    </span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Viaturas mais utilizadas no mês corrente</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="table" class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Qtd</th>
                            <th>Viatura</th>
                            <th>Tipo</th>
                            <th>EB/ Placa</th>
                            <th width="30px">Ver</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Comparativo de missões entre OM e OP</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span>Total: <span id="totalOmOp" class="text-bold text-lg"></span></span>

                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-muted">Responsável: COST e Fisc Adm</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="missionsOmOp" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-3">
                        <i class="fas fa-square text-gray"></i> OP
                    </span>
                    <span>
                        <i class="fas fa-square text-warning"></i> OM
                    </span>


                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tráfego de veículos na OM</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-responsive">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="rel-gda" style="display: block; width: 218px; height: 109px;"
                                class="chartjs-render-monitor" width="218" height="109"></canvas>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <ul class="chart-legend clearfix">
                            <li><i class="far fa-circle text-warning"></i> Civil</li>
                            <li><i class="far fa-circle text-secondary"></i> Outra OM</li>
                            <li><i class="far fa-circle text-danger"></i> 3° B Sup</li>
                        </ul>
                    </div>

                </div>

            </div>
            <div class="m-l-5 m-t-30 col">
                <h3 class="card-title">Comparativo com mês anterior</h3>

            </div>
            <hr>

            <div class="card-footer p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <div class="nav-link">
                            Civil
                            <span id="perCivil" class="float-right">

                            </span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link">
                            Outra OM
                            <span id="perOom" class="float-right">

                            </span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link">
                            3° B Sup
                            <span id="perOm" class="float-right">

                            </span>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
@endsection
{{-- @section('plugins')
    <script>
        /* global Chart:false */

        $(function() {
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $missionsOmOp = $('#missionsOmOp')
            $.get("{{ route('getGraphicMissionsOmOp') }}", function(result) {
                $('#totalOmOp').text(result.totalOmOp)
                var missionsOmOp = new Chart($missionsOmOp, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                            'Out', 'Nov',
                            'Dez'
                        ],
                        datasets: result.statistics
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
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                gridLines: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, .1)',
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
                                    display: true

                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                })
            })
            var $missionsCost = $('#missions-op')
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
            var relGda = $('#rel-gda').get(0).getContext('2d')
            $.get("{{ route('getGraphicRelGda') }}", function(result) {
                // CIVIL
                if (result.percentage.civil < 0) {
                    $('#perCivil').html(
                        '<strong class="text-danger"><i class="fas fa-arrow-down text-sm"></i> ' +
                        result.percentage.civil + '% </strong>')
                } else if (result.percentage.civil > 0) {
                    $('#perCivil').html(
                        '<strong class="text-success"><i class="fas fa-arrow-up text-sm"></i> ' +
                        result.percentage.civil + '% </strong>')
                } else {
                    $('#perCivil').html(
                        '<strong class="text-default"> ' +
                        result.percentage.civil + '% </strong>')
                }

                // Outra OM
                if (result.percentage.oom < 0) {
                    $('#perOom').html(
                        '<strong class="text-danger"><i class="fas fa-arrow-down text-sm"></i> ' +
                        result.percentage.oom + '% </strong>')
                } else if (result.percentage.oom > 0) {
                    $('#perOom').html(
                        '<strong class="text-success"><i class="fas fa-arrow-up text-sm"></i> ' +
                        result.percentage.oom + '% </strong>')
                } else {
                    $('#perOom').html(
                        '<strong class="text-default"> ' +
                        result.percentage.oom + '% </strong>')
                }

                // OM
                if (result.percentage.om < 0) {
                    $('#perOm').html(
                        '<strong class="text-danger"><i class="fas fa-arrow-down text-sm"></i> ' +
                        result.percentage.om + '% </strong>')
                } else if (result.percentage.om > 0) {
                    $('#perOm').html(
                        '<strong class="text-success"><i class="fas fa-arrow-up text-sm"></i> ' +
                        result.percentage.om + '% </strong>')
                } else {
                    $('#perOm').html(
                        '<strong class="text-default"> ' +
                        result.percentage.om + '% </strong>')
                }
                var pieData = {
                    labels: ['Civil', 'Outra OM', '3° B Sup'],
                    datasets: [{
                        data: result.statistics,
                        backgroundColor: ['#ffc107 ', '#6c757d ', '#dc3545 ']
                    }]
                }
                var pieOptions = {
                    legend: {
                        display: false
                    }
                }
                var pieChart = new Chart(relGda, {
                    type: 'doughnut',
                    data: pieData,
                    options: pieOptions
                })
            })
        })

        $(function() {
            $("#table").DataTable({
                "order": [
                    [0, 'desc']
                ],
                "bInfo": false,
                "paging": false,
                "pagingType": 'simple',
                "responsive": true,
                "lengthChange": false,
                "iDisplayLength": 10,
                "autoWidth": false,
                "dom": '<"top">rt<"bottom"ip><"clear">',
                "language": {
                    "url": "{{ asset('plugins/datatables/Portuguese2.json') }}"
                },
                "aoColumnDefs": [{
                    'sortable': false,
                    'aTargets': [1, 2, 3]
                }],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('rankVtr') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                },
            });

        });
    </script>
@endsection --}}

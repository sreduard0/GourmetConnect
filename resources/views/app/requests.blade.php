@extends('app.layout')
@section('title', 'Pedidos')
@section('menu-requests', 'menu-open')
@section('requests', 'active')
@section('title-header', 'Meus pedidos')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
{{-- CRUD --}}
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <select class="text-center w-250 select-rounded  res col-md-3 m-r-5" id="filter-item-table" class="form-control" onchange="return filter_all_requests()">
                    <option value='' selected>TODAS MESAS</option>
                    @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                        <option value="{{ $t }}">MESA #{{ $t }}</option>
                        @endfor
                </select>
                <button class="btn btn-accent rounded-pill btnres" onclick="modal_new_request()"><strong>NOVO PEDIDO</strong></button>
            </div>
        </div>
        <div class="card-body">
            <table id="requests-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30px">Ord.</th>
                        <th>Cliente</th>
                        <th width="30px">Mesa</th>
                        <th width='80px'>Pedido</th>
                        <th width="130px">Valor</th>
                        <th width="110px">Ações</th>

                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end row">
                <button class="btn btn-accent rounded-pill btnres" onclick="print_request_notification('all')"><strong>IMPRIMIR PENDENTES</strong></button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('modal')
{{-- NOVO PEDIDO --}}
<div class="modal fade" id="new-request-modal" role="dialog" tabindex="-1" aria-labelledby="newReqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="type-itemLabel">COMANDA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div-select-client" class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <select class="text-center col select-rounded m-b-10" id="table-select">
                            <option disabled selected value="">SELECIONE UMA MESA</option>
                            @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                                <option value="{{ $t }}">MESA #{{ $t }}</option>
                                @endfor
                        </select>
                        <input minlength="2" maxlength="200" id="client-name" value="" type="text" class="form-control rounded-pill text-center col m-b-10" placeholder="Nome do Cliente ou Nº da comanda">
                        <div class="d-flex justify-content-center">
                            <button id="btn-select-request" class="btn btn-accent rounded-pill"><i class="fa-solid fa-circle-chevron-right fs-35"></i></button>
                        </div>
                    </div>

                </div>
                <div style="display:none" id="div-add-request">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between row">
                                <h3 class="card-title ">CARDÁPIO</h3>
                                <select class=" text-center select-rounded res" id="filter-type-item" name="filter-type-item">
                                    <option disabled selected>BUSQUE POR UM TIPO</option>
                                    <option value="">TODOS</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width:100%" id="menu-table" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th width='25px'>Foto</th>
                                        <th>Item</th>
                                        <th width='100px'>Valor</th>
                                        <th width='70px'>Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between row">
                                <h3 id="title-requests" class="card-title "></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width:100%" id="client-requests-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25px">Foto</th>
                                        <th>Item</th>
                                        <th width="60px">Valor</th>
                                        <th width="70px">Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" id="modal-footer" style="display:none">
                <button id="send-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>ENVIAR PEDIDO</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- PEDIDOS DO CLIENTE --}}
<div class="modal fade" id="requests-client-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reqClienttitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills">
                    <li class="nav-item" onclick="requests_client_view_table(false)"><a class="requests nav-link rounded-pill" href="#requests" data-toggle="tab">Pedidos</a></li>
                    <li class="nav-item" onclick="requests_client_view_table(true)"><a class="pending nav-link rounded-pill" href="#pending" data-toggle="tab">Pendentes</a></li>
                </ul>
                <table style="width:100%" id="client-requests-view-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25px">Foto</th>
                            <th>Item</th>
                            <th width="30px">Qtd.</th>
                            <th width="80px">Valor</th>
                            <th width="30px">Ver</th>
                        </tr>
                    </thead>
                </table>
                <div class="tab-content">
                    <div class="requests tab-pane" id="requests">
                        <div class="col-md-5 m-t-10">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">TOTAL:</th>
                                            <td class="value-total"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="pending tab-pane" id="pending">
                        <input type="hidden" id="print_id">
                        <button type="button" onclick='print_request()' class="btn btn-accent rounded-pill float-right m-t-10"><strong>IMPRIMIR PEDIDO</strong></button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
{{-- LISTA DE ITEM DO MESMO TIPO DO PEDIDO --}}
<div class="modal fade" id="list-items-equals-modal" role="dialog" tabindex="-1" aria-labelledby="reqClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product_name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width:100%" id="list-items-equals-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25px">Foto</th>
                            <th>Item</th>
                            <th width="110px">Garçom</th>
                            <th width="80px">Valor</th>
                            <th width="60px">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- ADICIONAIS E OBS --}}
<div class="modal fade" id="observation-item-modal" role="dialog" tabindex="-1" aria-labelledby="observation-item-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observation-item-modalLabel">ADICIONAIS E OBSERVAÇÕES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="request_id">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title "><strong>Adicionais</strong></h5>
                    </div>
                    <form id="form-add-additional">
                        <div id="checkbox-container" class="card-body">
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> <strong>Observações</strong> </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="obs-additional" id="obs-additional" rows="8" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save-obs-item-request" type="button" class="btn btn-accent rounded-pill float-right"><strong>SALVAR</strong></button>
            </div>
        </div>
    </div>
</div>
@include('app.component.view-item')
@endsection
@section('plugins')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/request.js') }}"></script>
@endsection

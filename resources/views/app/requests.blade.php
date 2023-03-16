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
                <div class="col-md-6">
                    <select class="text-center w-250 select-rounded  res col-md-3 m-r-5" id="filter-item" class="form-control">
                        <option selected>TODAS MESAS</option>
                        @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                            <option value="{{ $t }}">MESA #{{ $t }}</option>
                            @endfor
                    </select>
                    <select class="text-center w-250 select-rounded  res col-md-3 " id="filter-item" class="form-control">
                        <option selected>STATUS</option>
                        <option>ABERTAS</option>
                        <option>FECHADAS</option>
                        <option>COM PEDIDO</option>
                        <option>XXXX</option>
                    </select>

                </div>
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
                        <th width="130px">Valor</th>
                        <th width="80px">Ações</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('modal')
{{-- NOVO PEDIDO --}}
<div class="modal fade" id="new-request-modal" role="dialog" tabindex="-1" aria-labelledby="TypeItemLabel" aria-hidden="true">
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
                        <input minlength="2" maxlength="200" id="client-name" value="" type="text" class="form-control rounded-pill col m-b-10" placeholder="Nome do Cliente">
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
                                        <th width="30px">Cod.</th>
                                        <th width="35px">Foto</th>
                                        <th>Item</th>
                                        <th width="30px">Qtd.</th>
                                        <th width="60px">Valor</th>
                                        <th width="80px">Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer" id="modal-footer" style="display:none">
                <button type="button" class="btn btn-accent rounded-pill float-right" data-dismiss="modal"><strong>ENVIAR PEDIDO</strong></button>
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

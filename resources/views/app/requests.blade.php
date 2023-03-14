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
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <select class="text-center w-250 select-rounded  res col-md-3 " id="filter-item" class="form-control">
                    <option selected>TODAS MESAS</option>
                    @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                        <option value="{{ $t }}">MESA #{{ $t }}</option>
                        @endfor
                </select>
                <button class="btn btn-accent rounded-pill btnres" onclick="modal_new_request()"><strong>NOVO PEDIDO</strong></button>
            </div>
        </div>
        <div class="card-body">
            <table id="requests-table" class="table table-bordered table-hover">
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
                <h5 class="modal-title" id="type-itemLabel">NOVO PEDIDO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between row">
                    <select class="text-center select-rounded col-md-3 m-b-10" id="filter-item">
                        <option disabled selected>MESA</option>
                        @for ($t = 1; $t <= $app_settings->number_tables; $t++)
                            <option value="{{ $t }}">MESA #{{ $t }}</option>
                            @endfor
                    </select>

                    <input minlength="2" maxlength="200" id="teste" name="teste" type="text" class="form-control rounded-pill col-md-3 m-b-10" placeholder="Nome do Cliente">

                </div>


                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between row">
                            <h3 class="card-title ">CARDÁPIO</h3>
                            <select class="text-center select-rounded res" id="filter-item">
                                <option disabled selected>BUSQUE POR UM ITEM</option>
                                <option value="">Todos</option>
                            </select>

                        </div>
                    </div>
                    <div class="card-body">
                        <table style="width:100%" id="menu-table" class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th width="30px">Cod.</th>
                                    <th width="30px">Foto</th>
                                    <th>Item</th>
                                    <th width="130px">Valor</th>
                                    <th width="80px">Ações</th>

                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between row">
                            <h3 class="card-title ">PEDIDOS DE PAULO</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table style="width:100%" id="client-requests-table" class="table table-bordered table-hover">


                            <thead>
                                <tr>
                                    <th width="30px">Cod.</th>
                                    <th>Foto</th>
                                    <th width="30px">Item</th>
                                    <th width="130px">Valor</th>
                                    {{-- <th width="80px">Ações</th> --}}

                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-accent rounded-pill" data-dismiss="modal"><strong>ENVIAR PEDIDO</strong></button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/request.js') }}"></script>
@endsection

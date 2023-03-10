@extends('app.layout')
@section('title', 'Cardápio')
@section('menu', 'active')
@section('title-header', 'Cardápio')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
<script src="{{ asset('js/forms-menu.js') }}"></script>
<script src="{{ asset('js/croppie.js') }}"></script>
@endsection
@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/croppie.css') }}" />
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <h3 class="card-title">CARDÁPIO</h3>
                <select class=" text-center select-rounded res" id="filter-type-item" name="filter-type-item" class="form-control">
                    <option disabled selected>BUSQUE POR UM TIPO</option>
                    <option value="">Todos</option>
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <button class=" btn  btn-accent rounded-pill btnres" onclick="modal_new_item()"><strong>NOVO ITEM</strong></button>
            </div>
        </div>
        <div class="card-body">
            <table id="table-menu" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30px">Cod.</th>
                        <th width="40px">Foto</th>
                        <th>Item</th>
                        <th width="130px">Tipo</th>
                        <th width="100px">Valor</th>
                        <th width="90px">Ações</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">

                <h3 class="card-title">TIPO</h3>
                <button class="btn btn-accent btn-sm rounded-pill btnres" onclick="modal_new_type_item()"><strong>NOVO TIPO</strong></button>
            </div>
        </div>
        <div class="card-body">
            <table id="type-item-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="mx-auto" style="width: 30px">Foto</th>
                        <th>Tipo</th>
                        <th style="width: 40px">Itens</th>
                        <th style="width:70px">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <h3 class="card-title ">ADICIONAIS</h3>
                <select class="text-center select-rounded res" id="filter-item" class="form-control">
                    <option disabled selected>BUSQUE POR UM ITEM</option>
                    <option value="">Todos</option>
                    @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-accent btn-sm rounded-pill btnres" onclick="modal_new_additional_item()"><strong>NOVO ADICIONAL</strong></button>

            </div>
        </div>
        <div class="card-body">
            <table id="additional-items-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="mx-auto" style="width: 10px">#</th>
                        <th>Adicional</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th style="width: 50px">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('modal')
{{-- TIPO DE ITEM --}}
<div class="modal fade" id="type-item-modal" tabindex="-1" role="dialog" aria-labelledby="TypeItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="type-itemLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="d-flex justify-content-sm-end">
                        <p class="f-s-13">(A imagem e campos com <span style="color:red">*</span>
                            são obrigatórios)</p>
                    </div>
                </div>
                <div class="row">
                    <div class="mx-auto">
                        <img id="img_type_product" width="200" class="img-circle" src="{{ asset('img/gourmetconnect-logo/g-c-.png') }} " alt="Imagem do produto">
                        <div class="d-flex justify-content-sm-end">
                            <label for="upload_type_item_image" class="btn btn-accent rounded-pill"><i class="fa-solid fa-folder-image"></i></label>
                            <input type="file" class="input-img-profile" name="upload_type_item_image" id="upload_type_item_image" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                        </div>
                    </div>
                </div>
                <form id="form-type-item">
                    <input type="hidden" name="id-type-product" id="id-type-product">
                    <input type="hidden" name="img-type-product" id="img-type-product-crop">
                    <div class="row">

                        <div class="form-group col">
                            <label for="name-type-product">Nome <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="name-type-product" name="name-type-product" type="text" class="form-control" placeholder="EX: Pizzas">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="obs-type-product">Observações</label>
                            <textarea name="obs-type-product" id="obs-type-product" rows="8" placeholder="Detalhes importantes da missão. Exemplo: Para Eixo Sul PGT" class="text form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal"><strong>FECHAR</strong></button>
                <button id="btn-save-type-item" type="button" class="btn btn-accent rounded-pill" onclick=""><strong>SALVAR</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- ITEM --}}
<div class="modal fade" id="item-modal" role="dialog" aria-labelledby="newItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="item-modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="d-flex justify-content-sm-end">
                        <p class="f-s-13">(A imagem e campos com <span style="color:red">*</span>
                            são obrigatórios)</p>
                    </div>
                </div>
                <div class="row">
                    <div class="mx-auto">
                        <img id="img_product" width="200" class="img-circle" src="{{ asset('img/gourmetconnect-logo/g-c-.png') }} " alt="Imagem do produto">
                        <div class="d-flex justify-content-sm-end">
                            <label for="upload_item_image" class="btn btn-accent rounded-pill"><i class="fa-solid fa-folder-image"></i></label>
                            <input type="file" class="input-img-profile" name="upload_type_item_image" id="upload_item_image" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                        </div>
                    </div>
                </div>
                <form id="form-item">
                    <input type="hidden" name="id-product" id="id-product">
                    <input type="hidden" name="img-product" id="img-product-crop">
                    <div class="row">

                        <div class="form-group col">
                            <label for="type-product">Tipo <span style="color:red">*</span></label>
                            <select id="type-product" name="type-product" class="form-control" style="width:100%">
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                                <option selected disabled value="">Selecione um tipo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="name-product">Nome <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="name-product" name="name-product" type="text" class="form-control" placeholder="EX: Pizza">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="value-product">Preço <span style="color:red">*</span></label>
                            <input onkeypress="return(moeda(this,'.',',',event))" id="value-product" name="value-product" type="text" class="form-control" placeholder="EX: R$ 10,00">


                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="obs-product">Observações</label>
                            <textarea name="obs-product" id="obs-product" rows="8" placeholder="Detalhes importantes da missão. Exemplo: Para Eixo Sul PGT" class="text form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal"><strong>FECHAR</strong></button>
                <button type="button" id="btn-save-item" class="btn btn-accent rounded-pill" onclick=""><strong>SALVAR</strong></button>

            </div>
        </div>
    </div>
</div>
{{-- ITEM ADICIONAL --}}
<div class="modal fade" id="additional-item-modal" role="dialog" aria-labelledby="additional-itemLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="additional-itemLabel">NOVO ITEM ADICIONAL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="d-flex justify-content-sm-end">
                        <p class="f-s-13">(Campos com <span style="color:red">*</span>
                            são obrigatórios)</p>
                    </div>
                </div>
                <form id="form-additional-item">
                    <input type="hidden" name="id_additional_item" id="id_additional_item">
                    <div class="row">
                        <div class="form-group col">
                            <label for="item-menu">Item <span style="color:red">*</span></label>
                            <select id="item-menu" name="item-menu" class="form-control select2" style="width: 100%;">
                                @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <option selected value="">Selecione um item</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="additional-name">Nome <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="name-additional" name="name-additional" type="text" class="form-control" placeholder="EX: Pizza">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="name-additional">Preço <span style="color:red">*</span></label>
                            <input onKeyPress="return(moeda(this,'.',',',event))" id="value-additional" name="value-additional" type="text" class="form-control" placeholder="EX: R$ 10,00">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="obs-additional">Observações</label>
                            <textarea name="obs-additional" id="obs-additional" rows="8" class="text form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal"><strong>FECHAR</strong></button>
                <button type="button" id="btn-save-additional-item" class="btn btn-accent rounded-pill" onclick=""><strong>SALVAR</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- VIEW ITEM --}}
@include('app.component.view-item')
{{-- ENVIO DE IMAGEM --}}
<div id="uploadimage" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajustar imagem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="image_demo"></div>
            </div>
            <div id="crop_image" class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/crop-img.js') }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
@endsection

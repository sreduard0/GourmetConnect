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
<link rel="stylesheet" href="{{ asset('css/croppie.css') }}" />
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-md-5">
                    <div class="row ">
                        <div class="form-group col">
                            <label for="statusFicha">Filtrar por status</label>
                            <select id="statusFicha" name="statusFicha" class="form-control">
                                <option value="">Todas</option>
                                <option value="3">Aguardando autorização</option>
                                <option value="1">Abertas</option>
                                <option value="2">Fechadas</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-sm-end">
                    <div class="col">
                        <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#register-ficha">NOVO ITEM</button>

                    </div>
                </div>
            </div>
            <div id="button-print"></div>
        </div>
        <div class="card-body">
            <table id="table-menu" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30px">Cod.</th>
                        <th>Foto</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">TIPO</h3>
            <div class="d-flex justify-content-sm-end">
                <button class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#new-type-item">NOVO TIPO</button>
            </div>
        </div>
        <div class="card-body">
            <table id="type-item-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="mx-auto" style="width: 30px">Foto</th>
                        <th>Tipo</th>
                        <th style="width: 40px">Itens</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ADICIONAIS</h3>
            <div class="d-flex justify-content-sm-end">
                <button class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#register-ficha">NOVO ADICIONAL</button>

            </div>
        </div>
        <div class="card-body">
            <table id="best-sellers-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="mx-auto" style="width: 10px">#</th>
                        <th>Adicional</th>
                        <th>Produto</th>
                        <th style="width: 40px">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('modal')
{{-- CRIAR NOVO TIPO DE ITEM --}}
<div class="modal fade" id="new-type-item" tabindex="-1" role="dialog" aria-labelledby="register-missionLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-type-itemLabel">NOVA CLASSIFICAÇÃO DE ITEM</h5>
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
                <div class="row">
                    <div class="mx-auto">
                        <img id="img_product" width="200" class="img-circle" src="{{ asset('img/gourmetconnect-logo/gourmetconnect.png') }} " alt="Imagem do produto">
                        <div class="d-flex justify-content-sm-end">
                            <label for="upload_image" class="btn btn-success rounded-pill"><i class="fa fa-pen"></i><span style="color:red">*</span></label>
                            <input type="file" class="btn btn-success input-img-profile" name="upload_image" id="upload_image" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                        </div>
                    </div>
                </div>
                <form id="form-new-type-item">
                    <div class="row">
                        <input type="hidden" name="img-type-product" id="img-product-crop">
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
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">FECHAR</button>
                <button type="button" class="btn btn-success rounded-pill" onclick="return save_new_type_item()">SALVAR</button>

            </div>
        </div>
    </div>
</div>

{{-- ENVIO DE IMAGEM --}}
<div id="uploadimage" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajustar imagem</h4>
            </div>
            <div class="modal-body">
                <div id="image_demo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default rounded-pill" data-dismiss="modal">FECHAR</button>
                <button class="btn btn-success rounded-pill crop_image">CORTAR</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/crop-img.js') }}"></script>
@endsection
@section('plugins')
<script>
    $(function() {
        $("#table-menu").DataTable({
            // "order": [
            //     [0, 'desc']
            // ],
            "bInfo": false
            , "paging": false
            , "pagingType": 'simple'
            , "responsive": true
            , "lengthChange": false
            , "iDisplayLength": 10
            , "autoWidth": false
            , "dom": '<"top">rt<"bottom"ip><"clear" >'
            , "language": {
                "url": "{{ asset('plugins/datatables/Portuguese2.json') }}"
            }
            , "aoColumnDefs": [{
                'sortable': false
                , 'aTargets': [1, 2, 3]
            }]
            // , "processing": true
            // , "serverSide": true
            // , "ajax": {
            //     "url": ""
            //     , "type": "POST"
            //     , "headers": {
            //         'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //     , }
            // , }
        });
        $("#type-item-table").DataTable({
            "ordering": false

            , "bInfo": false
            , "paging": true
            , "pagingType": 'simple_numbers'
            , "responsive": true
            , "lengthChange": false
            , "iDisplayLength": 10
            , "autoWidth": false
            , "dom": '<"top">rt<"bottom"ip> <"clear">'
            , "language": {
                "url": "{{ asset('plugins/datatables/Portuguese2.json') }}"
            }
            , "processing": true
            , "serverSide": true
            , "ajax": {
                "url": "{{ route('table_type_item') }}"
                , "type": "POST"
                , "headers": {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                , }
            , }
        });
        $("#best-sellers-table").DataTable({

            // "order": [
            // [0, 'desc']
            // ],
            "bInfo": false
            , "paging": false
            , "pagingType": 'simple'
            , "responsive": true
            , "lengthChange": false
            , "iDisplayLength": 10
            , "autoWidth": false
            , "dom": '<"top">rt<"bottom"ip> <"clear">'
            , "language": {
                "url": "{{ asset('plugins/datatables/Portuguese2.json') }}"
            },
            // , "aoColumnDefs": [{
            // 'sortable': false
            // , 'aTargets': [1, 2, 3]
            // }]
            // , "processing": true
            // , "serverSide": true
            // , "ajax": {
            // "url": ""
            // , "type": "POST"
            // , "headers": {
            // 'X-CSRF-TOKEN': "{{ csrf_token() }}"
            // , }
            // , }
        });

    });

</script>
@endsection

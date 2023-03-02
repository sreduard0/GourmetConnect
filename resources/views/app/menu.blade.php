@extends('app.layout')
@section('title', 'Cardápio')
@section('menu', 'active')
@section('title-header', 'Cardápio')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <th width="30px">N°</th>
                        <th width="140px">Viatura</th>
                        <th>Missão</th>
                        <th>Por ordem </th>
                        <th>Motorista</th>
                        <th>Segurança</th>
                        <th>Natureza</th>
                        <th>Encerramento</th>
                        <th>KM/s rodados</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tipo</h3>
            <div class="d-flex justify-content-sm-end">
                <button class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#new-type-item">NOVO TIPO</button>
            </div>
        </div>
        <div class="card-body">
            <table id="type-item-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
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
            <h3 class="card-title">Adicionais</h3>
            <div class="d-flex justify-content-sm-end">
                <button class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#register-ficha">NOVO ADICIONAL</button>

            </div>
        </div>
        <div class="card-body">
            <table id="best-sellers-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
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
<div class="modal fade" id="new-type-item" tabindex="-1" role="dialog" aria-labelledby="register-missionLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="register-missionLabel">NOVA CLASSIFICAÇÃO DE ITEM</h5>
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
                <form id="form-new-type-item">
                    <div class="row">
                        <div class="form-group col">
                            <label for="nameMission">Missão
                                <span style="color:red">*</span>
                            </label>
                            <input minlength="2" maxlength="200" id="nameMission" name="nameMission" type="text" class="form-control" placeholder="Ex: Feno e Aveia">
                        </div>
                        <div class="form-group col">
                            <label for="destinyMission">Destino <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="destinyMission" name="destinyMission" type="text" class="form-control" placeholder="Destino da missão (OM ou local).">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="classMission">Classe
                            </label>
                            <select class="form-control" name="classMission" id="classMission">
                                <option selected value="">Selecione</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V-arm">V-arm</option>
                                <option value="V-mun">V-mun</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col">
                            <label for="docMission">Documento
                            </label>
                            <input minlength="2" maxlength="200" id="docMission" name="docMission" type="text" class="form-control" placeholder="documento que deu ordem para a realizar a missão.">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-md-2">
                            <label for="pgSegMission">Posto/Grad <span style="color:red">*</span></label>
                            <select class="form-control" name="pgSegMission" id="pgSegMission">
                                <option value="">Selecione</option>
                                <option value="Gen">Gen</option>
                                <option value="Cel">Cel</option>
                                <option value="TC">TC</option>
                                <option value="Maj">Maj</option>
                                <option value="Cap">Cap</option>
                                <option value="1º Ten">1º Ten</option>
                                <option value="2º Ten">2º Ten</option>
                                <option value="Asp">Asp</option>
                                <option value="ST">ST</option>
                                <option value="1º Sgt">1º Sgt</option>
                                <option value="2º Sgt">2º Sgt</option>
                                <option value="3º Sgt">3º Sgt</option>
                                <option value="Cb">Cb</option>
                                <option value="Sd">Sd</option>
                            </select>
                        </div>

                        <div class="form-group col">
                            <label for="nameSegMission">Nome do cmt da missão <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="nameSegMission" name="nameSegMission" type="text" class="form-control" placeholder="Nome do cmt da missão">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contactCmtMission">Telefone de contato <span style="color:red">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="contactCmtMission" name="contactCmtMission" data-inputmask="'mask':'+55 (99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="EX: +55 (51) 9 8020-4426">
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="originMission">Origem </label>
                            <input minlength="2" maxlength="200" id="originMission" name="originMission" type="text" class="form-control" placeholder="3º B Sup">
                        </div>
                        <div class="form-group col">
                            <label>Prev. do dia e horário da partida <span style="color:red">*</span></label>
                            <div class="input-group date" id="prev_part" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#prev_part" id="datePrevPartMission" name="datePrevPartMission" value="">
                                <div class="input-group-append" data-target="#prev_part" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label>Prev. do dia e horário da chegada <span style="color:red">*</span></label>
                            <div class="input-group date" id="prev_chgd" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#prev_chgd" id="datePrevChgdMission" name="datePrevChgdMission" value="">
                                <div class="input-group-append" data-target="#prev_chgd" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="obsMission">Observações</label>
                            <textarea name="obsMission" id="obsMission" rows="8" placeholder="Detalhes importantes da missão. Exemplo: Para Eixo Sul PGT" class="text form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
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
            },
            // , "aoColumnDefs": [{
            //         'sortable': false
            //         , 'aTargets': [1, 2, 3]
            //     }]
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

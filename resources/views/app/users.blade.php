@extends('app.layout')
@section('title', 'Usuários')
@section('users', 'active')
@section('config', 'menu-open')
@section('title-header', 'Usuários')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@section('script')
<script src="{{ asset('assets/app/js/croppie.js') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/app/css/croppie.css') }}" />
<link rel="stylesheet" href="{{asset('assets/app/plugins/select2/css/select2.css')}}">
@endsection
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between row">
                <input class="text-center form-control col-md-3 select-rounded" id="filter-user" class="form-control" on placeholder="Busque por um nome">
                @can('create_user')
                <button class="btn btn-accent rounded-pill btnres" onclick="user_modal('create')"><strong>NOVO USUÁRIO</strong></button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table id="users" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width='30px'>Foto</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Função</th>
                        <th>Status</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('modal')
@can('permissions_user')
{{-- PERMISSÕES --}}
<div class="modal fade" id="user-permission-modal" role="dialog" aria-labelledby="user-permission-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Definir permissões</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="form-group">
                        <select id="permission_list" name="permission_list" class="permission_list" multiple="multiple" data-placeholder="Permissões" style="width: 100%">
                            <optgroup label="Painel de controle">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'dashboard')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Pedidos/ Local">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'requests_local')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Pedidos/ Delivery">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'requests_delivery')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Mesas">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'tables')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Cardápio">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'menu')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Usuários">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'user')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Configurações">
                                @foreach ($permissions as $permission)
                                @if ($permission->group_name == 'app')
                                <option id="{{ $permission->name }}" value="{{ $permission->name }}">{{ $permission->display_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" id="user_id">
                <button onclick="save_permissions($('#user_id').val())" type="button" class="btn btn-accent rounded-pill" data-dismiss="modal"><strong>SALVAR</strong></button>
            </div>
        </div>
    </div>
</div>
@endcan
@canany(['create_user','edit_user'])
{{-- CRIAR/EDITAR USUÁRIO --}}
<div class="modal fade" id="user-modal" role="dialog" aria-labelledby="userLaber" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userTitleLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <div class="d-flex justify-content-sm-end">
                        <p class="f-s-13">(Os campos com <span style="color:red">*</span>
                            são obrigatórios)</p>
                    </div>
                </div>
                <div class="row">
                    <div class="mx-auto">
                        <img id="adjusted-image" width="200" class="img-circle" src="{{ asset('img/avatar/user.png') }} " alt="Imagem do usuário">
                        <div class="d-flex justify-content-sm-end">
                            <label for="chenge-user-image" class="btn btn-accent rounded-pill"><i class="fa-solid fa-folder-image"></i></label>
                            <input type="file" class="input-img-profile" name="chenge-user-image" id="chenge-user-image" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                        </div>
                    </div>
                </div>
                <form id="form-user">
                    <input type="hidden" name="user-id" id="user-id">
                    <input type="hidden" name="img-user" id="img-adjusted-user">
                    <div class="row">
                        <div class="form-group col">
                            <label for="user-status">Status <span style="color:red">*</span></label>
                            <select id="user-status" name="user-status" class="form-control">
                                <option selected value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="first-name">Nome <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="first-name" name="first-name" type="text" class="form-control" placeholder="Nome">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="last-name">Sobrenome <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="last-name" name="last-name" type="text" class="form-control" placeholder="Sobrenome">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="user-job">Função <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="user-job" name="user-job" type="text" class="form-control" placeholder="EX: GARÇOM">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="user-phone">Telefone <span style="color:red">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="user-phone" name="user-phone" data-inputmask="'mask':'(99) 9 9999-9999'" data-mask="" inputmode="text" placeholder="Telefone">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="user-email">Email <span style="color:red">*</span></label>
                            <input minlength="2" maxlength="200" id="user-email" name="user-email" type="email" class="form-control" placeholder="exemplo@exemple.com">
                        </div>
                    </div>
                </form>
            </div>
            <div id="btn-user-modal" class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal"><strong>FECHAR</strong></button>
            </div>
        </div>
    </div>
</div>
{{-- AJUSTE DE IMAGEM --}}
<div id="changeimage" class="modal" role="dialog">
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
                <button onclick="return adjust_image()" class="btn btn-accent rounded-pill ">CORTAR</button>

            </div>
        </div>
    </div>
</div>
@endcan
@endsection
@section('plugins')
<script src="{{ asset('private/assets/js/users.js') }}"></script>
<script src="{{ asset('private/assets/js/form-users.js') }}"></script>
<script src="{{ asset('assets/app/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

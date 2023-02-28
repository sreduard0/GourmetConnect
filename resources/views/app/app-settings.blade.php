@extends('app.layout')
@section('title', 'Configurações do aplicativo')
@section('app-settings', 'active')
@section('config', 'menu-open')
@section('title-header', 'Configurações do aplicativo')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
<script src="{{ asset('js/forms-app-settings.js') }}"></script>
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#stablishment-settings" data-toggle="tab">Estabelecimento</a></li>
                <li class="nav-item"><a class="nav-link" href="#theme-settings" data-toggle="tab">Cores</a></li>
                <li class="nav-item"><a class="nav-link" href="#general-settings" data-toggle="tab">Geral</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="stablishment-settings">
                    <form id="form-stablishment-settings">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="stablishment-name">Nome do estabelecimento <span style="color:red">*</span></label>
                                <input class="form-control" name="stablishment-name" id="stablishment-name" placeholder="EX: XIS DO PEDRO">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="stablishment-cnpj">CNPJ <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="stablishment-cnpj" name="stablishment-cnpj" data-inputmask="'mask':'99.999.999/9999-99'" data-mask="" inputmode="text" placeholder="EX: 12.345.678/0003-00">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="stablishment-address">Logradouro <span style="color:red">*</span></label>
                                <input id="stablishment-address" name="stablishment-address" type="text" class="form-control" placeholder="EX: Rua do Açai">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="stablishment-number">Nº <span style="color:red">*</span></label>
                                <input id="stablishment-number" name="stablishment-number" type="text" class="form-control" placeholder="EX: 1890">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="stablishment-city">Cidade <span style="color:red">*</span></label>
                                <input id="stablishment-city" name="stablishment-city" type="text" class="form-control" placeholder="Porto Alegre">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="stablishment-state">UF <span style="color:red">*</span></label>
                                <input minlength="2" maxlength="200" id="stablishment-state" name="stablishment-state" type="text" class="form-control" placeholder="EX: RS">


                            </div>

                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-success">SALVAR</button>
                    </div>
                </div>
                <div class="tab-pane" id="theme-settings">
                    <form id="form-theme-settings">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-background">Cor do fundo</label>
                                <select class="form-control" name="theme-background" id="theme-background">
                                    <option value="dark-mode">Modo escuro</option>
                                    <option value="light-mode">Modo claro</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-accent">Cor de destaque</label>
                                <select class="form-control" name="theme-accent" id="theme-accent">
                                    <option value="accent-primary" class="bg-primary">Azul</option>
                                    <option value="accent-warning" class="bg-warning">Amarelo</option>
                                    <option value="accent-info" class="bg-info">Ciano</option>
                                    <option value="accent-danger" class="bg-danger">Vermelho</option>
                                    <option value="accent-success" class="bg-success">Verde</option>
                                    <option value="accent-indigo" class="bg-indigo">Indigo</option>
                                    <option value="accent-ligthblue" class="bg-lightblue">Azul-claro</option>
                                    <option value="accent-navy" class="bg-navy">Azul-marinho</option>
                                    <option value="accent-purple" class="bg-purple">Lilás</option>
                                    <option value="accent-fuchsia" class="bg-fuchsia">Magenta</option>
                                    <option value="accent-pink" class="bg-pink">Roza</option>
                                    <option value="accent-maroon" class="bg-maroon">Bordô</option>
                                    <option value="accent-orange" class="bg-orange">Laranja</option>
                                    <option value="accent-lime" class="bg-lime">Lima</option>
                                    <option value="accent-teal" class="bg-teal">Verde-azulado</option>
                                    <option value="accent-olive" class="bg-olive">Verde-oliva</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-sidebar">Cor do menu lateral</label>
                                <select class="form-control" name="theme-sidebar" id="theme-sidebar">
                                    <optgroup label="Lateral escura">
                                        <option value="sidebar-dark-primary" class="bg-primary">Escuro / Azul</option>
                                        <option value="sidebar-dark-warning" class="bg-warning">Escuro / Amarelo</option>
                                        <option value="sidebar-dark-info" class="bg-info"> Escuro / Ciano</option>
                                        <option value="sidebar-dark-danger" class="bg-danger"> Escuro / Vermelho</option>
                                        <option value="sidebar-dark-success" class="bg-success"> Escuro / Verde</option>
                                        <option value="sidebar-dark-indigo" class="bg-indigo"> Escuro / Indigo</option>
                                        <option value="sidebar-dark-ligthblue" class="bg-lightblue"> Escuro / Azul claro</option>
                                        <option value="sidebar-dark-navy" class="bg-navy"> Escuro / Azul-marinho</option>
                                        <option value="sidebar-dark-purple" class="bg-purple"> Escuro / Lilás</option>
                                        <option value="sidebar-dark-fuchsia" class="bg-fuchsia"> Escuro / Magenta</option>
                                        <option value="sidebar-dark-pink" class="bg-pink"> Escuro / Roza</option>
                                        <option value="sidebar-dark-maroon" class="bg-maroon"> Escuro / Bordô</option>
                                        <option value="sidebar-dark-orange" class="bg-orange"> Escuro / Laranja</option>
                                        <option value="sidebar-dark-lime" class="bg-lime"> Escuro / Lima</option>
                                        <option value="sidebar-dark-teal" class="bg-teal"> Escuro / Verde-azulado</option>
                                        <option value="sidebar-dark-olive" class="bg-olive"> Escuro / Verde-oliva</option>
                                    </optgroup>
                                    <optgroup label="Lateral clara" style="background-color: white;color:black">
                                        <option value="sidebar-light-primary" class="bg-primary"> Claro / Azul</option>
                                        <option value="sidebar-light-warning" class="bg-warning"> Claro / Amarelo</option>
                                        <option value="sidebar-light-info" class="bg-info"> Claro / Ciano</option>
                                        <option value="sidebar-light-danger" class="bg-danger"> Claro / Vermelho</option>
                                        <option value="sidebar-light-success" class="bg-success"> Claro / Verde</option>
                                        <option value="sidebar-light-indigo" class="bg-indigo"> Claro / Indigo</option>
                                        <option value="sidebar-light-ligthblue" class="bg-lightblue"> Claro / Azul-claro</option>
                                        <option value="sidebar-light-navy" class="bg-navy"> Claro / Axul-marinho</option>
                                        <option value="sidebar-light-purple" class="bg-purple"> Claro / Lilás</option>
                                        <option value="sidebar-light-fuchsia" class="bg-fuchsia"> Claro / Magenta</option>
                                        <option value="sidebar-light-pink" class="bg-pink"> Claro / Roza</option>
                                        <option value="sidebar-light-maroon" class="bg-maroon"> Claro / Bordô</option>
                                        <option value="sidebar-light-orange" class="bg-orange"> Claro / Laranja</option>
                                        <option value="sidebar-light-lime" class="bg-lime"> Claro / Lima</option>
                                        <option value="sidebar-light-teal" class="bg-teal"> Claro / Verde-azulado</option>
                                        <option value="sidebar-light-olive" class="bg-olive"> Claro / Verde-oliva</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-success">SALVAR</button>
                    </div>
                </div>
                <div class="tab-pane" id="general-settings">
                    <form id="general-settings">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="general-tables">Quantidade de mesas <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="general-tables" name="general-tables" data-inputmask="'mask':'999'" data-mask="" inputmode="text" placeholder="EX: 10">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-success">SALVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

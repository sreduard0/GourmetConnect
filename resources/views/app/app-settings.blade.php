@extends('app.layout')
@section('title', 'Configurações do aplicativo')
@section('app-settings', 'active')
@section('config', 'menu-open')
@section('title-header', 'Configurações do aplicativo')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.css')}}">
@endsection
@section('script')
<script src="{{ asset('js/forms-app-settings.js') }}"></script>
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="rounded-pill nav-link active" href="#establishment-settings" data-toggle="tab">Estabelecimento</a></li>
                <li class="nav-item"><a class="rounded-pill nav-link" href="#theme-settings" data-toggle="tab">Cores</a></li>
                <li class="nav-item"><a class="rounded-pill nav-link" href="#general-settings" data-toggle="tab">Geral</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="establishment-settings">
                    <form id="form-establishment-settings">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="establishment-name">Nome do estabelecimento <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->establishment_name }}" class="form-control" name="establishment-name" id="establishment-name" placeholder="EX: XIS DO PEDRO">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="establishment-cnpj">CNPJ <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input value="{{ $app_settings->cnpj }}" type="text" class="form-control" id="establishment-cnpj" name="establishment-cnpj" data-inputmask="'mask':'99.999.999/9999-99'" data-mask="" inputmode="text" placeholder="EX: 12.345.678/0003-00">

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="establishment-address">Logradouro <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->address }}" id="establishment-address" name="establishment-address" type="text" class="form-control" placeholder="EX: Rua do Açai">

                            </div>
                            <div class="form-group col-md-1">
                                <label for="establishment-number">Nº <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input value="{{ $app_settings->number }}" type="text" class="form-control" id="establishment-number" name="establishment-number" data-inputmask="'mask':'9999'" data-mask="" inputmode="text" placeholder="EX: 1800">

                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="establishment-neighborhood">Bairro <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->neighborhood }}" id="establishment-neighborhood" name="establishment-neighborhood" type="text" class="form-control" placeholder="EX: Centro">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="establishment-city">Cidade <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->city }}" id="establishment-city" name="establishment-city" type="text" class="form-control" placeholder="Porto Alegre">

                            </div>
                            <div class="form-group col-md-1">
                                <label for="establishment-state">UF <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->state }}" minlength="2" maxlength="200" id="establishment-state" name="establishment-state" type="text" class="form-control" placeholder="EX: RS">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="establishment-cep">UF <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->cep }}" minlength="2" maxlength="10" id="establishment-cep" name="establishment-cep" type="text" class="form-control" data-inputmask="'mask':'99.999-999'" data-mask="" inputmode="text" placeholder="EX: 92.480-000">
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-accent rounded-pill" onclick="return save_establishment_settings()">SALVAR</button>


                    </div>
                </div>
                <div class="tab-pane" id="theme-settings">
                    <form id="form-theme-settings">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-background">Cor do fundo</label>
                                <select class="form-control" name="theme-background" id="theme-background">
                                    <option @if($app_settings->theme_background == 'dark-mode') selected @endif value="dark-mode">Modo escuro</option>
                                    <option @if($app_settings->theme_background == 'light-mode') selected @endif value="light-mode">Modo claro</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-accent">Cor de destaque</label>
                                <select class="form-control" name="theme-accent" id="theme-accent">
                                    <option @if($app_settings->theme_accent == 'accent-primary') selected @endif value="accent-primary" class="bg-primary">Azul</option>
                                    <option @if($app_settings->theme_accent == 'accent-warning') selected @endif value="accent-warning" class="bg-warning">Amarelo</option>
                                    <option @if($app_settings->theme_accent == 'accent-info') selected @endif value="accent-info" class="bg-info">Ciano</option>
                                    <option @if($app_settings->theme_accent == 'accent-danger') selected @endif value="accent-danger" class="bg-danger">Vermelho</option>
                                    <option @if($app_settings->theme_accent == 'accent-success') selected @endif value="accent-success" class="bg-success">Verde</option>
                                    <option @if($app_settings->theme_accent == 'accent-indigo') selected @endif value="accent-indigo" class="bg-indigo">Indigo</option>
                                    <option @if($app_settings->theme_accent == 'accent-lightblue') selected @endif value="accent-ligthblue" class="bg-lightblue">Azul-claro</option>
                                    <option @if($app_settings->theme_accent == 'accent-navy') selected @endif value="accent-navy" class="bg-navy">Azul-marinho</option>
                                    <option @if($app_settings->theme_accent == 'accent-purple') selected @endif value="accent-purple" class="bg-purple">Lilás</option>
                                    <option @if($app_settings->theme_accent == 'accent-fuchsia') selected @endif value="accent-fuchsia" class="bg-fuchsia">Magenta</option>
                                    <option @if($app_settings->theme_accent == 'accent-pink') selected @endif value="accent-pink" class="bg-pink">Roza</option>
                                    <option @if($app_settings->theme_accent == 'accent-maroon') selected @endif value="accent-maroon" class="bg-maroon">Bordô</option>
                                    <option @if($app_settings->theme_accent == 'accent-orange') selected @endif value="accent-orange" class="bg-orange">Laranja</option>
                                    <option @if($app_settings->theme_accent == 'accent-lime') selected @endif value="accent-lime" class="bg-lime">Lima</option>
                                    <option @if($app_settings->theme_accent == 'accent-teal') selected @endif value="accent-teal" class="bg-teal">Verde-azulado</option>
                                    <option @if($app_settings->theme_accent == 'accent-olive') selected @endif value="accent-olive" class="bg-olive">Verde-oliva</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="theme-sidebar">Cor do menu lateral</label>
                                <select class="form-control" name="theme-sidebar" id="theme-sidebar">

                                    <optgroup label="Lateral escura">
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-primary') selected @endif value="sidebar-dark-primary" class="bg-primary">Escuro / Azul</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-warning') selected @endif value="sidebar-dark-warning" class="bg-warning">Escuro / Amarelo</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-info') selected @endif value="sidebar-dark-info" class="bg-info"> Escuro / Ciano</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-danger') selected @endif value="sidebar-dark-danger" class="bg-danger"> Escuro / Vermelho</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-success') selected @endif value="sidebar-dark-success" class="bg-success"> Escuro / Verde</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-indigo') selected @endif value="sidebar-dark-indigo" class="bg-indigo"> Escuro / Indigo</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-lightblue') selected @endif value="sidebar-dark-ligthblue" class="bg-lightblue"> Escuro / Azul claro</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-navy') selected @endif value="sidebar-dark-navy" class="bg-navy"> Escuro / Azul-marinho</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-purple') selected @endif value="sidebar-dark-purple" class="bg-purple"> Escuro / Lilás</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-fuchsia') selected @endif value="sidebar-dark-fuchsia" class="bg-fuchsia"> Escuro / Magenta</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-pink') selected @endif value="sidebar-dark-pink" class="bg-pink"> Escuro / Roza</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-maroon') selected @endif value="sidebar-dark-maroon" class="bg-maroon"> Escuro / Bordô</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-orange') selected @endif value="sidebar-dark-orange" class="bg-orange"> Escuro / Laranja</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-lime') selected @endif value="sidebar-dark-lime" class="bg-lime"> Escuro / Lima</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-teal') selected @endif value="sidebar-dark-teal" class="bg-teal"> Escuro / Verde-azulado</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-olive') selected @endif value="sidebar-dark-olive" class="bg-olive"> Escuro / Verde-oliva</option>
                                    </optgroup>
                                    <optgroup label="Lateral clara" style="background-color: white;color:black">
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-primary') selected @endif value="sidebar-light-primary" class="bg-primary"> Claro / Azul</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-warning') selected @endif value="sidebar-light-warning" class="bg-warning"> Claro / Amarelo</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-info') selected @endif value="sidebar-light-info" class="bg-info"> Claro / Ciano</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-danger') selected @endif value="sidebar-light-danger" class="bg-danger"> Claro / Vermelho</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-success') selected @endif value="sidebar-light-success" class="bg-success"> Claro / Verde</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-indigo') selected @endif value="sidebar-light-indigo" class="bg-indigo"> Claro / Indigo</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-lightblue') selected @endif value="sidebar-light-ligthblue" class="bg-lightblue"> Claro / Azul-claro</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-navy') selected @endif value="sidebar-light-navy" class="bg-navy"> Claro / Axul-marinho</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-purple') selected @endif value="sidebar-light-purple" class="bg-purple"> Claro / Lilás</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-fuchsia') selected @endif value="sidebar-light-fuchsia" class="bg-fuchsia"> Claro / Magenta</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-pink') selected @endif value="sidebar-light-pink" class="bg-pink"> Claro / Roza</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-maroon') selected @endif value="sidebar-light-maroon" class="bg-maroon"> Claro / Bordô</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-orange') selected @endif value="sidebar-light-orange" class="bg-orange"> Claro / Laranja</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-lime') selected @endif value="sidebar-light-lime" class="bg-lime"> Claro / Lima</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-teal') selected @endif value="sidebar-light-teal" class="bg-teal"> Claro / Verde-azulado</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-olive') selected @endif value="sidebar-light-olive" class="bg-olive"> Claro / Verde-oliva</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-accent rounded-pill" onclick="return save_theme_settings()">APLICAR CORES</button>


                    </div>
                </div>
                <div class="tab-pane" id="general-settings">
                    <form id="form-general-settings">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="general-tables">Quantidade de mesas <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input value="{{ $app_settings->number_tables }}" type="text" class="form-control" id="general-tables" name="general-tables" data-inputmask="'mask':'999'" data-mask="" inputmode="text" placeholder="EX: 10">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Formas de pagamento</label>
                                    <select id="payments" name="payments" class="select-payments" multiple="multiple" data-placeholder="Formas de pagamento" style="width: 100%;">
                                        <optgroup label="Cartões de crédito">
                                            @foreach ($payment_methods as $method)
                                            @if ($method->group_payment == 'credit_card')
                                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Cartões de débito">
                                            @foreach ($payment_methods as $method)
                                            @if ($method->group_payment == 'debit_card')
                                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endif
                                            @endforeach

                                        </optgroup>
                                        <optgroup label="Outras formas de pagamento">
                                            @foreach ($payment_methods as $method)
                                            @if ($method->group_payment == 'other_forms')
                                            <option @if ($method->active) selected @endif value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-sm-end">
                        <button class="btn btn-accent rounded-pill" onclick="return save_general_settings()">SALVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('plugins')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@php
use App\Classes\Tools;
@endphp
@extends('app.layout')
@section('title', 'Configurações do aplicativo')
@section('app-settings', 'active')
@section('config', 'menu-open')
@section('title-header', 'Configurações do aplicativo')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/app/plugins/select2/css/select2.css')}}">
@endsection
@section('script')
<script src="{{ asset('private/assets/js/app-settings.js') }}"></script>
<script src="{{ asset('private/assets/js/forms-app-settings.js') }}"></script>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                @can('config_app_data')
                <li class="nav-item"><a class="rounded-pill nav-link" href="#establishment-settings" data-toggle="tab">Dados</a></li>
                @endcan
                @can('config_app_delivery')
                <li class="nav-item"><a class="rounded-pill nav-link" href="#delivery-settings" data-toggle="tab">Delivery</a></li>
                @endcan
                @can('config_app_email')
                <li class="nav-item"><a class="rounded-pill nav-link" href="#email-settings" data-toggle="tab">E-mail</a></li>
                @endcan
                @can('config_app_theme')
                <li class="nav-item"><a class="rounded-pill nav-link" href="#theme-settings" data-toggle="tab">Cores</a></li>
                @endcan
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                @can('config_app_data')
                <div class="tab-pane" id="establishment-settings">
                    <form id="form-establishment-settings">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="border-bottom border-default m-b-20 col-md-5">
                                    <h5>ESTABELECIMENTO</h5>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="establishment-name">Nome do estabelecimento <span style="color:red">*</span></label>
                                        <input value="{{ $app_settings->establishment_name }}" class="form-control" name="establishment-name" id="establishment-name" placeholder="EX: XIS DO PEDRO">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="establishment-legal-name">Razão social <span style="color:red">*</span></label>
                                        <input value="{{ $app_settings->establishment_legal_name }}" class="form-control" name="establishment-legal-name" id="establishment-legal-name" placeholder="EX: XIS-DO-PEDRO ltda">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="establishment-cnpj">CNPJ <span style="color:red">*</span></label>
                                        <div class="input-group">
                                            <input value="{{ $app_settings->cnpj }}" type="text" class="form-control" id="establishment-cnpj" name="establishment-cnpj" data-inputmask="'mask':'99.999.999/9999-99'" data-mask="" inputmode="text" placeholder="EX: 12.345.678/0003-00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-center">
                                    <label for="establishment-logo">Logo</label>
                                    <div class="row">
                                        <div class="col">
                                            <img id="establishment-logo" width="200" class="img-circle" src="{{ $app_settings->logo_url? asset($app_settings->logo_url)  : asset('img/gourmetconnect-logo/gourmetconnect.png') }} " alt="Imagem do logotipo">
                                        </div>
                                        <div class="col">
                                            <label style="left: -56px; position:absolute;bottom:0" for="chenge-establishment-logo" class="btn btn-accent rounded-pill position-absolute"><i class="fs-30 fa-solid fa-folder-image"></i></label>
                                            <input type="file" class="input-img-profile" id="chenge-establishment-logo" accept="image/png,image/jpg,image/jpeg" onchange="checkExt(this)" />
                                        </div>
                                        <input type="hidden" name="establishment-logo-adjusted" id="establishment-logo-adjusted">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>ENDEREÇO</h5>
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
                                <label for="establishment-cep">CEP <span style="color:red">*</span></label>
                                <input value="{{ $app_settings->cep }}" minlength="2" maxlength="10" id="establishment-cep" name="establishment-cep" type="text" class="form-control" data-inputmask="'mask':'99.999-999'" data-mask="" inputmode="text" placeholder="EX: 92.480-000">
                            </div>
                        </div>
                        <hr>
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>MESAS</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="general-tables">Quantidade de mesas <span style="color:red">*</span></label>
                                <div class="input-group">
                                    <input value="{{ $app_settings->number_tables }}" type="text" class="form-control" id="general-tables" name="general-tables" data-inputmask="'mask':'999'" data-mask="" inputmode="text" placeholder="EX: 10">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="border-bottom border-default m-b-20 col-md-3">
                            <h5>PAGAMENTO</h5>
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
                        <button class="btn btn-accent rounded-pill" onclick="return save_establishment_settings()">SALVAR</button>
                    </div>
                </div>
                @endcan
                @can('config_app_delivery')
                <div class="tab-pane" id="delivery-settings">
                    <div class="row">
                        <div class="col-md-6 m-b-50">
                            <div class="border-bottom border-default m-b-20 col-md-8">
                                <span>NOVA REGIÃO DE ENTREGA</span>
                            </div>
                            <div class="col-md-8">
                                <form id="form-delivery-settings">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="delivery-neighborhood">Cidade/Bairro<span style="color:red">*</span></label>
                                            <input value="" class="form-control" name="delivery-neighborhood" id="delivery-neighborhood" placeholder="EX: CENTRO">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="delivery-reference">Referência</label>
                                            <input value="" class="form-control" name="delivery-reference" id="delivery-reference" placeholder="EX: Até o mercado">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="delivery-value">Valor <span style="color:red">*</span></label>
                                            <input onKeyPress="return(moeda(this,'.',',',event))" id="delivery-value" name="delivery-value" type="text" class="form-control" placeholder="EX: R$ 10,00">
                                        </div>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-sm-end">
                                    <button class="btn btn-accent rounded-pill" onclick="return add_delivery_location()">ADICIONAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-bottom border-default m-b-20 col-md-6">
                                <span>REGIÕES DE ENTREGA</span>
                            </div>

                            <table id="delivery-locations-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="100px">Bairro</th>
                                        <th>Referencia</th>
                                        <th width="100px">Valor</th>
                                        <th width="30px">Excluir</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                @endcan
                @can('config_app_email')
                <div class="tab-pane" id="email-settings">
                    <div class="row">
                        <div class="col-md-7">
                            <form id="form-email-settings">
                                <div class="border-bottom border-default m-b-20 col-md-4">
                                    <h5>CONFIGURAÇÃOES SMTP</h5>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailer-user">Usuário</label>
                                        <input value="{{ $app_settings->mailer_email }}" class="form-control" name="mailer-user" id="mailer-user" placeholder="exemplo@gmail.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailer-password">Senha</label>
                                        <input type="password" value="{{ Tools::hash($app_settings->mailer_password ,'decrypt') }}" class="form-control" name="mailer-password" id="mailer-password" placeholder="12345678">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailer-host">Host <span style="color:red">*</span></label>
                                        <input value="{{ $app_settings->mailer_host }}" class="form-control" name="mailer-host" id="mailer-host" placeholder="smtp.email.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailer-port">Porta <span style="color:red">*</span></label>
                                        <input value="{{ $app_settings->mailer_port }}" class="form-control" type="number" name="mailer-port" id="mailer-port" placeholder="583">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="mailer-encryption">Tipo de encripitação<span style="color:red">*</span></label>
                                        <input value="{{ $app_settings->mailer_encryption }}" class="form-control" name="mailer-encryption" id="mailer-encryption" placeholder="TLS">
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-sm-end m-b-20">
                                <button class="btn btn-accent rounded-pill" onclick="return save_email_settings()">SALVAR</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="callout callout-warning fs-14">

                                <h3>SMTP do Gmail</h3>
                                <p>Gostaríamos de informar que utilizamos o SMTP do Gmail como nosso método padrão de envio de e-mails. Essa escolha se deve ao fato de que o Gmail oferece um serviço gratuito de envio de até 500 e-mails por dia, o que atende às nossas necessidades de comunicação.</p>
                                <p>Além disso, o Gmail é uma plataforma fácil de usar e confiável, garantindo que suas mensagens cheguem aos destinatários de forma rápida e segura.</p>



                                <h4>Ativar senha de app no Google para SMTP</h4>
                                <p>Para ativar a senha de app no Google e utilizar SMTP, siga as seguintes instruções:</p>
                                <ol>
                                    <li>Crie uma conta no Google, caso ainda não tenha uma. Você pode criar uma conta gratuitamente em <a href="https://accounts.google.com/signup">https://accounts.google.com/signup</a>.</li>
                                    <li>Faça login em sua conta do Google em <a href="https://accounts.google.com/signin">https://accounts.google.com/signin</a>.</li>
                                    <li>Acesse a página "Segurança" em sua conta do Google. Para isso, clique na sua imagem de perfil no canto superior direito da tela e selecione "Gerenciar sua Conta Google".</li>
                                    <li>Na página da sua conta do Google, role para baixo até a seção "Segurança" e clique em "Senha e métodos de login".</li>
                                    <li>Clique na opção "Senha de app". Caso essa opção não esteja disponível, ative a verificação em duas etapas em "Verificação em duas etapas" na mesma página.</li>
                                    <li>Selecione o app e o dispositivo que você deseja usar com a senha de app. Escolha "Outro (personalizado)" para nomear o app ou dispositivo, se necessário.</li>
                                    <li>Clique em "Gerar" para criar a senha de app. Copie a senha gerada para usá-la ao configurar o SMTP.</li>
                                    <li>Configure o SMTP com as informações do servidor de e-mail e a senha de app gerada. Você pode encontrar instruções detalhadas sobre como configurar o SMTP do Google em diferentes programas de e-mail em <a href="https://support.google.com/mail/answer/7126229">https://support.google.com/mail/answer/7126229</a>.</li>
                                </ol>

                            </div>
                        </div>
                    </div>

                </div>
                @endcan
                @can('config_app_theme')
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
                                        <option @if($app_settings->theme_sidebar == 'sidebar-dark-lightblue') selected @endif value="sidebar-dark-lightblue" class="bg-lightblue"> Escuro / Azul claro</option>
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
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-lightblue') selected @endif value="sidebar-light-lightblue" class="bg-lightblue"> Claro / Azul-claro</option>
                                        <option @if($app_settings->theme_sidebar == 'sidebar-light-navy') selected @endif value="sidebar-light-navy" class="bg-navy"> Claro / Azul-marinho</option>
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
                @endcan

            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
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
                <div class="callout callout-success fs-12 m-t-20">
                    <h5>Para um bom logo lembre:</h5>
                    <p>Ao escolher um logotipo para um estabelecimento, é importante seguir algumas boas práticas para garantir que o logotipo represente adequadamente a empresa e atraia o público-alvo. Aqui estão algumas dicas:</p>
                    <ol>
                        <li><strong>Simplicidade:</strong> um logotipo simples e fácil de entender é mais fácil de lembrar e reconhecer. Evite designs complicados e excessivamente detalhados.</li>
                        <li><strong>Originalidade:</strong> crie um logotipo único que seja facilmente reconhecível e diferencie a empresa dos concorrentes.</li>
                        <li><strong>Cores:</strong> use cores que reflitam a personalidade e os valores da empresa. As cores devem ser atraentes e harmoniosas.</li>
                        <li><strong>Escalabilidade:</strong> o logotipo deve ser facilmente legível e reconhecível em qualquer tamanho, desde pequenos ícones em mídias sociais até grandes outdoors.</li>
                        <li><strong>Consistência:</strong> o logotipo deve ser consistente em todas as plataformas de marketing e comunicação da empresa, desde o website até as redes sociais.</li>
                        <li><strong>Legibilidade:</strong> certifique-se de que o texto e as imagens no logotipo sejam legíveis em todos os tamanhos e em diferentes fundos.</li>
                    </ol>
                    <p>Ao seguir essas boas práticas, você poderá criar um logotipo eficaz que ajude a empresa a se destacar e atrair clientes. Lembre-se de que um logotipo bem projetado pode ser uma poderosa ferramenta de marketing e comunicação para a empresa.</p>
                </div>

            </div>
            <div id="crop_image" class="modal-footer">
                <button onclick="return adjust_image()" class="btn btn-accent rounded-pill ">CORTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<script src="{{ asset('assets/app/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

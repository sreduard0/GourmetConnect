@php
$tools = new App\Classes\Tools;
@endphp
@extends('app.layout')
@section('title', 'Encerrar comanda')
@section('menu-requests', 'menu-open')
@section('requests', 'active')
@section('title-header', 'Encerramento da comanda #'.$command->id)
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<input type="hidden" id="print_id" value="{{ $tools->hash($command->id, 'encrypt') }}">
<div class="col-md-12">
    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col m-b-20">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fa-duotone fa-store"></i> {{ $app_settings->establishment_name }}
                            <img class="float-right" src="{{ asset($app_settings->logo_url) }}" width="80" alt="{{ $app_settings->establishment_name }}">
                        </h4>

                    </div>
                </div>
                <div class="col-sm-4 fs-18 p-b-20">
                    <strong> {{ $command->client_name }}</strong><br>
                    <b>Cod: #{{ $command->id }}</b><br>
                    <b>Aberta:</b> {{ date('d/m/Y h:i',strtotime($command->created_at)) }}<br>
                    <b>Mesa:</b> #{{ $command->table }}<br>

                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table id="client-requests-payment-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="30px">Cod.</th>
                                    <th width="40px">Foto</th>
                                    <th>Item</th>
                                    <th width="50px">Qtd.</th>
                                    <th width="100px">Valor</th>
                                    <th width="30px">Ver</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @if(isset($finalize->status))
                <p class="lead">{{ $command->client_name }} - {{ date('d/m/Y') }}</p>
                <div class="table-responsive">
                    <table class="table fs-17">
                        <th>TOTAL:</th>
                        <td class="value-total"></td>
                        </tr>
                    </table>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <div class="float-right">
                            <button type="button" class="btn btn-primary" onclick="split_payment_modal()"><i class="fa-duotone fa-users"></i> DIVIDIR</button>
                            <button type="button" class="btn btn-accent" onclick="payment_type_modal()"><i class="fa-duotone fa-credit-card"></i> FINALIZAR</button>
                        </div>
                        @else
                        <p class="lead">{{ $command->client_name }} - {{ date('d/m/Y') }}</p>
                        <div class="table-responsive">
                            <table class="table fs-17">
                                <th>TOTAL:</th>
                                <td>R$ 0,00</td>
                                </tr>
                            </table>
                        </div>
                        <div class="row no-print">
                            <div class="col-12">

                                <div class="float-right">
                                    <button type="button" class="btn btn-primary" disabled><i class="fa-duotone fa-users"></i> DIVIDIR</button>
                                    <button type="button" class="btn btn-accent" disabled><i class="fa-duotone fa-credit-card"></i> FINALIZAR</button>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="callout callout-warning fs-14">
                            <strong>Aviso de Segurança</strong> <br>
                            <p>Para garantir a sua segurança ao receber pagamentos, gostaríamos de alertá-lo sobre algumas práticas importantes a serem seguidas:</p>
                            <ol>
                                <li><strong>Verifique a autenticidade do pagamento:</strong> Certifique-se de que o pagamento foi efetuado. Sempre verifique as informações do comprador para garantir que não haja suspeitas de fraude.</li>
                                <li><strong>Utilize uma máquina de cartão confiável:</strong> Certifique-se de que a sua máquina de cartão esteja em boas condições e com a segurança atualizada. Desconfie de qualquer equipamento que pareça suspeito ou danificado.</li>
                                <li><strong>Nunca compartilhe suas informações pessoais ou bancárias:</strong> Não forneça informações confidenciais, como números de conta bancária, senhas ou dados de acesso, para terceiros.</li>
                                <li><strong>Verifique o comprovante de pagamento:</strong> Sempre confira o comprovante de pagamento e garanta que ele esteja correto. Verifique se o valor e o método de pagamento estão corretos e se o comprovante está assinado.</li>
                                <li><strong>Fique atento a possíveis golpes:</strong> Esteja ciente de possíveis golpes, como a utilização de cartões clonados. Desconfie de compradores que pareçam suspeitos ou que tentem pressioná-lo a aceitar formas de pagamento incomuns ou pouco confiáveis.</li>
                            </ol>
                            <p>Lembre-se sempre de que a sua segurança é fundamental para a realização de negócios bem-sucedidos. Esteja atento e siga essas práticas para evitar fraudes e prejuízos.</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('app.component.view-item')
        @endsection
        @section('modal')
        {{-- FORMA  DE PAGAMENTO --}}
        <div class="modal fade" id="payment-type-modal" role="dialog" tabindex="-1" aria-labelledby="payment-type-modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Qual a forma de pagamento? </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col">
                            <select id="payment-type" name="payment-type" class="form-control" style="width:100%">
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
                                <option selected disabled value="">SELECIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="split-payment-select">
                        <button onclick="finalize_payment()" class="btn btn-accent"><i class="fa-duotone fa-credit-card"></i> FINALIZAR</button>
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
        {{-- LISTA DE ITEM PARA DIVIDIR O PAGAMENTO --}}
        <div class="modal fade" id="split-payment-modal" role="dialog" tabindex="-1" aria-labelledby="split-payment-modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">SELECIONE OS ITEM A PAGAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-split-payment">
                            <table style="width:100%" id="split-payment-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25px">Cod.</th>
                                        <th>Item</th>
                                        <th width="80px">Valor</th>
                                        <th width="25px"><i class="fa-duotone fa-check"></i></th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="return payment_type_modal(true)" class="btn rounded-pill btn-accent">PAGAR ITEMS</button>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('plugins')
        <script src="{{ asset('private/assets/js/request.js') }}"></script>
        <script>
            $(window).on("load", function() {
                sum_requests_client($('#print_id').val())
            });

        </script>
        @endsection

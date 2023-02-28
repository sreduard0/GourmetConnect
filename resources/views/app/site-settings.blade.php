@extends('app.layout')
@section('title', 'Configurações do site')
@section('site-settings', 'active')
@section('config', 'menu-open')
@section('title-header', 'Configurações do site')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#" data-toggle="tab">Estabelecimento</a></li>
                <li class="nav-item"><a class="nav-link" href="#teste2" data-toggle="tab">Cores</a></li>
                <li class="nav-item"><a class="nav-link" href="#teste3" data-toggle="tab">Geral</a></li>
                <li class="nav-item"><a class="nav-link" href="#teste4" data-toggle="tab">TESTE 4</a></li>
                <li class="nav-item"><a class="nav-link" href="#teste5" data-toggle="tab">TESTE 5</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="teste1">
                    TESTE 1
                </div>
                <div class="tab-pane" id="teste2">
                    TESTE 2
                </div>
                <div class="tab-pane" id="teste3">
                    TESTE 3
                </div>
                <div class="tab-pane" id="teste4">
                    TESTE 4
                </div>
                <div class="tab-pane" id="teste5">
                    TESTE 5
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('plugins')

@endsection

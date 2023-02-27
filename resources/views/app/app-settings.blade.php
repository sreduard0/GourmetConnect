@extends('app.layout')
@section('title', 'Configurações do aplicativo')
@section('app-settings', 'active')
@section('config', 'menu-open')
@section('title-header', 'Configurações do aplicativo')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    TESTE 1
                </div>
                <div class="tab-pane" id="timeline">
                    TESTE 2
                </div>
                <div class="tab-pane" id="settings">
                    TESTE 3
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('plugins')

@endsection

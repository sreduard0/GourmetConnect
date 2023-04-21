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
<script src="{{ asset('private/assets/js/users.js') }}"></script>
<script src="{{ asset('private/assets/js/form-users.js') }}"></script>

@endsection
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
        </div>
        <div class="card-body">
            <table id="users" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

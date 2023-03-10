@extends('app.layout')
@section('title', 'Mesas')
@section('tables', 'active')
@section('title-header', 'Mesas')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @for ($i = 1; $i < $app_settings->number_tables; ++$i )
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header border-bottom-0">
                                <h4><strong>MESA #{{ $i }}</strong></h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-md"><strong>Clientes: </strong> João Pedro / Guilherme </p>
                                        <ul class="ml-4 mb-0 fa-ul">
                                            <li><span class="fa-li"><i class="text-success fa-duotone fa-money-bill"></i></span><strong> Valor:</strong> R$ 150</li>
                                            <li><span class="fa-li"><i class="text-warning fa-duotone fa-burger-soda"></i></span><strong> Pedido via:</strong> QR Code</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="#" class="btn btn-sm bg-secondary">
                                        <i class="fa-duotone fa-qrcode"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-accent">
                                        <i class="fa-duotone fa-burger-soda"></i> <strong>PEDIDOS</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
                <ul class="pagination justify-content-center m-0">
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                </ul>
            </nav>
        </div>
        <!-- /.card-footer -->
    </div>
</div>

@endsection
@section('plugins')

@endsection

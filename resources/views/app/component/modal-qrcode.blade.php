@section('script')
<script src="{{ asset('assets/app/plugins/qr-generator/dist/easy.qrcode.min.js') }}" type="text/javascript" charset="utf-8">
</script>
<script src="{{ asset('assets/app/plugins/qr-generator/qr_generator.js') }}" type="text/javascript" charset="utf-8"></script>
@endsection

<!-- DIV QR CODE-->
<div class="modal fade" id="modal_qr" tabindex="-1" role="dialog" aria-labelledby="table_qr" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table_label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-center" id="qr_vtr_generate"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-accent" onclick="return printQR()">Imprimir</button>
            </div>
        </div>
    </div>
</div>

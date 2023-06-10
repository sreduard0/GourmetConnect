{{-- ITEM ADICIONAL --}}
<div class="modal fade" id="view-item-modal" role="dialog" aria-labelledby="view-itemLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-itemLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="item-img-view" class="item-img-view img-fluid img-circle" src="" alt="User profile picture">
                </div>

                <strong><i class="fa-duotone fa-burger-soda mr-1"></i> NOME</strong>
                <p id="item-name-view" class="text-muted">
                    -
                </p>
                <hr>
                <strong><i class="fa-duotone fa-money-bill mr-1"></i>VALOR</strong>
                <p id="item-value-view" class="text-muted">
                    -
                </p>
                <hr>
                <strong><i class="fa-duotone fa-pencil-alt mr-1"></i> ADICIONAIS</strong>
                <ul id="item-additional-view" class="text-muted">

                </ul>
                <hr>
                <strong><i class="fa-duotone fa-file-alt mr-1"></i> DESCRIÇÃO</strong>
                <p id="item-description-view" class="text-muted">-</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-accent rounded-pill  float-right" data-dismiss="modal"><strong>FECHAR</strong></button>

            </div>
        </div>
    </div>
</div>
<div style=" display:none;" class="popup-item">
    <img src="" alt="TESTE">
</div>
<script>
    function view_item_request(id) {
        var Toast = Swal.mixin({
            toast: true
            , position: 'top-end'
            , showConfirmButton: false
            , timer: 4000
        });

        const URL = '/administrator/post/info/request/item'
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: URL
            , type: 'post'
            , data: {
                id: id
            , }
            , dataType: 'text'
            , success: function(response) {
                var data = JSON.parse(response)
                $('#view-itemLabel').text('VER ITEM')
                $('#item-img-view').attr('src', window.location.origin + '/' + data.product.photo_url)
                $('#item-name-view').text(data.product.name)
                $('#item-value-view').text(data.value)
                $('#item-additional-view').empty()
                $.each(data.additionals, function(index, item) {
                    $('#item-additional-view').append("<li>" + item.info.name + "</li>")
                })
                if (data.observation) {
                    $('#item-description-view').html(data.observation)
                } else {
                    $('#item-description-view').text('Não há.')
                }
                $('#view-item-modal').modal('show')
            }
            , error: function() {
                Toast.fire({
                    icon: 'error'
                    , title: '&nbsp&nbsp Erro na rede.'
                });
            }
        });
    }

    function modal_view_item(id) {
        var Toast = Swal.mixin({
            toast: true
            , position: 'top-end'
            , showConfirmButton: false
            , timer: 4000
        });

        const URL = '/administrator/post/info/menu/item'
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: URL
            , type: 'post'
            , data: {
                id: id
            , }
            , dataType: 'text'
            , success: function(response) {
                var data = JSON.parse(response)
                $('#view-itemLabel').text(data.name + '   |  ' + data.type.name)
                $('#item-img-view').attr('src', window.location.origin + '/' + data.photo_url)
                $('#item-name-view').text(data.name)
                $('#item-value-view').text("R$" + money(data.value))
                $('#item-additional-view').empty()
                $.each(data.additionals, function(index, item) {
                    $('#item-additional-view').append("<li>" + item.name + "</li>")
                })
                if (data.description) {
                    $('#item-description-view').html(data.description)
                } else {
                    $('#item-description-view').text('Não há.')
                }
                $('#view-item-modal').modal('show')
            }
            , error: function() {
                Toast.fire({
                    icon: 'error'
                    , title: '&nbsp&nbsp Erro na rede.'
                });
            }
        });
    }
    $('.item-img-view').on('click', function(event) {
        bootbox.dialog({
            message: '<img width="100%" src="' + event.target.currentSrc + '">'
            , backdrop: true
            , size: 'large'
            , closeButton: false
        });

    })

</script>

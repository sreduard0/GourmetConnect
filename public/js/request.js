
// TABLES
$(function () {
    $("#requests-table").DataTable({
        "order": [
            [2, 'asc']
        ],
        "bInfo": false
        , "paging": true
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": true
        , "iDisplayLength": 10
        , "autoWidth": false
        , "dom": '<"top">rt<"bottom"ip> <"clear" > '
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': 5
        },
        {
            'sortable': false,
            'aTargets': 5
        }],
        "processing": true
        , "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/all"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }

    });
    $("#menu-table").DataTable({
        "order": [
            [1, 'asc']
        ],
        "pagingType": 'simple_numbers',
        "bInfo": false,
        "responsive": true,
        "lengthChange": false,
        "iDisplayLength": 10,
        "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip><"clear" >',
        "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 3]
        },
        {
            'sortable': false,
            'aTargets': [0, 2, 3]
        }],
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/menu",
            "type": "POST",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        }

    });
    $("#client-requests-table").DataTable({
        "order": [
            [3, 'asc']
        ],
        "bInfo": false
        , "paging": true
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip> <"clear">'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 3]
        },
        {
            'sortable': false,
            'aTargets': [0, 3]
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/client"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
    $("#list-items-equals-table").DataTable({
        "bInfo": false
        , "paging": true
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip> <"clear">'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 2, 3]
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/list-items-equals"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
    $("#client-requests-view-table").DataTable({
        "order": [
            [1, 'asc']
        ],
        "bInfo": false
        , "paging": false
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip> <"clear">'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 2, 3, 4]
        },
        {
            'sortable': false,
            'aTargets': [0, 3, 4]
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/client-view"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
});

// SELEÇÃO DE MESA E CLIENTE
$('#table-select').on('change', function (event) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/info/table/client'
        , type: 'post'
        , data: {
            number: event.target.value
        }
        , dataType: 'text'
        , success: function (response) {
            var data = JSON.parse(response)
            $("#client-name").autocomplete({
                source: data
                , minLength: 0
            }).focus(function () {
                $(this).data("uiAutocomplete").search($(this).val());
            });
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
})

$('#btn-select-request').on('click', function () {
    if (!$('#table-select').val()) {
        $('#table-select').css('border', '2px solid red')
        return false
    } else {
        $('#table-select').removeAttr("style")
    }
    if (!$('#client-name').val()) {
        $('#client-name').addClass('is-invalid')
        return false
    } else {
        $('#client-name').removeClass('is-invalid')
    }
    $('#client-requests-table').DataTable().column(1).search($('#table-select').val().toUpperCase()).column(2).search($('#client-name').val().toUpperCase()).draw()

    $('#type-itemLabel').text('NOVO PEDIDO')
    $('#title-requests').text('PEDIDOS DE ' + $('#client-name').val().toUpperCase())
    $('#div-select-client').removeClass('d-flex')
    $('#div-select-client').addClass('d-none')
    $('#div-add-request').css('display', 'block')
    $('.modal-footer').css('display', 'block')
    $('#requests-table').DataTable().clear().draw()
})

// MODAL
function modal_new_request() {
    $('#new-request-modal').modal('show');
}
$('#new-request-modal').on('show.bs.modal', function () {
    setTimeout(() => {
        $("#menu-table").DataTable()
            .columns.adjust()
            .responsive.recalc();
        $("#requests-table").DataTable()
            .columns.adjust()
            .responsive.recalc();
    }, 200);
});
$('#new-request-modal').on('hide.bs.modal', function () {
    $('#client-requests-table').DataTable().column(1).search('').draw()
    $('#type-itemLabel').text('COMANDA')
    $('#table-select').val('')
    $('#client-name').val('')
    $('#title-requests').text('-')
    $('#div-select-client').addClass('d-flex')
    $('#div-select-client').removeClass('d-none')
    $('#div-add-request').css('display', 'none')
    $('#modal-footer').css('display', 'none')
});
$('#view-item-modal').on('hide.bs.modal', function () {
    setTimeout(() => {
        $('body').addClass('modal-open')
    }, 500);
});
$('#list-items-equals-modal').on('hide.bs.modal', function () {
    $('#list-items-equals-table').DataTable().clear().draw()
    $('#requests-table').DataTable().clear().draw()
    $('#client-requests-view-table').DataTable().clear().draw()
    $('#requests-client-modal').modal('show')
    setTimeout(() => {
        $('body').addClass('modal-open')
    }, 500);
});
$('#observation-item-modal').on('hide.bs.modal', function () {
    setTimeout(() => {
        $('body').addClass('modal-open')
    }, 500);
});

// ADICIONAR ITEM NO PEDIDO
function select_amount_item(item) {
    bootbox.prompt({
        title: 'Quantidade',
        inputType: 'number',
        size: 'small',
        centerVertical: true,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'Adicionar',
                className: 'btn-accent'
            }
        },
        callback: function (result) {
            if (result == '') {
                $('.bootbox-input-number').addClass('is-invalid')
                return false
            } else if (result) {
                add_item_request(item, result)
                setTimeout(() => {
                    $('body').addClass('modal-open')
                }, 500)
            }
        }
    });
}
function add_item_request(item, amt) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/item/add'
        , type: 'post'
        , data: {
            item: item,
            table: $('#table-select').val(),
            client: $('#client-name').val(),
            amount: amt,
        }
        , dataType: 'text'
        , success: function (response) {
            $('#client-requests-table').DataTable().clear().draw()
            Toast.fire({
                icon: 'success'
                , title: '&nbsp&nbsp Item adicionado.'
            });
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });

}
// FILTRO
$('#filter-type-item').on('change', function (event) {
    $('#menu-table').DataTable().column(1).search(event.target.value).draw()
})
function filter_all_requests() {
    $('#requests-table').DataTable().column(1).search($('#filter-item-table').val()).draw()
}
// ENVIAR PEDIDO
$('#send-request').on('click', function (event) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/item/send'
        , type: 'post'
        , data: {
            table: $('#table-select').val(),
            client: $('#client-name').val(),
        }
        , dataType: 'text'
        , success: function (response) {

            switch (response) {
                case 'success':
                    Toast.fire({
                        icon: 'success'
                        , title: '&nbsp&nbsp Pedido enviado.'
                    });
                    $('#requests-table').DataTable().clear().draw()
                    $('#new-request-modal').modal('hide')
                    break;
                case 'not-send':
                    Toast.fire({
                        icon: 'warning'
                        , title: '&nbsp&nbsp Adicione itens no pedido.'
                    });
                    break;
            }
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
})
// ADICIONAIS E OBSERVAÇÃO
function additional_item_request(product_id, request_id) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/item/additionals'
        , type: 'post'
        , data: {
            item: product_id,
            request_id: request_id,
        }
        , dataType: 'text'
        , success: function (response) {
            var data = JSON.parse(response)
            $('#checkbox-container').empty()
            if (data['items'].length === 0) {
                $('#checkbox-container').html('<div class="col text-center"><span>Este item não possui adicionais.</span></div>')
            } else {
                $.each(data.items, function (index, checkbox) {
                    $('#checkbox-container').append('<div class= "d-flex justify-content-between row border-bottom-list" ><div div class= "m-r-30"><span>' + checkbox.name + ' - R$' + money(checkbox.value) + '</span></div><div class="custom-control custom-switch "><input type="checkbox" class="custom-control-input" name="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" id="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" value="' + checkbox.id + '" ' + checkbox.check + '><label class="custom-control-label" for="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional"></label></div></div><hr>');
                });
            }
            $('#obs-additional').summernote('code', data.observation)
            $('#request_id').val(request_id)
            $('#observation-item-modal').modal('show')
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}
// SALVAS OBS E ADICIONAIS
$('#save-obs-item-request').on('click', function () {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    var inputs = {};
    $('#form-add-additional :input').each(function () {
        if ($(this).prop('checked')) {
            inputs[$(this).attr('name')] = {
                name: $(this).attr('name'),
                id: $(this).val(),
                check: true
            }
        } else {
            inputs[$(this).attr('name')] = {
                name: $(this).attr('name'),
                id: $(this).val(),
                check: false
            }
        }
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/additional-item/save'
        , type: 'post'
        , data: {
            id: $('#request_id').val(),
            obs: $('#obs-additional').val(),
            additionals: inputs,
        }
        , dataType: 'text'
        , success: function (response) {
            switch (response) {
                case 'success':
                    Toast.fire({
                        icon: 'success'
                        , title: '&nbsp&nbsp Salvo.'
                    });
                    $('#client-requests-table').DataTable().clear().draw()
                    $('#list-items-equals-table').DataTable().clear().draw()
                    $('#requests-table').DataTable().clear().draw()
                    $('#client-requests-view-table').DataTable().clear().draw()
                    $('#observation-item-modal').modal('hide')
                    $('#checkbox-container').empty()
                    $('#obs-additional').summernote('code', '')

                    $('#request_id').val('')
                    break;
                case 'not-save':
                    Toast.fire({
                        icon: 'warning'
                        , title: '&nbsp&nbsp Ouve algum erro ao salvar.'
                    });
                    break;
            }
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
})
// APAGAR PEDIDO
function delete_item_request(id) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });
    bootbox.confirm({
        title: 'Excluir item do pedido',
        message: 'Deseja mesmo excluir?',
        size: 'small',
        centerVertical: true,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'Excluir',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: window.location.origin + '/administrator/post/request/item/delete'
                    , type: 'post'
                    , data: {
                        item: id,
                    }
                    , dataType: 'text'
                    , success: function (response) {
                        $('#client-requests-table').DataTable().clear().draw()
                        $('#list-items-equals-table').DataTable().clear().draw()
                        switch (response) {
                            case 'success':
                                Toast.fire({
                                    icon: 'success'
                                    , title: '&nbsp&nbsp Item excluído.'
                                });
                                break;
                            case 'not-delete':
                                Toast.fire({
                                    icon: 'warning'
                                    , title: '&nbsp&nbsp Este item já foi excluido.'
                                });
                                break;
                        }
                    }
                    , error: function () {
                        Toast.fire({
                            icon: 'error'
                            , title: '&nbsp&nbsp Erro na rede.'
                        });
                    }
                });
                setTimeout(() => {
                    $('body').addClass('modal-open')
                }, 500)
            }
        }
    });

}

// PEDIDOS DO CLIENTE
function requests_client_view_modal(id) {
    const URL = window.location.origin + '/administrator/post/request/client/requests-view'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'post',
        data: {
            id: id,
        },
        dataType: 'text',
        success: function (response) {
            var data = JSON.parse(response)
            if (data.pending) {
                $('.requests').removeClass('active');
                $('.pending').addClass('active treme');
            } else {
                $('.pending').removeClass('active treme');
                $('.requests').addClass('active');
            }
            $('#client-requests-view-table').DataTable().column(1).search(id).column(2).search(data.pending).draw()
            $('#reqClienttitle').text('MESA #' + data.table + ' - ' + data.client)
            $('.value-total').text(data.total)
            $('#requests-client-modal').modal('show')
        },

    });
}
function requests_client_view_table(pending) {
    $('#client-requests-view-table').DataTable().column(2).search(pending).draw()
}
$('#new-request-modal').on('hide.bs.modal', function () {
    $('#client-requests-view-table').DataTable().clear().draw()
    $('#reqClienttitle').text('')
    $('.value-total').text('')

});
function list_items_equals_request(request, item, product) {
    $('#product_name').text(product)
    $('#list-items-equals-table').DataTable().column(1).search(request).column(2).search(item).draw()
    $('#requests-client-modal').modal('hide')
    $('#list-items-equals-modal').modal('show')

}





var Toast = Swal.mixin({
    toast: true
    , position: 'top-end'
    , showConfirmButton: false
    , timer: 4000
});
// TABLES
$(function () {
    $("#requests-table").DataTable({
        "order": [
            [3, 'asc']
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
            "url": window.location.origin + "/administrator/post/table/orders"
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
    $("#order-requests-table").DataTable({
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
            'aTargets': [0, 3, 4]
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
    $("#client-requests-payment-table").DataTable({
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
            'aTargets': [0, 3, 4, 5]
        },
        {
            'sortable': false,
            'aTargets': [0, 1, 4, 5]
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/client-payment/" + $('#print_id').val()
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
    $("#split-payment-table").DataTable({
        "order": [
            [1, 'asc']
        ],
        "bInfo": false
        , "paging": false
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
            'aTargets': [0, 2, 3]
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/request/split-payment"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    })
    // var minhaTabela = $('#minha-tabela');

    //         // Calcula o número de linhas e colunas da tabela
    //         var numLinhas = minhaTabela.find('tbody tr').length;
    //         var numColunas = minhaTabela.find('thead th').length;

    //         // Define a largura da tabela com base no número de linhas e colunas
    //         minhaTabela.css('width', (numColunas * 100) + "px");
});


// MODAL
function modal_new_request() {
    $('#new-request-modal').modal('show');
}
// SELEÇÃO DE MESA E CLIENTE
$('#table-select').on('change', function (event) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/get/table/orders/' + event.target.value
        , type: 'GET'
        , success: function (data) {
            // var data = JSON.parse(response)
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

$('#btn-select-order').on('click', function () {
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


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/order/new'
        , type: 'post'
        , data: {
            table: $('#table-select').val(),
            client_name: $('#client-name').val().toUpperCase(),
        }
        , dataType: 'text'
        , success: function (data) {
            var response = JSON.parse(data)
            if (response.error) {
                Toast.fire({
                    icon: 'error'
                    , title: '&nbsp&nbsp ' + response.message
                });
            } else {
                $('#order-requests-table').DataTable().column(1).search(response.order).draw()
                $('#type-itemLabel').text('NOVO PEDIDO')
                $('#title-requests').text('PEDIDOS DE ' + $('#client-name').val().toUpperCase())
                $('#div-select-client').removeClass('d-flex')
                $('#div-select-client').addClass('d-none')
                $('#div-add-request').css('display', 'block')
                $('.modal-footer').css('display', 'block')
                $('#requests-table').DataTable().clear().draw()
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
// SOMA PEDIDOS DO CLIENTE
function sum_requests_client(id) {
    const URL = window.location.origin + '/administrator/post/sum/request/client-payment'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'post',
        data: {
            id: id,
        },
        dataType: 'text',
        success: function (data) {
            $('.value-total').text(data)
        },
    });
}
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
            $('#order-requests-table').DataTable().clear().draw()
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
                    sum_requests_client($('#print_id').val())
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
                                sum_requests_client($('#print_id').val())
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
    const URL = window.location.origin + '/administrator/get/order/information/' + id
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'GET',
        success: function (data) {
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
            $('#print_id').val(id)
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
function list_items_equals_request(request, item, product, status) {
    $('#product_name').text(product)
    $('#list-items-equals-table').DataTable().column(1).search(request).column(2).search(item).column(3).search(status).draw()
    $('#requests-client-modal').modal('hide')
    $('#list-items-equals-modal').modal('show')

}
function delete_order(id) {
    bootbox.confirm({
        title: 'Tem certeza que deseja excluir essa comanda?',
        message: '<p class="text-danger"> <strong>ESTA AÇÃO NÃO PODE SER DESFEITA</strong></p><p>Ao excluir esta comanda você apagará todos itens pendentes ou não.</p>',
        // size: 'small',
        buttons: {
            cancel: {
                label: 'CANCELAR',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'EXCLUIR',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: window.location.origin + '/administrator/delete/order/' + id
                    , type: 'DELETE'
                    , success: function (response) {
                        $('#requests-table').DataTable().clear().draw()
                        Toast.fire({
                            icon: 'success'
                            , title: '&nbsp&nbsp Comanda excluída.'
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
        }
    });
}
function print_request() {

    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "text",
        url: window.location.origin + "/administrator/post/request/print",
        data: { id: $('#print_id').val() },
        success: function (response) {
            if (response == 'not-exists') {
                Toast.fire({
                    icon: 'warning'
                    , title: '&nbsp&nbsp Não há pedidos pendentes para imprimir.'
                });
            } else {
                window.open().document.write(response);
                bootbox.confirm({
                    title: 'Pedido impressso?',
                    message: 'Remover dos pendentes?',
                    size: 'small',
                    buttons: {
                        cancel: {
                            label: 'Não',
                            className: 'btn-secondary'
                        },
                        confirm: {
                            label: 'Sim',
                            className: 'btn-accent'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                                , url: window.location.origin + '/administrator/post/request/print/confirm'
                                , type: 'post'
                                , data: { id: $('#print_id').val() }
                                , dataType: 'text'
                                , success: function (response) {
                                    $('#requests-table').DataTable().clear().draw()
                                    $('#requests-client-modal').modal('hide');
                                }
                                , error: function () {
                                    Toast.fire({
                                        icon: 'error'
                                        , title: '&nbsp&nbsp Erro na rede.'
                                    });
                                }
                            });
                        } else {
                            setTimeout(() => {
                                $('body').addClass('modal-open')
                            }, 500)
                        }
                    }
                });

            }
        },
        error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });

}
//PAGAMENTO
function payment_type_modal(action = '') {
    if (action) {
        const formData = new FormData(document.getElementById('form-split-payment'))
        if (formData.getAll('item') == '') {
            Toast.fire({
                icon: 'warning'
                , title: '&nbsp&nbsp Selecione pelo menos um item.'
            });
            return false;
        }
        $('#split-payment-modal').modal('hide');
        $('#split-payment-select').val(1);
    }
    $('#payment-type-modal').modal('show');
}

function finalize_payment() {

    if ($('#print_id').val() == '') {
        Toast.fire({
            icon: 'warning'
            , title: '&nbsp&nbsp Atualize a  pagina e tente novamente'
        });
        return false;
    }
    if ($('#payment-type').val() == null) {
        $('#payment-type').addClass('is-invalid');
        return false;
    } else {
        $('#payment-type').removeClass('is-invalid');
    }

    $('#payment-type-modal').modal('hide');

    //
    // SOLICITA CPF AQUI
    //
    var split_payment = {
        active: false,
    }
    if ($('#split-payment-select').val()) {
        const formData = new FormData(document.getElementById('form-split-payment'))
        split_payment = {
            active: true,
            items: formData.getAll('item')
        }
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/finalize-payment'
        , type: 'post'
        , data: {
            id: $('#print_id').val(),
            method: $('#payment-type').val(),
            cpf: '',
            split_payment: split_payment

        }
        , dataType: 'text'
        , success: function (status) {
            if (status) {
                bootbox.prompt({
                    title: 'PRONTO!',
                    message: '<p>Escolha como o cliente ira receber sua nota fiscal.</p>',
                    inputType: 'select',
                    inputOptions: [{
                        text: 'Não quer',
                        value: 1
                    },
                    {
                        text: 'Email',
                        value: 2
                    },
                    {
                        text: 'WhatsApp',
                        value: 3
                    },
                    {
                        text: 'Impresso',
                        value: 4,
                    }
                    ],
                    buttons: {
                        cancel: {
                            label: '',
                            className: 'd-none'
                        },
                        confirm: {
                            label: 'PRONTO',
                            className: 'btn-accent'
                        }
                    },
                    callback: function (coupon_send) {
                        switch (coupon_send) {
                            case '1':
                                $.ajax({
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    dataType: "text",
                                    url: window.location.origin + "/administrator/post/request/tax-coupon",
                                    data: {
                                        id: $('#print_id').val(),
                                        action: 'not',
                                        split_payment: split_payment

                                    },
                                    success: function (response) {
                                        Toast.fire({
                                            icon: 'success'
                                            , title: '&nbsp&nbsp Pronto, tudo finalizado.'
                                        });
                                        $('#split-payment-table').DataTable().clear().draw()
                                        $('#client-requests-payment-table').DataTable().clear().draw()
                                        $.get("/administrator/get/check/order/finish/" + $('#print_id').val(),
                                            function (data) {
                                                if (data == 'true') {
                                                    window.location.reload()
                                                }
                                            },
                                        );
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: 'error'
                                            , title: '&nbsp&nbsp Erro na rede.'
                                        });
                                    }
                                });
                                break;
                            case '2':

                                break;
                            case '3':

                                break;
                            case '4':
                                $.ajax({
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    dataType: "text",
                                    url: window.location.origin + "/administrator/post/request/tax-coupon",
                                    data: {
                                        id: $('#print_id').val(),
                                        action: 'print',
                                        method: $('#payment-type').val(),
                                        split_payment: split_payment

                                    },
                                    success: function (response) {
                                        window.open().document.write(response);
                                        bootbox.confirm({
                                            title: 'Cupom impressso?',
                                            message: 'Necessita imprimir novamente?',
                                            size: 'small',
                                            buttons: {
                                                cancel: {
                                                    label: 'Não',
                                                    className: 'btn-secondary'
                                                },
                                                confirm: {
                                                    label: 'Sim',
                                                    className: 'btn-accent'
                                                }
                                            },
                                            callback: function (action) {
                                                if (action) {
                                                    window.open().document.write(response);
                                                }
                                                $.get("/administrator/get/info/request/finish/" + $('#print_id').val(),
                                                    function (data) {
                                                        if (data == 'true') {
                                                            window.location.reload()
                                                        }
                                                    },
                                                );
                                            }
                                        });
                                        $('#split-payment-table').DataTable().clear().draw()
                                        $('#client-requests-payment-table').DataTable().clear().draw()
                                    },
                                    error: function () {
                                        Toast.fire({
                                            icon: 'error'
                                            , title: '&nbsp&nbsp Erro na rede.'
                                        });
                                    }
                                });
                                break;
                        }

                    }
                }).find('select').val(4);
            }
            $('#split-payment-select').val('')
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}
function split_payment_modal() {
    const formData = new FormData(document.getElementById('form-split-payment'))
    if (formData.getAll('item') == '') {
        $('#split-payment-table').DataTable().column(1).search($('#print_id').val()).draw()
    }
    $('#split-payment-modal').modal('show')
    setTimeout(() => {
        $("#split-payment-table").DataTable()
            .columns.adjust()
            .responsive.recalc();
    }, 200);
}



var Toast = Swal.mixin({
    toast: true
    , position: 'top-end'
    , showConfirmButton: false
    , timer: 4000
});
// SOMA VALORES
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


// CRIA COMANDA DE DELIVERY
$('#btn-new-delivery').on('click', function () {
    const formData = new FormData(document.getElementById('form-new-delivery'))
    // Verificação
    if (formData.get('delivery-client') == '' || formData.get('delivery-client').length > 255) {
        $('#delivery-client').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-client').removeClass('is-invalid');
    }
    var phone = formData.get('delivery-client-phone').replace(/[()  ._-]/g, '')
    if (formData.get('delivery-client-phone') == '' || phone.length != 11) {
        $('#delivery-client-phone').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-client-phone').removeClass('is-invalid');
    }

    if (formData.get('delivery-location') == '') {
        $('#delivery-location').css('border', '2px solid red');
        return false;
    } else {
        $('#delivery-location').removeAttr('style');
    }
    if (formData.get('delivery-address') == '' || formData.get('delivery-address').length > 255) {
        $('#delivery-address').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-address').removeClass('is-invalid');
    }
    if (formData.get('delivery-number') == '') {
        $('#delivery-number').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-number').removeClass('is-invalid');
    }
    if (formData.get('delivery-neighborhood') == '' || formData.get('delivery-neighborhood').length > 255) {
        $('#delivery-neighborhood').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-neighborhood').removeClass('is-invalid');
    }
    if (formData.get('delivery-reference') == '' || formData.get('delivery-reference').length > 255) {
        $('#delivery-reference').addClass('is-invalid');
        return false;
    } else {
        $('#delivery-reference').removeClass('is-invalid');
    }
    if (formData.get('payment-method') == '') {
        $('#payment-method').addClass('is-invalid');
        return false;
    } else {
        $('#payment-method').removeClass('is-invalid');
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/delivery/request/new'
        , type: 'post'
        , data: {
            client: formData.get('delivery-client').toUpperCase(),
            phone: formData.get('delivery-client-phone'),
            location: formData.get('delivery-location'),
            address: formData.get('delivery-address'),
            number: formData.get('delivery-number'),
            neighborhood: formData.get('delivery-neighborhood'),
            reference: formData.get('delivery-reference'),
            payment: formData.get('payment-method')
        }
        , dataType: 'text'
        , success: function (response) {
            if (response == "exists") {
                Toast.fire({
                    icon: 'warning'
                    , title: '&nbsp&nbsp Já existe um delivery com estes dados.'
                });
            } else if (response == 'error') {
                Toast.fire({
                    icon: 'error'
                    , title: '&nbsp&nbsp Algo deu errado atualize a página e tente novamente.'
                });
            } else {
                $('#type-itemLabel').text('ITEMS DO DELIVERY')
                $('#title-requests').text('PEDIDOS DE ' + formData.get('delivery-client').toUpperCase())
                $('#client').val(response)
                $('#div-select-client').css('display', 'none')
                $('#div-add-request').css('display', 'block')
                $('#modal-footer').css('display', 'block')
                $('#delivery-table').DataTable().clear().draw()
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

// APAGAR COMANDA E PEDIDOS
function delete_delivery(id) {
    bootbox.confirm({
        title: 'Tem certeza que deseja excluir essa delivery?',
        message: '<p class="text-danger"> <strong>ESTA AÇÃO NÃO PODE SER DESFEITA</strong></p><p>Ao excluir este delivery você apagará todos itens pendentes ou não.</p>',
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
                    }
                    , url: window.location.origin + '/administrator/delete/order/' + id
                    , type: 'DELETE'
                    , success: function (response) {
                        $('#delivery-table').DataTable().clear().draw()
                        Toast.fire({
                            icon: 'success'
                            , title: '&nbsp&nbsp Delivery excluído.'
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
// FINALIZAR ENTREGA
function finalize_delivery(id) {
    bootbox.confirm({
        title: 'Finalizar delivery?',
        message: '<strong>ESSA OPERAÇÃO NÃO PODE SER DESFEITA</strong><br>Ao finalizar este delivery sairá da lista',
        size: 'small',
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'Sim',
                className: 'btn-success'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: window.location.origin + '/administrator/post/delivery/status/finalize'
                    , type: 'post'
                    , data: {
                        id: id,
                    }
                    , dataType: 'text'
                    , success: function (response) {
                        $('#delivery-table').DataTable().clear().draw()
                        $('#delivery-client-modal').modal('hide')
                        Toast.fire({
                            icon: 'success'
                            , title: '&nbsp&nbsp Delivery finalizado'
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

// ALTERA PARA SAIU PARA ENTREGA ENTREGA
function alt_status(id) {
    bootbox.confirm({
        title: 'Mudar status do pedido',
        message: 'Deseja mudar o status para "Saiu para entrega"?',
        size: 'small',
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'Sim',
                className: 'btn-primary'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: window.location.origin + '/administrator/post/delivery/status/send'
                    , type: 'post'
                    , data: {
                        id: id,
                    }
                    , dataType: 'text'
                    , success: function (response) {
                        $('#delivery-table').DataTable().clear().draw()
                        $('#delivery-client-modal').modal('hide')
                        Toast.fire({
                            icon: 'success'
                            , title: '&nbsp&nbsp Status alterado para "Saiu para entrega"'
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
            client_id: $('#client').val(),
            amount: amt,
        }
        , dataType: 'text'
        , success: function (response) {
            $('#client-requests-table').DataTable().column(1).search($('#client').val()).draw()
            $('#delivery-table').DataTable().clear().draw()
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

// APAGAR ITEM PEDIDO
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
                        $('#client-delivery-view-table').DataTable().clear().draw()
                        $('#delivery-table').DataTable().clear().draw()
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
// ENVIA PEDIDOS
$('#send-request').on('click', function (event) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/request/item/send'
        , type: 'post'
        , data: {
            client_id: $('#client').val(),
        }
        , dataType: 'text'
        , success: function (response) {

            switch (response) {
                case 'success':
                    Toast.fire({
                        icon: 'success'
                        , title: '&nbsp&nbsp Pedido enviado.'
                    });
                    $('#delivery-table').DataTable().clear().draw()
                    $('#new-delivery-modal').modal('hide')
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
// VE PEDIDOS DO CLIENTE
function delivery_client_view_modal(id) {
    const URL = window.location.origin + '/administrator/post/delivery/client/delivery-view'
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
            $('#client-delivery-view-table').DataTable().column(1).search(id).column(2).search('delivery').draw()
            $('#btn-act').html(data.btn)
            $('#DeliveryViewtitle').html('<strong>CLIENTE: </strong>' + data.client + '<br><strong> STATUS: </strong>' + data.status + '<br><strong> PAGAMENTO: </strong>' + data.payment + '<br><strong> DELIVERY: </strong> R$' + data.value + '<br><strong> ENDEREÇO: </strong>' + data.address)
            $('#edit_delivery_btn').html(data.edit)
            $('.value-total').text(data.value_total)
            $('#print_id').val(id)
            $('#delivery-client-modal').modal('show')
        },

    });
}
function edit_delivery(id, client) {
    // const URL = window.location.origin + '/administrator/post/delivery/client/delivery-view'
    // $.ajax({
    //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //     url: URL,
    //     type: 'post',
    //     data: {
    //         id: id,
    //     },
    //     dataType: 'text',
    //     success: function (response) {
    //         var data = JSON.parse(response)
    $('#type-itemLabel').text('ITEMS DO DELIVERY')
    $('#title-requests').text('PEDIDOS DE ' + client.toUpperCase())
    $('#client').val(id)
    $('#div-select-client').css('display', 'none')
    $('#div-add-request').css('display', 'block')
    $('#modal-footer').css('display', 'block')
    $('#delivery-client-modal').modal('hide')
    $('#client-requests-table').DataTable().column(1).search(id).draw()
    $('#new-delivery-modal').modal('show')
    //     },

    // });
}

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
                    $('#list-items-equals-table').DataTable().clear().draw()
                    $('#requests-table').DataTable().clear().draw()
                    $('#client-delivery-view-table').DataTable().clear().draw()
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

// IMPRIMIR PEDIDO
function print_request(id = '') {
    if (!id) {
        var id = $('#print_id').val();
    }
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "text",
        url: window.location.origin + "/administrator/post/request/print",
        data: {
            id: id,
            delivery: 1
        },
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
                    message: 'Mudar status para "Em andamento"?',
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
                                , data: { id: id }
                                , dataType: 'text'
                                , success: function (response) {
                                    $('#delivery-table').DataTable().clear().draw()
                                    $('#delivery-client-modal').modal('hide');
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

// FILTRAR DELIVERYS
function filter_delivery() {
    $('#delivery-table').DataTable().column(1).search($('#filter-delivery').val()).draw()
}
// LISTA ITEMS IGUAIS
function list_items_equals_request(request, item, product) {
    $('#product_name').text(product)
    $('#list-items-equals-table').DataTable().column(1).search(request).column(2).search(item).draw()
    $('#requests-client-modal').modal('hide')
    $('#list-items-equals-modal').modal('show')
}

// MODAL
function modal_new_delivery() {
    $('#new-delivery-modal').modal('show');
}
$('#new-delivery-modal').on('show.bs.modal', function () {
    setTimeout(() => {
        $("#menu-table").DataTable()
            .columns.adjust()
            .responsive.recalc();
        $("#client-requests-table").DataTable()
            .columns.adjust()
            .responsive.recalc();
    }, 200);
});
$('#new-delivery-modal').on('hide.bs.modal', function () {
    $('#client-requests-table').DataTable().column(1).search('').draw()
    $('#newDeliveryLabel').text('DELIVERY')
    $('#form-new-delivery')[0].reset();
    $('#title-requests').text('-')
    $('#div-select-client').css('display', 'block')
    $('#div-add-request').css('display', 'none')
    $('#modal-footer').css('display', 'none')
});

// TABLES
$(function () {
    $("#delivery-table").DataTable({
        "ordering": false,
        "bInfo": false,
        "paging": true,
        "pagingType": 'simple_numbers',
        "responsive": true,
        "lengthChange": true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip> <"clear" > ',
        "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': 5
        },
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/administrator/post/table/delivery/all"
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
            "url": window.location.origin + "/administrator/post/table/delivery/client"
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
    $("#client-delivery-view-table").DataTable({
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
    // $("#client-requests-payment-table").DataTable({
    //     "order": [
    //         [1, 'asc']
    //     ],
    //     "bInfo": false
    //     , "paging": false
    //     , "pagingType": 'simple_numbers'
    //     , "responsive": true
    //     , "lengthChange": false
    //     , "iDisplayLength": 10
    //     , "autoWidth": false,
    //     "dom": '<"top">rt<"bottom"ip> <"clear">'
    //     , "language": {
    //         "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
    //     },
    //     "aoColumnDefs": [{
    //         'className': 'text-center',
    //         'aTargets': [0, 3, 4, 5]
    //     },
    //     {
    //         'sortable': false,
    //         'aTargets': [0, 1, 4, 5]
    //     }],
    //     "serverSide": true
    //     , "ajax": {
    //         "url": window.location.origin + "/administrator/post/table/request/client-payment/" + $('#print_id').val()
    //         , "type": "POST"
    //         , "headers": {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             ,
    //         }
    //         ,
    //     }
    // });
    // $("#split-payment-table").DataTable({
    //     "order": [
    //         [1, 'asc']
    //     ],
    //     "bInfo": false
    //     , "paging": false
    //     , "responsive": true
    //     , "lengthChange": false
    //     , "iDisplayLength": 10
    //     , "autoWidth": false,
    //     "dom": '<"top">rt<"bottom"ip> <"clear">'
    //     , "language": {
    //         "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
    //     },
    //     "aoColumnDefs": [{
    //         'className': 'text-center',
    //         'aTargets': [0, 3]
    //     },
    //     {
    //         'sortable': false,
    //         'aTargets': [0, 2, 3]
    //     }],
    //     "serverSide": true
    //     , "ajax": {
    //         "url": window.location.origin + "/administrator/post/table/request/split-payment"
    //         , "type": "POST"
    //         , "headers": {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             ,
    //         }
    //         ,
    //     }
    // })
    // var minhaTabela = $('#minha-tabela');

    //         // Calcula o número de linhas e colunas da tabela
    //         var numLinhas = minhaTabela.find('tbody tr').length;
    //         var numColunas = minhaTabela.find('thead th').length;

    //         // Define a largura da tabela com base no número de linhas e colunas
    //         minhaTabela.css('width', (numColunas * 100) + "px");
});

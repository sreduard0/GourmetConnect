// CARREGA A CONTAGEM DOS STATUS
$(window).on('load', function (event) {
    count_orders()
    sum_cart_value()
    $('#pending').tab('show');
});

function count_orders() {
    $('.nav-item .nav-link span').remove();
    $.get(window.location.origin + "/get/orders/status/count", function (data) {
        $.each(data, function (status, count) {

            $('#' + status).append('<span>' + count.count + '</span>');
        });
    });

}
function sum_cart_value() {
    $.get(window.location.origin + "/get/sum/cart/value", function (data) {
        $('.value-total').text(data + ' + ENTREGA');
    });
}

//----------------------------------------
// TABELAS
//----------------------------------------
$(function () {
    // PEDIDOS NO CARRINHO
    $("#client-cart-table").DataTable({
        "order": [
            [1, 'asc']
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
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [
            {
                'sortable': false,
                'aTargets': [0, 1, 5]
            },
            {
                'className': 'text-center',
                'aTargets': [0, 1, 4, 5]
            },
            {
                'className': 'td-buttons',
                'aTargets': 5
            },
        ],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + '/post/table/cart'
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        },
        "drawCallback": function () {
            var max = 0; // valor máximo inicializado em zero
            var maxCell; // célula com o valor máximo

            // Loop pelas células da tabela com a classe "tdbtn"
            $("td.td-buttons").each(function () {
                var count = $(this).children().length; // conta o número de elementos dentro da célula
                if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
                    max = count;
                    maxCell = this; // atualiza o valor máximo e a célula correspondente
                }
            });
            calc = max * 35;
            $("th.td-buttons").css({
                "width": calc + "px",
            });
            $("td").css({
                "white-space": "nowrap",
            });
            sum_cart_value()
            cart_count()
        }
    });
    // ITENS DO PEDIDO
    $("#items-request-table").DataTable({
        "order": [
            [1, 'asc']
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
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [
            {
                'sortable': false,
                'aTargets': [0, 1, 4]
            },
            {
                'className': 'text-center',
                'aTargets': [0, 4]
            },
            {
                'className': 'td-buttons',
                'aTargets': 4
            },
        ],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + '/post/table/items/request'
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        },
        "drawCallback": function () {
            var max = 0; // valor máximo inicializado em zero
            var maxCell; // célula com o valor máximo

            // Loop pelas células da tabela com a classe "tdbtn"
            $("td.td-buttons").each(function () {
                var count = $(this).children().length; // conta o número de elementos dentro da célula
                if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
                    max = count;
                    maxCell = this; // atualiza o valor máximo e a célula correspondente
                }
            });
            calc = max * 35;
            $("th.td-buttons").css({
                "width": calc + "px",
            });
            $("td").css({
                "white-space": "nowrap",
            });
            sum_cart_value()
            cart_count()
        }
    });
    // TODAS PEDIDOS
    $("#orders-table").DataTable({
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
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'td-buttons text-center',
            'aTargets': 5
        },
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/post/table/orders"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        },
        "drawCallback": function () {
            var max = 0; // valor máximo inicializado em zero
            var maxCell; // célula com o valor máximo

            // Loop pelas células da tabela com a classe "tdbtn"
            $("td.td-buttons").each(function () {
                var count = $(this).children().length; // conta o número de elementos dentro da célula
                if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
                    max = count;
                    maxCell = this; // atualiza o valor máximo e a célula correspondente
                }
            });
            calc = max * 35;
            $("th.td-buttons").css({
                "width": calc + "px",
            });
            $("td").css({
                "white-space": "nowrap",
            });
            sum_cart_value()
            count_orders()
        }

    });
    // ITENS DO PEDIDO
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
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 3, 4]
        },
        {
            'className': 'td-buttons',
            'aTargets': 4
        },],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/post/table/equals/items"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
        , "drawCallback": function () {
            var max = 0; // valor máximo inicializado em zero
            var maxCell; // célula com o valor máximo

            // Loop pelas células da tabela com a classe "tdbtn"
            $("td.td-buttons").each(function () {
                var count = $(this).children().length; // conta o número de elementos dentro da célula
                if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
                    max = count;
                    maxCell = this; // atualiza o valor máximo e a célula correspondente
                }
            });
            calc = max * 35;
            $("th.td-buttons").css({
                "width": calc + "px",
            });
            $("td").css({
                "white-space": "nowrap",
            });
        }
    });
});

//--------------------------------------
// CARRINHO
//--------------------------------------
// LIMPA CARRINHO
$('#clear-cart').on('click', function () {
    bootbox.confirm({
        title: 'Deseja limpar seu carrinho?',
        message: "<p>Aproveite explore novos sabores e desfrute de uma refeição saborosa.</p>",
        centerVertical: true,
        buttons: {
            cancel: {
                label: "NÃO",
                className: 'btn-secondary rounded-pill',
            },
            confirm: {
                label: "SIM",
                className: 'btn-danger rounded-pill',

            }
        },
        callback: function (action) {
            if (action) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: window.location.origin + "/delete/clear/cart",
                    success: function (response) {
                        if (!response.error) {
                            let dialog = bootbox.dialog({
                                message: '<p class="text-center"><i class="m-l-24 fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center">' + response.message + '</p><p class="m-t-15 text-center"><a class="btn btn-accent rounded-pill" href="' + window.location.origin + '/menu">VER CARDÁPIO</a></p>',
                                size: 'small',
                                centerVertical: true,
                            });
                            $('#client-cart-table').DataTable().clear().draw()

                        } else {
                            let dialog = bootbox.dialog({
                                message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
                                size: 'small',
                                centerVertical: true,
                                closeButton: false
                            });
                            $('#client-cart-table').DataTable().clear().draw()

                            setTimeout(() => {
                                dialog.modal('hide');
                            }, 2000);
                        }

                    },
                    error: function () {
                        let dialog = bootbox.dialog({
                            message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">ERRO NA REDE</p>',
                            size: 'small',
                            centerVertical: true,
                            closeButton: false
                        });
                        s$('#client-cart-table').DataTable().clear().draw()

                        setTimeout(() => {
                            dialog.modal('hide');
                        }, 2000);
                    }
                });
            }
        }
    });

});
// ENVIAR PEDIDO
$('#send-cart').on('click', function () {
    // Verificação
    if ($('#payment-method').val() == null) {
        $('#payment-method').css('border', '2px solid red');
        return false;
    } else {
        $('#payment-method').removeAttr('style');
    }
    if ($('#select-address').val() == null) {
        $('#select-address').css('border', '2px solid red');

        return false;
    } else {
        $('#select-address').removeAttr('style');
    }
    var location = 'saved-location'
    var address = {}
    if ($('#select-address').val() == 'other-address') {
        var phone = $('#delivery-client-phone').val().replace(/[()  ._-]/g, '')
        if ($('#delivery-client-phone').val() == null || phone.length != 11) {
            $('#delivery-client-phone').addClass('is-invalid');
            return false;
        } else {
            $('#delivery-client-phone').removeClass('is-invalid');
        }

        if ($('#delivery-location').val() == null) {
            $('#delivery-location').css('border', '2px solid red');
            return false;
        } else {
            $('#delivery-location').removeAttr('style');
            var location = $('#delivery-location').val()
        }

        if ($('#delivery-address').val() == '' || $('#delivery-address').val().length > 255) {
            $('#delivery-address').addClass('is-invalid');
            return false;
        } else {
            $('#delivery-address').removeClass('is-invalid');
        }
        if ($('#delivery-number').val() == '' || $('#delivery-number').val().length > 5) {
            $('#delivery-number').addClass('is-invalid');
            return false;
        } else {
            $('#delivery-number').removeClass('is-invalid');
        }
        if ($('#delivery-neighborhood').val() == '' || $('#delivery-neighborhood').val().length > 255) {
            $('#delivery-neighborhood').addClass('is-invalid');
            return false;
        } else {
            $('#delivery-neighborhood').removeClass('is-invalid');
        }
        if ($('#delivery-reference').val() == '' || $('#delivery-reference').val().length > 255) {
            $('#delivery-reference').addClass('is-invalid');
            return false;
        } else {
            $('#delivery-reference').removeClass('is-invalid');
        }

        var address = {
            phone: $('#delivery-client-phone').val(),
            location: $('#delivery-location').val(),
            street: $('#delivery-address').val(),
            number: $('#delivery-number').val(),
            neighborhood: $('#delivery-neighborhood').val(),
            reference: $('#delivery-reference').val(),
        }
    }
    $.get(window.location.origin + '/get/send/cart/confirm/' + location, function (data) {
        if (!data.error) {
            bootbox.confirm({
                title: 'Enviar pedido?',
                message: "<p>Total do pedido + entrega: <strong> " + data.value + "</strong> .</p><br><p>Tem certeza que não deseja mais nada? Que tal dar mais uma olhadinha no cardápio?</p>",
                centerVertical: true,
                buttons: {
                    cancel: {
                        label: "CANCELAR",
                        className: 'btn-secondary rounded-pill',
                    },
                    confirm: {
                        label: "ENVIAR",
                        className: 'btn-accent rounded-pill',

                    }
                },
                callback: function (action) {
                    if (action) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                payment: $('#payment-method').val(),
                                address: address
                            },
                            type: "PUT",
                            url: window.location.origin + "/put/send/cart",
                            success: function (response) {
                                if (!response.error) {
                                    let dialog = bootbox.dialog({
                                        message: '<p class="text-center"><i class="m-l-24 fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center">' + response.message + '</p>',
                                        size: 'small',
                                        centerVertical: true,
                                    });
                                    $('#client-cart-table').DataTable().clear().draw()
                                    $('#orders-table').DataTable().clear().draw()
                                    count_orders()
                                    $('#set-address-modal').modal('hide');
                                    setTimeout(() => {
                                        dialog.modal('hide');
                                    }, 2000);

                                } else {
                                    let dialog = bootbox.dialog({
                                        message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
                                        size: 'small',
                                        centerVertical: true,
                                        closeButton: false
                                    });
                                    $('#client-cart-table').DataTable().clear().draw()
                                    $('#orders-table').DataTable().clear().draw()

                                    setTimeout(() => {
                                        dialog.modal('hide');
                                    }, 2000);
                                }

                            },
                            error: function () {
                                let dialog = bootbox.dialog({
                                    message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">ERRO NA REDE</p>',
                                    size: 'small',
                                    centerVertical: true,
                                    closeButton: false
                                });
                                setTimeout(() => {
                                    dialog.modal('hide');
                                }, 2000);
                            }
                        });
                    }
                }
            });
        } else {
            let dialog = bootbox.dialog({
                message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
                size: 'small',
                centerVertical: true,
                closeButton: false
            });
            setTimeout(() => {
                dialog.modal('hide');
            }, 2000);
        }

    });
});
// APAGAR ITEM CARRINHO
function delete_item_request(id) {
    bootbox.confirm({
        title: 'Excluir item do seu carrinho?',
        message: 'Deseja mesmo excluir?',
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary rounded-pill'
            },
            confirm: {
                label: 'Excluir',
                className: 'btn-danger rounded-pill'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: window.location.origin + '/delete/item/cart/' + id
                    , type: 'DELETE'
                    , dataType: 'text'
                    , success: function (response) {
                        response = JSON.parse(response)
                        if (!response.error) {
                            let dialog = bootbox.dialog({
                                message: '<p class="text-center"><i class="m-l-24 fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center">' + response.message + '</p>',
                                size: 'small',
                                centerVertical: true,
                            });
                            $('#client-cart-table').DataTable().clear().draw()
                            $('#list-items-equals-table').DataTable().clear().draw()

                            setTimeout(() => {
                                dialog.modal('hide');
                            }, 1000);

                        } else {
                            let dialog = bootbox.dialog({
                                message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
                                size: 'small',
                                centerVertical: true,
                                closeButton: false
                            });
                            setTimeout(() => {
                                dialog.modal('hide');
                            }, 2000);
                        }
                    }
                    , error: function () {
                        let dialog = bootbox.dialog({
                            message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">ERRO NA REDE</p>',
                            size: 'small',
                            centerVertical: true,
                            closeButton: false
                        });
                        setTimeout(() => {
                            dialog.modal('hide');
                        }, 2000);
                    }
                });
                setTimeout(() => {
                    $('body').addClass('modal-open')
                }, 500)
            }
        }
    });

}
// EDITA ITEM DO CARRINHO
function edit_item(id) {
    $.ajax({
        url: window.location.origin + '/get/edit/item/' + id
        , type: 'GET'
        , dataType: 'text'
        , success: function (data) {
            data = JSON.parse(data);
            $('#checkbox-container-edit-item').empty()
            if (data['items'].length === 0) {
                $('#checkbox-container-edit-item').html('<div class="col text-center"><span>Este item não possui adicionais.</span></div>')
            } else {
                $.each(data.items, function (index, checkbox) {
                    $('#checkbox-container-edit-item').append('<div class= "d-flex justify-content-between row border-bottom-list" ><div div class= "m-r-30"><span>' + checkbox.name + ' - R$' + money(checkbox.value) + '</span></div><div class="custom-control custom-switch "><input type="checkbox" class="custom-control-input" name="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" id="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" value="' + checkbox.id + '" ' + checkbox.check + '><label class="custom-control-label" for="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional"></label></div></div><hr>');
                });
            }
            $('#item_id').val(id)
            $('#edit-obs-item-request').val(data.observation)

            $('#list-items-equals-modal').modal('hide')
            $('#edit-item').modal('show')
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}
$('#edit-item').on('hidden.bs.modal', function () {
    $('#list-items-equals-modal').modal('show')
})
// MODAL DE EDIÇÃO DE PAGAMENTO E ENDEREÇO
function edit_address_or_payment(id) {
    $.get(window.location.origin + "/get/edit/address/" + id, function (data) {
        $("#new-payment-method").val(data.payment.payment_method)
        $("#new-delivery-client-phone").val(data.address.phone)
        $("#new-delivery-location").val(data.address.location_id)
        $("#new-delivery-address").val(data.address.street_address)
        $("#new-delivery-number").val(data.address.number)
        $("#new-delivery-neighborhood").val(data.address.neighborhood)
        $("#new-delivery-reference").val(data.address.reference)
        $("#update-address-modal").modal('show')
    });
}
// SALVA ALTERAÇÃO
function save_edit_item() {
    var id = $('#item_id').val()
    var inputs = {};
    $('#form-add-additional-edit :input').each(function () {
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
        , url: window.location.origin + '/put/item/edit'
        , type: 'PUT'
        , data: {
            id: id,
            obs: $('#edit-obs-item-request').val(),
            additionals: inputs,
        }
        , dataType: 'text'
        , success: function (response) {
            response = JSON.parse(response)
            if (!response.error) {
                $('#client-cart-table').DataTable().clear().draw()
                $('#list-items-equals-table').DataTable().clear().draw()
                $('#edit-item').modal('hide')
                $('#checkbox-container').empty()
                $('#edit-obs-item-request').val('')
                $('#item_id').val('')
                let dialog = bootbox.dialog({
                    message: '<p class="text-center"><i class="fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center">' + response.message + '</p>',
                    size: 'small',
                    centerVertical: true,
                    closeButton: false
                });

                setTimeout(() => {
                    dialog.modal('hide');
                }, 2000);
            } else {
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
                    size: 'small',
                    centerVertical: true,
                    closeButton: false
                });
                $('#client-cart-table').DataTable().clear().draw()

                setTimeout(() => {
                    dialog.modal('hide');
                }, 2000);
            }
        }
        , error: function () {
            let dialog = bootbox.dialog({
                message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">ERRO NA REDE</p>',
                size: 'small',
                centerVertical: true,
                closeButton: false
            });
            setTimeout(() => {
                dialog.modal('hide');
            }, 2000);
        }
    });

}
// LISTA O PEDIDO
function list_items_equals_request(request, item, product) {
    $('#product_name').text(product)
    $('#list-items-equals-table').DataTable().column(1).search(request).column(2).search(item).column(4).search('delivery').draw()
    $('#items-request-modal').modal('hide')
    $('#list-items-equals-modal').modal('show')
}
// ITENS DO PEDIDO
function items_request(id) {
    const URL = window.location.origin + '/get/order/information/' + id
    $.ajax({
        url: URL,
        type: 'GET',
        success: function (data) {
            $('#items-request-table').DataTable().column(1).search(id).draw()
            $('#DeliveryViewtitle').html('<strong> STATUS: </strong>' + data.status + '<br><strong> PAGAMENTO: </strong>' + data.payment + '<br><strong> DELIVERY: </strong> R$' + data.value + '<br><strong> ENDEREÇO: </strong>' + data.address + '<br><strong> CONTATO: </strong>' + data.phone)
            $('.order-total-value').text(data.value_total)
            $('#items-request-modal').modal('show');
        },
    });
}
// MODAL ENDEREÇO E PAGAMENTO
$('#set_address').on('click', function () {
    $('#set-address-modal').modal('show');
});
// ENVIAR PEDIDO
$('#update-address').on('click', function () {
    // Verificação
    if ($('#new-payment-method').val() == null) {
        $('#payment-method').css('border', '2px solid red');
        return false;
    } else {
        $('#new-payment-method').removeAttr('style');
    }
    var phone = $('#new-delivery-client-phone').val().replace(/[()  ._-]/g, '')
    if ($('#new-delivery-client-phone').val() == null || phone.length != 11) {
        $('#new-delivery-client-phone').addClass('is-invalid');
        return false;
    } else {
        $('#new-delivery-client-phone').removeClass('is-invalid');
    }

    if ($('#new-delivery-location').val() == null) {
        $('#new-delivery-location').css('border', '2px solid red');
        return false;
    } else {
        $('#new-delivery-location').removeAttr('style');
        var location = $('#new-delivery-location').val()
    }

    if ($('#new-delivery-address').val() == '' || $('#new-delivery-address').val().length > 255) {
        $('#new-delivery-address').addClass('is-invalid');
        return false;
    } else {
        $('#new-delivery-address').removeClass('is-invalid');
    }
    if ($('#new-delivery-number').val() == '' || $('#new-delivery-number').val().length > 5) {
        $('#new-delivery-number').addClass('is-invalid');
        return false;
    } else {
        $('#new-delivery-number').removeClass('is-invalid');
    }
    if ($('#new-delivery-neighborhood').val() == '' || $('#new-delivery-neighborhood').val().length > 255) {
        $('#new-delivery-neighborhood').addClass('is-invalid');
        return false;
    } else {
        $('#new-delivery-neighborhood').removeClass('is-invalid');
    }
    if ($('#new-delivery-reference').val() == '' || $('#new-delivery-reference').val().length > 255) {
        $('#new-delivery-reference').addClass('is-invalid');
        return false;
    } else {
        $('#new-delivery-reference').removeClass('is-invalid');
    }

    var address = {
        phone: $('#new-delivery-client-phone').val(),
        location: $('#new-delivery-location').val(),
        street: $('#new-delivery-address').val(),
        number: $('#new-delivery-number').val(),
        neighborhood: $('#new-delivery-neighborhood').val(),
        reference: $('#new-delivery-reference').val(),
    }
    console.log(address)
    // bootbox.confirm({
    //     title: 'Realmente deseja alterar o endereço de entrega?',
    //     message: "Certifique-se que o endereço esta correto, o estabelecimento cobrará uma nova taxa de entrega em caso de erros.",
    //     centerVertical: true,
    //     buttons: {
    //         cancel: {
    //             label: "CANCELAR",
    //             className: 'btn-secondary rounded-pill',
    //         },
    //         confirm: {
    //             label: "SALVAR",
    //             className: 'btn-accent rounded-pill',

    //         }
    //     },
    //     callback: function (action) {
    //         if (action) {
    //             $.ajax({
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 data: {
    //                     payment: $('#new-payment-method').val(),
    //                     address: address
    //                 },
    //                 type: "PUT",
    //                 url: window.location.origin + "/put/update/address",
    //                 success: function (response) {
    //                     if (!response.error) {
    //                         let dialog = bootbox.dialog({
    //                             message: '<p class="text-center"><i class="m-l-24 fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center">' + response.message + '</p>',
    //                             size: 'small',
    //                             centerVertical: true,
    //                         });
    //                         $('#client-cart-table').DataTable().clear().draw()
    //                         $('#orders-table').DataTable().clear().draw()
    //                         count_orders()
    //                         $('#set-address-modal').modal('hide');
    //                         setTimeout(() => {
    //                             dialog.modal('hide');
    //                         }, 2000);

    //                     } else {
    //                         let dialog = bootbox.dialog({
    //                             message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + response.message + '</p>',
    //                             size: 'small',
    //                             centerVertical: true,
    //                             closeButton: false
    //                         });
    //                         $('#client-cart-table').DataTable().clear().draw()
    //                         $('#orders-table').DataTable().clear().draw()

    //                         setTimeout(() => {
    //                             dialog.modal('hide');
    //                         }, 2000);
    //                     }

    //                 },
    //                 error: function () {
    //                     let dialog = bootbox.dialog({
    //                         message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">ERRO NA REDE</p>',
    //                         size: 'small',
    //                         centerVertical: true,
    //                         closeButton: false
    //                     });
    //                     setTimeout(() => {
    //                         dialog.modal('hide');
    //                     }, 2000);
    //                 }
    //             });
    //         }
    //     }
    // });
});
// SELEÇAO DE ENDEREÇO
$('#select-address').on('change', function (event) {
    switch (event.target.value) {
        case 'saved-address':
            $('#address-form').addClass('d-none')
            break;
        case 'other-address':
            $('#address-form').removeClass('d-none')
            break;
        default:
            $('#address-form').addClass('d-none')
            break;
    }
});
// PEDIDOS PENDENTES/ANDAMENTOO/FINALIZADO
function orders_table(val) {
    $('#orders-table').DataTable().column(1).search(val).draw()
}


//--------------------------------------
// PAGINA
//--------------------------------------
// CARROSSEL DE SUGESTÕES
var $product = $('.suggestion-slider');
if ($product.length > 0) {
    $(document).ready(function () {
        $(".suggestion-slider").owlCarousel({
            loop: true,
            center: false,
            margin: 10,
            items: 6,
            autoplay: true,
            autoplayTimeout: 9000,
            nav: false,
            navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
            responsive: {
                0: {
                    items: 3,
                },
                430: {
                    items: 3,
                },
                767: {
                    items: 3,
                },
                991: {
                    items: 6,
                },
            }
        });
    });
}

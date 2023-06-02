// MASCARA DINHEIRO
function money(value) {
    // Converte o valor para um número com duas casas decimais
    value = parseFloat(value).toFixed(2);

    // Adiciona o separador de milhares (ponto) e separador de decimal (vírgula)
    value = value.replace(".", ",");
    value = value.replace(/(\d)(?=(\d{3})+\,)/g, "$1.");

    // Adiciona o símbolo de real (R$)
    // valor = "R$ " + valor;

    return value;
}

function increaseCount(a, b) {
    var input = b.previousElementSibling;
    var value = parseInt(input.value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    input.value = value;
}

function decreaseCount(a, b) {
    var input = b.nextElementSibling;
    var value = parseInt(input.value, 10);
    if (value > 1) {
        value = isNaN(value) ? 0 : value;
        value--;
        input.value = value;
    }
}
//---------------------------------------------------------------
//   ITEMS E PEDIDOS
//---------------------------------------------------------------
//MODAL ADICIONAR AO CARRINHO
function add_cart_modal(id) {
    $.ajax({
        url: window.location.origin + '/get/item/additionals/' + id,
        type: 'GET',
        dataType: 'text',
        success: function (response) {

            var data = JSON.parse(response)
            $('#checkbox-container').empty()
            if (data['items'].length === 0) {
                $('#checkbox-container').html('<div class="col text-center"><span>Este item não possui adicionais.</span></div>')
            } else {
                $.each(data.items, function (index, checkbox) {
                    $('#checkbox-container').append('<div class= "border-bottom-list d-flex justify-content-between"><span>' + checkbox.name + ' - R$' + money(checkbox.value) + '</span><div class=" col-md-1 custom-control custom-switch "><input type="checkbox" class="custom-control-input" name="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" id="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" value="' + checkbox.id + '" ' + checkbox.check + '><label class="custom-control-label" for="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional"></label></div></div><hr>');
                });
            }
            $('.modal').modal('hide');
            $('#add-cart').modal('show');
        },
    });
}
//MODAL VER ITEMS
function view_item(id) {
    $.get(window.location.origin + "/get/item/show/" + id, function (data) {
        // LIMPANDO CAMPOS
        $('#item-img').attr('src', '')
        $('#item-name').text('')
        $('#item-likes').text('')
        $('#item-value').text('')
        $('#item-old-value').text('')
        $('#item-description').text('')
        $('#pro-detail-button-id').val('')
        $('#view-item').attr('class', '')
        $('.detail-rating i').removeClass('far fas')
        $('.pro-detail-button i').removeClass('far fas')
        $('.modal').modal('hide')
        $('#view-item').addClass('modal fade')

        // PREENCHENDO CAMPOS
        $('#item-img').attr('src', data.photo_url)
        $('#item-name').text(data.name)
        $('#item-likes').text(data.likes)
        $('#item-value').text('R$ ' + money(data.value))
        if (data.value < data.old_value) {
            $('#item-old-value').text('R$ ' + money(data.old_value))
        }
        if (data.like == null) {
            $('.detail-rating i').addClass('far')
            $('.pro-detail-button i').addClass('far')
        } else {
            $('.detail-rating i').addClass('fas')
            $('.pro-detail-button i').addClass('fas')
        }

        $('#item-description').html(data.description)
        $('#pro-detail-button-id').val(id)
        $('#view-item').addClass(id)
        $('#view-item').modal('show')
    });
}
// ADICIONAR PEDIDO AO CARRINHO
function add_cart() {
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
        , url: window.location.origin + '/put/add/item/cart'
        , type: 'PUT'
        , data: {
            additionals: inputs,
            obs: $('#obs-item-request').val(),
            qty: $('#qty-item-request').val(),
        }
        , dataType: 'text'
        , success: function (response) {
            var responseData = JSON.parse(response)
            if (!responseData.error) {
                $('#add-cart').modal('hide');
                $('#obs-item-request').val('')
                $('#qty-item-request').val(1)
                $('#client-cart-table').DataTable().clear().draw()
                cart_count()
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center mb-0">' + responseData.message + '</p>',
                    size: 'small',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide');
                }, 1000);
            } else {
                $('#add-cart').modal('hide');
                $('#obs-item-request').val('')
                $('#qty-item-request').val('1')
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + responseData.message + '</p>',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide');
                }, 2000);
            }
        }
        , error: function () {
            // Toast.fire({
            //     icon: 'error'
            //     , title: '&nbsp&nbsp Erro na rede.'
            // });
        }
    });
}


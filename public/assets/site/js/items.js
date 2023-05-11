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
//---------------------------------------------------------------
//   ITEMS E PEDIDOS
//---------------------------------------------------------------
// NOVO PDIDO
function new_order() {
    $('#new-order').modal('show');
}
// VER ITEMS
function view_item(id) {
    $.get(window.location.origin + "/get/item/show/" + id, function (data) {
        // LIMPANDO CAMPOS
        $('#item-img').attr('src', '')
        $('#item-name').text('')
        $('#item-likes').text('')
        $('#item-value').text('')
        $('#item-old-value').text('')
        $('#item-description').text('')

        // PREENCHENDO CAMPOS
        $('#item-img').attr('src', data.photo_url)
        $('#item-name').text(data.name)
        $('#item-likes').text(data.likes)
        $('#item-value').text('R$ ' + money(data.value))
        if (data.value < data.old_value) {
            $('#item-old-value').text('R$ ' + money(data.old_value))
        }
        $('#item-description').text(data.description)
        $('#view-item').modal('show')
    });
}

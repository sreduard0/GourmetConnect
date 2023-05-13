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
//-----------------------------------
//    TABELAS
//-----------------------------------
// $(function () {
//     $("#requests-table").DataTable({
//         "order": [
//             [3, 'asc']
//         ],
//         "bInfo": false
//         , "paging": true
//         , "pagingType": 'simple_numbers'
//         , "responsive": true
//         , "lengthChange": true
//         , "iDisplayLength": 10
//         , "autoWidth": false
//         , "dom": '<"top">rt<"bottom"ip> <"clear" > '
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'td-buttons text-center',
//             'aTargets': 5
//         }],
//         "processing": true
//         , "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/orders"
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }

//     });
//     $("#menu-table").DataTable({
//         "order": [
//             [1, 'asc']
//         ],
//         "pagingType": 'simple_numbers',
//         "bInfo": false,
//         "responsive": true,
//         "lengthChange": false,
//         "iDisplayLength": 10,
//         "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip><"clear" >',
//         "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 3]
//         },
//         {
//             'className': 'td-buttons',
//             'aTargets': 3
//         },
//         {
//             'sortable': false,
//             'aTargets': [0, 2, 3]
//         }],
//         "serverSide": true,
//         "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/menu",
//             "type": "POST",
//             "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

//             }

//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }

//     });
//     $("#order-requests-table").DataTable({
//         "order": [
//             [3, 'asc']
//         ],
//         "bInfo": false
//         , "paging": true
//         , "pagingType": 'simple_numbers'
//         , "responsive": true
//         , "lengthChange": false
//         , "iDisplayLength": 10
//         , "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip> <"clear">'
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 3]
//         },
//         {
//             'className': 'td-buttons',
//             'aTargets': 3
//         },
//         {
//             'sortable': false,
//             'aTargets': [0, 3]
//         }],
//         "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/client"
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }
//     });
//     $("#list-items-equals-table").DataTable({
//         "bInfo": false
//         , "paging": true
//         , "pagingType": 'simple_numbers'
//         , "responsive": true
//         , "lengthChange": false
//         , "iDisplayLength": 10
//         , "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip> <"clear">'
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 3, 4]
//         },
//         {
//             'className': 'td-buttons',
//             'aTargets': 4
//         },],
//         "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/list-items-equals"
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }
//     });
//     $("#client-requests-view-table").DataTable({
//         "order": [
//             [1, 'asc']
//         ],
//         "bInfo": false
//         , "paging": false
//         , "pagingType": 'simple_numbers'
//         , "responsive": true
//         , "lengthChange": false
//         , "iDisplayLength": 10
//         , "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip> <"clear">'
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 2, 3, 4]
//         },
//         {
//             'className': 'td-buttons-table',
//             'aTargets': 4
//         },
//         {
//             'sortable': false,
//             'aTargets': [0, 3, 4]
//         }],
//         "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/client-view"
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons-table").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons-table").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }
//     });
//     $("#client-requests-payment-table").DataTable({
//         "order": [
//             [1, 'asc']
//         ],
//         "bInfo": false
//         , "paging": false
//         , "pagingType": 'simple_numbers'
//         , "responsive": true
//         , "lengthChange": false
//         , "iDisplayLength": 10
//         , "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip> <"clear">'
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 3, 4, 5]
//         },
//         {
//             'className': 'td-buttons',
//             'aTargets': 5
//         },
//         {
//             'sortable': false,
//             'aTargets': [0, 1, 4, 5]
//         }],
//         "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/client-payment/" + $('#print_id').val()
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }
//     });
//     $("#split-payment-table").DataTable({
//         "order": [
//             [1, 'asc']
//         ],
//         "bInfo": false
//         , "paging": false
//         , "responsive": true
//         , "lengthChange": false
//         , "iDisplayLength": 10
//         , "autoWidth": false,
//         "dom": '<"top">rt<"bottom"ip> <"clear">'
//         , "language": {
//             "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
//         },
//         "aoColumnDefs": [{
//             'className': 'text-center',
//             'aTargets': [0, 3]
//         },
//         {
//             'className': 'td-buttons',
//             'aTargets': 3
//         },
//         {
//             'sortable': false,
//             'aTargets': [0, 2, 3]
//         }],
//         "serverSide": true
//         , "ajax": {
//             "url": window.location.origin + "/administrator/post/table/request/split-payment"
//             , "type": "POST"
//             , "headers": {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 ,
//             }
//             ,
//         },
//         "drawCallback": function () {
//             var max = 0; // valor máximo inicializado em zero
//             var maxCell; // célula com o valor máximo

//             // Loop pelas células da tabela com a classe "tdbtn"
//             $("td.td-buttons").each(function () {
//                 var count = $(this).children().length; // conta o número de elementos dentro da célula
//                 if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
//                     max = count;
//                     maxCell = this; // atualiza o valor máximo e a célula correspondente
//                 }
//             });
//             calc = max * 35;
//             $("th.td-buttons").css({
//                 "width": calc + "px",
//             });
//             $("td").css({
//                 "white-space": "nowrap",
//             });
//         }
//     })
// });

//---------------------------------------------------------------
//   ITEMS E PEDIDOS
//---------------------------------------------------------------
// NOVO PDIDO
function new_order() {
    $('#new-order').modal('show');
}
// ADICIONAR AO CARRINHO
function add_cart(id) {
    $.ajax({
        url: window.location.origin + '/get/request/item/additionals/' + id,
        type: 'GET',
        dataType: 'text',
        success: function (response) {
            var data = JSON.parse(response)
            $('#checkbox-container').empty()
            if (data['items'].length === 0) {
                $('#checkbox-container').html('<div class="col text-center text-light"><span>Este item não possui adicionais.</span></div>')
            } else {
                $.each(data.items, function (index, checkbox) {
                    $('#checkbox-container').append('<div class= "border-bottom-list d-flex justify-content-between"><span class="text-light">' + checkbox.name + ' - R$' + money(checkbox.value) + '</span><div class=" col-md-1 custom-control custom-switch "><input type="checkbox" class="custom-control-input" name="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" id="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional" value="' + checkbox.id + '" ' + checkbox.check + '><label class="custom-control-label" for="' + checkbox.name.toLowerCase().replace(' ', '-') + '-additional"></label></div></div><hr>');
                });
            }
            $('#observation-item').modal('show');
        },
        error: function () {

        }
    });
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
// ADICIONAIS E OBSERVAÇÃO
function additional_show(product_id) {

}

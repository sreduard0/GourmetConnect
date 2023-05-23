// CURTI E DESCURTI
function like_item(item) {
    $.ajax({
        url: window.location.origin + '/get/item/like/' + item,
        type: 'GET',
        success: function (response) {
            switch (response.event) {
                case 'like':
                    $('.' + item + ' .fa-heart').removeClass('far')
                    $('.' + item + ' .fa-heart').addClass('fas')
                    $('.' + item + ' strong').text(response.likes)
                    $('.' + item + ' #item-likes').text(response.likes)
                    $('#like-items-table').DataTable().ajax.reload()
                    break;
                case 'unlike':
                    $('.' + item + ' .fa-heart').removeClass('fas')
                    $('.' + item + ' .fa-heart').addClass('far')
                    $('.' + item + ' strong').text(response.likes)
                    $('.' + item + ' #item-likes').text(response.likes)
                    $('#like-items-table').DataTable().ajax.reload()
                    break
            }
        },
    });
}
// MODAL DE ITEMS CURTIDOS
function like_items() {
    $('#like-items').modal('show');
    setTimeout(() => {
        $("#like-items-table").DataTable()
            .responsive.recalc().draw();
    }, 200)
    setTimeout(() => {
        $('.load-table-custom').addClass('d-none')
    }, 1500);
}
// TABELA DE ITENS CURTIDOS
$(function () {
    $("#like-items-table").DataTable({
        "ordering": false,
        "pagingType": 'simple_numbers',
        "responsive": true,
        "lengthChange": false,
        "iDisplayLength": 10,
        "autoWidth": false,
        "dom": '<"top">rt<"bottom"ip><"clear" >',
        "language": {
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [
            {
                'className': 'td-buttons-menu text-center'
                , 'aTargets': 3
            }
        ],
        "processing": false,
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/post/table/item/like",
            "type": "POST",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        "drawCallback": function () {
            var max = 0; // valor máximo inicializado em zero
            var maxCell; // célula com o valor máximo
            $("td.td-buttons-menu").each(function () {
                var count = $(this).children().length; // conta o número de elementos dentro da célula
                if (count > max) { // verifica se o número de elementos é maior que o valor máximo atual
                    max = count;
                    maxCell = this; // atualiza o valor máximo e a célula correspondente
                }
            });
            calc = max * 35;
            $("th.td-buttons-menu").css({
                "width": calc + "px",
            });
            $("td").css({
                "white-space": "nowrap",
            });
        }
    });
});

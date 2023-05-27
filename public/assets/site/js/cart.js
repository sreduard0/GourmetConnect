
// TABLES
$(function () {
    $("#client-cart-table").DataTable({
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
            "url": window.location.origin + "/assets/app/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': [0, 3, 4, 5]
        },
        {
            'className': 'td-buttons',
            'aTargets': 5
        },
        {
            'sortable': false,
            'aTargets': [0, 1, 4, 5]
        }],
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
        }
    });
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
        // "serverSide": true,
        // "ajax": {
        //     "url": window.location.origin + "/administrator/post/table/delivery"
        //     , "type": "POST"
        //     , "headers": {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         ,
        //     }
        //     ,
        // },
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
        }

    });
});

// PEDIDOS MOSTRA PENDENTES
function cart_table(val) {
    $('#client-cart-table').DataTable().column(1).search(val).draw()

}

//product
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


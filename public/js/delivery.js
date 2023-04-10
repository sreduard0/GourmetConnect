var Toast = Swal.mixin({
    toast: true
    , position: 'top-end'
    , showConfirmButton: false
    , timer: 4000
});

// PEDIDOS DO CLIENTE
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
            switch (data.status) {
                case 1:
                    var status = 'NOVO PEDIDO';
                    break;
                case 2:
                    var status = 'EM ANDAMENTO';
                    break;
            }
            $('#client-delivery-view-table').DataTable().column(1).search(id).draw()
            $('#DeliveryViewtitle').html('<strong>CLIENTE: </strong>' + data.client + '<div><strong> STATUS: </strong>' + status + '</div >')
            $('.value-total').text(data.total)
            $('#print_id').val(id)
            $('#delivery-client-modal').modal('show')
        },

    });
}

// IMORIMIR PEDIDO
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
    // $("#menu-table").DataTable({
    //     "order": [
    //         [1, 'asc']
    //     ],
    //     "pagingType": 'simple_numbers',
    //     "bInfo": false,
    //     "responsive": true,
    //     "lengthChange": false,
    //     "iDisplayLength": 10,
    //     "autoWidth": false,
    //     "dom": '<"top">rt<"bottom"ip><"clear" >',
    //     "language": {
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
    //     "serverSide": true,
    //     "ajax": {
    //         "url": window.location.origin + "/administrator/post/table/request/menu",
    //         "type": "POST",
    //         "headers": {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

    //         }

    //     }

    // });
    // $("#client-requests-table").DataTable({
    //     "order": [
    //         [3, 'asc']
    //     ],
    //     "bInfo": false
    //     , "paging": true
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
    //         'aTargets': [0, 3]
    //     },
    //     {
    //         'sortable': false,
    //         'aTargets': [0, 3]
    //     }],
    //     "serverSide": true
    //     , "ajax": {
    //         "url": window.location.origin + "/administrator/post/table/request/client"
    //         , "type": "POST"
    //         , "headers": {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             ,
    //         }
    //         ,
    //     }
    // });
    // $("#list-items-equals-table").DataTable({
    //     "bInfo": false
    //     , "paging": true
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
    //         'aTargets': [0, 3, 4]
    //     }],
    //     "serverSide": true
    //     , "ajax": {
    //         "url": window.location.origin + "/administrator/post/table/request/list-items-equals"
    //         , "type": "POST"
    //         , "headers": {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             ,
    //         }
    //         ,
    //     }
    // });
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


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
        }
        , "processing": true
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
        "processing": false,
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
        "bInfo": false
        , "paging": true
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false
        , "aoColumnDefs": [{
            'className': 'text-center'
            , 'aTargets': 3
        }],
        "dom": '<"top">rt<"bottom"ip> <"clear">'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        }
        , "processing": true
        , "serverSide": true
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



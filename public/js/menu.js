// TABELAS
$(function () {
    $("#table-menu").DataTable({
        "order": [
            [0, 'asc']
        ]
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false
        , "dom": '<"top">rt<"bottom"ip><"clear" >'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        }
        , "aoColumnDefs": [{
            'className': 'text-center'
            , 'aTargets': 5
        }, {
            'sortable': false
            , 'aTargets': [1, 4]
        }]
        , "processing": true
        , "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/menu/items"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
    $("#type-item-table").DataTable({
        "ordering": false
        , "bInfo": false
        , "paging": true
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false
        , "aoColumnDefs": [{
            'className': 'text-center'
            , 'aTargets': 3
        }]

        , "dom": '<"top">rt<"bottom"ip> <"clear">'
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        }
        , "processing": true
        , "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/menu/type"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });
    $("#additional-items-table").DataTable({
        "order": [
            [0, 'asc']
        ]
        , "pagingType": 'simple_numbers'
        , "responsive": true
        , "lengthChange": false
        , "iDisplayLength": 10
        , "autoWidth": false
        , "dom": '<"top">rt<"bottom"ip><"clear" > '
        , "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        }
        , "aoColumnDefs": [{
            'className': 'text-center'
            , 'aTargets': 5
        }]
        , "processing": true
        , "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/menu/additional-items"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }

    })
});
// FILTROS
$('#filter-type-item').on('change', function (event) {
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });

    $('#table-menu').DataTable().column(1).search(event.target.value).draw()

    Toast.fire({
        icon: 'success'
        , title: '&nbsp&nbsp Filtado com successo.'
    })
})
$('#filter-item').on('change', function (event) {

    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false
        , timer: 4000
    });

    $('#additional-items-table').DataTable().column(1).search(event.target.value).draw()
    $('#item-menu').val(event.target.value).trigger('change')

    Toast.fire({
        icon: 'success'
        , title: '&nbsp&nbsp Filtado com successo.'
    })
})

// MODALS
function modal_new_type_item() {
    $('#type-itemLabel').text('NOVA CLASSIFICAÇÃO DE ITEM')
    $('#btn-save-type-item').attr('onclick', 'return save_new_type_item()')
    $('#type-item-modal').modal('show')
}
function modal_new_item() {
    $('#item-modalLabel').text('NOVO ITEM')
    $('#btn-save-item').attr('onclick', 'return save_new_item()')
    $('#item-modal').modal('show')
}
function modal_new_additional_item() {
    $('#additional-itemLabel').text('NOVO ITEM ADICIONAL')
    $('#btn-save-additional-item').attr('onclick', 'return save_new_additional_item()')
    $('#additional-item-modal').modal('show')
}
function modal_type_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    const URL = '/administrator/post/info/menu/type'
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
            $('#id-type-product').val(data.id)
            $('#img_type_product').attr('src', window.location.origin + '/' + data.photo_url)
            $('#name-type-product').val(data.name)
            $('#obs-type-product').summernote('code', data.description)
            $('#type-itemLabel').text('EDITAR CLASSIFICAÇÃO DE ITEM')
            $('#btn-save-type-item').attr('onclick', 'return edit_type_item()')
            $('#type-item-modal').modal('show');
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}
function modal_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    const URL = '/administrator/post/info/menu/item'
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
            $('#id-product').val(data.id)
            $('#img_product').attr('src', window.location.origin + '/' + data.photo_url)
            $('#status-product').val(data.status)
            $('#type-product').val(data.type_id)
            $('#name-product').val(data.name)
            $('#value-product').val(money(data.value))
            $('#obs-product').summernote('code', data.description)
            $('#item-modalLabel').text('EDITAR ITEM')
            $('#btn-save-item').attr('onclick', 'return edit_item()')
            $('#item-modal').modal('show');
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}
function modal_additional_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    const URL = '/administrator/post/info/menu/additional-item'
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
            $('#id_additional_item').val(data.id)
            $('#item-menu').val(data.item_id).trigger('change')
            $('#name-additional').val(data.name)
            $('#value-additional').val(money(data.value))
            $('#status-additional').val(data.status)
            $('#obs-additional').summernote('code', data.description)
            $('#additional-itemLabel').text('EDITAR ITEM ADICIONAL')
            $('#btn-save-additional-item').attr('onclick', 'return edit_additional_item()')
            $('#additional-item-modal').modal('show')
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}

// SELECTS
function matchCustom(params, data) {
    document.querySelector(".select2-search__field").placeholder = "Buscar item";
    if ($.trim(params.term) === '') {
        return data;
    }
    if (data.title.indexOf(params.term) > -1) {
        var modifiedData = $.extend({}, data, true)
        return modifiedData;
    }
    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
        var modifiedData = $.extend({}, data, true);
        return modifiedData;
    }
    return '';
}
$('.select2').select2({
    matcher: matchCustom
    ,
});

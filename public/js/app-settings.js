// AUTO SELECIONAR ABA VIA URL
$(function () {
    // Obtém o ID do elemento na URL
    var url = window.location.href;
    var element_id = url.split('#')[1];
    // Ativa a aba correspondente
    $('a[href="#' + element_id + '"]').tab('show');
});
// TABLES
$(function () {
    $("#delivery-locations-table").DataTable({
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
            'aTargets': [0, 2, 3]
        },
        {
            'sortable': false,
            'aTargets': 3
        }],
        "serverSide": true
        , "ajax": {
            "url": window.location.origin + "/administrator/post/table/app-settings/delivery-locations"
            , "type": "POST"
            , "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                ,
            }
            ,
        }
    });

});

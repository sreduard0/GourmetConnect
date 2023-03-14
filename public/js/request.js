function modal_new_request() {
    $('#new-request-modal').modal('show');
}

// TABLES
$(function () {
    $("#requests-table").DataTable({
        // "order": [
        //     [0, 'desc']
        // ],
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
        // , "aoColumnDefs": [{
        //     'sortable': false
        //     , 'aTargets': [1, 2, 3]
        // }]
        // , "processing": true
        // , "serverSide": true
        // , "ajax": {
        //     "url": ""
        //     , "type": "POST"
        //     , "headers": {
        //         'X-CSRF-TOKEN': "{{ csrf_token() }}"
        //     , }
        // , }
        ,
    });
    $("#menu-table").DataTable({
        // "order": [
        //     [0, 'asc']
        // ]
        "pagingType": 'simple_numbers',
        "bInfo": false,
        "responsive": true,
        "lengthChange": false,
        "iDisplayLength": 10,
        "autoWidth": true,
        "dom": '<"top">rt<"bottom"ip><"clear" >',
        "language": {
            "url": window.location.origin + "/plugins/datatables/Portuguese2.json"
        },
        "aoColumnDefs": [{
            'className': 'text-center',
            'aTargets': 4
        },
        {
            'sortable': false,
            'aTargets': [1, 3]
        }],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": window.location.origin + "/administrator/post/table/menu/items",
            "type": "POST",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

            }

        }

    });
    $("#client-requests-table").DataTable({
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
});
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

$(function (clients) {
    var availableTags = [
        "ActionScript"
        , "AppleScript"
    ];
    $("#teste").autocomplete({
        source: availableTags
        , minLength: 0
    }).focus(function () {
        $(this).data("uiAutocomplete").search($(this).val());
    });
});



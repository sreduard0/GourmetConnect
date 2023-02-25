function filterReports() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    data = {
        vtr: $('#vtr_filter').val(),
        driver: $('#mot_filter').val(),
        dateEnt: $('#dateEnt_filter').val(),
        dateSai: $('#dateSai_filter').val(),
        om: $('#om_filter').val(),
        typeVtr: $('#typevtr_filter').val(),
    }
    if (
        data.vtr ||
        data.driver ||
        data.dateEnt ||
        data.dateSai ||
        data.om ||
        data.typeVtr
    ) {
        $('#table').DataTable()
            .column(0).search(data.vtr)
            .column(1).search(data.driver)
            .column(2).search(data.dateEnt)
            .column(3).search(data.dateSai)
            .column(4).search(data.om)
            .column(5).search(data.typeVtr)
            .column(6).search('find')
            .draw()
    } else {
        $('#table').DataTable()
            .column(6).search('')
            .draw()
    }

    Toast.fire({
        icon: 'success',
        title: '&nbsp&nbsp Filtado com successo.'
    });


}

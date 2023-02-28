function save_stablishment_settings() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-stablishment-settings'))

    // Verificação
    if (formData.get('stablishment_name') == '' || formData.get('stablishment_name') < 4) {
        $('#nrFicha').addClass('is-invalid');
        return false;
    } else {
        $('#nrFicha').removeClass('is-invalid');
    }
    if (formData.get('vtrFicha') == '') {
        $('#vtrFicha').addClass('is-invalid');
        return false;
    } else {
        $('#vtrFicha').removeClass('is-invalid');
    }
    if (formData.get('missionFicha') == '') {
        $('#missionFicha').addClass('is-invalid');
        return false;
    } else {
        $('#missionFicha').removeClass('is-invalid');
    }
    if (formData.get('inOrderFicha') == '' || formData.get('nameSegFicha').length > 200) {
        $('#inOrderFicha').addClass('is-invalid');
        return false;
    } else {
        $('#inOrderFicha').removeClass('is-invalid');
    }
    if (formData.get('idMotFicha') == '') {
        $('#idMotFicha').addClass('is-invalid');
        return false;
    } else {
        $('#idMotFicha').removeClass('is-invalid');
    }
    if (formData.get('natOfServFicha') == '' || formData.get('nameSegFicha').length > 200) {
        $('#natOfServFicha').addClass('is-invalid');
        return false;
    } else {
        $('#natOfServFicha').removeClass('is-invalid');
    }
    if (formData.get('dateClose') == '' || formData.get('dateClose').length > 200) {
        $('#dateClose').addClass('is-invalid');
        return false;
    } else {
        $('#dateClose').removeClass('is-invalid');
    }




    var values = {
        nrFicha: formData.get('nrFicha'),
        vtrFicha: formData.get('vtrFicha'),
        missionFicha: formData.get('missionFicha'),
        inOrderFicha: formData.get('inOrderFicha'),
        idMotFicha: formData.get('idMotFicha'),
        pgSegFicha: formData.get('pgSegFicha'),
        nameSegFicha: formData.get('nameSegFicha'),
        dateClose: formData.get('dateClose'),
        natOfServFicha: formData.get('natOfServFicha'),
    }

    const URL = '/register_ficha'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'vtr':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Esta viatura já contém uma ficha aberta.'
                    });
                    $('#vtrFicha').addClass('is-invalid')
                    break;
                case 'ficha':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Já existe uma ficha com este número.'
                    });
                    $('#nrFicha').addClass('is-invalid')
                    break;

                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Ficha adicionada com sucesso.'
                    });

                    $('#register-ficha').modal('hide');
                    $('#form-register-ficha')[0].reset();
                    $("#table").DataTable().clear().draw();
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao cadastrar.'
            });
        }
    });
}

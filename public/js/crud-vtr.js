function registerVtr() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-register-vtr'))

    // Verificação
    if (formData.get('nrVtr') == '' || formData.get('nrVtr').length > 4) {
        $('#nrVtr').addClass('is-invalid');
        return false;
    } else {
        $('#nrVtr').removeClass('is-invalid');
    }
    if (formData.get('typeVtr') == '') {
        $('#typeVtr').addClass('is-invalid');
        return false;
    } else {
        $('#typeVtr').removeClass('is-invalid');
    }
    if (formData.get('modVtr') == '' || formData.get('modVtr').length > 200) {
        $('#modVtr').addClass('is-invalid');
        return false;
    } else {
        $('#modVtr').removeClass('is-invalid');
    }
    if (formData.get('ebPlacaVtr') == '' || formData.get('ebPlacaVtr').length > 20) {
        $('#ebPlacaVtr').addClass('is-invalid');
        return false;
    } else {
        $('#ebPlacaVtr').removeClass('is-invalid');
    }
    if (formData.get('tonVtr') == '' || formData.get('tonVtr').length > 10) {
        $('#tonVtr').addClass('is-invalid');
        return false;
    } else {
        $('#tonVtr').removeClass('is-invalid');
    }
    if (formData.get('volVtr') == '' || formData.get('volVtr').length > 10) {
        $('#volVtr').addClass('is-invalid');
        return false;
    } else {
        $('#volVtr').removeClass('is-invalid');
    }
    if (formData.get('fuelVtr') == '') {
        $('#fuelVtr').addClass('is-invalid');
        return false;
    } else {
        $('#fuelVtr').removeClass('is-invalid');
    }
    if (formData.get('statusVtr') == '') {
        $('#statusVtr').addClass('is-invalid');
        return false;
    } else {
        $('#statusVtr').removeClass('is-invalid');
    }

    var values = {
        nrVtr: formData.get('nrVtr'),
        typeVtr: formData.get('typeVtr'),
        modVtr: formData.get('modVtr'),
        ebPlacaVtr: formData.get('ebPlacaVtr'),
        tonVtr: formData.get('tonVtr'),
        volVtr: formData.get('volVtr'),
        fuelVtr: formData.get('fuelVtr'),
        statusVtr: formData.get('statusVtr'),
        obsVtr: formData.get('obsVtr'),

    }

    const URL = '/register_vtr'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {

            switch (data) {
                case 'nrvtr':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Já existe uma viatura com este número.'
                    });
                    $('#nrVtr').addClass('is-invalid');
                    break;
                case 'ebplaca':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Já existe uma viatura com este EB ou Placa.'
                    });
                    $('#ebPlacaVtr').addClass('is-invalid')
                    break;

                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Viatura adicionada com sucesso.'
                    });

                    $('#register-vtr').modal('hide');
                    $('#form-register-vtr')[0].reset();
                    $('#obsVtr').summernote('code', '');
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
function editVtr() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-edit-vtr'))

    // Verificação
    if (formData.get('e_nrVtr') == '' || formData.get('e_nrVtr').length > 4) {
        $('#e_nrVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_nrVtr').removeClass('is-invalid');
    }
    if (formData.get('e_typeVtr') == '') {
        $('#e_typeVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_typeVtr').removeClass('is-invalid');
    }
    if (formData.get('e_modVtr') == '' || formData.get('e_modVtr').length > 200) {
        $('#e_modVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_modVtr').removeClass('is-invalid');
    }
    if (formData.get('e_ebPlacaVtr') == '' || formData.get('e_ebPlacaVtr').length > 20) {
        $('#e_ebPlacaVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_ebPlacaVtr').removeClass('is-invalid');
    }
    if (formData.get('e_tonVtr') == '' || formData.get('e_tonVtr').length > 10) {
        $('#e_tonVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_tonVtr').removeClass('is-invalid');
    }
    if (formData.get('e_volVtr') == '' || formData.get('e_volVtr').length > 10) {
        $('#e_volVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_volVtr').removeClass('is-invalid');
    }
    if (formData.get('e_fuelVtr') == '') {
        $('#e_fuelVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_fuelVtr').removeClass('is-invalid');
    }
    if (formData.get('e_statusVtr') == '') {
        $('#e_statusVtr').addClass('is-invalid');
        return false;
    } else {
        $('#e_statusVtr').removeClass('is-invalid');
    }

    var values = {
        id: formData.get('id_vtr'),
        nrVtr: formData.get('e_nrVtr'),
        typeVtr: formData.get('e_typeVtr'),
        modVtr: formData.get('e_modVtr'),
        ebPlacaVtr: formData.get('e_ebPlacaVtr'),
        tonVtr: formData.get('e_tonVtr'),
        volVtr: formData.get('e_volVtr'),
        fuelVtr: formData.get('e_fuelVtr'),
        statusVtr: formData.get('e_statusVtr'),
        obsVtr: formData.get('e_obsVtr'),

    }

    const URL = '/edit_vtr'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {

            switch (data) {
                case 'nrvtr':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Já existe uma viatura com este número.'
                    });
                    $('#e_nrVtr').addClass('is-invalid');
                    break;
                case 'ebplaca':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Já existe uma viatura com este EB ou Placa.'
                    });
                    $('#e_ebPlacaVtr').addClass('is-invalid')
                    break;

                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Viatura adicionada com sucesso.'
                    });

                    $('#edit-vtr').modal('hide');
                    $('#form-edit-vtr')[0].reset();
                    $('#e_obsVtr').summernote('code', '');
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

function deleteVtr(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir esta viatura?',
        message: '<strong>Essa operação não pode ser desfeita e apagará todos os dados desta viatura.</strong>',
        callback: function (confirmacao) {

            if (confirmacao)
                $.ajax({
                    url: '/delete_vtr/' + id,
                    type: "GET",
                    success: function (data) {
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp&nbsp Viatura excluida com sucesso.'
                        });
                        $("#table").DataTable().clear().draw();


                    },
                    error: function (data) {
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp&nbsp Erro excluir.'
                        });

                    }
                });
        },
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            },
            confirm: {
                label: 'Excluir',
                className: 'btn-danger'
            }

        }
    });
}


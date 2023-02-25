function registerMot() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-register-drive'))

    // Verificação
    if (formData.get('pgMot') == '') {
        $('#pgMot').addClass('is-invalid');
        return false;
    } else {
        $('#pgMot').removeClass('is-invalid');
    }

    if (formData.get('nameMot') == '' || formData.get('nameMot').length > 200) {
        $('#nameMot').addClass('is-invalid');
        return false;
    } else {
        $('#nameMot').removeClass('is-invalid');
    }

    if (formData.get('catMot') == '') {
        $('#catMot').addClass('is-invalid');
        return false;
    } else {
        $('#catMot').removeClass('is-invalid');
    }

    if (formData.get('fullNameMot') == '' || formData.get('fullNameMot').length > 250) {
        $('#fullNameMot').addClass('is-invalid');
        return false;
    } else {
        $('#fullNameMot').removeClass('is-invalid');
    }

    if (formData.get('contactMot') == '' || formData.get('contactMot').length != 16) {
        $('#contactMot').addClass('is-invalid');
        return false;
    } else {
        $('#contactMot').removeClass('is-invalid');
    }

    if (formData.get('cnhMot') == '' || formData.get('cnhMot').length != 11) {
        $('#cnhMot').addClass('is-invalid');
        return false;
    } else {
        $('#cnhMot').removeClass('is-invalid');
    }

    if (formData.get('ValCnhMot') == '') {
        $('#ValCnhMot').addClass('is-invalid');
        return false;
    } else {
        $('#ValCnhMot').removeClass('is-invalid');
    }
    if (formData.get('idtMot') == '' || formData.get('idtMot').length != 13) {
        $('#idtMot').addClass('is-invalid');
        return false;
    } else {
        $('#idtMot').removeClass('is-invalid');
    }
    var values = {
        pgMot: formData.get('pgMot'),
        nameMot: formData.get('nameMot'),
        catMot: formData.get('catMot'),
        fullNameMot: formData.get('fullNameMot'),
        contactMot: formData.get('contactMot'),
        cnhMot: formData.get('cnhMot'),
        ValCnhMot: formData.get('ValCnhMot'),
        idtMot: formData.get('idtMot'),
        mopp: formData.get('mopp'),
        tc: formData.get('tc'),
        cve: formData.get('cve'),
        ci: formData.get('ci'),
    }

    const URL = '/register_mot'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {

            switch (data) {
                case 'idt':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Já existe um motorista com essa <strong>idt mil</strong>.'
                    });
                    $('#idtMot').addClass('is-invalid');
                    break;
                case 'cnh':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp   Já existe um motorista com essa <strong>CNH</strong>.'
                    });
                    $('#cnhMot').addClass('is-invalid')
                    break;

                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Motorisca cadastrado com sucesso.'
                    });

                    $('#register-drive').modal('hide');
                    $('#form-register-drive')[0].reset();
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

function editMot(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-edit-drive'))

    // Verificação
    if (formData.get('e_pgMot') == '') {
        $('#e_pgMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_pgMot').removeClass('is-invalid');
    }

    if (formData.get('e_nameMot') == '' || formData.get('e_nameMot').length > 200) {
        $('#e_nameMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_nameMot').removeClass('is-invalid');
    }

    if (formData.get('e_catMot') == '') {
        $('#e_catMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_catMot').removeClass('is-invalid');
    }

    if (formData.get('e_fullNameMot') == '' || formData.get('e_fullNameMot').length > 250) {
        $('#e_fullNameMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_fullNameMot').removeClass('is-invalid');
    }

    if (formData.get('e_contactMot') == '' || formData.get('e_contactMot').length != 16) {
        $('#e_contactMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_contactMot').removeClass('is-invalid');
    }

    if (formData.get('e_cnhMot') == '' || formData.get('e_cnhMot').length != 11) {
        $('#e_cnhMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_cnhMot').removeClass('is-invalid');
    }

    if (formData.get('e_ValCnhMot') == '') {
        $('#e_ValCnhMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_ValCnhMot').removeClass('is-invalid');
    }
    if (formData.get('e_idtMot') == '' || formData.get('e_idtMot').length != 13) {
        $('#e_idtMot').addClass('is-invalid');
        return false;
    } else {
        $('#e_idtMot').removeClass('is-invalid');
    }
    var values = {
        id_mot: formData.get('e_idMot'),
        pgMot: formData.get('e_pgMot'),
        nameMot: formData.get('e_nameMot'),
        catMot: formData.get('e_catMot'),
        fullNameMot: formData.get('e_fullNameMot'),
        contactMot: formData.get('e_contactMot'),
        cnhMot: formData.get('e_cnhMot'),
        ValCnhMot: formData.get('e_ValCnhMot'),
        idtMot: formData.get('e_idtMot'),
        mopp: formData.get('e_mopp'),
        tc: formData.get('e_tc'),
        cve: formData.get('e_cve'),
        ci: formData.get('e_ci'),
    }

    const URL = '/edit_mot'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {

            switch (data) {
                case 'idt':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Já existe um motorista com essa <strong> idt mil</strong>.'
                    });
                    $('#e_idtMot').addClass('is-invalid');
                    break;
                case 'cnh':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp   Já existe um motorista com essa <strong> CNH</strong>.'
                    });
                    $('#e_cnhMot').addClass('is-invalid')
                    break;

                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Motorisca cadastrado com sucesso.'
                    });

                    $('#edit-drive').modal('hide');
                    $('#form-edit-drive')[0].reset();
                    $('#e_mopp').removeAttr('checked');
                    $('#e_tc').removeAttr('checked');
                    $('#e_cve').removeAttr('checked');
                    $('#e_ci').removeAttr('checked');
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

function deleteMot(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir este militar?',
        message: '<strong>Essa operação não pode ser desfeita.</strong><br> Se ouver alguma ficha com este militar será finalizada!',
        callback: function (confirmacao) {

            if (confirmacao)
                $.ajax({
                    url: '/delete_mot/' + id,
                    type: "GET",
                    success: function (data) {
                        if (data == 'ficha') {
                            Toast.fire({
                                icon: 'warning',
                                title: '&nbsp&nbsp Este militar tem fichas abertas.'
                            });
                        } else {
                            Toast.fire({
                                icon: 'success',
                                title: '&nbsp&nbsp Militar excluído com sucesso.'
                            });
                            $("#table").DataTable().clear().draw();
                        }
                    },
                    error: function (data) {
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp&nbsp Erro ao excluir.'
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

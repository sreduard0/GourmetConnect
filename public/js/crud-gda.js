function selectVtrType(value) {
    // Mostrando data no campo
    $('#_hora').val(moment().format('DD-MM-YYYY HH:mm'))
    $('#hourSai').val(moment().format('DD-MM-YYYY HH:mm'))



    switch (value) {
        case 'civil':
            $('#veicle_type').val('civil')
            $("#f-civil").css("display", "block")
            $("#f-oom").css("display", "none")
            $("#f-om").css("display", "none")
            $("#register-vtrLabel").text("REGISTRO DE ENTRADA DE VEÍCULO CIVIL")
            break;
        case 'oom':
            $('#veicle_type').val('oom')
            $("#f-oom").css("display", "block")
            $("#f-civil").css("display", "none")
            $("#f-om").css("display", "none")
            $("#register-vtrLabel").text("REGISTRO DE ENTRADA DE VEÍCULO DE OUTRA OM")

            break;
        case 'adm':
        case 'op':
        case 'om':
            $('#veicle_type').val('om')
            $("#f-civil").css("display", "none")
            $("#f-oom").css("display", "none")
            $("#f-om").css("display", "block")
            $("#register-vtrLabel").text("REGISTRO DE SÁIDA DE VIATURA")

            break;
        default:
            $('#veicle_type').val('')
            $("#f-civil").css("display", "none")
            $("#f-oom").css("display", "none")
            $("#f-om").css("display", "none")
            $("#register-vtrLabel").text("REGISTRO DE VEÍCULO")

            break;
    }
}
function selectFichaRel(value) {
    var url = 'get_info_ficha/' + value
    $('#nrFichaRel').val(value)
    $.get(url, function (result) {
        $('#typeVtr').val(result.vtrinfo.type_vtr)
        // selectVtrType(result.vtrinfo.type_vtr)
        $('#vtrTypeRel').val(result.vtrinfo.type_vtr)
        $('#idMotRel').val(result.id_mot)
        $('#pgSegRel').val(result.pg_seg)
        $('#nameSegRel').val(result.name_seg)
        $('#modVtrRelDes').val(result.vtrinfo.mod_vtr)
        $('#modVtrRel').val(result.vtrinfo.mod_vtr)
        $('#ebPlacaRelDes').val(result.vtrinfo.ebplaca)
        $('#ebPlacaRel').val(result.vtrinfo.ebplaca)
        if (result.missioninfo) {
            $('#destinyRel').val(result.missioninfo.destiny + " | " + result.missioninfo.mission_name)
        } else {
            $('#destinyRel').val(result.nat_of_serv)

        }
    })
}

// REGISTRAR
function registerCivil() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-civil'))

    // Verificação
    if (formData.get('nameMotCivilRel') == '' || formData.get('nameMotCivilRel').length > 200) {
        $('#nameMotCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#nameMotCivilRel').removeClass('is-invalid');
    }

    if (formData.get('docCivilRel') == '' || formData.get('docCivilRel').length > 15) {
        $('#docCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#docCivilRel').removeClass('is-invalid');
    }

    if (formData.get('modVeiCivilRel') == '' || formData.get('modVeiCivilRel').length > 200) {
        $('#modVeiCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#docCivilRel').removeClass('is-invalid');
    }

    if (formData.get('placaCivilRel') == '' || formData.get('placaCivilRel').length > 15) {
        $('#placaCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#placaCivilRel').removeClass('is-invalid');
    }

    if (formData.get('qtdPassCivilRel') == '') {
        $('#qtdPassCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#qtdPassCivilRel').removeClass('is-invalid');
    }


    if (formData.get('destinyCivilRel') == '' || formData.get('destinyCivilRel').length > 15) {
        $('#destinyCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#destinyCivilRel').removeClass('is-invalid');
    }

    var values = {
        nameMot: formData.get('nameMotCivilRel'),
        doc: formData.get('docCivilRel'),
        modVtr: formData.get('modVeiCivilRel'),
        placaVtr: formData.get('placaCivilRel'),
        qtdPass: formData.get('qtdPassCivilRel'),
        destiny: formData.get('destinyCivilRel'),
        obs: formData.get('obsCivilRel'),
        hourEnt: $('#hourSai').val(),
        vtrType: $('#veicle_type').val()
    }

    const URL = '/register_relgda'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'veicle':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Este veículo já está registrado.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Veículo registrado.'
                    });
                    $('#register-vtr ').modal('hide');
                    selectVtrType('')
                    $('#form-civil')[0].reset();
                    $('#obsCivilRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    selectVtrType('')
                    contRel()
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });

}
function registerOom() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    const formData = new FormData(document.getElementById('form-oom'))


    if (formData.get('pgSegOomRel') == '') {
        $('#pgSegOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#pgSegOomRel').removeClass('is-invalid');
    }

    if (formData.get('nameSegOomRel') == '' || formData.get('nameSegOomRel').length > 200) {
        $('#nameSegOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#nameSegOomRel').removeClass('is-invalid');
    }

    if (formData.get('idtMilOomRel') == '' || formData.get('idtMilOomRel').length > 15) {
        $('#idtMilOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#idtMilOomRel').removeClass('is-invalid');
    }

    if (formData.get('modVtrOomRel') == '' || formData.get('modVtrOomRel').length > 200) {
        $('#modVtrOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#modVtrOomRel').removeClass('is-invalid');
    }

    if (formData.get('ebPlacaOomRel') == '' || formData.get('ebPlacaOomRel').length > 15) {
        $('#ebPlacaOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#ebPlacaOomRel').removeClass('is-invalid');
    }

    if (formData.get('omOomRel') == '' || formData.get('omOomRel').length > 15) {
        $('#omOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#omOomRel').removeClass('is-invalid');
    }

    if (formData.get('destinyOomRel') == '' || formData.get('destinyOomRel').length > 200) {
        $('#destinyOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#destinyOomRel').removeClass('is-invalid');
    }

    var values = {
        pgMot: formData.get('pgMotOomRel'),
        nameMot: formData.get('nameMotOomRel'),
        pgSeg: formData.get('pgSegOomRel'),
        nameSeg: formData.get('nameSegOomRel'),
        idtMil: formData.get('idtMilOomRel'),
        modVtr: formData.get('modVtrOomRel'),
        ebPlaca: formData.get('ebPlacaOomRel'),
        om: formData.get('omOomRel'),
        destiny: formData.get('destinyOomRel'),
        obs: formData.get('obsOomRel'),
        hourEnt: $('#hourSai').val(),
        vtrType: $('#veicle_type').val()
    }

    const URL = '/register_relgda'

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
                        title: '&nbsp&nbsp Esta viatura já está registrada.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Viatura de outra OM registrada.'
                    });
                    $('#register-vtr ').modal('hide');
                    $('#form-oom')[0].reset();
                    $('#obsOomRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    selectVtrType('')
                    contRel()


                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });
}
function registerOm() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-om'))

    // Verificação
    if (formData.get('nrFichaRel') == '') {
        $('#nrFichaRel').addClass('is-invalid');
        return false;
    } else {
        $('#nrFichaRel').removeClass('is-invalid');
    }

    if (formData.get('idMotRel') == '') {
        $('#idMotRel').addClass('is-invalid');
        return false;
    } else {
        $('#idMotRel').removeClass('is-invalid');
    }

    if (formData.get('pgSegRel') == '') {
        $('#pgSegRel').css('border', '1px solid #dc3545');
        $('#nameSegRel').addClass('is-invalid');
        return false;
    } else {
        $('#pgSegRel').removeAttr("style");
        $('#nameSegRel').removeClass('is-invalid');
    }

    if (formData.get('nameSegRel') == '' || formData.get('nameSegRel').length > 200) {
        $('#pgSegRel').css('border', '1px solid #dc3545');
        $('#nameSegRel').addClass('is-invalid');
        return false;
    } else {
        $('#pgSegRel').removeAttr("style");
        $('#nameSegRel').removeClass('is-invalid');
    }

    if (formData.get('modVtrRel') == '' || formData.get('modVtrRel').length > 200) {
        $('#modVtrRel').addClass('is-invalid');
        return false;
    } else {
        $('#modVtrRel').removeClass('is-invalid');
    }

    if (formData.get('ebPlacaRel') == '' || formData.get('ebPlacaRel').length > 15) {
        $('#ebPlacaRel').addClass('is-invalid');
        return false;
    } else {
        $('#ebPlacaRel').removeClass('is-invalid');
    }

    if (formData.get('odSaiRel') == '' || formData.get('odSaiRel').length > 150) {
        $('#odSaiRel').addClass('is-invalid');
        return false;
    } else {
        $('#odSaiRel').removeClass('is-invalid');
    }

    if (formData.get('destinyRel') == '' || formData.get('destinyRel').length > 150) {
        $('#destinyRel').addClass('is-invalid');
        return false;
    } else {
        $('#destinyRel').removeClass('is-invalid');
    }

    var values = {
        nrFicha: formData.get('nrFichaRel'),
        idMot: formData.get('idMotRel'),
        pgSeg: formData.get('pgSegRel'),
        nameSeg: formData.get('nameSegRel'),
        modVtr: formData.get('modVtrRel'),
        ebPlaca: formData.get('ebPlacaRel'),
        odSai: formData.get('odSaiRel'),
        destiny: formData.get('destinyRel'),
        obs: formData.get('obsRel'),
        vtrType: $('#vtrTypeRel').val(),
        hourSai: $('#hourSai').val(),
    }

    const URL = '/register_relgda'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'ficha':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Esta viatura já está registrada.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Saída de viatura registrada.'
                    });
                    $('#register-vtr ').modal('hide');
                    $('#form-om')[0].reset();
                    $('#obsRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    selectVtrType('')
                    contRel()


                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });
}

function registerVtr() {
    switch ($('#veicle_type').val()) {
        case 'civil':
            registerCivil()
            break;
        case 'oom':
            registerOom()
            break;
        case 'om':
            registerOm()
            break;
        default:
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            Toast.fire({
                icon: 'warning',
                title: '&nbsp&nbsp Selecione um tipo de viatura.'
            });
            break;
    }
}

// FECHAR
function closeRegisterModal(id, vtr) {
    $('#close-register-modal').modal('show')
    // Mostrando data no campo
    $('#ent_hora').val(moment().format('DD-MM-YYYY HH:mm'))
    $('#hourEnt').val(moment().format('DD-MM-YYYY HH:mm'))
    $('#idResgister').val(id)
    $('#vtr').val(vtr)
    if (vtr == 'civil' || vtr == 'oom') {
        $('.od').addClass('d-none');
    } else {
        $('.od').removeClass('d-none');
        $('.obs').removeClass('d-none');

    }

}
function closeRegister() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-reg-close'))

    // Verificação
    if (formData.get('hourEnt') == '') {
        $('#ent_hora').addClass('is-invalid');
        return false;
    } else {
        $('#ent_hora').removeClass('is-invalid');
    }

    if (formData.get('idResgister') == '' || formData.get('vtr') == '') {
        Toast.fire({
            icon: 'warning',
            title: '&nbsp&nbsp Erro ao encontrar registro'
        });
        return false;
    }

    if (formData.get('vtr') == 'adm' || formData.get('vtr') == 'op') {
        if (formData.get('odEntRel') == '' || formData.get('odEntRel').length > 150) {
            $('#odEntRel').addClass('is-invalid');
            return false;
        } else {
            $('#odEntRel').removeClass('is-invalid');
        }
    }

    var values = {
        od: formData.get('odEntRel'),
        hour: formData.get('hourEnt'),
        id_rel: formData.get('idResgister'),
        vtrType: formData.get('vtr'),
        obs: formData.get('obsFinish')
    }

    const URL = '/close_relgda'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'erro':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Este registro não existe.'
                    });
                    break;
                case 'fin':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Este registro já está finalizado.'
                    });
                    break;
                case 'od':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Odômetro menor que o anterior.'
                    });
                    break;
                default:
                    const km = data ? '<br> Viatura andou ' + data + ' Km(s)' : ''
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Finalizado com sucesso.' + km
                    });
                    $('#close-register-modal').modal('hide');
                    $('#form-reg-close')[0].reset();
                    $("#table").DataTable().clear().draw();
                    contRel()

                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}

// EXCLUIR
function deleteRelGda(id) {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir este registro?',
        message: '<strong>Essa operação não pode ser desfeita.</strong>',
        callback: function (confirmacao) {

            if (confirmacao)
                $.ajax({
                    url: '/deleterelgda/' + id,
                    type: "GET",
                    success: function (data) {
                        $("#table").DataTable().clear().draw();
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp&nbsp Registro excluido com sucesso.'
                        });
                        $("#table").DataTable().clear().draw();


                    },
                    error: function (data) {
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp&nbsp Erro ao fechar.'
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

// EDITAR REGISTRO
function selectEditVtrType(id) {
    // Mostrando data no campo
    var url = "/get_info_register/" + id;
    $.get(url, function (result) {
        $('#idEditRegister').val(result.id)
        $('#editTypeVtr').val(result.type_veicle)

        switch (result.type_veicle) {
            case 'op':
            case 'adm':
                $('#e_dateEntRel').val(result.hour_ent ? moment(result.hour_ent).format('DD-MM-YYYY HH:mm') : '')
                $('#e_dateSaiRel').val(moment(result.hour_sai).format('DD-MM-YYYY HH:mm'))
                $('#e_odEntRel').val(result.od_ent)
                $('#e_odSaiRel').val(result.od_sai)
                $('#e_nrFichaRel').val(result.id_ficha)
                $('#e_typeVtr').val(result.type_veicle)
                $('#e_idMotRel').val(result.id_mot)
                $('#e_pgSegRel').val(result.pg_seg)
                $('#e_nameSegRel').val(result.name_seg)
                $('#e_modVtrRel').val(result.mod_veicle)
                $('#e_ebPlacaRel').val(result.placaeb)
                $('#e_destinyRel').val(result.destiny)
                $('#e_obsRel').summernote('code', result.obs)

                $("#e-f-om").css("display", "block")
                $("#e-f-oom").css("display", "none")
                $("#e-f-civil").css("display", "none")
                break;
            case 'oom':
                $('#e_dateSaiOomRel').val(result.hour_sai ? moment(result.hour_sai).format('DD-MM-YYYY HH:mm') : '')
                $('#e_dateEntOomRel').val(moment(result.hour_ent).format('DD-MM-YYYY HH:mm'))
                $('#e_pgMotOomRel').val(result.pg_mot)
                $('#e_nameMotOomRel').val(result.name_mot)
                $('#e_pgSegOomRel').val(result.pg_seg)
                $('#e_nameSegOomRel').val(result.name_seg)
                $('#e_idtMilOomRel').val(result.idt)
                $('#e_modVtrOomRel').val(result.mod_veicle)
                $('#e_ebPlacaOomRel').val(result.placaeb)
                $('#e_omOomRel').val(result.om)
                $('#e_destinyOomRel').val(result.destiny)
                $('#e_obsOomRel').summernote('code', result.obs)

                $("#e-f-om").css("display", "none")
                $("#e-f-oom").css("display", "block")
                $("#e-f-civil").css("display", "none")
                break;
            case 'civil':
                $('#e_nameMotCivilRel').val(result.name_mot)
                $('#e_docCivilRel').val(result.idt)
                $('#e_modVeiCivilRel').val(result.mod_veicle)
                $('#e_placaCivilRel').val(result.placaeb)
                $('#e_qtdPassCivilRel').val(result.passengers)
                $('#e_destinyCivilRel').val(result.destiny)
                $('#e_obsCivilRel').summernote('code', result.obs)
                $('#e_dateEntCivilRel').val(moment(result.hour_ent).format('DD-MM-YYYY HH:mm'))
                result.hour_sai ? $('#e_dateSaiCivilRel').val(moment(result.hour_sai).format('DD-MM-YYYY HH:mm')) : ''

                $("#e-f-om").css("display", "none")
                $("#e-f-oom").css("display", "none")
                $("#e-f-civil").css("display", "block")
                break;
        }
    })
    $('#edit-register-gda').modal('show')

}
function EditRegisterCivil() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('e-form-civil'))

    // Verificação
    if (formData.get('e_dateEntCivilRel') == '' || formData.get('e_dateEntCivilRel').length > 200) {
        $('#e_dateEntCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_dateEntCivilRel').removeClass('is-invalid');
    }
    if (formData.get('e_nameMotCivilRel') == '' || formData.get('e_nameMotCivilRel').length > 200) {
        $('#e_nameMotCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_nameMotCivilRel').removeClass('is-invalid');
    }

    if (formData.get('e_docCivilRel') == '' || formData.get('e_docCivilRel').length > 15) {
        $('#e_docCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_docCivilRel').removeClass('is-invalid');
    }

    if (formData.get('e_modVeiCivilRel') == '' || formData.get('e_modVeiCivilRel').length > 200) {
        $('#e_modVeiCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_modVeiCivilRel').removeClass('is-invalid');
    }

    if (formData.get('e_placaCivilRel') == '' || formData.get('e_placaCivilRel').length > 15) {
        $('#e_placaCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_placaCivilRel').removeClass('is-invalid');
    }

    if (formData.get('e_qtdPassCivilRel') == '') {
        $('#e_qtdPassCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_qtdPassCivilRel').removeClass('is-invalid');
    }


    if (formData.get('e_destinyCivilRel') == '' || formData.get('e_destinyCivilRel').length > 15) {
        $('#e_destinyCivilRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_destinyCivilRel').removeClass('is-invalid');
    }

    var values = {
        dateEnt: formData.get('e_dateEntCivilRel'),
        dateSai: formData.get('e_dateSaiCivilRel'),
        nameMot: formData.get('e_nameMotCivilRel'),
        doc: formData.get('e_docCivilRel'),
        modVtr: formData.get('e_modVeiCivilRel'),
        placaVtr: formData.get('e_placaCivilRel'),
        qtdPass: formData.get('e_qtdPassCivilRel'),
        destiny: formData.get('e_destinyCivilRel'),
        obs: formData.get('e_obsCivilRel'),
        vtrType: $('#editTypeVtr').val(),
        id: $('#idEditRegister').val(),
    }

    const URL = '/edit_relgda'


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
                        title: '&nbsp&nbsp Este veículo já está registrado.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo com sucesso.'
                    });
                    $('#edit-register-gda').modal('hide');
                    $('#e-form-civil')[0].reset();
                    $('#e_obsCivilRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });

}
function EditRegisterOom() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    const formData = new FormData(document.getElementById('e-form-oom'))


    if (formData.get('e_dateEntOomRel') == '') {
        $('#e_dateEntOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_dateEntOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_pgMotOomRel') == '') {
        $('#e_pgMotOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_pgMotOomRel').removeClass('is-invalid');
    }
    if (formData.get('e_nameMotOomRel') == '') {
        $('#e_nameMotOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_nameMotOomRel').removeClass('is-invalid');
    }
    if (formData.get('e_pgSegOomRel') == '') {
        $('#e_pgSegOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_pgSegOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_nameSegOomRel') == '' || formData.get('e_nameSegOomRel').length > 200) {
        $('#e_nameSegOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_nameSegOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_idtMilOomRel') == '' || formData.get('e_idtMilOomRel').length != 13) {
        $('#e_idtMilOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_idtMilOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_modVtrOomRel') == '' || formData.get('e_modVtrOomRel').length > 200) {
        $('#e_modVtrOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_modVtrOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_ebPlacaOomRel') == '' || formData.get('e_ebPlacaOomRel').length > 15) {
        $('#e_ebPlacaOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_ebPlacaOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_omOomRel') == '' || formData.get('e_omOomRel').length > 15) {
        $('#e_omOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_omOomRel').removeClass('is-invalid');
    }

    if (formData.get('e_destinyOomRel') == '' || formData.get('e_destinyOomRel').length > 200) {
        $('#e_destinyOomRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_destinyOomRel').removeClass('is-invalid');
    }

    var values = {
        dateEnt: formData.get('e_dateEntOomRel'),
        dateSai: formData.get('e_dateSaiOomRel'),
        pgMot: formData.get('e_pgMotOomRel'),
        nameMot: formData.get('e_nameMotOomRel'),
        pgSeg: formData.get('e_pgSegOomRel'),
        nameSeg: formData.get('e_nameSegOomRel'),
        idtMil: formData.get('e_idtMilOomRel'),
        modVtr: formData.get('e_modVtrOomRel'),
        ebPlaca: formData.get('e_ebPlacaOomRel'),
        om: formData.get('e_omOomRel'),
        destiny: formData.get('e_destinyOomRel'),
        obs: formData.get('e_obsOomRel'),
        vtrType: $('#editTypeVtr').val(),
        id: $('#idEditRegister').val(),

    }

    const URL = '/edit_relgda'


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
                        title: '&nbsp&nbsp Esta viatura já está registrada.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo com sucesso.'
                    });
                    $('#edit-register-gda').modal('hide');
                    $('#e-form-oom')[0].reset();
                    $('#e_obsOomRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });
}
function EditRegisterOm() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('e-form-om'))


    if (formData.get('e_dateSaiRel') == '') {
        $('#e_dateSaiRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_dateSaiRel').removeClass('is-invalid');
    }



    if (formData.get('e_odSaiRel') == '') {
        $('#e_odSaiRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_odSaiRel').removeClass('is-invalid');
    }


    if (formData.get('e_idMotRel') == '') {
        $('#e_idMotRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_idMotRel').removeClass('is-invalid');
    }

    if (formData.get('e_pgSegRel') == '') {
        $('#e_pgSegRel').css('border', '1px solid #dc3545');
        $('#e_nameSegRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_pgSegRel').removeAttr("style");
        $('#e_nameSegRel').removeClass('is-invalid');
    }

    if (formData.get('e_nameSegRel') == '' || formData.get('e_nameSegRel').length > 200) {
        $('#e_pgSegRel').css('border', '1px solid #dc3545');
        $('#e_nameSegRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_pgSegRel').removeAttr("style");
        $('#e_nameSegRel').removeClass('is-invalid');
    }

    if (formData.get('e_odSaiRel') == '' || formData.get('e_odSaiRel').length > 150) {
        $('#e_odSaiRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_odSaiRel').removeClass('is-invalid');
    }

    if (formData.get('e_destinyRel') == '' || formData.get('e_destinyRel').length > 150) {
        $('#e_destinyRel').addClass('is-invalid');
        return false;
    } else {
        $('#e_destinyRel').removeClass('is-invalid');
    }

    var values = {
        dateEnt: formData.get('e_dateEntRel'),
        dateSai: formData.get('e_dateSaiRel'),
        odEnt: formData.get('e_odEntRel'),
        odSai: formData.get('e_odSaiRel'),
        idMot: formData.get('e_idMotRel'),
        pgSeg: formData.get('e_pgSegRel'),
        nameSeg: formData.get('e_nameSegRel'),
        destiny: formData.get('e_destinyRel'),
        obs: formData.get('e_obsRel'),
        vtrType: $('#editTypeVtr').val(),
        id: $('#idEditRegister').val(),
    }


    const URL = '/edit_relgda'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'od':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Odômetro menor que o anterior.'
                    });
                    break;
                case 'enc':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp Este registro esta fechado.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo com sucesso.'
                    })
                    $('#edit-register-gda').modal('hide');
                    $('#e-form-om')[0].reset();
                    $('#e_obsRel').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao registrar.'
            });
        }
    });
}

function EditRegisterVtr() {
    switch ($('#editTypeVtr').val()) {
        case 'civil':
            EditRegisterCivil()
            break;
        case 'oom':
            EditRegisterOom()
            break;
        case 'op':
        case 'adm':
            EditRegisterOm()
            break;
        default:
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            Toast.fire({
                icon: 'warning',
                title: '&nbsp&nbsp Nenhum registro escolhido.'
            });
            break;
    }
}







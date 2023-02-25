function selectFichaRel(value) {
    if (value) {
        var url = 'get_info_ficha/' + value
        $.get(url, function (result) {
            $('#driver').val(result.motinfo.pg + ' ' + result.motinfo.name)
            $('#in_order').val(result.in_order)
            if (result.missioninfo) {
                $('#mission').val(result.missioninfo.mission_name)
            } else {
                $('#mission').val(result.nat_of_serv)
            }
            $('#vtr').val(result.vtrinfo.ebplaca + '|' + result.vtrinfo.mod_vtr)
            $('#fuelType').val(result.vtrinfo.fuel ? result.vtrinfo.fuel : 'Não especificado')
            if (result.missioninfo) {
                $('#destiny').val(result.missioninfo.destiny)
            }
        })
    } else {
        $('#form-request-fuel')[0].reset();
        $('#obs').summernote('code', '');
    }
}

function requestFuel() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-request-fuel'))

    // Verificação
    if (formData.get('id_ficha') == '') {
        $('#id_ficha').addClass('is-invalid');
        return false;
    } else {
        $('#id_ficha').removeClass('is-invalid');
    }
    if (formData.get('od') == '') {
        $('#od').addClass('is-invalid');
        return false;
    } else {
        $('#od').removeClass('is-invalid');
    }
    if (formData.get('destiny') == '') {
        $('#destiny').addClass('is-invalid');
        return false;
    } else {
        $('#destiny').removeClass('is-invalid');
    }



    var values = {
        id_ficha: formData.get('id_ficha'),
        od: formData.get('od'),
        destiny: formData.get('destiny'),
        obs: formData.get('obs'),
    }

    const URL = '/request_fuel'

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
                        title: '&nbsp&nbsp Ja há uma solicitação de combustível para esta ficha.'
                    });
                    break;
                default:
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Solicitação enviada.'
                    });
                    $('#request-fuel').modal('hide');
                    $('#form-request-fuel')[0].reset();
                    $('#obs').summernote('code', '');
                    $("#table").DataTable().clear().draw();
                    break;
            }
        },

        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro ao solicitar.'
            });
        }
    });

}

function authorize(id, action) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('#info-request-fuel').modal('hide');

    if (action == 1) {
        bootbox.confirm({
            title: ' Deseja autorizar esta abastecimento?',
            message: ' <strong style="color:red">Essa operação não pode ser desfeita.</strong><br><br><div div class= "row" ><div class="od form-group col"><label for="code_sec_autorized">Código de segurança <span style="color:red">*</span></label> <div class="input-group"> <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div> <input type="text" class="form-control" id="code_sec_autorized" name="code_sec_autorized" placeholder="Ex: B58CB"> </div> </div></div><div class="row"> <div class="form-group col"><label for="qtd_fuel_autorized">Quantidade liberada <span style="color:red">*</span></label> <div class="od input-group"> <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-gas-pump"></i></span></div> <input type="text" class="form-control" id="qtd_fuel_autorized" name="qtd_fuel_autorized" data-inputmask="\'mask\':\'9999999\'" data-mask="" inputmode="text" placeholder="Ex: 60"> </div> </div> </div> <div class="obs row">  <div class="form-group col"><label for="obs_fiscadm_autorized">Observações</label> <textarea name="obs_fiscadm_autorized" id="obs_fiscadm_autorized" rows="8" placeholder="Ex: Solicito pronto do abastecimento." class=" text form-control"></textarea> </div>  </div>',
            callback: function (confirmacao) {

                if (confirmacao) {
                    var values = {
                        id: id,
                        action: 1,
                        qtdAutorized: $('#qtd_fuel_autorized').val(),
                        code: $('#code_sec_autorized').val(),
                        obs: $('#obs_fiscadm_autorized').val(),
                    }
                    // Verificação
                    if (values.code == '') {
                        $('#code_sec_autorized').addClass('is-invalid');
                        return false;
                    } else {
                        $('#code_sec_autorized').removeClass('is-invalid');
                    }

                    if (values.qtdAutorized == '' || $.isNumeric(values.qtdAutorized) == false) {
                        $('#qtd_fuel_autorized').addClass('is-invalid');
                        return false;
                    } else {
                        $('#qtd_fuel_autorized').removeClass('is-invalid');
                    }


                    var URL = '/action_request_fuel'
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: URL,
                        type: 'POST',
                        data: values,
                        dataType: 'text',
                        success: function (data) {
                            switch (data) {
                                case 'response':
                                    Toast.fire({
                                        icon: 'warning',
                                        title: '&nbsp&nbsp Esta solicitação já foi respondida.'
                                    });
                                    break;
                                default:
                                    Toast.fire({
                                        icon: 'success',
                                        title: '&nbsp&nbsp Solicitação autorizada com sucesso.'
                                    });
                                    $('code_sec_autorized').val('');
                                    $('qtd_fuel_utorized').val('');
                                    $('#obs_fiscadm_autorized').summernote('code', '');
                                    $("#table").DataTable().clear().draw();
                                    break;
                            }
                        },

                        error: function (data) {
                            Toast.fire({
                                icon: 'error',
                                title: '&nbsp&nbsp Erro ao autorizar.'
                            });
                        }
                    });
                }

            },
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-danger'
                },
                confirm: {
                    label: 'Confirmar',
                    className: 'btn-success'
                }

            }
        });

    }
    if (action == 2) {
        bootbox.confirm({
            title: ' Deseja negar esta solicitação de abastecimento?',
            message: '<strong>Essa operação não pode ser desfeita.</strong><br><br><p>O militar podera solicitar novamente combustivel para esta ficha.</p>',
            callback: function (confirmacao) {

                if (confirmacao) {
                    var values = {
                        id: id,
                        action: 2,
                        qtdAutorized: null,
                        code: null,
                        obs: null,
                    }
                    var URL = '/action_request_fuel'
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: URL,
                        type: 'POST',
                        data: values,
                        dataType: 'text',
                        success: function (data) {
                            switch (data) {
                                case 'response':
                                    Toast.fire({
                                        icon: 'warning',
                                        title: '&nbsp&nbsp Esta solicitação já foi respondida.'
                                    });
                                    break;
                                default:
                                    Toast.fire({
                                        icon: 'success',
                                        title: '&nbsp&nbsp Solicitação negada com sucesso.'
                                    });
                                    $("#table").DataTable().clear().draw();
                                    break;
                            }
                        },

                        error: function (data) {
                            Toast.fire({
                                icon: 'error',
                                title: '&nbsp&nbsp Erro ao negar.'
                            });
                        }
                    });
                }

            },
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-default'
                },
                confirm: {
                    label: 'Confirmar',
                    className: 'btn-danger'
                }

            }
        });

    }
}

function finishRequestFuel(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('#info-request-fuel').modal('hide');

    bootbox.confirm({
        title: 'Concluir abastecimento?',
        message: '<strong>Essa operação não pode ser desfeita.</strong><br><br><p>Ao finalizar este abastecimento o status mudará para <strong>"abastecido"</strong>.</p>',
        callback: function (confirmacao) {

            if (confirmacao) {

                var data = {
                    action: 1,
                    id: id
                }
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '/finish_request_fuel',
                    type: 'POST',
                    data: data,
                    dataType: 'text',
                    success: function (data) {
                        switch (data) {
                            case 'response':
                                Toast.fire({
                                    icon: 'warning',
                                    title: '&nbsp&nbsp Esta solicitação já foi respondida.'
                                });
                                break;
                            default:
                                Toast.fire({
                                    icon: 'success',
                                    title: '&nbsp&nbsp Abastecimento concluido.'
                                });
                                $("#table").DataTable().clear().draw();
                                break;
                        }
                    },

                    error: function (data) {
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp&nbsp Erro.'
                        });
                    }
                });
            }

        },
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            },
            confirm: {
                label: 'Confirmar',
                className: 'btn-success'
            }

        }
    });

}

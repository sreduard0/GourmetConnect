function sendEmail(id, ass) {
    bootbox.prompt({
        title: 'Digite o email que deseja receber o relatório.',
        centerVertical: true,
        inputType: 'email',
        callback: function (result) {
            if (result) {
                $.get("/relatorio/send/email/" + id + "/" + result + "/" + ass, function () {

                })
            }
        },
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'd-none'
            },
            confirm: {
                label: 'Enviar',
                className: 'btn-success'
            }

        }
    });
}
function saveReport() {
    const formData = new FormData(document.getElementById('form-report'))

    // Verificação
    if (formData.get('dateFinish') == '') {
        $('#dateFinish').addClass('is-invalid');
        return false;
    } else {
        $('#dateFinish').removeClass('is-invalid');
    }

    if (formData.get('kiloGram') == '') {
        $('#kiloGram').addClass('is-invalid');
        return false;
    } else {
        $('#kiloGram').removeClass('is-invalid');
    }

    if (formData.get('metersCub') == '') {
        $('#metersCub').addClass('is-invalid');
        return false;
    } else {
        $('#metersCub').removeClass('is-invalid');
    }

    if (formData.get('consGas') == '') {
        $('#consGas').addClass('is-invalid');
        return false;
    } else {
        $('#consGas').removeClass('is-invalid');
    }

    if (formData.get('consDiesel') == '') {
        $('#consDiesel').addClass('is-invalid');
        return false;
    } else {
        $('#consDiesel').removeClass('is-invalid');
    }

    if (formData.get('altMission') == '') {
        $('#altMission').addClass('is-invalid');
        return false;
    } else {
        $('#altMission').removeClass('is-invalid');
    }

    if ($('#sendReport').val() == '') {
        2
        $('#sendReport').addClass('is-invalid');
        return false;
    } else {
        $('#sendReport').removeClass('is-invalid');
    }

    if ($('#sendReport').val() >= 1) {
        if ($('#pg').val() == '') {
            2
            $('#pg').addClass('is-invalid');
            return false;
        } else {
            $('#pg').removeClass('is-invalid');
        }

        if ($('#fullName').val() == '') {
            2
            $('#fullName').addClass('is-invalid');
            return false;
        } else {
            $('#fullName').removeClass('is-invalid');
        }
    }


    var values = {
        id: formData.get('id_mission'),
        dateFinish: formData.get('dateFinish'),
        kiloGram: formData.get('kiloGram').replace(/_/g, ''),
        metersCub: formData.get('metersCub').replace(/_/g, ''),
        consGas: formData.get('consGas').replace(/_/g, ''),
        consDiesel: formData.get('consDiesel').replace(/_/g, ''),
        altMission: formData.get('altMission'),
        obsMission: formData.get('obsMission'),
        sendReport: $('#sendReport').val(),

    }
    var fullname = $('#fullName').val().toUpperCase() + ' - ' + $('#pg').val()
    const URL = '/save_report_cmt_mission'
    var msg = { 0: 'Você optou por não receber nenhum relatório desta missão.', 1: 'Você optou por receber via Email o relatório desta missão.', 2: 'Você optou por receber via WhatsApp o relatório desta missão.', 3: 'Você optou por imprimir o relatório desta missão.' }
    bootbox.confirm({
        title: 'Deseja salvar este relatório de missão?',
        message: '<strong>Após salvar você não poderá editar os dados preenchidos.</strong><br>' + msg[values.sendReport],
        callback: function (confirmacao) {
            if (confirmacao) {
                $('#form').addClass('d-none')
                $("#send-loading").addClass('loading').append('<div class="load-block border-s"><div class="c-loader"></div></div>')
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: URL,
                    type: 'POST',
                    data: values,
                    dataType: 'text',
                    success: function (result) {
                        $("#send-loading").addClass('loading').append('<div class="load-block border-s"><i class="fs-50 fa fa-check"></i></div>')
                        setTimeout(() => {
                            $('#dateFinMission').text(formData.get('dateFinish'))
                            $('#kg').text(formData.get('kiloGram').replace(/_/g, '') + ' Kg')
                            $('#m3').text(formData.get('metersCub').replace(/_/g, '') + ' m')
                            $('#conGas').text(formData.get('consGas').replace(/_/g, '') + ' L')
                            $('#conDiesel').text(formData.get('consDiesel').replace(/_/g, '') + ' L')
                            $('#alt').text(formData.get('altMission') == 1 ? "Sim " : "Não")
                            $('#obs').html(formData.get('obsMission') ? formData.get('obsMission') : 'Sem observações')
                            $('#panelInfoCon').removeClass('d-none')
                            $("#send-loading").remove()
                            $('#form').remove()
                            if (values.sendReport == 1) {
                                return sendEmail(values.id, fullname);
                            }
                            if (values.sendReport == 3) {
                                return window.open('/relatorio/print/' + values.id + '/true/' + fullname, '', 'height=700, width=700');
                            }
                        }, 1200);

                    },

                    error: function (data) {
                        $("#send-loading").append('<div class="load-block border-r"><i class="text-danger fs-60 fa fa-times"></i></div>')
                        setTimeout(() => {
                            $("#send-loading").addClass('d-none')
                            $('#form').removeClass('d-none')
                        }, 1500);

                    }
                })
            }
        },
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            },
            confirm: {
                label: 'Salvar',
                className: 'btn-success'
            }

        }
    });

}

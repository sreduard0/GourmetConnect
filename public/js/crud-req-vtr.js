function requestVtr() {

    const formData = new FormData(document.getElementById('requestVtr'))

    // Verificação
    if (formData.get('rank') == '') {
        $('#rank').addClass('error');
        return false;
    } else {
        $('#rank').removeClass('error');
    }
    if (formData.get('professional_name') == '' || formData.get('professional_name').length > 200) {
        $('#professional_name').addClass('error');
        return false;
    } else {
        $('#professional_name').removeClass('error');
    }
    if (formData.get('mission') == '' || formData.get('mission').length > 200) {
        $('#mission').addClass('error');
        return false;
    } else {
        $('#mission').removeClass('error');
    }
    if (formData.get('destiny') == '' || formData.get('destiny').length > 20) {
        $('#destiny').addClass('error');
        return false;
    } else {
        $('#destiny').removeClass('error');
    }
    if (formData.get('date_part') == '') {
        $('#date_part').addClass('error');
        return false;
    } else {
        $('#date_part').removeClass('error');
    }
    if (formData.get('phone') == '' || formData.get('phone').length > 17) {
        $('#phone').addClass('error');
        return false;
    } else {
        $('#phone').removeClass('error');
    }
    if (formData.get('qtd_mil') == '') {
        $('#qtd_mil').addClass('error');
        return false;
    } else {
        $('#qtd_mil').removeClass('error');
    }

    var values = {
        rank: formData.get('rank'),
        name: formData.get('professional_name'),
        mission: formData.get('mission'),
        destiny: formData.get('destiny'),
        date_part: formData.get('date_part'),
        contact: formData.get('phone'),
        qtd_mil: formData.get('qtd_mil'),
        obs: formData.get('obs'),
    }


    $("#loading-request").addClass('loading-request').html('<div class="c-loader"></div>')
    const URL = '/request_vtr'

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            if (data == 'success') {
                setTimeout(function () {
                    $("#loading-request").html('<div><div class= "row" ><i class="fs-60 fa fa-check" style="color:#00664d; margin: 0% 45% 0% 45%;"></i></div ><div class="row"><span class="c-w">Sua solicitação enviada com sucesso, aguarde o contato da Seção de Transporte.</span></div></div >')
                }, 1000);
            } else {
                $("#loading-request").html('<div><div class= "row" ><i class="fs-50 fa fa-times text-danger" style="margin: 0% 45% 0% 45%;"></i></div ><div class="row"><span class="c-w">Ouve algum erro em sua solicitação, tente novamente.</span></div></div >')
            }

        },

        error: function (data) {
            $("#loading-request").html('<div><div class= "row" ><i class="fs-50 fa fa-times text-danger" style="margin: 0% 45% 0% 45%;"></i></div ><div class="row"><span class="c-w">Ouve algum erro em sua solicitação, tente novamente.</span></div></div >')
        }
    });
}

function denyReqVtr(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $.get('/obs_req_vtr/' + id, function (result) {
        bootbox.confirm({
            title: 'Negar esta solicitação de viatura?',
            message: '<strong class="text-danger">Essa operação não pode ser desfeita.</strong><br> O militar pode solicitar novamente se for necessário.<br><br><strong>Observações do solicitante:</strong><br>' + result.obs,
            callback: function (confirmacao) {

                if (confirmacao) {
                    $.ajax({
                        url: '/req_vtr_action/deny/' + id,
                        type: "GET",
                        success: function (data) {
                            Toast.fire({
                                icon: 'error',
                                title: '&nbsp&nbsp Solicitação foi negada com sucesso.'
                            });
                            $("#table").DataTable().clear().draw();
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
                    label: 'Negar',
                    className: 'btn-danger'
                }

            }
        });
    })

}
function aceptReqVtr(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $.get('/obs_req_vtr/' + id, function (result) {
        var obs = result.obs ? '<br><br><strong>Observações do solicitante:</strong><br>' + result.obs : ''
        bootbox.confirm({
            title: 'Aceitar esta solicitação de viatura?',
            message: '<strong class="text-danger">Essa operação não pode ser desfeita.</strong><br> Ao aceitar esta solicitação será gerada uma missão OM.' + obs,
            callback: function (confirmacao) {

                if (confirmacao) {
                    $.ajax({
                        url: '/req_vtr_action/acept/' + id,
                        type: "GET",
                        success: function (data) {
                            Toast.fire({
                                icon: 'success',
                                title: '&nbsp&nbsp Solicitação aceita com sucesso.'
                            });
                            $("#table").DataTable().clear().draw();
                        },
                        error: function (data) {
                            Toast.fire({
                                icon: 'error',
                                title: '&nbsp&nbsp Erro ao aceitar.'
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
                    label: 'Aceitar',
                    className: 'btn-success'
                }

            }
        });
    })
}


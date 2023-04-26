
/*==================================================================
[ Focus input ]*/
$('.input100').each(function () {
    $(this).on('blur', function () {
        if ($(this).val().trim() != "") {
            $(this).addClass('has-val');
        }
        else {
            $(this).removeClass('has-val');
        }
    })
})
/*==================================================================
[ Validate ]*/
var input = $('.validate-input .input100');

$('#btn-submit-form').on('click', function () {
    var check = true;
    for (var i = 0; i < input.length; i++) {
        if (validate(input[i]) == false) {
            showValidate(input[i]);
            check = false;
        }
    }
    if (check) {
        let submit = bootbox.dialog({
            message: '<p class="text-center"><i class="fs-40 fa-duotone fa-burger-soda fa-flip"></i></p><p class="text-center">Verificando email e senha.<br> Se tudo estiver correto você receberá em seu email um código de verificação.</p>',
            className: 'modal-check-login',
            centerVertical: true,
            closeButton: false
        });
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "POST",
            url: window.location.origin + "/administrator/post/validate/login",
            data: {
                email: $('#email').val(),
                password: $('#password').val(),
            },
            dataType: 'text',
            success: function (response) {
                $('.modal-check-login').remove();
                $('.modal-backdrop').remove();
                switch (response) {
                    case 'verified':
                        $('#form').addClass('d-none');
                        $('#verification').removeClass('d-none');
                        break;
                    case 'failed':
                        let dialog = bootbox.dialog({
                            message: '<p class="text-center mb-0">Desculpe, parece que ouve algum erro, Tente novamente.</p>',
                            centerVertical: true,
                            closeButton: false
                        });
                        setTimeout(() => {
                            dialog.modal('hide')
                        }, 2000);
                        break;
                    case 'block':
                        bootbox.dialog({
                            message: '<p class="text-center mb-0"><i class="fs-40 fa-duotone fa-circle-xmark fa-shake" style="--fa-primary-color: #6f0003; --fa-secondary-color: #6f0003;"></i></p><p class="text-center"> O usuário foi bloqueado.</p><div style="width:30%;height:35px;" class="wrap-login100-form-btn"><div class="login100-form-bgbtn"></div><button class="login100-form-btn" data-dismiss="modal"   style="height: 34px;">Fechar</button></div>',
                            centerVertical: true,
                            closeButton: false
                        });
                        break;
                    case 'erro':
                        bootbox.dialog({
                            message: '<p class="text-center mb-0">Desculpe, parece que o <strong>e-mail e/ou senha</strong> que você inseriu estão incorretos. Por favor, verifique se ambos estão corretos e tente novamente.</p><div class="text-center m-t-20" id="close"><p class="text-center">Tente novamente em:</p><strong><p class="text-center fs-30" id="countdown"></p></strong></div>',
                            centerVertical: true,
                            closeButton: false
                        });
                        const endDate = new Date().getTime() + 11000;
                        const countdownInterval = setInterval(function () {
                            const now = new Date().getTime();
                            const difference = endDate - now;
                            $("#countdown").text(Math.ceil(difference / 1000));
                            if (difference < 0) {
                                clearInterval(countdownInterval);
                                $("#close").html('<div style="width:30%;height:35px;" class="wrap-login100-form-btn"><div class="login100-form-bgbtn"></div><button class="login100-form-btn" data-dismiss="modal"  style="height: 34px;">Fechar</button></div>');
                            }
                        }, 1000);
                        break;


                }
            },
            error: function () {
                submit.modal('hide')
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0">Desculpe, parece que ouve algum erro, Tente novamente.</p>',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide')
                }, 2000);
            }
        });
    }
});
$('#verify-code').on('click', function () {
    var check = true;
    for (var i = 0; i < input.length; i++) {
        if (validate(input[i]) == false) {
            showValidate(input[i]);
            check = false;
        }
    }
    if (check) {
        bootbox.dialog({
            message: '<p class="text-center"><i class="fs-40 fa-duotone fa-burger-soda fa-flip"></i></p><p class="text-center">Válidando código.</p>',
            className: 'modal-check-code',
            size: 'small',
            centerVertical: true,
            closeButton: false
        });
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "POST",
            url: window.location.origin + "/administrator/post/submit/login",
            data: {
                email: $('#email').val(),
                password: $('#password').val(),
                code: $('#verification-code').val(),
            },
            dataType: 'text',
            success: function (response) {
                response = JSON.parse(response)
                $('.modal-check-code').remove();
                $('.modal-backdrop').remove();
                switch (response.error) {
                    case 'code_expired':
                        bootbox.dialog({
                            message: '<p class="text-center mb-0"><i class="fs-40 fa-duotone fa-circle-xmark fa-shake" style="--fa-primary-color: #6f0003; --fa-secondary-color: #6f0003;"></i></p><p class="text-center"> Este código expirou</p><div style="width:30%;height:35px;" class="wrap-login100-form-btn m-t-20"><div class="login100-form-bgbtn"></div><button class="login100-form-btn" onclick="window.location.reload()"  style="height: 34px;">Fechar</button></div>',
                            centerVertical: true,
                            closeButton: false
                        });
                        break;
                    case 'code_error':
                        bootbox.dialog({
                            message: '<p class="text-center mb-0">Se você inserir o código de verificação incorretamente três vezes, seu acesso será bloqueado.</p><div class="text-center m-t-20" id="close"><p class="text-center">Tente novamente em:</p><strong><p class="text-center fs-30" id="countdown"></p></strong></div>',
                            centerVertical: true,
                            closeButton: false
                        });

                        const endDate = new Date().getTime() + 11000;
                        const countdownInterval = setInterval(function () {
                            const now = new Date().getTime();
                            const difference = endDate - now;
                            $("#countdown").text(Math.ceil(difference / 1000));
                            if (difference < 0) {
                                clearInterval(countdownInterval);
                                $("#close").html('<div style="width:30%;height:35px;" class="wrap-login100-form-btn"><div class="login100-form-bgbtn"></div><button class="login100-form-btn" data-dismiss="modal"  style="height: 34px;">Fechar</button></div>');
                            }
                        }, 1000);
                        break;
                    case 'block':
                        bootbox.dialog({
                            message: '<p class="text-center mb-0"><i class="fs-40 fa-duotone fa-circle-xmark fa-shake" style="--fa-primary-color: #6f0003; --fa-secondary-color: #6f0003;"></i></p><p class="text-center"> O usuário foi bloqueado.</p><div style="width:30%;height:35px;" class="wrap-login100-form-btn"><div class="login100-form-bgbtn"></div><button class="login100-form-btn" onclick="window.location.replace(\'' + response.url + '\')"  style="height: 34px;">Fechar</button></div>',
                            centerVertical: true,
                            closeButton: false
                        });
                        break;
                    case 'logged':
                        window.location.replace(response.url);
                        break;

                }
            },
            error: function () {
                $('.modal-check-code').modal('hide')
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0">Desculpe, parece que ouve algum erro, Tente novamente.</p>',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide')
                }, 2000);
            }
        });
    }
});

$('.validate-form .input100').each(function () {
    $(this).focus(function () {
        hideValidate(this);
    });
});
function validate(input) {
    if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
        if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            return false;
        }
    }
    else {
        if ($(input).val().trim() == '') {
            return false;
        }
    }
}
function showValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
}

function hideValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).removeClass('alert-validate');
}

/*==================================================================
[ Show pass ]*/
var showPass = 0;
$('.btn-show-pass').on('click', function () {
    if (showPass == 0) {
        $(this).next('input').attr('type', 'text');
        $(this).find('i').removeClass('fa-eye');
        $(this).find('i').addClass('fa-eye-slash');
        showPass = 1;
    }
    else {
        $(this).next('input').attr('type', 'password');
        $(this).find('i').addClass('fa-eye');
        $(this).find('i').removeClass('fa-eye-slash');
        showPass = 0;
    }

});

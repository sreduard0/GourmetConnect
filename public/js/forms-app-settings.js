function save_establishment_settings() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-establishment-settings'))

    // Verificação
    if (formData.get('establishment-name') == '' || formData.get('establishment-name') < 4) {
        $('#establishment-name').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-name').removeClass('is-invalid');
    }

    var cnpj = formData.get('establishment-cnpj').replace(/[._-]/g, '').replace('/', '')
    if (formData.get('establishment-cnpj') == '' || cnpj.length > 14) {
        $('#establishment-cnpj').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-cnpj').removeClass('is-invalid');
    }

    if (formData.get('establishment-address') == '' || formData.get('establishment-address').length > 255) {
        $('#establishment-address').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-address').removeClass('is-invalid');
    }
    if (formData.get('establishment-number') == '' || formData.get('establishment-number').length > 4) {
        $('#establishment-number').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-number').removeClass('is-invalid');
    }
    if (formData.get('establishment-neighborhood') == '' || formData.get('establishment-neighborhood').length > 255) {
        $('#establishment-neighborhood').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-neighborhood').removeClass('is-invalid');
    }
    if (formData.get('establishment-city') == '' || formData.get('establishment-city').length > 255) {
        $('#establishment-city').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-city').removeClass('is-invalid');
    }
    if (formData.get('establishment-state') == '' || formData.get('establishment-state').length > 2) {
        $('#establishment-state').addClass('is-invalid');
        return false;
    } else {
        $('#establishment-state').removeClass('is-invalid');
    }



    var values = {
        establishment_name: formData.get('establishment-name'),
        establishment_cnpj: formData.get('establishment-cnpj').replace(/[._-]/g, '').replace('/', ''),
        establishment_address: formData.get('establishment-address'),
        establishment_number: formData.get('establishment-number').replace(/[._-]/g, ''),
        establishment_neighborhood: formData.get('establishment-neighborhood'),
        establishment_city: formData.get('establishment-city'),
        establishment_state: formData.get('establishment-state'),
    }

    const URL = '/administrator/post/save/establishment-settings'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Configurações salvas.'
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);

                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  As configuraççoes não foram salvas'
                    });
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
function save_theme_settings() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-theme-settings'))

    // Verificação
    if (formData.get('theme-background') == '') {
        $('#theme-background').addClass('is-invalid');
        return false;
    } else {
        $('#theme-background').removeClass('is-invalid');
    }

    if (formData.get('theme-accent') == '') {
        $('#theme-accent').addClass('is-invalid');
        return false;
    } else {
        $('#theme-accent').removeClass('is-invalid');
    }

    if (formData.get('theme-sidebar') == '') {
        $('#theme-sidebar').addClass('is-invalid');
        return false;
    } else {
        $('#etheme-sidebar').removeClass('is-invalid');
    }




    var values = {
        theme_background: formData.get('theme-background'),
        theme_accent: formData.get('theme-accent'),
        theme_sidebar: formData.get('theme-sidebar'),
    }

    const URL = '/administrator/post/save/theme-settings'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    if (formData.get('theme-background') == 'dark-mode') {
                        $('body').addClass('dark-mode')
                    } else {
                        $('body').removeClass('dark-mode')
                    }
                    if (formData.get('theme-accent')) {
                        const element = document.querySelector('body');
                        element.classList.forEach(className => {
                            if (className.startsWith('accent-')) {
                                element.classList.remove(className);
                            }
                        });
                        $('body').addClass(formData.get('theme-accent'))
                    } else {
                        $('body').removeClass('dark-mode')
                    }
                    if (formData.get('theme-sidebar')) {
                        const element = document.querySelector('aside');
                        element.classList.forEach(className => {
                            if (className.startsWith('sidebar-')) {
                                element.classList.remove(className);
                            }
                        });
                        $('aside').addClass(formData.get('theme-sidebar'))
                    } else {
                        $('aside').removeClass('dark-mode')
                    }









                    setTimeout(() => {
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp&nbsp Configurações salvas.'
                        });
                    }, 1000);

                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  As configuraççoes não foram salvas'
                    });
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
function save_general_settings() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-general-settings'))

    // Verificação
    if (formData.get('general-tables') == '') {
        $('#general-tables').addClass('is-invalid');
        return false;
    } else {
        $('#general-tables').removeClass('is-invalid');
    }

    var values = {
        general_tables: formData.get('general-tables').replace(/[._-]/g, ''),
    }

    const URL = '/administrator/post/save/general-settings'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'POST',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Configurações salvas.'
                    });
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  As configuraççoes não foram salvas'
                    });
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


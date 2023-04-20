//---------------------------
// CRUD TIPO DE ITEMS
//---------------------------
function save_new_type_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-type-item'))

    // Verificação
    if (formData.get('img-type-product') == '') {
        $('#img_type_product').css('border', '4px solid red');
        return false;
    } else {
        $('#img_type_product').removeAttr("style");
    }
    if (formData.get('name-type-product') == '') {
        $('#name-type-product').addClass('is-invalid');
        return false;
    } else {
        $('#name-type-product').removeClass('is-invalid');
    }

    var values = {
        img_type_product: formData.get('img-type-product'),
        name_type_product: formData.get('name-type-product'),
        obs_type_product: formData.get('obs-type-product')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/type/new'
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
                        title: '&nbsp&nbsp Novo tipo adicionado com sucesso.'
                    });
                    $('#type-item-modal').modal('hide');
                    $('#img-type-product-crop').val('');
                    $('#obs-type-product').summernote('code', '');
                    $('#form-type-item')[0].reset();
                    document.getElementById("img_type_product").src = '/img/gourmetconnect-logo/g-c-.png';
                    $("#type-item-table").DataTable().clear().draw();
                    $.get('/administrator/get/info/menu/types', function (data) {
                        $('#type-product').empty()
                        $.each(data, function (index, item) {
                            $('#type-product').append($('<option>', {
                                value: item.id
                                , text: item.name
                            }));
                        });
                    });
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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
function edit_type_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-type-item'))
    // Verificação
    if (formData.get('id-type-product') == '') {
        return false;
    }
    if (formData.get('name-type-product') == '') {
        $('#name-type-product').addClass('is-invalid');
        return false;
    } else {
        $('#name-type-product').removeClass('is-invalid');
    }

    var values = {
        id: formData.get('id-type-product'),
        img_type_product: formData.get('img-type-product'),
        name_type_product: formData.get('name-type-product'),
        obs_type_product: formData.get('obs-type-product')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/type/edit'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'PUT',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo.'
                    });
                    $('#type-item-modal').modal('hide');
                    $('#img-type-product-crop').val('');
                    $('#obs-type-product').summernote('code', '');
                    $('#form-type-item')[0].reset();
                    document.getElementById("img_type_product").src = '/img/gourmetconnect-logo/g-c-.png';
                    $("#type-item-table").DataTable().clear().draw();
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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
function delete_type_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir este tipo de item?',
        message: '<strong class="text-danger">Essa operação não pode ser desfeita.</strong><br> Será excluido também os itens e adicionais vinculados.',
        callback: function (confirmacao) {
            if (confirmacao) {
                const URL = window.location.origin + '/administrator/post/delete/menu/type/' + id
                $.ajax({
                    url: URL,
                    type: 'delete',
                    dataType: 'text',
                    success: function (data) {
                        switch (data) {
                            case 'success':
                                Toast.fire({
                                    icon: 'success',
                                    title: '&nbsp&nbsp Tipo excluido com sucesso.'
                                });
                                $("#type-item-table").DataTable().clear().draw();
                                $("#table-menu").DataTable().clear().draw();
                                $("#additional-items-table").DataTable().clear().draw();
                                break;
                            case 'error':
                                Toast.fire({
                                    icon: 'warning',
                                    title: '&nbsp&nbsp  Ouve um erro ao excluir.'
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

//---------------------------
// CRUD ITEMS
//---------------------------
function save_new_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-item'))

    // Verificação
    if (formData.get('img-product') == '') {
        $('#img_product').css('border', '4px solid red');
        return false;
    } else {
        $('#img_product').removeAttr("style");
    }
    if (formData.get('status-product') == '') {
        $('#status-product').addClass('is-invalid');
        return false;
    } else {
        $('#status-product').removeClass('is-invalid');
    }
    if (formData.get('type-product') == '') {
        $('#type-product').addClass('is-invalid');
        return false;
    } else {
        $('#type-product').removeClass('is-invalid');
    }
    if (formData.get('name-product') == '') {
        $('#name-product').addClass('is-invalid');
        return false;
    } else {
        $('#name-product').removeClass('is-invalid');
    }
    if (formData.get('value-product') == '') {
        $('#value-product').addClass('is-invalid');
        return false;
    } else {
        $('#value-product').removeClass('is-invalid');
    }

    var values = {
        img_product: formData.get('img-product'),
        status_product: formData.get('status-product'),
        type_product: formData.get('type-product'),
        name_product: formData.get('name-product'),
        value_product: formData.get('value-product'),
        obs_product: formData.get('obs-product')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/item/new'
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
                        title: '&nbsp&nbsp Novo item adicionado com sucesso.'
                    });
                    $('#item-modal').modal('hide');
                    $('#img-product-crop').val('');
                    $('#obs-product').summernote('code', '');
                    $('#form-item')[0].reset();
                    document.getElementById("img_product").src = '/img/gourmetconnect-logo/g-c-.png';
                    $("#table-menu").DataTable().clear().draw();
                    $.get('/administrator/get/info/menu/items', function (data) {
                        $('#item-menu').empty()
                        $.each(data, function (index, item) {
                            $('#item-menu').append($('<option>', {
                                value: item.id
                                , text: item.name
                            }));
                        });
                    });
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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
function delete_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir este registro?',
        message: '<strong>Essa operação não pode ser desfeita.</strong><br>Será excluido também seus adicionais.',
        callback: function (confirmacao) {
            if (confirmacao) {
                const URL = window.location.origin + '/administrator/post/delete/menu/item/' + id
                $.ajax({
                    url: URL,
                    type: 'DELETE',
                    dataType: 'text',
                    success: function (data) {
                        switch (data) {
                            case 'success':
                                Toast.fire({
                                    icon: 'success',
                                    title: '&nbsp&nbsp Item excluido com sucesso.'
                                });
                                $("#table-menu").DataTable().clear().draw();
                                $("#additional-items-table").DataTable().clear().draw();
                                break;
                            case 'error':
                                Toast.fire({
                                    icon: 'warning',
                                    title: '&nbsp&nbsp  Ouve um erro ao excluir.'
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
function edit_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-item'))

    // Verificação
    if (formData.get('id-product') == '') {
        return false;
    }
    if (formData.get('status-product')) {
        $('#status-product').removeClass('is-invalid');
    } else {
        $('#status-product').addClass('is-invalid');
        return false;
    }
    if (formData.get('type-product')) {
        $('#type-product').removeClass('is-invalid');
    } else {
        $('#type-product').addClass('is-invalid');
        return false;
    }
    if (formData.get('name-product') == '') {
        $('#name-product').addClass('is-invalid');
        return false;
    } else {
        $('#name-product').removeClass('is-invalid');
    }
    if (formData.get('value-product') == '') {
        $('#value-product').addClass('is-invalid');
        return false;
    } else {
        $('#value-product').removeClass('is-invalid');
    }

    var values = {
        id: formData.get('id-product'),
        img_product: formData.get('img-product'),
        status_product: formData.get('status-product'),
        type_product: formData.get('type-product'),
        name_product: formData.get('name-product'),
        value_product: formData.get('value-product'),
        obs_product: formData.get('obs-product')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/item/edit'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'PUT',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo.'
                    });
                    $('#item-modal').modal('hide');
                    $('#img-product-crop').val('');
                    $('#obs-product').summernote('code', '');
                    $('#form-item')[0].reset();
                    document.getElementById("img_product").src = '/img/gourmetconnect-logo/g-c-.png';
                    $("#table-menu").DataTable().clear().draw();
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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

//---------------------------
// CRUD ADICIONAL DE ITEMS
//---------------------------
function save_new_additional_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-additional-item'))
    // Verificação
    if (formData.get('status-additional') == '') {
        $('#status-additional').addClass('is-invalid');
        return false;
    } else {
        $('#status-additional').removeClass('is-invalid');
    }
    if (formData.get('item-menu') == '') {
        $('.select2-selection').css('border', '1px solid red');
        return false;
    } else {
        $('.select2-selection').removeAttr('style');
    }
    if (formData.get('name-additional') == '') {
        $('#name-additional').addClass('is-invalid');
        return false;
    } else {
        $('#name-additional').removeClass('is-invalid');
    }
    if (formData.get('value-additional') == '') {
        $('#value-additional').addClass('is-invalid');
        return false;
    } else {
        $('#value-additional').removeClass('is-invalid');
    }

    var values = {
        item_menu: formData.get('item-menu'),
        name_additional: formData.get('name-additional'),
        status_additional: formData.get('status-additional'),
        value_additional: formData.get('value-additional'),
        obs_additional: formData.get('obs-additional')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/additional-item/new'
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
                        title: '&nbsp&nbsp Novo item adicionado com sucesso.'
                    });
                    $('#additional-item-modal').modal('hide');
                    $('#obs-additional').summernote('code', '');
                    $('#form-additional-item')[0].reset();
                    $('#item-menu').val('').trigger('change')
                    $("#additional-items-table").DataTable().clear().draw();
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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
function delete_additional_item(id) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    bootbox.confirm({
        title: ' Deseja excluir este item adicional?',
        message: '<strong class="text-danger">Essa operação não pode ser desfeita.</strong><br>Este adicional sairá do cardápio',
        callback: function (confirmacao) {
            if (confirmacao) {
                const URL = window.location.origin + '/administrator/post/delete/menu/additional-item/' + id
                $.ajax({
                    url: URL,
                    type: 'DELETE',
                    dataType: 'text',
                    success: function (data) {
                        switch (data) {
                            case 'success':
                                Toast.fire({
                                    icon: 'success',
                                    title: '&nbsp&nbsp Adicional excluido com sucesso.'
                                });
                                $("#additional-items-table").DataTable().clear().draw();
                                break;
                            case 'error':
                                Toast.fire({
                                    icon: 'warning',
                                    title: '&nbsp&nbsp  Ouve um erro ao excluir.'
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
function edit_additional_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-additional-item'))
    // Verificação
    if (formData.get('id_additional_item') == '') {
        return false;
    }

    if (formData.get('status-additional') == '') {
        $('#status-additional').addClass('is-invalid');
        return false;
    } else {
        $('#status-additional').removeClass('is-invalid');
    }
    if (formData.get('item-menu') == '') {
        $('.select2-selection').css('border', '1px solid red');
        return false;
    } else {
        $('.select2-selection').removeAttr('style');
    }
    if (formData.get('name-additional') == '') {
        $('#name-additional').addClass('is-invalid');
        return false;
    } else {
        $('#name-additional').removeClass('is-invalid');
    }
    if (formData.get('value-additional') == '') {
        $('#value-additional').addClass('is-invalid');
        return false;
    } else {
        $('#value-additional').removeClass('is-invalid');
    }

    var values = {
        id: formData.get('id_additional_item'),
        item_menu: formData.get('item-menu'),
        name_additional: formData.get('name-additional'),
        status_additional: formData.get('status-additional'),
        value_additional: formData.get('value-additional'),
        obs_additional: formData.get('obs-additional')
    }

    const URL = window.location.origin + '/administrator/post/save/menu/additional-item/edit'
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL,
        type: 'PUT',
        data: values,
        dataType: 'text',
        success: function (data) {
            switch (data) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Salvo..'
                    });
                    $('#additional-item-modal').modal('hide');
                    $('#obs-additional').summernote('code', '');
                    $('#form-additional-item')[0].reset();
                    $('#item-menu').val('').trigger('change')
                    $("#additional-items-table").DataTable().clear().draw();
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'warning',
                        title: '&nbsp&nbsp  Ouve um erro ao salvar.'
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

function save_new_type_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-new-type-item'))

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

    const URL = '/administrator/post/save/menu/type/new'
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
                    $('#new-type-item').modal('hide');
                    $('#img-type-product-crop').val('');
                    $('#obs-type-product').summernote('code', '');
                    $('#form-new-type-item')[0].reset();
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
function save_new_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-new-item'))

    // Verificação
    if (formData.get('img-product') == '') {
        $('#img_product').css('border', '4px solid red');
        return false;
    } else {
        $('#img_product').removeAttr("style");
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
        type_product: formData.get('type-product'),
        name_product: formData.get('name-product'),
        value_product: formData.get('value-product'),
        obs_product: formData.get('obs-product')
    }

    const URL = '/administrator/post/save/menu/item/new'
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
                    $('#new-item').modal('hide');
                    $('#img-product-crop').val('');
                    $('#obs-product').summernote('code', '');
                    $('#form-new-item')[0].reset();
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
function save_new_additional_item() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    const formData = new FormData(document.getElementById('form-new-additional-item'))
    // Verificação
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
        value_additional: formData.get('value-additional'),
        obs_additional: formData.get('obs-additional')
    }

    const URL = '/administrator/post/save/menu/additional-item/new'
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
                    $('#new-additional-item').modal('hide');
                    $('#obs-additional').summernote('code', '');
                    $('#form-new-additional-item')[0].reset();
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

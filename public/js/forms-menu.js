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

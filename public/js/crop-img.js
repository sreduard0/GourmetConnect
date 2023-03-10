function checkExt($input) {
    // var do toast de sucesso
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    // fim
    var extTrue = ['jpg', 'png', 'jpeg'];
    var extFile = $input.value.split('.').pop();

    if (typeof extTrue.find(function (ext) {
        return extFile == ext;
    }) == 'undefined') {

        Toast.fire({
            icon: 'error',
            title: '&nbsp&nbsp Por favor selecione um arquivo .JPG, .JPEG ou .PNG'
        });

        $input.value = '';
        return false;
    }
}

//====================== INICIALIZANDO MODULO CROP
$(document).ready(function () {
    $image = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 550,
            height: 550,
            type: 'square' //circle
        },
        boundary: {
            width: 600,
            height: 600
        },
    });
});
//===================== CORTE DE IMAGEM FORM NOVO TIPO DE ITEM
$(document).ready(function () {
    $('#upload_type_item_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (event) {
            $image.croppie('bind', {
                url: event.target.result
            })
        }
        reader.readAsDataURL(this.files[0]);
        $('#crop_image').html('<button onclick="return crop_type_item_image()" class="btn btn-accent rounded-pill ">CORTAR</button>')
        $('#new-type-item').modal('hide');
        $('#uploadimage').modal('show');
    });
});
function crop_type_item_image() {
    $image.croppie('result', {
        type: 'canvas',
        size: 'original',
        quality: 1
    }).then(function (response) {
        $('#crop_image').html('')
        $('#uploadimage').modal('hide');
        document.getElementById("img_type_product").src = response;
        document.getElementById("img-type-product-crop").value = response;
        $('#new-type-item').modal('show');
        setTimeout(() => {
            $('body').addClass('modal-open');
        }, 500);

    })
};
//===================== CORTE DE IMAGEM FORM NOVO ITEM
$(document).ready(function () {
    $('#upload_item_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (event) {
            $image.croppie('bind', {
                url: event.target.result
            })
        }
        reader.readAsDataURL(this.files[0]);
        $('#crop_image').html('<button onclick="return crop_item_image()" class="btn btn-accent rounded-pill ">CORTAR</button>')
        $('#new-item').modal('hide');
        $('#uploadimage').modal('show');
    });



});
function crop_item_image() {
    $image.croppie('result', {
        type: 'canvas',
        size: 'original',
        quality: 1
    }).then(function (response) {
        $('#crop_image').html('')
        $('#uploadimage').modal('hide');
        document.getElementById("img_product").src = response;
        document.getElementById("img-product-crop").value = response;
        $('#new-item').modal('show');
        setTimeout(() => {
            $('body').addClass('modal-open');
        }, 500);

    })
};

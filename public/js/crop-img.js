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
//===================== CORTE DE IMAGEM FORM NOVO VISITANTE
$(document).ready(function () {
    $image = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 300,
            height: 300,
            type: 'square' //circle
        },
        boundary: {
            width: 400,
            height: 400
        }
    });

    $('#upload_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (event) {
            $image.croppie('bind', {
                url: event.target.result
            })
        }
        reader.readAsDataURL(this.files[0]);
        $('#new-type-item').modal('hide');
        $('#uploadimage').modal('show');
    });

    $('.crop_image').click(function (event) {
        $image.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $('#uploadimage').modal('hide');
            document.getElementById("img_product").src = response;
            document.getElementById("img-product-crop").value = response;
            $('#new-type-item').modal('show');
        })
    });

});

//===================== CORTE DE IMAGEM FORM NOVO VISITANTE
$(document).ready(function() {
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

    $('#upload_image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(event) {
            $image.croppie('bind', {
                url: event.target.result
            }).then(function() {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#register').modal('hide');
        $('#uploadimage').modal('show');
    });

    $('.crop_image').click(function(event) {
        $image.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {
            $('#uploadimage').modal('hide');
            document.getElementById("img_profile").src = response;
            document.getElementById('image_profile').value = response;
            $('#register').modal('show');
        })
    });

});

//======================== EDITAR FOTO
$(document).ready(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $image_crop = $('#image_prev').croppie({
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

    $('#upload_new_image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function() {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#visitor_profile').modal('hide');
        $('#uploanewdimage').modal('show');
    });

    $('.crop_new_image').click(function(event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {
            $('#uploanewdimage').modal('hide');
            document.getElementById("edit_img").src = response;
            var data = {
                id: $('#id').val(),
                photo: response,
            };
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: '/edit_img_profile',
                type: 'POST',
                data: data,
                dataType: 'text',
                success: function(data) {
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp&nbsp Imagem atualizada..'
                    });
                    $('#visitor_profile').modal('show');
                    $("#table").DataTable().clear().draw(6);
                },

                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: '&nbsp&nbsp Erro ao atualizar.'
                    });
                }
            });
        })
    });

});
function comment() {
    const formData = new FormData(document.getElementById('commit-form'))

    if (formData.get('rating') == '') {
        $('#rating').addClass('is-invalid');
        return false;
    } else {
        $('#rating').removeClass('is-invalid');
    }
    if (formData.get('comment') == '') {
        $('#comment').addClass('is-invalid');
        return false;
    } else {
        $('#comment').removeClass('is-invalid');
    }

    var entries = {
        rating: formData.get('rating'),
        comment: formData.get('comment'),
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: window.location.origin + '/post/create/comment/client',
        type: 'POST',
        data: entries,
        dataType: 'text',
        success: function (response) {
            var responseData = JSON.parse(response)
            if (!responseData.error) {
                $('#rating').val('')
                $('#comment').val('')
                $('.client-slider .owl-stage-outer .no-data').remove()
                $('.client-slider').owlCarousel("add", responseData.cardData)
                $(".client-slider").owlCarousel("refresh")
                var novoItemIndex = $(".client-slider .owl-item").length - 1;
                $(".client-slider").owlCarousel("to", novoItemIndex);
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fs-50 text-success fa-solid fa-check fa-beat-fade"></i></p><p class="text-center mb-0">' + responseData.message + '</p>',
                    size: 'small',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide');
                }, 1000);
            } else {
                $('#rating').val('')
                $('#comment').val('')
                let dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">' + responseData.message + '</p>',
                    centerVertical: true,
                    closeButton: false
                });
                setTimeout(() => {
                    dialog.modal('hide');
                }, 2000);
            }
        }
        , error: function () {
            let dialog = bootbox.dialog({
                message: '<p class="text-center mb-0"><i class="fs-50 text-danger fa-solid fa-times fa-beat-fade"></i></p><p class="text-center mb-0">Ouve um erro na rede tente novamente.</p>',
                centerVertical: true,
                closeButton: false
            });
            setTimeout(() => {
                dialog.modal('hide');
            }, 2000);
        }
    });
}
function delete_comment() {

}

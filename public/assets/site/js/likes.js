function like_item(item) {
    $.ajax({
        url: window.location.origin + '/get/items/like/' + item,
        type: 'GET',
        success: function (response) {
            switch (response.event) {
                case 'like':
                    $('.' + item + ' .fa-heart').removeClass('far')
                    $('.' + item + ' .fa-heart').addClass('fas')
                    $('.' + item + ' strong').text(response.likes)
                    break;
                case 'unlike':
                    $('.' + item + ' .fa-heart').removeClass('fas')
                    $('.' + item + ' .fa-heart').addClass('far')
                    $('.' + item + ' strong').text(response.likes)
                    break
            }
        },
        error: function () {

        }
    });
}



// $.ajax({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//     , url: window.location.origin + '/administrator/post/request/item/additionals'
//     , type: 'post'
//     , data: {
//         item: product_id,
//         request_id: request_id,
//     }
//     , dataType: 'text'
//     , success: function (response) {

//     }
//     , error: function () {
//         Toast.fire({
//             icon: 'error'
//             , title: '&nbsp&nbsp Erro na rede.'
//         });
//     }
// });

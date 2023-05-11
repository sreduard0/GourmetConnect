function like_item(item) {
    $.ajax({
        url: window.location.origin + '/get/items/like/' + item,
        type: 'GET',
        success: function (response) {
            alert(response)
        },
        error: function () {
            Toast.fire({
                icon: 'error',
                title: '&nbsp&nbsp Erro na rede.'
            });
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

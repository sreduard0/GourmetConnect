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
                    $('.' + item + ' #item-likes').text(response.likes)
                    break;
                case 'unlike':
                    $('.' + item + ' .fa-heart').removeClass('fas')
                    $('.' + item + ' .fa-heart').addClass('far')
                    $('.' + item + ' strong').text(response.likes)
                    $('.' + item + ' #item-likes').text(response.likes)
                    break
            }
        },
        error: function () {

        }
    });
}

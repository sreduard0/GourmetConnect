

//-------------------------------
// SELEÇÃO DA TAB
// ------------------------------
// AUTO SELECIONAR ABA VIA URL
$(function () {
    var url = window.location.href;
    var element_id = $('#' + url.split('#')[1]);
    if (element_id.length) {
        var headerHeight = document.querySelector('header').offsetHeight;
        $('html, body').stop().animate({
            scrollTop: element_id.offset().top - headerHeight
        }, 1000);
    }

});

$(document).ready(function () {
    $('a[href^="#"]').on('click', function (event) {
        event.preventDefault();

        var target = $(this.getAttribute('href'));

        if (target.length) {
            var headerHeight = document.querySelector('header').offsetHeight;
            $('html, body').stop().animate({
                scrollTop: target.offset().top - headerHeight
            }, 1000);
        }
    });
});

var source = new EventSource(window.location.origin + '/get/notification/events', {
    retry: 5000
});
source.timeout = 3000;
source.onmessage = function (event) {
    var data = JSON.parse(event.data);
    if (data == null) {
        return false;
    }
    if (data.notify == true) {
        $('#client-cart-table').DataTable().clear().draw()
        $('#orders-table').DataTable().clear().draw()
        if ($('.bootbox').is(':visible') == true) {
            $('#requests_bootbox').append('<tr><td>' + data.messege + '</td></tr>')
        } else {
            bootbox.dialog({
                title: data.title,
                message: '<table class="table table-hover"><tbody id="requests_bootbox" ><tr><td>' + data.messege + '</td></tr></tbody></table>',
                size: data.size,
                centerVertical: data.centervertical,
                buttons: {
                    cancel: {
                        label: 'FECHAR',
                        className: 'btn-accent rounded-pill'
                    }
                },
            });
        }
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
        if (Notification.permission === "granted") {
            var notification = new Notification(data.title, {
                body: data.messege,
                icon: window.location.origin + '/' + data.icon,
                sound: window.location.origin + "/assets/app/sound/notification.mp3"
            });
        }
        var notificationSound = new Audio(window.location.origin + "/assets/app/sound/notification.mp3");
        notificationSound.play();

    }


}

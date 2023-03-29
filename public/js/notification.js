var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});



var source = new EventSource(window.location.origin + '/administrator/notification/events', {
    retry: 5000
});
source.timeout = 3000;
source.onmessage = function (event) {
    var data = JSON.parse(event.data);
    if (data == null) {
        return false;
    }
    if (window.location.pathname == '/administrator/requests') {
        $('#requests-table').DataTable().clear().draw()
    }
    if (data.notify == true) {
        switch (data.type) {
            case 'bootbox':
                if ($('.bootbox').is(':visible') == true) {
                    $('#requests_bootbox').append('<tr data-widget="expandable-table" aria-expanded="false"><td> "NOME" </td></tr><tr class="expandable-body d-none"><td><p class="m-l-30 text-muted">MESA#01 </p><p class="m-l-30 text-muted"> SEILA</p><p class=" m-l-30 text-muted">teste2:  </p></td></tr>')
                } else {
                    bootbox.confirm({
                        title: '<h2>' + data.title + '</h2>',
                        message: '<table class="table table-hover"><tbody id="requests_bootbox" ><tr data-widget="expandable-table" aria-expanded="false"><td> "NOME" </td></tr><tr class="expandable-body d-none"><td><p class="m-l-30 text-muted">MESA#01 </p><p class="m-l-30 text-muted"> SEILA</p><p class=" m-l-30 text-muted">teste2:  </p></td></tr></tbody></table>',
                        size: data.size,
                        centerVertical: data.centervertical,
                        buttons: {
                            confirm: {
                                label: 'FECHAR',
                                className: 'btn-accent'
                            },
                            cancel: {
                                label: '',
                                className: 'd-none'
                            }
                        },
                        callback: function (result) {

                        }
                    });
                }
                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }
                if (Notification.permission === "granted") {
                    var notification = new Notification(data.title, {
                        body: data.messege,
                        icon: window.location.origin + '/' + data.icon,
                        sound: window.location.origin + "/sound/notification.mp3"
                    });
                }
                var notificationSound = new Audio(window.location.origin + "/sound/notification.mp3");
                notificationSound.play();
                break;
            case 'native':

                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }
                if (Notification.permission === "granted") {
                    var notification = new Notification(data.title, {
                        body: data.message,
                        icon: window.location.origin + '/' + data['icon'],
                    });
                    // notification.onclick = function () {
                    //     window.open("https://www.exemplo.com");
                    // }
                }
                break;
            case 'popup':
                var notificationSound = new Audio(window.location.origin + "/sound/notification.mp3");
                $(document).Toasts('create', {
                    class: 'bg-accent',
                    title: data.title,
                    subtitle: '',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
                notificationSound.play();
                break;
        }

    }


};

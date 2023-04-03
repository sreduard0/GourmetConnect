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
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "text",
                    url: window.location.origin + "/administrator/notification/events/requests",
                    data: { id: data.request_id },
                    success: function (response) {
                        var response = JSON.parse(response);
                        var items = ''

                        $.each(response.items, function (index, item) {
                            var observation = item.observation ? '<strong style="padding-left: 10px;">Observação:</strong>' + item.observation : '';
                            var additionals = ''
                            $.each(item.additionals, function (index, additional) {
                                additionals += '<li class="additional">' + additional.info.name + '</li>'
                            });
                            items += '<strong style="padding-left: 10px;">' + item.name + '</strong> - x' + item.amount + '<ul>' + additionals + '</ul>' + observation + '<hr>'
                        });
                        if ($('.bootbox').is(':visible') == true) {
                            $('.' + data.request_id).remove()
                            $('#requests_bootbox').append('<tr class="' + data.request_id + '" data-widget="expandable-table" aria-expanded="false"><td>Pedido na MESA #' + response.command.table + ' para ' + response.command.client_name + '<buttom class="btn btn-sm btn-accent float-right" onclick="return print_request_notification(\'' + data.request_id + '\')"><i class="fa-duotone fa-print"></i></buttom></td></tr><tr class=" ' + data.request_id + ' expandable-body d-none"><td style="font-size: 12px" colspan="3">' + items + '<td></tr>')
                        } else {
                            bootbox.dialog({
                                title: '<h2>' + data.title + '</h2>',
                                message: '<table class="table table-hover"><tbody id="requests_bootbox" ><tr class="' + data.request_id + '" data-widget="expandable-table" aria-expanded="false"><td>Pedido na MESA #' + response.command.table + ' para ' + response.command.client_name + '<buttom class="btn btn-sm btn-accent float-right" onclick="return print_request_notification(\'' + data.request_id + '\')"><i class="fa-duotone fa-print"></i></buttom></td></tr><tr class=" ' + data.request_id + ' expandable-body d-none"><td style="font-size: 12px" colspan="3">' + items + '<td></tr></tbody></table>',
                                size: data.size,
                                centerVertical: data.centervertical,
                                buttons: {
                                    noclose: {
                                        label: 'IMPRIMIR TODOS',
                                        className: 'btn-accent',
                                        callback: function (result) {
                                            if (result) {
                                                print_request_notification('all')
                                            }
                                        }
                                    },
                                    cancel: {
                                        label: 'FECHAR',
                                        className: 'btn-default'
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
                                sound: window.location.origin + "/sound/notification.mp3"
                            });
                        }
                        var notificationSound = new Audio(window.location.origin + "/sound/notification.mp3");
                        notificationSound.play();
                    }
                });
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


}
//SCRIPT PARA IMPRIMIR VIA NOTIFICAÇÃO ESTA NO ADMINLTE.JS


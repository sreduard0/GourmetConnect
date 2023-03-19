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
    if (data.notify == true) {
        switch (data.type) {
            case 'bootbox':
                bootbox.confirm({
                    title: data.title,
                    message: data.messege,
                    size: data.size,
                    centerVertical: data.centervertical,
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-accent'
                        },
                        cancel: {
                            label: 'No',
                            className: 'd-none'
                        }
                    },
                    callback: function (result) {
                        console.log('This was logged in the callback: ' + result);
                    }
                });
                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }
                if (Notification.permission === "granted") {
                    var notification = new Notification(data.title, {
                        body: data.messege,
                        icon: window.location.origin + data.icon,
                        sound: window.location.origin + "/sound/notification.mp3"
                    });
                }
                break;
            case 'native':

                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }
                if (Notification.permission === "granted") {
                    var notification = new Notification(data.title, {
                        body: data.message,
                        icon: data.icon,
                        sound: "/sound/notification.mp3"
                    });
                }
                break;
            case 'popup':
                var notificationSound = new Audio("/sound/notification.mp3");
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
                notificationSound.play();
                break;
        }

    }
};

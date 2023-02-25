function altPermission(idUser, profile, id, name) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });

    bootbox.prompt({
        title: "Alterar permissão de " + name,
        inputType: 'select',
        value: profile.toString(),
        inputOptions: [

            {
                text: 'Nenhuma',
                value: '',
            },
            {
                text: 'CMT GDA',
                value: '0',
            },
            {
                text: 'ADJ / OF',
                value: '2',
            },
            {
                text: 'TRNP',
                value: '1',
            },
            {
                text: 'COST',
                value: '3',
            },
            {
                text: 'FISC ADM',
                value: '4',
            },
            {
                text: 'AUDITOR',
                value: '5',
            },
            {
                text: 'ADM',
                value: '6',
            }
        ],
        callback: function (result) {
            if (result != null) {
                console.log(result)
                if (result) {
                    var data = '/' + result + '/' + id
                } else {
                    var data = '/6/' + id
                }
                var url = '/alt_permission_user/' + idUser + data
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp&nbsp Permissão alterada com sucesso.'
                        });
                        $("#table").DataTable().clear().draw();
                    },
                    error: function (data) {
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp&nbsp Erro ao alterar.'
                        });

                    }
                });
            }
        },
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-default'
            },
            confirm: {
                label: 'Salvar',
                className: 'btn-success'
            }

        }
    });
}

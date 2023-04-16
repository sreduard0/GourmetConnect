$(function () {
    var source = new EventSource(window.location.origin + '/administrator/post/table/events', {
        retry: 5000
    });
    source.timeout = 3000;
    source.onmessage = function (event) {
        var data = JSON.parse(event.data);
        if (data == '') {
            return false;
        }
        $('#tables-list').empty()
        $.each(data, function (index, table) {
            var table_html = ''
            table_html += '<div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">'
            table_html += ' <div class="card bg-light d-flex flex-fill">'
            table_html += '    <div class="card-header border-bottom-0 row">'
            table_html += '        <h4 class="col"><strong>MESA #' + table.table + '</strong></h4>'
            table_html += '<div class="text-right col">'
            table_html += table.pendent ? '<div class="btn btn-sm btn-success rounded-pill"><strong>Há pedidos</strong></div>' : ''
            table_html += '  </div>'
            table_html += ' </div>'
            table_html += '     <div class="card-body pt-0">'
            table_html += '         <div class="row">'
            table_html += '            <div class="col">'
            table_html += '                <p class="text-md"><strong>Clientes: </strong> ' + table.client + '</p>'
            table_html += '               <ul class="ml-4 mb-0 fa-ul">'
            table_html += '                   <li><span class="fa-li"><i class="text-success fa-duotone fa-money-bill"></i></span><strong> Valor:</strong> ' + table.value + ' </li>'
            table_html += '                    <li><span class="fa-li"><i class="text-warning fa-duotone fa-burger-soda"></i></span><strong> Pedido via:</strong> ' + table.request + '</li>'
            table_html += '           </ul>'
            table_html += '        </div>'
            table_html += '      </div>'
            table_html += '  </div>'
            table_html += '   <div class="card-footer">'
            table_html += '      <div class="text-right">'
            table_html += '           <button onclick="qr_code(\'' + table.qr_value + '\',' + table.table + ')" class="btn btn-sm bg-secondary">'
            table_html += '               <i class="fa-duotone fa-qrcode"></i>'
            table_html += '            </button>'
            table_html += '           <botton onclick="view_requests_table(' + table.table + ')" class="btn btn-sm btn-accent">'
            table_html += '              <i class="fa-duotone fa-burger-soda"></i> <strong>PEDIDOS</strong>'
            table_html += '         </botton>'
            table_html += '    </div>'
            table_html += '   </div>'
            table_html += '   </div>'
            table_html += ' </div>'

            $('#tables-list').append(table_html);
        });
    }
});

function view_requests_table(table) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , url: window.location.origin + '/administrator/post/table/info/clients'
        , type: 'post'
        , data: {
            table: table,
        }
        , dataType: 'text'
        , success: function (response) {
            var data = JSON.parse(response);
            if (data.length > 1) {
                bootbox.prompt({
                    title: 'Selecione um cliente',
                    inputType: 'select',
                    size: 'small',
                    inputOptions: data,
                    buttons: {
                        cancel: {
                            label: 'FECHAR',
                            className: 'btn-secondary'
                        },
                        confirm: {
                            label: 'VER',
                            className: 'btn-accent'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            requests_client_view_modal(result)
                        } else if (result == '') {
                            $('.bootbox-input-select').addClass('is-invalid')
                            return false
                        }
                    },
                });
            } else {
                requests_client_view_modal(data[0].value)
            }
        }
        , error: function () {
            Toast.fire({
                icon: 'error'
                , title: '&nbsp&nbsp Erro na rede.'
            });
        }
    });
}


function removeQR() {
    var qrcode = new QRCode(document.getElementById("qr_vtr_generate"));
    qrcode.clear();
}


function qr_code(content, table) {
    removeQR()
    $.get(window.location.origin + "/administrator/get/app-settings/logo", function (data) {
        var options = {
            // text: content, // Content
            width: 240, // Widht
            height: 240, // Height
            colorDark: "#000000", // Dark color
            colorLight: "#ffffff", // Light color
            quietZone: 20,
            drawer: 'svg',
            logo: window.location.origin + "/" + data, // LOGO
            logoWidth: 80,
            logoHeight: 80,
            logoBackgroundTransparent: true, // Whether use transparent image, default is false
            correctLevel: QRCode.CorrectLevel.H // L, M, Q, H
        };
        var qrcode = new QRCode(document.getElementById("qr_vtr_generate"), options);

        qrcode.makeCode(content);
        $("#table_label").text('QR code da MESA #' + table)
        $("#modal_qr").modal('show')
    });

}

function printQR() {
    var divContents = document.getElementById("qr_vtr_generate").innerHTML;
    var a = window.open('', '', 'height=700, width=700');
    a.document.write('<html>');
    a.document.write('<body><h1>' + $("#table_label").html() + '</h1><br>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.print();
    a.close();
}

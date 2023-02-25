function removeQR() {
    var qrcode = new QRCode(document.getElementById("qr_vtr_generate"));
    qrcode.clear();
}


function qr_vtr(content) {
    removeQR()
    var options = {
        // text: content, // Content
        width: 240, // Widht
        height: 240, // Height
        colorDark: "#000000", // Dark color
        colorLight: "#ffffff", // Light color
        quietZone: 20,
        drawer: 'svg',
        logo: "./img/3bsup.png", // LOGO
        logoWidth: 80,
        logoHeight: 80,
        logoBackgroundTransparent: true, // Whether use transparent image, default is false
        correctLevel: QRCode.CorrectLevel.H // L, M, Q, H
    };
    var qrcode = new QRCode(document.getElementById("qr_vtr_generate"), options);

    qrcode.makeCode(content);

    $("#info-vtr").modal('hide')
    $("#modal_qr").modal('show')


}





function printQR() {
    var divContents = document.getElementById("qr_vtr_generate").innerHTML;
    var a = window.open('', '', 'height=700, width=700');
    a.document.write('<html>');
    a.document.write('<body><h1>3º B Sup</h1><br>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
}

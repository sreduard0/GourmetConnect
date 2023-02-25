
import QrScanner from "./qr-scanner.min.js";

const video = document.getElementById('qr-video');
const videoContainer = document.getElementById('video-container');
const camList = document.getElementById('cam-list');
const camQrResult = document.getElementById('cam-qr-result');

$('#qr-code-modal').on('hide.bs.modal', function () {
    scanner.stop()
});

function setResult(label, result) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    $("#qr-code-modal").modal('hide')
    var url = 'get_info_relgda/' + result.data
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            if (data == '') {
                Toast.fire({
                    icon: 'warning',
                    title: '&nbsp&nbsp Este QRCode não pertence ao CES Vtr.'
                });
            }
            else if (data.info_ficha == null) {
                Toast.fire({
                    icon: 'warning',
                    title: '&nbsp&nbsp Esta viatura não contém ficha.'
                });
            } else if (data.info_ficha.relgda) {
                closeRegisterModal(data.info_ficha.relgda.id, data.type_vtr)
            } else {
                selectVtrType(data.type_vtr)
                selectFichaRel(data.info_ficha.id)
                $("#register-vtr").modal('show')
                setTimeout(function () {
                    $('body').addClass("modal-open")
                }, 400);
            }
        },
        error: function () {
            Toast.fire({
                icon: 'warning',
                title: '&nbsp&nbsp Este QRCode não pertence ao CES Vtr.'
            });
        }
    });

}

// ####### Web Cam Scanning #######

const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
    highlightScanRegion: true,
    highlightCodeOutline: true,

});

const updateFlashAvailability = () => {
    scanner.hasFlash().then(() => {
        document.getElementById('flash-btn').style.display = 'block'
    });
};


document.getElementById('flash-btn').addEventListener('click', () => {
    scanner.toggleFlash().then(() => document.getElementById('flash-btn').className = scanner.isFlashOn() ? 'btn btn-success' : 'btn btn-secondary');
});


// for debugging
window.scanner = scanner;
scanner._updateOverlay();


camList.addEventListener('change', event => {
    scanner.setCamera(event.target.value).then(updateFlashAvailability);
});


document.getElementById('qr-read').addEventListener('click', () => {
    scanner.start().then(() => {
        updateFlashAvailability();
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
    });
});



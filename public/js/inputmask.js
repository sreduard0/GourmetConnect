
// // Datemask dd / mm / yyyy
// $('#date').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
// // Datemask2 mm / dd / yyyy
// // $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
// //Money Euro
// $('[data-mask]').inputmask();

//Date picker
// $('#date').datetimepicker({
//     format: 'DD/MM/YYYY',
//     locale: 'pt-br',

// });

$(function () {
    $('.text').summernote({
        height: 150,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table'],
        ]
    });
});

$(function () {
    $('.text_placeolder').summernote({
        placeholder: 'Observações para o cumprimento da missão.',
        height: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table'],
        ]
    });
    $('.text_placeolder').summernote('code', '');

});





$('.date').datetimepicker({
    timePicker: true,
    timePickerIncrement: 30,
    format: 'DD-MM-YYYY HH:mm',
    locale: 'pt-br',
    icons: { time: 'far fa-clock' }
});

$('.datet').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'pt-br',
});

$('[data-mask]').inputmask()


//Date and time picker
$('.time').datetimepicker({
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
        format: 'DD-MM-YYYY'
    }
})


//Date range picker
moment.locale('pt-br');
$('#betweenDate').daterangepicker({
    locale: {
        "format": "DD-MM-YYYY",
        "separator": " > ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sáb"
        ],
        "monthNames": [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        "firstDay": 0
    }

})
            //Date range picker with time picker
        // $('#reservationtime').daterangepicker({
        //         timePicker: true,
        //         timePickerIncrement: 30,
        //         locale: {
        //             format: 'DD/MM/YYYY'

        //     })
//             //Date range as a button
//         $('#daterange-btn').daterangepicker({
//                 ranges: {
//                     'Amanhã': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//                     'Próximos 7 dias': [moment().subtract(6, 'days'), moment()],
//                     'Próximos 30 dias': [moment().subtract(29, 'days'), moment()],
//                 },
//                 startDate: moment().subtract(29, 'days'),
//                 endDate: moment()
//             },
//             function(start, end) {
//                 $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
//             }
//         )

//         //Timepicker
//         $('#timepicker').datetimepicker({
//             format: 'LT'
//         })

//         //Bootstrap Duallistbox
//         $('.duallistbox').bootstrapDualListbox()

//         //Colorpicker
//         $('.my-colorpicker1').colorpicker()
//             //color picker with addon
//         $('.my-colorpicker2').colorpicker()

//         $('.my-colorpicker2').on('colorpickerChange', function(event) {
//             $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
//         })

//         $("input[data-bootstrap-switch]").each(function() {
//             $(this).bootstrapSwitch('state', $(this).prop('checked'));
//         })

//     })
//     // BS-Stepper Init
// document.addEventListener('DOMContentLoaded', function() {
//     window.stepper = new Stepper(document.querySelector('.bs-stepper'))
// })

// // DropzoneJS Demo Code Start
// Dropzone.autoDiscover = false

// // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
// var previewNode = document.querySelector("#template")
// previewNode.id = ""
// var previewTemplate = previewNode.parentNode.innerHTML
// previewNode.parentNode.removeChild(previewNode)

// var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
//     url: "/target-url", // Set the url
//     thumbnailWidth: 80,
//     thumbnailHeight: 80,
//     parallelUploads: 20,
//     previewTemplate: previewTemplate,
//     autoQueue: false, // Make sure the files aren't queued until manually added
//     previewsContainer: "#previews", // Define the container to display the previews
//     clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
// })

// myDropzone.on("addedfile", function(file) {
//     // Hookup the start button
//     file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
// })

// // Update the total progress bar
// myDropzone.on("totaluploadprogress", function(progress) {
//     document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
// })

// myDropzone.on("sending", function(file) {
//     // Show the total progress bar when upload starts
//     document.querySelector("#total-progress").style.opacity = "1"
//         // And disable the start button
//     file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
// })

// // Hide the total progress bar when nothing's uploading anymore
// myDropzone.on("queuecomplete", function(progress) {
//     document.querySelector("#total-progress").style.opacity = "0"
// })

// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
// document.querySelector("#actions .start").onclick = function() {
//     myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
// }
// document.querySelector("#actions .cancel").onclick = function() {
//         myDropzone.removeAllFiles(true)
//     }
//     // DropzoneJS Demo Code End

window.onload = contRel();
function contRel() {
    var url = 'countRelGda'
    $.get(url, function (result) {
        $('#countVtrCivil').text(result.civil)
        $('#countVtrOom').text(result.oom)
        $('#countVtrAdm').text(result.adm)
        $('#countVtrOp').text(result.op)
    })
}
// FILTROS TELA GDA
function filterRel() {
    $('#table').DataTable().column(3).search($('#typeVtr_filter').val()).draw();
}

$('#register-vtr').on('hide.bs.modal', function (event) {
    $('#form-civil')[0].reset();
    $('#form-oom')[0].reset();
    $('#form-om')[0].reset();
    $('#obsCivilRel').summernote('code', '');
    $('#obsOomRel').summernote('code', '');
    $('#obsRel').summernote('code', '');
});

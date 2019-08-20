jQuery.fn.CKEditorValFor = function(element_id) {
    return CKEDITOR.instances[element_id].getData();
}

$('#addProgram').on('hidden.bs.modal', function(e) {
    resetFields();
});

$(document).ready(function() {
    CKEDITOR.replace('welcome');
    CKEDITOR.replace('thanks');
    refresh();
});

function sleep(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

function animate(sec) {
    var target = document.getElementById('target1');
    var spinner = new Spinner({
        radius: 30,
        length: 0,
        width: 10,
        trail: 40
    }).spin(target);

    sleep(sec).then(() => {
        $.notify("All records display", "info");
        spinner.stop();
    });
    return;
}

function refresh() {
    getAllData();
    animate(500);
}


function getAllData() {
    $("#programTable").dataTable().fnDestroy();
    return;
}
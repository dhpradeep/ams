jQuery.fn.CKEditorValFor = function(element_id) {
    return CKEDITOR.instances[element_id].getData();
}

$('#addProgram').on('hidden.bs.modal', function(e) {
    resetFields();
});

function create_program() {
    $('#addProgram').modal('show');
}

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

$(document).on("click", ".remove-icon", function(e) {
    var id = $(this).data('id');
    BootstrapDialog.show({
        title: 'Delete',
        message: 'Are you sure to delete this record?',
        buttons: [{
            label: 'Yes',
            cssClass: 'btn-primary',
            action: function(dialog) {
                //deletedata(id);
                dialog.close();
            }
        }, {
            label: 'No',
            cssClass: 'btn-warning',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
});

$('#programTable tbody').on('click', '.edit-icon', function() {
    //var tr = $(this).closest('tr');
    //var row = table.row(tr);
    //create_program(row.data());
    create_program();
});
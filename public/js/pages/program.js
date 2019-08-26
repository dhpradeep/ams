$('#addProgram').on('hidden.bs.modal', function(e) {
    resetFields();
});
$('body').on('shown.bs.modal', '#addProgram', function() {
    $('input:visible:enabled:first', this).focus();
})

function create_program(data = null) {
    if (data != null) {
        $("#pid").data('id', data.id);
        $('#name').val(data.name);
        $('#details').val(data.details);
        $("#noOfYearOrSemester").val(data.noOfYearOrSemester);
        if (data.yearOrSemester == 1) {
            $("#semesterSelected").prop("checked", true);
        } else {
            $("#yearSelected").prop("checked", true);
        }
        $("#saveBtn")[0].innerHTML = "Update";
        $('#addProgram').modal('show');
    } else {
        $("#saveBtn")[0].innerHTML = "Add";

        $('#addProgram').modal('show');
    }
}

function resetFields() {
    $("#pid").data('id', '-1');
    $("#yearSelected").prop("checked", true);
    $("#noOfYearOrSemester").val('2');
    $('#name').val('');
    $('#details').val('');
}

$(document).ready(function() {
    refresh();
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if (btn == "Update") {
        updateProgram();
    } else {
        addProgram();
    }
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
        //$.notify("All records display", "info");
        spinner.stop();
    });
    return;
}

function refresh() {
    getAllData();
    animate(500);
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
                deletedata(id);
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

function updateProgram() {
    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });
    if ($("#yearSelected").prop("checked") == true) {
        yearOrSemester = 0;
    } else {
        yearOrSemester = 1;
    }


    var id = $('#pid').data('id');
    if (id > 0) {
        $.ajax({
            url: '../manage/program/update',
            async: true,
            type: 'POST',
            data: {
                id: id,
                name: $('#name').val(),
                details: $('#details').val(),
                noOfYearOrSemester: $('#noOfYearOrSemester').val(),
                yearOrSemester: yearOrSemester
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addProgram').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                        $.notify(element, "error");
                    });
                    if (decode.status === -1) $('#addProgram').modal('hide');
                    return;
                }
            },
            error: function(error) {
                console.log("Error:");
                console.log(error.responseText);
                console.log(error.message);
                if (error.responseText) {
                    var msg = JSON.parse(error.responseText)
                    $.notify(msg.msg, "error");
                }
                return;
            }
        });
    }

}

function addProgram() {

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    if ($("#yearSelected").prop("checked") == true) {
        yearOrSemester = 0;
    } else {
        yearOrSemester = 1;
    }

    $.ajax({
        url: '../manage/program/add',
        async: true,
        type: 'POST',
        data: {
            name: $('#name').val(),
            details: $('#details').val(),
            noOfYearOrSemester: $('#noOfYearOrSemester').val(),
            yearOrSemester: yearOrSemester
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addProgram').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                if (decode.status == -1) $('#addProgram').modal('hide');
                return;
            }
        },
        error: function(error) {
            console.log("Error:");
            console.log(error.responseText);
            console.log(error.message);
            if (error.responseText) {
                var msg = JSON.parse(error.responseText)
                $.notify(msg.msg, "error");
            }
            return;
        }
    });
}

function deletedata(id) {
    $.ajax({
        url: '../manage/program/delete',
        async: true,
        type: 'POST',
        data: {
            id: id
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                refresh();
                $.notify("Record successfully updated", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                return;
            }
        },
        error: function(error) {
            console.log("Error:");
            console.log(error.responseText);
            console.log(error.message);
            if (error.responseText) {
                var msg = JSON.parse(error.responseText)
                $.notify(msg.msg, "error");
            }
            return;
        }
    });
}

function getAllData() {
    $("#programTable").dataTable().fnDestroy();
    var table = $('#programTable').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../manage/program/get",
            "type": "POST"
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "columns": [
            { "data": "name" },
            {
                sortable: false,
                "render": function(data, type, row, meta) {
                    return (row.yearOrSemester == 1) ? "Semester" : "Year";
                }
            },
            { "data": "noOfYearOrSemester" },
            { "data": "details" },
            {
                sortable: false,
                "render": function(data, type, row, meta) {
                    return "<a data-id=" + row.id + " class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i> </a><a data-id=" + row.id + " class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                }
            }
        ],
        "order": [
            [1, 'asc']
        ]
    });

    $('#programTable tbody').on('click', '.edit-icon', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        create_program(row.data());
    });
}
$('#addSubject').on('hidden.bs.modal', function(e) {
    resetFields();
});
$('body').on('shown.bs.modal', '#addSubject', function() {
    $('input:visible:enabled:first', this).focus();
})

$("#programId").change(function() {
    semesterAddFunction($(this));
    sectionAddFunction();
});


$("#filterDataProgram").change(function() {
    semesterAddFunction($(this), 1);
    sectionAddFunction(null, 1);
    getAllData();
});

$("#filterDataSemester").change(function() {
    sectionAddFunction($(this), 1);
    getAllData();
});

$("#filterDataSection").change(function() {
    getAllData();
});

$("#yearOrSemester").change(function() {
    sectionAddFunction($(this));
});

function semesterAddFunction(data = null, mode = 0) {
    var source, destination;
    if (mode == 0) {
        source = "#programId";
        destination = "#yearOrSemester";
    } else {
        source = "#filterDataProgram";
        destination = "#filterDataSemester";
    }

    if (data == null) {
        data = $(source);
    }
    var totals = data.find(':selected').data("no");
    var html = '<option data-value="-1" value="-1">None</option>';
    if (totals > 0) {
        for (var i = 1; i <= totals; i++) {
            html += '<option data-value="' + i + '" value="' + i + '">' + i + '</option>';
        }
    }
    $(destination).html(html);
}

function sectionAddFunction(data = null, mode = 0, value = 0) {
    var source, destination, root;
    if (mode == 0) {
        root = "#programId";
        source = "#yearOrSemester";
        destination = "#sectionId";
    } else {
        root = "#filterDataProgram";
        source = "#filterDataSemester";
        destination = "#filterDataSection";
    }
    if (data == null) {
        data = $(source);
    }
    var programId = $(root).find(':selected').data("value");
    var yearOrSemester = data.find(':selected').data("value");
    if (yearOrSemester > 0 && programId > 0) {
        $.ajax({
            url: '../student/all/getSections',
            async: true,
            type: 'POST',
            data: {
                programId: programId,
                yearOrSemester: yearOrSemester
            },
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    var html = '<option value="-1">None</option>';
                    if (decode.sections.length >= 1) {
                        for (var i = 0; i < decode.sections.length; i++) {
                            html += '<option value="' + decode.sections[i].id + '">' + decode.sections[i].name + '</option>';
                        }
                    } else {
                        $.notify("Problem fetching sections for this program and semester/year.");
                    }
                    $(destination).html(html);
                    if (value != 0) {
                        $(destination).val(value);
                    }
                } else if (decode.success === false) {
                    var html = '<option value="-1">None</option>';
                    if (decode.error != undefined) {
                        $.notify(decode.error[0], "error");
                    } else {
                        $.notify("Problem fetching sections for this program and semester/year.", "error");
                    }
                    $(destination).html(html);
                    return;
                }
            }
        });
    } else {
        var html = '<option value="-1">None</option>';
        $(destination).html(html);
    }
}

function create_subject(data = null) {
    if (data != null) {
        $("#subjectId").data('id', data.id);
        $('#name').val(data.name);
        $('#details').val(data.details);
        $("#userId").val(data.userId);
        $('#userId option:selected').each(function() {
            $(this).prop('selected', true);
        });
        $('#programId').val(data.programId);
        semesterAddFunction();
        $('#yearOrSemester').val(data.yearOrSemester);
        sectionAddFunction(null, 0, data.sectionId);
        //$('#sectionId').val(data.sectionId);

        $("#saveBtn")[0].innerHTML = "Update";
        $('#addSubject').modal('show');
    } else {
        $("#saveBtn")[0].innerHTML = "Add";

        $('#addSubject').modal('show');
    }
}

function resetFields() {
    $("#subjectId").data('id', '-1');
    $('#programId').val('-1');
    semesterAddFunction();
    $('#yearOrSemester').val('-1');
    sectionAddFunction();
    $('#sectionId').val('-1');
    $("#userId").val([]);
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
        updateSubject();
    } else {
        addSubject();
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

function updateSubject() {
    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var userId = $('#userId').val();
    if(userId == null) {
        userId = [];
    }

    var id = $('#subjectId').data('id');
    if (id > 0) {
        $.ajax({
            url: '../manage/subject/update',
            async: true,
            type: 'POST',
            data: {
                id: id,
                name: $('#name').val(),
                details: $('#details').val(),
                yearOrSemester: $('#yearOrSemester').val(),
                programId: $('#programId').val(),
                sectionId: $('#sectionId').val(),
                userId: userId
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addSubject').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                        $.notify(element, "error");
                    });
                    if (decode.status === -1) $('#addSubject').modal('hide');
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

function addSubject() {

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var userId = $('#userId').val();
    if(userId == null) {
        userId = [];
    }

    $.ajax({
        url: '../manage/subject/add',
        async: true,
        type: 'POST',
        data: {
            name: $('#name').val(),
            details: $('#details').val(),
            yearOrSemester: $('#yearOrSemester').val(),
            programId: $('#programId').val(),
            sectionId: $('#sectionId').val(),
            userId : userId
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addSubject').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                if (decode.status == -1) $('#addSubject').modal('hide');
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
        url: '../manage/subject/delete',
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
    $("#subjectTable").dataTable().fnDestroy();
    var table = $('#subjectTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../manage/subject/get",
            "type": "POST",
            "data": {
                filterDataProgram: $("#filterDataProgram").val(),
                filterDataSemester: $("#filterDataSemester").val(),
                filterDataSection: $("#filterDataSection").val()
            }
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "columns": [
            { "data": "name" },
            { "data": "programName", sortable: false },
            { "data": "yearOrSemester" },
            { "data": "teachers", sortable: false },
            { "data": "sectionName", sortable: false },
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


    $('#subjectTable tbody').on('click', '.edit-icon', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        create_subject(row.data());
    });
}
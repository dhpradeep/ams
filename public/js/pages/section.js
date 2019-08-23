$('#addSection').on('hidden.bs.modal', function(e) {
    resetFields();
});

function create_section(data = null) {
    if(data != null) {
        $("#sid").data('id',data.id);
        $('#name').val(data.name);
        $('#details').val(data.details);
        $("#programId").val(data.programId);
        semesterAddFunction();
        $("#yearOrSemester").val(data.yearOrSemester);
        $("#saveBtn")[0].innerHTML = "Update";
        $('#addSection').modal('show');
    }else{
        $("#saveBtn")[0].innerHTML = "Add";
               
        $('#addSection').modal('show');
    }
}

function resetFields() {
    $("#sid").data('id','-1');
    $("#programId").val('-1');
    semesterAddFunction();
    $("#yearOrSemester").val('-1');
    $('#name').val('');
    $('#details').val('');
}

$(document).ready(function() {
    refresh();
});

$("#programId").change(function () {
    semesterAddFunction($(this));
});

function semesterAddFunction(data = null) {
    if(data == null) {
        data = $("#programId");
    }
    var totals = data.find(':selected').data("no");
     var html;
     if(totals <= 0) {
        html = '<option value="-1">None</option>';
     }else {
        html = '';
        for (var i = 1; i <= totals; i++) {
            html += '<option value="'+i+'">'+i+'</option>';
        }
     }
     $('#yearOrSemester').html(html);
}

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if(btn == "Update") {
        updateSection();
    } else {
        addSection();
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

function updateSection() {
     $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('#sid').data('id');
    if(id > 0) {
        $.ajax({
            url: '../manage/section/update',
            async: true,
            type: 'POST',
            data: {
                id: id,
                programId: $('#programId').val(),
                name: $('#name').val(),
                details: $('#details').val(),
                yearOrSemester: $('#yearOrSemester').val()
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addSection').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                      $.notify(element, "error");
                    });
                    if(decode.status === -1) $('#addSection').modal('hide');
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

function addSection(){

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    $.ajax({
        url: '../manage/section/add',
        async: true,
        type: 'POST',
        data: {
            programId: $('#programId').val(),
            name: $('#name').val(),
            details: $('#details').val(),
            yearOrSemester: $('#yearOrSemester').val()
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addSection').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                  $.notify(element, "error");
                });
                if(decode.status == -1) $('#addSection').modal('hide');
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
            url: '../manage/section/delete',
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

$(document).on("change", "#filterData", function(e) {
    e.preventDefault();
    getAllData();
});

function getAllData(){
    $("#sectionTable").dataTable().fnDestroy();
    var table = $('#sectionTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../manage/section/get",
            "type": "POST",
            "data": {
                filterData: $("#filterData").val()
            }
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "columns": [
            { "data": "name" },
            { "data": "programName" ,
                sortable: false
            },
            { "data": "yearOrSemester" },
            { "data": "details" },
            {   
                 sortable: false,
                 "render": function ( data, type, row, meta ) {
                    return "<a data-id="+ row.id +" class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i> </a><a data-id="+ row.id +" class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                 }
            }
        ],
        "order": [[1, 'asc']]
    } );

    $('#sectionTable tbody').on('click', '.edit-icon', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        create_section(row.data());
    } );
}

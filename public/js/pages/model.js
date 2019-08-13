function create_model(data = null) {
    if(data != null) {
        $("#modelId").data('id',data.id);
        $('#noOfQuestions').val(data.noOfQuestions);
        $("#saveBtn")[0].innerHTML = "Update";

        $('#categoryId').val(data.categoryId);

        $('#minLevel').val(data.minLevel);

        $('#addModel').modal('show');
    }else{
        $("#modelId").data('id','-1');
        $("#saveBtn")[0].innerHTML = "Add";
        $('#categoryId').val('');
        $('#minLevel').val('');
        $('#noOfQuestions').val("");
        $('#addModel').modal('show');
    }
}
 
$(document).ready(function() {
    refresh();
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if(btn == "Update") {
        updateModel();
    } else {
        addModel();
    }
});


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

function updateModel() {
     $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var programId = $('#programId').data('id');
    var id = $('#modelId').data('id');
    if(id > 0) {
        $.ajax({
            url: '../../question/modelController/update',
            async: true,
            type: 'POST',
            data: {
                id: $('#modelId').data('id'),
                programId: $('#programId').data('id'),
                categoryId: $('#categoryId').val(),
                minLevel: $('#minLevel').val(),
                maxLevel: $('#minLevel').val(),
                noOfQuestions: $('#noOfQuestions').val()
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addModel').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                      $.notify(element, "error");
                    });
                    if(decode.status === -1) $('#addModel').modal('hide');
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

function addModel(){

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    $.ajax({
        url: '../../question/modelController/add',
        async: true,
        type: 'POST',
        data: {
            programId: $('#programId').data('id'),
            categoryId: $('#categoryId').val(),
            minLevel: $('#minLevel').val(),
            maxLevel: $('#minLevel').val(),
            noOfQuestions: $('#noOfQuestions').val()
            },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addModel').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                  $.notify(element, "error");
                });
                if(decode.status == -1) $('#addModel').modal('hide');
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
            url: '../../question/modelController/delete',
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

function sleep (time) {
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


function getAllData(){
    var programId = $('#programId').data('id');
    if(programId > 0) {
        $("#modelTable").dataTable().fnDestroy();
        var table = $('#modelTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../../question/modelController/get",
                "data": {
                    programId: programId
                },
                "type": "POST"
            },
            "columns": [
                { "data": "category" },
                { "data": "levelName" },
                { "data": "noOfQuestions" },
                {   
                     sortable: false,
                     "render": function ( data, type, row, meta ) {
                        return "<a data-id="+ row.id +" class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i> </a><a data-id="+ row.id +" class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                     }
                }
            ],
            "order": [[1, 'asc']]
        } );

        $('#modelTable tbody').on('click', '.edit-icon', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            create_model(row.data());
        } );
    }
}
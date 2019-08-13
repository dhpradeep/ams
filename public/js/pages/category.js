function create_category(data = null) {
    if(data != null) {
        $('#addCategory').modal('show');
    }else{
        $("#categoryId").data('id','-1');
        $("#saveBtn")[0].innerHTML = "Add";
        $("#categoryName").val("");
        $("#categoryDescription").val("");
        $('#addCategory').modal('show');
    }
}
 
$(document).ready(function() {
    refresh();
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if(btn == "Update") {
        updateCategory();
    } else {
        addCategory();
    }
});

$(document).on("click", ".edit-icon", function() {
    var columnValues = $(this).parent().siblings().map(function() {
        return $(this).text();
    }).get();

    $('#categoryId').data('id', $(this).data('id'));
    $("#saveBtn")[0].innerHTML = "Update";
    $("#categoryName").val(columnValues[0].trim());
    $("#categoryDescription").val(columnValues[1].trim());

    catId = $(this).data('id');
    create_category(catId);
});

$(document).on("click", ".remove-icon", function(e) {
    var id = $(this).data('id');
    BootstrapDialog.show({
        title: 'Delete',
        message: 'Are you sure to delete this record? <b>(All questions and question models of the category will be deleted)</b>',
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

function updateCategory() {
     $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('#categoryId').data('id');
    if(id > 0) {
        $.ajax({
            url: '../question/category/update',
            async: true,
            type: 'POST',
            data: {
                id: $('#categoryId').data('id'),
                name: $('#categoryName').val(),
                description: $('#categoryDescription').val()
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addCategory').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                      $.notify(element, "error");
                    });
                    if(decode.status === -1) $('#addCategory').modal('hide');
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

function addCategory(){

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    $.ajax({
        url: '../question/category/add',
        async: true,
        type: 'POST',
        data: {
            name: $('#categoryName').val(),
            description: $('#categoryDescription').val()
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addCategory').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                  $.notify(element, "error");
                });
                if(decode.status == -1) $('#addCategory').modal('hide');
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
            url: '../question/category/delete',
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
    $("#categoryTable").dataTable().fnDestroy();
     $('#categoryTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../question/category/get",
            "type": "POST"
        },
        "columns": [
            { "data": "name" },
            { "data": "description" },
            {   
                 sortable: false,
                 "render": function ( data, type, row, meta ) {
                     return "<a data-id="+ row.id +" class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i> </a><a data-id="+ row.id +" class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                 }
            }
        ]
    } );
}
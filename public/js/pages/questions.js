jQuery.fn.CKEditorValFor = function(element_id) {
    return CKEDITOR.instances[element_id].getData();
}

$('#addQuestion').on('hidden.bs.modal', function(e) {
    resetFields();
});

function resetFields() {
    CKEDITOR.instances['question'].setData("");
    $("#questionId").data('id','-1');
    $('#answer').val('');
    $('#choice2').val('');
    $('#choice3').val('');
    $('#choice4').val('');
    $('#level').val('');
    $('#categoryId').val('');
}

function create_question(data = null) {
    if(data != null) {
        if(data != undefined) {
            CKEDITOR.instances['question'].setData(data.question);
            $("#questionId").data('id',data.id);
            $("#saveBtn")[0].innerHTML = "Update";
            $('#answer').val(data.answer);
            $('#choice2').val(data.choice2);
            $('#choice3').val(data.choice3);
            $('#choice4').val(data.choice4);

            $('#level').val(data.level);

            $('#categoryId').val(data.categoryId);

            $('#addQuestion').modal('show');
        }        
    }else{
            $("#saveBtn")[0].innerHTML = "Add";
                   
            $('#addQuestion').modal('show');
    }
}
 
$(document).ready(function() {
    CKEDITOR.replace('question');
    refresh();
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if(btn == "Update") {
        updateQuestion();
    } else {
        addQuestion();
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

function updateQuestion() {
     $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('#questionId').data('id');
    if(id > 0) {
        $.ajax({
            url: '../question/all/update',
            async: true,
            type: 'POST',
            data: {
                id: $('#questionId').data('id'),
                categoryId: $('#categoryId').children("option:selected").val(),
                question : $().CKEditorValFor('question'),
                level: $('#level').children("option:selected").val(),
                answer: $('#answer').val(),
                choice2: $('#choice2').val(),
                choice3: $('#choice3').val(),
                choice4: $('#choice4').val()
            },
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addQuestion').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                      $.notify(element, "error");
                    });
                    if(decode.status === -1) $('#addQuestion').modal('hide');
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

function addQuestion(){

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    $.ajax({
        url: '../question/all/add',
        async: true,
        type: 'POST',
        data: {
            categoryId: $('#categoryId').children("option:selected").val(),
            question : $().CKEditorValFor('question'),
            level: $('#level').children("option:selected").val(),
            answer: $('#answer').val(),
            choice2: $('#choice2').val(),
            choice3: $('#choice3').val(),
            choice4: $('#choice4').val()
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addQuestion').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                  $.notify(element, "error");
                });
                if(decode.status == -1) $('#addQuestion').modal('hide');
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
            url: '../question/all/delete',
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
    resetFields();
   animate(500);
}

/* Formatting function for row details*/
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td class = "choices">Question:</td>'+
            '<td class = "answers"><b>'+d.question+'</b></td>'+
        '</tr>'+
        '<tr>'+
            '<td class = "choices">Answer:</td>'+
            '<td class = "answers"><b>'+d.answer+'</b></td>'+
        '</tr>'+
        '<tr>'+
            '<td class = "choices">2nd Choice:</td>'+
            '<td class = "answers">'+d.choice2+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class = "choices">3rd Choice:</td>'+
            '<td class = "answers">'+d.choice3+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class = "choices">4th Choice:</td>'+
            '<td class = "answers">'+d.choice4+'</td>'+
        '</tr>'+
    '</table>';
}

function getAllData(){
    $("#questionTable").dataTable().fnDestroy();
    var table = $('#questionTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../question/all/get",
            "type": "POST"
        },
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { 
                "data" : "question"
            },
            { "data": "category" },
            { "data": "levelName" },
            {   
                 sortable: false,
                 "render": function ( data, type, row, meta ) {
                     return "<a data-id="+ row.id +" class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i> </a><a data-id="+ row.id +" class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                 }
            }
        ],
        "order": [[1, 'asc']]
    } );

     // Add event listener for opening and closing details
    $('#questionTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        if(row.data() != undefined) {
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        }
    } );

    $('#questionTable tbody').on('click', '.edit-icon', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        create_question(row.data());
    } );
}
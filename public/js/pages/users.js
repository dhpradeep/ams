function create_user(data = null) {
    $('#adduser').modal('show');
}

$('body').on('shown.bs.modal', '#adduser', function() {
    $('input:visible:enabled:first', this).focus();
});

$('body').on('hidden.bs.modal', '#adduser', function() {
    resetFields();
});

$('body').on('hidden.bs.modal', '#resetuser', function() {
    $('#idReset').val(-1);
    $('#nameToReset').html("");
    $('#pass').val("");
    $('#confirmPass').val("");
});

$('body').on('click', '.reset-icon', function(e){
    var id = $(this).data('id');
    var name = $(this).data('name');
    if(id > 0){
        $('#idReset').val(id);
        $('#nameToReset').html(name);
        $('#resetuser').modal('show');
    }
});

function resetFields() {
    $('#idReset').val(-1);
    $('#fname').val("");
    $('#mname').val("");
    $('#lname').val("");
    $('#username').val("");
    $('#passwordHash').val("");
    $('#cpasswordHash').val("");
    $('#email').val("");
    $('#mobileNo').val("");
    $('#role').val(1);
}

$(document).ready(function() {
    refresh();
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

$(document).on("change", ".change-role", function(e) {
    var id = $(this).data('id');
    var role = $(this).children("option:selected").val();
    updateUser(id, role);
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    addUser();
});

function updateUser(id, role) {
    $.ajax({
        url: '../user/users/update',
        async: true,
        type: 'POST',
        data: {
            id: id,
            role: role
        },
        success: function(response) {
            animate(300);
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $.notify("Record successfully updated", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                if (decode.status === -1) $('#adduser').modal('hide');
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

function addUser() {

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    $.ajax({
        url: '../user/users/add',
        async: true,
        type: 'POST',
        data: {
            fname: $('#fname').val(),
            mname: $('#mname').val(),
            lname: $('#lname').val(),
            username: $('#username').val(),
            passwordHash: $('#passwordHash').val(),
            cpasswordHash: $('#cpasswordHash').val(),
            email: $('#email').val(),
            mobileNo: $('#mobileNo').val(),
            role: $('#role').val()
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#adduser').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                if (decode.status == -1) $('#adduser').modal('hide');
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
        url: '../user/users/delete',
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

$(document).on("click", "#resetUserBtn", function(e) {
    e.preventDefault();
    resetpassword();
});

function resetpassword(id) {
    var id = $('#idReset').val();
    if(id > 0) {
        $.ajax({
            url: '../user/users/reset',
            async: true,
            type: 'POST',
            data: {
                id: id,
                pass: $('#pass').val(),
                confirmPass: $('#confirmPass').val()
            },
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#resetuser').modal('hide');
                    refresh();
                    $.notify("Password successfully reset", "success");

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
}

$(document).on("change", "#filterData", function(e) {
    e.preventDefault();
    getAllData();
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
        // $.notify("All records display", "info");
        spinner.stop();
    });
    return;
}

function refresh() {
    getAllData();
    animate(500);
}

function getAllData() {

    $("#userTable").dataTable().fnDestroy();
    $('#userTable').DataTable({
        "processing": true,
        "serverSide": true,
        stateSave : true,
        "ajax": {
            "url": "../user/users/get",
            "type": "POST",
            "data": {
                filterData: $("#filterData").val()
            }
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "columns": [
            { "data": "name" },
            { "data": "username" },
            { "data": "email" },
            { "data": "mobileNo" ,
                sortable: false
            },
            {
                "data": "role",
                sortable: true,
                "render": function(data, type, row, meta) {
                    return "<select style = 'width:80%' class='form-control change-role' data-id=" + row.id + ">" +
                        "<option" + (row.role == 1 ? ' selected' : '') + " value='1'>Admin</option>" +
                        "<option" + (row.role == 2 ? ' selected' : '') + " value='2'>Teacher</option>" +
                        "</select>";
                }
            },
            {
                sortable: false,
                "render": function(data, type, row, meta) {
                    return "<a data-id=" + row.id + " data-name=" + row.name + " class='reset-icon btn btn-warning btn-xs'>Reset</a>" +
                    "<a data-id=" + row.id + " class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>";
                }
            }
        ]
    });
}
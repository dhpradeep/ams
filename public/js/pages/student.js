$('#addStudent').on('hidden.bs.modal', function(e) {
    resetFields();
});

function resetFields() {
    $("#nestedForm").empty();
    $("#studentId").data('id', '-1');
    $("#counter").data("id", '0');

    $('#fname').val('');
    $('#mname').val('');
    $('#lname').val('');
    $('#programId').val('');
    //$('#doa').val('2019-08-09');
    $('#dobAd').val('');
    $('#gender').val('');
    //$('#nationality').val('');
    $('#fatherName').val('');
    $('#municipality').val('');
    $('#wardNo').val('');
    $('#area').val('');
    $('#district').val('');
    $('#zone').val('');
    $('#mobileNo').val('');
    $('#telephoneNo').val('');
    $('#blockNo').val('');
    $('#email').val('');
    $('#guardianName').val('');
    $('#guardianRelation').val('');
    $('#guardianContact').val('');
    $('#formNo').val('');
    $('#entranceNo').val('');

    $("#eligible").prop("checked", false);
    $("#marksheet_see").prop("checked", false);
    $("#marksheet_11").prop("checked", false);
    $("#marksheet_12").prop("checked", false);
    $("#transcript").prop("checked", false);
    $("#characterCertificate_see").prop("checked", false);
    $("#characterCertificate_12").prop("checked", false);
    $("#citizenship").prop("checked", false);
    $("#photo").prop("checked", false);

    $("#remarks").val('');
}

function isTrue(str) {
    return (str == "true");
}

function setFields(data) {
    $("#nestedForm").empty();
    $("#studentId").data('id', data.id);
    $('#fname').val(data.fname);
    $('#mname').val(data.mname);
    $('#lname').val(data.lname);
    $('#programId').val(data.programId);
    $('#doa').val(data.doa);
    $('#dobAd').val(data.dobAd);
    $('#gender').val(data.gender);
    $('#nationality').val(data.nationality);
    $('#fatherName').val(data.fatherName);
    $('#municipality').val(data.municipality);
    $('#wardNo').val(data.wardNo);
    $('#area').val(data.area);
    $('#district').val(data.district);
    $('#zone').val(data.zone);
    $('#mobileNo').val(data.mobileNo);
    $('#telephoneNo').val(data.telephoneNo);
    $('#blockNo').val(data.blockNo);
    $('#email').val(data.email);
    $('#guardianName').val(data.guardianName);
    $('#guardianRelation').val(data.guardianRelation);
    $('#guardianContact').val(data.guardianContact);
    $('#formNo').val(data.formNo);
    $('#entranceNo').val(data.entranceNo);

    $("#eligible").prop("checked", isTrue(data.eligible));
    $("#marksheet_see").prop("checked", isTrue(data.marksheet_see));
    $("#marksheet_11").prop("checked", isTrue(data.marksheet_11));
    $("#marksheet_12").prop("checked", isTrue(data.marksheet_12));
    $("#transcript").prop("checked", isTrue(data.transcript));
    $("#characterCertificate_see").prop("checked", isTrue(data.characterCertificate_see));
    $("#characterCertificate_12").prop("checked", isTrue(data.characterCertificate_12));
    $("#citizenship").prop("checked", isTrue(data.citizenship));
    $("#photo").prop("checked", isTrue(data.photo));

    $("#remarks").val(data.remarks);
    for (var i = 0; i < data.edu.length; i++) {
        educationFormMaker();
        $("#level" + i).val(data.edu[i].level);
        $("#board" + i).val(data.edu[i].board);
        $("#faculty" + i).val(data.edu[i].faculty);
        $("#yearOfCompletion" + i).val(data.edu[i].yearOfCompletion);
        $("#percent" + i).val(data.edu[i].percent);
        $("#institution" + i).val(data.edu[i].institution);
    }
}

function create_student(data = null) {
    if (data != null) {
        if (data != undefined) {
            $("#saveBtn")[0].innerHTML = "Update";
            setFields(data);
            $('#addStudent').modal('show');
        }
    } else {
        $("#saveBtn")[0].innerHTML = "Add";
        $('#addStudent').modal('show');
    }
}

$(document).ready(function() {
    refresh();
});

$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if (btn == "Update") {
        updateStudent();
    } else {
        addStudent();
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

function prepareData(id = 0) {
    var data = {};
    if (id > 0) {
        data.id = $("#studentId").data('id');
    }
    data.fname = $('#fname').val();
    data.mname = $('#mname').val();
    data.lname = $('#lname').val();
    data.programId = $('#programId').val();
    data.doa = $('#doa').val();
    data.dobAd = $('#dobAd').val();
    data.gender = $('#gender').val();
    data.nationality = $('#nationality').val();
    data.fatherName = $('#fatherName').val();
    data.municipality = $('#municipality').val();
    data.wardNo = $('#wardNo').val();
    data.area = $('#area').val();
    data.district = $('#district').val();
    data.zone = $('#zone').val();
    data.mobileNo = $('#mobileNo').val();
    data.telephoneNo = $('#telephoneNo').val();
    data.blockNo = $('#blockNo').val();
    data.email = $('#email').val();
    data.guardianName = $('#guardianName').val();
    data.guardianRelation = $('#guardianRelation').val();
    data.guardianContact = $('#guardianContact').val();
    data.formNo = $('#formNo').val();
    data.entranceNo = $('#entranceNo').val();

    data.eligible = $("#eligible").prop("checked");
    data.marksheet_see = $("#marksheet_see").prop("checked");
    data.marksheet_11 = $("#marksheet_11").prop("checked");
    data.marksheet_12 = $("#marksheet_12").prop("checked");
    data.transcript = $("#transcript").prop("checked");
    data.characterCertificate_see = $("#characterCertificate_see").prop("checked");
    data.characterCertificate_12 = $("#characterCertificate_12").prop("checked");
    data.citizenship = $("#citizenship").prop("checked");
    data.photo = $("#photo").prop("checked");

    data.remarks = $("#remarks").val();

    data.edu = [];

    var counter = $("#counter").data("id");

    for (var i = 0; i < counter; i++) {
        var obj = {};
        obj.level = $("#level" + i).val();
        obj.board = $("#board" + i).val();
        obj.faculty = $("#faculty" + i).val();
        obj.yearOfCompletion = $("#yearOfCompletion" + i).val();
        obj.percent = $("#percent" + i).val();
        obj.institution = $("#institution" + i).val();
        data.edu.push(obj);
    }

    return data;
}

function updateStudent() {
    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });

    var id = $('#studentId').data('id');
    if (id > 0) {
        var allData = prepareData(id);
        $.ajax({
            url: '../student/all/update',
            async: true,
            type: 'POST',
            data: allData,
            success: function(response) {
                animate(300);
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addStudent').modal('hide');
                    refresh();
                    $.notify("Record successfully updated", "success");
                } else if (decode.success === false) {
                    decode.errors.forEach(function(element) {
                        $.notify(element, "error");
                    });
                    if (decode.status === -1) $('#addStudent').modal('hide');
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

function addStudent() {

    $('input[type="text"]').each(function() {
        $(this).val($(this).val().trim());
    });
    var allData = prepareData(0);

    $.ajax({
        url: '../student/all/add',
        async: true,
        type: 'POST',
        data: allData,
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                $('#addStudent').modal('hide');
                refresh();
                $.notify("Record successfully saved", "success");
            } else if (decode.success === false) {
                decode.errors.forEach(function(element) {
                    $.notify(element, "error");
                });
                if (decode.status == -1) $('#addStudent').modal('hide');
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
        url: '../student/all/delete',
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
    resetFields();
    animate(500);
}

function returnIcon(str) {
    if (isTrue(str)) {
        return "<a class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
    } else {
        return "<a class='btn btn-warning btn-xs'><i class='fa fa-remove'></i></a>";
    }
}

/* Formatting function for row details*/
function format(d) {
    var start = '<tr>' +
        '<td class = "choices">Education : </td>' +
        '<td class = "answers"></td>' +
        '</tr>';
    var end = "";
    for (var i = 0; i < d.edu.length; i++) {
        end += '<tr>' +
            '<td class = "choices">Level:</td>' +
            '<td class = "answers"><i>' + d.edu[i].levelName + '</i></td>' +
            '<td class = "choices">Board</td>' +
            '<td class = "answers">' + d.edu[i].board + '</td>' +
            '<td class = "choices">Faculty:</td>' +
            '<td class = "answers"><i>' + d.edu[i].faculty + '</i></td>' +
            '</tr>' +
            '<tr>' +
            '<td class = "choices">Year of Completion:</td>' +
            '<td class = "answers">' + d.edu[i].yearOfCompletion + '</td>' +
            '<td class = "choices">Percent/GPA:</td>' +
            '<td class = "answers">' + d.edu[i].percent + '</td>' +
            '<td class = "choices">Institute:</td>' +
            '<td class = "answers">' + d.edu[i].institution + '</td>' +
            '</tr>';
    }
    var education = start + end;

    var documents = '<tr>' +
        '<td class = "choices">Eligible:</td>' +
        '<td class = "answers">' + returnIcon(d.eligible) + '</td>' +
        '<td class = "choices">Marksheet SEE/SLC:</td>' +
        '<td class = "answers">' + returnIcon(d.marksheet_see) + '</td>' +
        '<td class = "choices">Marksheet 11:</td>' +
        '<td class = "answers">' + returnIcon(d.marksheet_11) + '</td>' +
        '<td class = "choices">Marksheet 12:</td>' +
        '<td class = "answers">' + returnIcon(d.marksheet_12) + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Transcript:</td>' +
        '<td class = "answers">' + returnIcon(d.transcript) + '</td>' +
        '<td class = "choices">Character Certificate SEE/SLC:</td>' +
        '<td class = "answers">' + returnIcon(d.characterCertificate_see) + '</td>' +
        '<td class = "choices">Character Certificate (+2):</td>' +
        '<td class = "answers">' + returnIcon(d.characterCertificate_12) + '</td>' +
        '<td class = "choices">Citizenship:</td>' +
        '<td class = "answers">' + returnIcon(d.citizenship) + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Photo:</td>' +
        '<td class = "answers">' + returnIcon(d.photo) + '</td>' +
        '</tr>';
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td class = "choices">Password:</td>' +
        '<td class = "answers"><i>' + d.password + '</i></td>' +
        '<td class = "choices"></td>' +
        '<td class = "answers"></td>' +
        '<td class = "choices">Form Number:</td>' +
        '<td class = "answers"><i>' + d.formNo + '</i></td>' +
        '<td class = "choices">Program:</td>' +
        '<td class = "answers">' + d.programName + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices"></td>' +
        '<td class = "answers"></td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Date of application:</td>' +
        '<td class = "answers">' + d.doa + '</td>' +
        '<td class = "choices">Date of Birth (AD):</td>' +
        '<td class = "answers">' + d.dobAd + '</td>' +
        '<td class = "choices">Date of Birth (BS):</td>' +
        '<td class = "answers">' + d.dobBs + '</td>' +
        '<td class = "choices">Gender:</td>' +
        '<td class = "answers">' + d.genderName + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Nationality:</td>' +
        '<td class = "answers">' + d.nationality + '</td>' +
        '<td class = "choices">Father\'s name:</td>' +
        '<td class = "answers">' + d.fatherName + '</td>' +
        '<td class = "choices">Municipality:</td>' +
        '<td class = "answers">' + d.municipality + '</td>' +
        '<td class = "choices">Ward No:</td>' +
        '<td class = "answers">' + d.wardNo + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Area:</td>' +
        '<td class = "answers">' + d.area + '</td>' +
        '<td class = "choices">District:</td>' +
        '<td class = "answers">' + d.district + '</td>' +
        '<td class = "choices">Zone:</td>' +
        '<td class = "answers">' + d.zone + '</td>' +
        '<td class = "choices">Mobile No:</td>' +
        '<td class = "answers">' + d.mobileNo + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Telephone No:</td>' +
        '<td class = "answers">' + d.telephoneNo + '</td>' +
        '<td class = "choices">Block No.:</td>' +
        '<td class = "answers">' + d.blockNo + '</td>' +
        '<td class = "choices">Guardian Name:</td>' +
        '<td class = "answers">' + d.guardianName + '</td>' +
        '<td class = "choices">Guardian Relation:</td>' +
        '<td class = "answers">' + d.guardianRelation + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Guardian Contact:</td>' +
        '<td class = "answers">' + d.guardianContact + '</td>' +
        '</tr>' + education +
        documents +
        '<tr>' +
        '<td class = "choices">Remarks:</td>' +
        '<td class = "answers">' + d.remarks + '</td>' +
        '</tr>' +
        '</table>';
}

function getAllData() {
    $("#studentTable").dataTable().fnDestroy();
    var table = $('#studentTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../student/all/get",
            "type": "POST"
        },
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                "data": "name"
            },
            { "data": "entranceNo" },
            { "data": "username" },
            { "data": "email" },
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

    // Add event listener for opening and closing details
    $('#studentTable tbody').on('click', '.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.data() != undefined) {
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        }
    });

    $('#studentTable tbody').on('click', '.edit-icon', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        create_student(row.data());
    });
}
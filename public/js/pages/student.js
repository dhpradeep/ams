$('#addStudent').on('hidden.bs.modal', function(e) {
    resetFields();
});

$(".next").click(function() { $('#tabList li.active').next('li').find('a').trigger('click') });
$(".previous").click(function() { $('#tabList li.active').prev('li').find('a').trigger('click') });

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

function resetFields() {
    $("#studentId").data('id', '-1');
    $('#tabList li').first().find('a').trigger('click');

    $('#fname').val('');
    $('#mname').val('');
    $('#lname').val('');
    $('#programId').val('-1');
    semesterAddFunction();
    $('#yearOrSemester').val('-1');
    sectionAddFunction();
    $('#sectionId').val('-1');
    $('#dobAd').val('');
    $('#rollNo').val('');
    $('#gender').val('-1');
    $('#nationality').val('Nepali');
    $('#fatherName').val('');
    $('#municipality').val('');
    $('#wardNo').val('');
    $('#area').val('');
    $('#district').val('');
    $('#zone').val('');
    $('#mobileNo').val('');
    $('#telephoneNo').val('');
    $('#email').val('');
    $('#guardianName').val('');
    $('#guardianRelation').val('');
    $('#guardianContact').val('');
    $('#level').val('1');
    $('#board').val('');
    $('#faculty').val('');
    $('#yearOfCompletion').val('');
    $('#percent').val('');
    $('#institution').val('');

}

function setFields(data) {
    $("#studentId").data('id', data.id);
    $('#fname').val(data.fname);
    $('#mname').val(data.mname);
    $('#lname').val(data.lname);
    $('#programId').val(data.programId);
    semesterAddFunction();
    $('#yearOrSemester').val(data.yearOrSemester);
    sectionAddFunction(null, 0, data.sectionId);
    //$('#sectionId').val(data.sectionId);
    $('#dobAd').val(data.dobAd);
    $('#rollNo').val(data.rollNo);
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
    $('#email').val(data.email);
    $('#guardianName').val(data.guardianName);
    $('#guardianRelation').val(data.guardianRelation);
    $('#guardianContact').val(data.guardianContact);
    $("#level").val(data.level);
    $("#board").val(data.board);
    $("#faculty").val(data.faculty);
    $("#yearOfCompletion").val(data.yearOfCompletion);
    $("#percent").val(data.percent);
    $("#institution").val(data.institution);
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
    $('#toExport').hide();
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

$(document).on("click", "#upgradeProgramBtn", function(e) {
    var id = $("#upgradeProgram").val();
    console.log(id);
    BootstrapDialog.show({
        title: 'Delete',
        message: '<b>Are you sure to upgrade all student in the final semester/year to passout?</b>',
        buttons: [{
            label: 'Yes',
            cssClass: 'btn-primary',
            action: function(dialog) {
                upgradeProgram(id);
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


function upgradeProgram(id) {
    if (!(id >= 1)) {
        $.notify("Please select valid program");
        return;
    }

    $.ajax({
        url: '../student/upgrade/program',
        async: true,
        type: 'POST',
        data: {
            programId: id
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                refresh();
                $.notify("Program upgraded successfully", "success");
            } else if (decode.success === false) {
                if (decode.error != undefined) {
                    $.notify(decode.error, "error");
                }
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

function prepareData(id = 0) {
    var data = {};
    if (id > 0) {
        data.id = $("#studentId").data('id');
    }
    data.fname = $('#fname').val();
    data.mname = $('#mname').val();
    data.lname = $('#lname').val();
    data.programId = $('#programId').val();
    data.yearOrSemester = $('#yearOrSemester').val();
    data.sectionId = $('#sectionId').val();
    data.dobAd = $('#dobAd').val();
    data.rollNo = $('#rollNo').val();
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
    data.email = $('#email').val();
    data.guardianName = $('#guardianName').val();
    data.guardianRelation = $('#guardianRelation').val();
    data.guardianContact = $('#guardianContact').val();
    data.level = $('#level').val();
    data.board = $('#board').val();
    data.faculty = $('#faculty').val();
    data.yearOfCompletion = $('#yearOfCompletion').val();
    data.percent = $('#percent').val();
    data.institution = $('#institution').val();

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
        //$.notify("All records display", "info");
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
function format(d) {
    var start = '<tr>' +
        '<td class = "choices">Education : </td>' +
        '<td class = "answers"></td>' +
        '</tr>';
    var end = "";
    end += '<tr>' +
        '<td class = "choices">Level:</td>' +
        '<td class = "answers"><i>' + d.levelName + '</i></td>' +
        '<td class = "choices">Board</td>' +
        '<td class = "answers">' + d.board + '</td>' +
        '<td class = "choices">Faculty:</td>' +
        '<td class = "answers"><i>' + d.faculty + '</i></td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Year of Completion:</td>' +
        '<td class = "answers">' + d.yearOfCompletion + '</td>' +
        '<td class = "choices">Percent/GPA:</td>' +
        '<td class = "answers">' + d.percent + '</td>' +
        '<td class = "choices">Institute:</td>' +
        '<td class = "answers">' + d.institution + '</td>' +
        '</tr>';
    var education = start + end;

    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td class = "choices">Date of Birth (AD):</td>' +
        '<td class = "answers">' + d.dobAd + '</td>' +
        '<td class = "choices">Gender:</td>' +
        '<td class = "answers">' + d.genderName + '</td>' +
        '<td class = "choices">Nationality:</td>' +
        '<td class = "answers">' + d.nationality + '</td>' +
        '</tr>' +
        '<tr>' +
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
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Mobile No:</td>' +
        '<td class = "answers">' + d.mobileNo + '</td>' +
        '<td class = "choices">Telephone No:</td>' +
        '<td class = "answers">' + d.telephoneNo + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class = "choices">Guardian Name:</td>' +
        '<td class = "answers">' + d.guardianName + '</td>' +
        '<td class = "choices">Guardian Relation:</td>' +
        '<td class = "answers">' + d.guardianRelation + '</td>' +
        '<td class = "choices">Guardian Contact:</td>' +
        '<td class = "answers">' + d.guardianContact + '</td>' +
        '</tr>' + education +
        '<tr>' +
        '</table>';
}

function export_format(data) {
    var arr = {
        rollNo: "Roll No",
        name: "Fullname",
        programName: "Program",
        yearOrSemester: "Semester / Year",
        sectionName: "Section",
        dobAd: "Date of Birth (AD)",
        genderName: "Gender",
        nationality: "Nationality",
        fatherName: "Father's name",
        municipality: "Municipality",
        wardNo: "Ward No",
        area: "Area",
        district: "District",
        zone: "Zone",
        mobileNo: "Mobile",
        telephoneNo: "Telephone",
        guardianName: "Guardian Name",
        guardianRelation: "Guardian Relation",
        guardianContact: "Guardian Contact",
        levelName: "Level",
        board: "Board",
        faculty: "Faculty",
        yearOfCompletion: "Year",
        percent: "Percent / GPA",
        institution: "Institute"
    };

    if (data.length <= 0) {
        $.notify("No data to export!");
        return;
    }
    var doc = "<table border='1'><tr>";
    var key;
    for (key in arr) {
        doc += "<th>" + arr[key] + "</th>";
    }
    doc += "</tr>";
    for (i = 0; i < data.length; i++) {
        doc += "<tr>";

        for (key in arr) {
            if (data[i][key] == undefined) {
                doc += "<td></td>";
            } else {
                doc += "<td>" + data[i][key] + "</td>";
            }
        }
        doc += "</tr>";
    }

    doc += "</table>";
    $('#toExport').html(doc);
    exportTableToCSV("studentData.csv");

}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], { type: "text/csv" });

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}


function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#toExport table tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [],
            cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function print_to_excel(data) {
    var data = data.json.data;
    export_format(data);
}

function getAllData(trigger = null) {
    $("#studentTable").dataTable().fnDestroy();
    var table = $('#studentTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../student/all/get",
            "type": "POST",
            "data": {
                filterDataProgram: $("#filterDataProgram").val(),
                filterDataSemester: $("#filterDataSemester").val(),
                filterDataSection: $("#filterDataSection").val()
            }
        },
        "drawCallback": function(data) {
            if (trigger != null) {
                trigger = null;
                print_to_excel(data);
            }
        },
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                "data": "rollNo"
            },
            {
                "data": "name"
            },
            {
                "data": "programName",
                sortable: false
            },
            {
                "data": "yearOrSemester",
                "render": function(data, type, row, meta) {
                    return (row.yearOrSemester == -2) ? "Graduated" : row.yearOrSemester;
                }
            },
            { "data": "sectionName" },
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
$(document).ready(function() {
    $('input[name="daterange"]').daterangepicker();
    $('#studentTable').hide();
    $('#studentList').hide();
    $('#morris-bar-chart').hide();
});

$(".filter_bar").click(function() {
    $(".filter_bar_val").slideToggle();
});


$(".filter_table").click(function() {
    $(".filter_table_val").slideToggle();
});

$(document).on("click", "#export_excel", function(e) {
    var id = $(this).data('id');
    BootstrapDialog.show({
        title: 'Export',
        message: 'Are you sure to export this record?',
        buttons: [{
            label: 'Yes',
            cssClass: 'btn-primary',
            action: function(dialog) {
                exportTableToCSV('records.csv');
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



$("#filterDataProgram").change(function() {
    semesterAddFunction($(this), 0);
    sectionAddFunction(null, 0);
});

$("#filterDataSemester").change(function() {
    sectionAddFunction($(this), 0);
});

$("#filterDataProgram1").change(function() {
    semesterAddFunction($(this), 1);
    sectionAddFunction(null, 1);
});

$("#filterDataSemester1").change(function() {
    sectionAddFunction($(this), 1);
});

$("#filterOverview1").click(function() {
    getAllData(-1);
});

$("#filterOverview").click(function() {
    getAllData(0);
});

function dateDiff(dt1, dt2) {
    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) -
        Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
}

function dateFormater(today) {
    var dd = today.getDate();

    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    today = yyyy + '-' + mm + '-' + dd;
    return today;
}

function validate(mode = 0) {
    var programId = $("#filterDataProgram").val();
    var semester = $("#filterDataSemester").val();
    var sectionId = $("#filterDataSection").val();
    var dateRange = $("#filterDataDate").val();
    if (mode == -1) {
        programId = $("#filterDataProgram1").val();
        semester = $("#filterDataSemester1").val();
        sectionId = $("#filterDataSection1").val();
        dateRange = $("#filterDataDate1").val();
    }
    var dates, startDate, endDate;
    if (dateRange.length > 0) {
        dates = dateRange.split("-");
        startDate = dates[0].trim();
        endDate = dates[1].trim();
        startDate = new Date(startDate);
        endDate = new Date(endDate);
        dates[0] = dateFormater(startDate);
        dates[1] = dateFormater(endDate);
        dates[2] = programId;
        dates[3] = semester;
        dates[4] = sectionId;
        return (dateDiff(startDate, endDate) >= 0 && programId > 0 && (semester > 0 || semester == -2 ) && sectionId > 0) ? dates : null;
    }
    return null;
}

function semesterAddFunction(data = null, mode = 0) {
    var source, destination;
    if (mode == 0) {
        source = "#filterDataProgram";
        destination = "#filterDataSemester";
    } else {
        source = "#filterDataProgram1";
        destination = "#filterDataSemester1";
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
    html += '<option data-value="-2" value="-2">Graduated</option>';
    $(destination).html(html);
}

function sectionAddFunction(data = null, mode = 0) {
    var source, destination, root;
    if (mode == 0) {
        root = "#filterDataProgram";
        source = "#filterDataSemester";
        destination = "#filterDataSection";
    } else {
        root = "#filterDataProgram1";
        source = "#filterDataSemester1";
        destination = "#filterDataSection1";
    }
    if (data == null) {
        data = $(source);
    }
    var programId = $(root).find(':selected').data("value");
    var yearOrSemester = data.find(':selected').data("value");
    if ((yearOrSemester > 0 || yearOrSemester == -2) && programId > 0) {
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
            },
            error: function(error) {
                if (error.responseText) {
                    var msg = JSON.parse(error.responseText)
                    $.notify(msg.msg, "error");
                }
                return;
            }
        });
    } else {
        var html = '<option value="-1">None</option>';
        $(destination).html(html);
    }
}


function getTable(subjectNames, studentNames, records) {
    var key, html = "<thead><tr><th>Roll No.</th><th>Name</th>";
    for (key in subjectNames) {
        html += "<th>" + subjectNames[key]['name'] + " ( " + subjectNames[key]['totalAttendance'] +" )</th>";
    }
    html += "</tr></thead><tbody>";

    for (key in studentNames) {
        html += "<tr><td>"+ studentNames[key]['rollNo'] +"</td><td>" + studentNames[key]['name'] + "</td>";
        var subkey;
        for (subkey in subjectNames) {
            html += "<td>" + records[key][subkey] + "</td>";
        }
        html += "</tr>";
    }
    html += "</tbody>";
    return html;
}

function getList(studentNames) {
    var key, html = "";
    for (key in studentNames) {
        html += '<div class="col col-md-6"><a href="#" data-id="' + key + '" id="student' +
            key + '" class="fetchData list-group-item list-group-item-action" style= "padding: 10px 15px;">' + studentNames[key]['name'] + '</a></div>';
    }
    return html;
}

$('#studentList').on('click', '.fetchData', function(e) {
    e.preventDefault();
    getAllData($(this).data('id'));
});


function checkObjectSize(obj) {
    return Object.keys(obj).length;
}


function getAllData(mode = 0) {

    var destination;
    if (mode == -1) {
        destination = $('#studentTable');
    } else if (mode == 0) {
        destination = $('#studentList');
    } else {
        destination = $('#morris-bar-chart');
        destination.html("");
    }

    var data = validate(mode);
    if (data == null) {
        $.notify("Filter Selection error", "error");
        destination.hide();
        if(mode == 0) {
            $('#morris-bar-chart').html('');
        }
        return;
    }

    $.ajax({
        "url": "../report/view/get1",
        async: true,
        type: 'POST',
        data: {
            programId: data[2],
            yearOrSemester: data[3],
            sectionId: data[4],
            startDate: data[0],
            endDate: data[1]
        },
        success: function(response) {
            var decode = JSON.parse(response);
            if (decode.success == true) {
                var html = 'Nothing to show';
                if (checkObjectSize(decode.data.records) >= 1 && checkObjectSize(decode.data.subjectNames) >= 1 && checkObjectSize(decode.data.studentNames) >= 1) {
                    if (mode == -1) html = getTable(decode.data.subjectNames, decode.data.studentNames, decode.data.records);
                    else if (mode == 0) html = getList(decode.data.studentNames);
                    else morrisChart(decode.data, mode);
                } else {
                    $.notify("Problem fetching data.", "error");
                }
                if (mode == -1 || mode == 0) {
                    if(mode == -1) {
                        $(".filter_table_val").hide();
                    }else {
                        $(".filter_bar_val").hide();
                    }
                    destination.html(html);
                }
                destination.show();
                return;
            } else if (decode.success == false) {
                var html = '<p style= "margin-left : 10px;">Error occured : ';
                if (decode.error != undefined) {
                    $.notify(decode.error, "error");
                    html += decode.error;
                } else {
                    $.notify("Problem fetching informations.", "error");
                }
                html += '</p>';
                destination.html(html);
                if(mode == 0) {
                    $('#morris-bar-chart').html('');
                }
                return;
            }
        },
        error: function(error) {
            if (error.responseText) {
                var msg = JSON.parse(error.responseText)
                $.notify(msg.msg, "error");
            }
            return;
        }
    });
}
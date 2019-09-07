
$(document).ready( function () {
    $('#tableToHide').hide();
});


$(document).on('click', '.fetchAttendance', function(e) {
	e.preventDefault();
	getAllData($(this).data('id'));
    $('#subjectSelected').data('id',$(this).data('id'));
});

$("#tableToHide").on('click', '#allChecker', function(e){
	var checked = $(this).prop("checked");
	$('.attendanceStatus').each(function() {
		$(this).prop("checked", checked);
	});
});

$("#tableToHide").on('click', '#sendAttendance', function(e){
	var subjectId = $(this).data('sid');
	var date = $(this).data('date');
	var status = [];
	$('.attendanceStatus').each(function() {
		var oneStatus = $(this).prop("checked");
		oneStatus = (oneStatus == true) ? 1 : 0;
		var id = $(this).data('id');
		var data = {
			userId : id,
			status : oneStatus
		};
		status.push(data);
	});
	sendData(status, subjectId, date);
});



function dateDiff(dt1, dt2) {
    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) -
     Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
}

function checkObjectSize(obj) {
    return Object.keys(obj).length;
}

function getHTML(data, subjectId, date) {
	var key, html;
	html = '<h3 class="text-center text-primary">List of Students</h3>'+                  
              '<div class="dataTable_wrapper attTable">'+
                  '<table class="table attTable">'+
                    '<thead>'+
                      '<tr>'+
                        '<th scope="col">Roll No</th>'+
                        '<th scope="col">Full Name</th>'+
                        '<th scope="col">Review</th>'+
                        '<th scope="col">'+
                          '<label class="switch">'+
                            '<input type="checkbox" id="allChecker">'+
                            '<span class="slider round"></span>'+
                          '</label>'+
                        '</th>'+
                      '</tr>'+
                    '</thead>'+
                    '<tbody>';
	for(key in data) {
		html += '<tr><td>'+ data[key]['rollNo'] +'</td><td>'+ data[key]['name'] + '</td>'+
                '<td>'+'<a data-sid='+ data[key]['userId'] +' data-tid= '+ $('#teacherId').data('id') +' data-sname='+
                 data[key]['name'] +
                 ' href="#" class="student-review btn btn-default btn-xs">Review <span class="badge badge-danger ml-2">'+
                 data[key]['reviewNo']+'</span></a>'+'</td>'+
				'<td>'+
                  '<label class="switch">'+
                    '<input class="attendanceStatus" type="checkbox" data-id="'+ data[key]['userId']+ '"';
                     if(data[key]['status'] == 1) html += ' checked ';
         			html += '>'+
                    '<span class="slider round"></span>'+
                  '</label>'+
                '</td></tr>';
	}
	html += '</tbody></table><button data-sid='+ subjectId +' data-date='+ date +' id="sendAttendance" type="submit" class="btn btn-primary pull-left">Submit</button>'+
                '</div>';
    return html;

}

function sendData(status, subjectId, date) {
	$.ajax({
            "url": "../attendance/attendance/set",
            async: true,
            type: 'POST',
            data: {
                subjectId : subjectId,
                date : date,
                status : status
            } ,
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $.notify("Successfully saved in database", "success");
                    $("#tableToHide").html("");
                    $("#tableToHide").hide();
                    return;   
                } else if (decode.success == false) {
                    if(decode.error != undefined) {
                        $.notify(decode.error, "error");
                    }else {
                        $.notify("Problem connecting.", "error");
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


function getAllData(mode = 0){

    var destination = $("#tableToHide");
    destination.html("");

    var date = $('#currentdate').val();
    if(date == "" || date == undefined) {
    	$.notify("Please select date", "error");
    	return;
    }
    dateFor = new Date(date);
    currentdate = new Date();

    var diff = dateDiff(dateFor, currentdate);

    if(diff < 0 || mode <= 0) {
    	$.notify("Please select valid data");
    	return;
    }

    $.ajax({
            "url": "../attendance/attendance/get",
            async: true,
            type: 'POST',
            data: {
                subjectId : mode,
                date : date,
                teacherId: $('#teacherId').data('id')
            } ,
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                        var html = 'Nothing to show'; 
                        if(checkObjectSize(decode.data.records) >= 1) {
                            html = getHTML(decode.data.records, decode.data.subjectId, decode.data.date);
                        }else {                       
                            $.notify("Problem fetching data.", "error");
                        }
                        destination.html(html);
                        destination.show();
                        return;   
                } else if (decode.success == false) {
                    var html = 'Error occured!'; 
                    if(decode.error != undefined) {
                        $.notify(decode.error, "error");
                    }else {
                        $.notify("Problem fetching informations.", "error");
                    }                 
                    destination.html(html);
                    destination.show();
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

$('body').on('hidden.bs.modal', '#addReview', function() {
    $('#sid').val(-1);
    $('#tid').val(-1);
    $('#nameOfStudent').html("");
    $('#review').val("");
    getAllData($('#subjectSelected').data('id'));
});

$(document).on("click", ".student-review", function() {
    var sid = $(this).data('sid');
    var tid = $(this).data('tid');
    var sname = $(this).data('sname');
    if(sid > 0 && tid > 0) {
        getReview(sid, tid, sname);
    }
});


function getReview(sid, tid, sname) {
        $.ajax({
            url: '../attendance/review/get',
            async: true,
            type: 'POST',
            data: {
                studentId : sid,
                teacherId : tid
            },
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#review').val(decode.review);
                    $('#nameOfStudent').html(sname);
                    $('#sid').val(sid);
                    $('#tid').val(tid);
                    $('#addReview').modal('show');
                } else if (decode.success === false) {
                    if (decode.errors != undefined) {
                        $.notify(decode.errors[0], "error");
                    }
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

$(document).on("click", "#sendReviewBtn", function(e) {
    e.preventDefault();
    var sid = $('#sid').val();
    var tid = $('#tid').val();
    var review = $('#review').val();
    if(sid > 0 && tid > 0 ){
        sendReview(sid, tid, review);
    }else {
        $.notify("Invalid Student/Teacher Data", "error");
    }
});

function sendReview(sid, tid, review) {
        $.ajax({
            url: '../attendance/review/set',
            async: true,
            type: 'POST',
            data: {
                studentId : sid,
                teacherId : tid,
                review : review
            },
            success: function(response) {
                var decode = JSON.parse(response);
                if (decode.success == true) {
                    $('#addReview').modal('hide');
                    $.notify("Review saved", "success");
                } else if (decode.success === false) {
                    if(decode.status == -1){
                        $('#addReview').modal('hide');
                    }
                    if (decode.errors != undefined) {
                        $.notify(decode.errors, "error");
                    }
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






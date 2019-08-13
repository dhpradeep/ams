$(document).ready(function() {
    var time = $("#timeTrack").data('time');
    var examId = $("#timeTrack").data('exam');
    if (time <= 0) {
        alert("Already submitted !");
    }
    if (examId <= 0) {
        alert("Error in exam !");
    } else {
        startTimer(time, examId);
    }
});

function startTimer(sec, id) {
    var minutes = Math.floor(sec / 60);
    var seconds = sec - minutes * 60;
    var interval = setInterval(function() {
        sec--;
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;

        if (sec % 3 == 0) {
            sendStatus(sec, id, false);
        }

        if (minutes <= 0 && seconds <= 0 && sec <= 0) {
            sendStatus(0, id, true);
            clearInterval(interval);
            BootstrapDialog.show({
                title: 'Thank you.',
                message: 'You test/exam is submitted. Time Over!',
                buttons: [{
                    label: 'Ok',
                    cssClass: 'btn-primary',
                    action: function(dialog) {
                        dialog.close();
                    }
                }]
            });
            document.location.reload();
        }
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;

        $('#time').html(minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
    }, 1000);
}

function sendStatus(time, id, isSubmitted = false) {
    $.ajax({
        url: '../test/update/status',
        async: true,
        type: 'POST',
        data: {
            remainingTime: time,
            examId: id,
            isSubmitted: isSubmitted
        }
    });
}

$(document).on("click", ".answerRadio", function(e) {
    var target = e.target;
    var answer = target.dataset.choice;
    var qid = target.dataset.qid;
    var id = $("#timeTrack").data('exam');
    $.ajax({
        url: '../test/update/answer',
        async: true,
        type: 'POST',
        data: {
            examId: id,
            questionId: qid,
            userAnswer: answer,
        }
    });
});


$(document).on("click", "#submitBtn", function(e) {
    BootstrapDialog.show({
        title: 'Confirm',
        message: 'Are you sure to to submit ?<b> You can\'t retake the test/exam.</b>',
        buttons: [{
            label: 'Yes',
            cssClass: 'btn-primary',
            action: function(dialog) {
                dialog.close();
                submitTest();
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

function submitTest() {
    var id = $("#timeTrack").data('exam');
    var time = $("#timeTrack").data('time');
    time = (time < 0) ? 0 : time;
    sendStatus(time, id, true);
    BootstrapDialog.show({
        title: 'Thank you.',
        message: 'You test/exam is submitted.',
        buttons: [{
            label: 'Ok',
            cssClass: 'btn-primary',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
    document.location.reload();
}

$(".next").click(function() { $('#myTabs li.active').next('li').find('a').trigger('click') });
$(".previous").click(function() { $('#myTabs li.active').prev('li').find('a').trigger('click') });
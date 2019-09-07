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
                $.notify("Program upgraded successfully", "success");
            } else if (decode.success === false) {
                if (decode.errors != undefined) {
                    $.notify(decode.errors, "error");
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
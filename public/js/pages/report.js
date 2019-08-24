$(document).ready(function() {
    $('input[name="daterange"]').daterangepicker();
});

$(".filter_bar_val").hide();
$(".filter_bar").click(function() {
    $(".filter_bar_val").slideToggle();
});

$(".filter_table_val").hide();
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
                // exportdata();
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

$("#studentTable").dataTable();
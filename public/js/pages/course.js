//for datatable
$(document).ready( function () {
    $('#Table').DataTable();
} );
function create_course(data = null) {
    if(data != null) {
        $("#courseId").data('id',data.id);
        $('#name').val(data.name);
        $("#saveBtn")[0].innerHTML = "Update";
        $('#addProgram').modal('show');
    }else{
        $("#saveBtn")[0].innerHTML = "Add";      
        $('#addProgram').modal('show');
    }
}
$(document).on("click", "#saveBtn", function(e) {
    e.preventDefault();
    var btn = $('#saveBtn')[0].innerHTML;
    if(btn == "Update") {
        updateCourse();
    } else {
        addCourse();
    }
});


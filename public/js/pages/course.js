<<<<<<< HEAD
//for datatable
$(document).ready( function () {
    $('#Table').DataTable();
} );
=======
>>>>>>> 299c7e3f9b3531108abdfe989fbd75fc4b785f90
function create_course(data = null) {
    if(data != null) {
        $("#courseId").data('id',data.id);
        $('#name').val(data.name);
        $("#saveBtn")[0].innerHTML = "Update";
        $('#addProgram').modal('show');
    }else{
        $("#saveBtn")[0].innerHTML = "Add";      
<<<<<<< HEAD
        $('#addProgram').modal('show');
=======
        $('#addCourse').modal('show');
>>>>>>> 299c7e3f9b3531108abdfe989fbd75fc4b785f90
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
<<<<<<< HEAD

=======
//for datatable
$(document).ready( function () {
    $('#Table').DataTable();
} );
>>>>>>> 299c7e3f9b3531108abdfe989fbd75fc4b785f90

function create_student() {
   $(#addStudent).modal('show');
}

$(document).on("click", "#saveBtn", function(e) {
   e.preventDefault();
   var btn = $('#saveBtn')[0].innerHTML;
   if(btn == "Update") {
       updateStudent();
   } else {
       addStudent();
   }
});

//for datatable
$(document).ready( function () {
   $('#Table').DataTable();
} );
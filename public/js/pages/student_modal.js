$("#addEducation").click(function() {
    educationFormMaker();
});

function educationFormMaker() {
    var counter = $("#counter").data("id");
    educationFormatter(counter);
    counter++;
    $("#counter").data("id", counter);
}

function educationFormatter(i) {
    var htm = '<div class="edu"><div>' +
        '<div class="form-group col-md-3">' +
        '<label for="level' + i + '">Level *</label>' +
        '<select class="form-control" name="level' + i + '" id="level' + i + '">' +
        '<option value="1">SLC</option>' +
        '<option value="2">+2</option>' +
        '<option value="3">Intermediate</option>' +
        '<option value="4">HA</option>' +
        '</select>' +
        '</div>' +
        '<div class="form-group col-md-3">' +
        '<label for="board' + i + '">Board *</label>' +
        '<input type="text" class="form-control" name="board' + i + '" id="board' + i + '" placeholder="Board" />' +
        '<span class="help-inline"></span>' +
        '</div>' +
        '<div class="form-group col-md-5">' +
        '<label for="faculty' + i + '">Faculty</label>' +
        '<input type="text" class="form-control" name="faculty' + i + '" id="faculty' + i + '" placeholder="Faculty" />' +
        '<span class="help-inline"></span>' +
        '</div>'+
        '<div class="form-group col-md-1"></div></div>'+
        '<div>' +
        '<div class="form-group col-md-3">' +
        '<label for="yearOfCompletion' + i + '">Y.O.C *</label>' +
        '<input type="text" class="form-control" name="yearOfCompletion' + i + '" id="yearOfCompletion' + i + '" placeholder="Year of completion" />' +
        '<span class="help-inline"></span>' +
        '</div>' +
        '<div class="form-group col-md-3">' +
        '<label for="percent' + i + '">Percent/GPA *</label>' +
        '<input type="text" class="form-control" name="percent' + i + '" id="percent' + i + '" placeholder="Percent/GPA" />' +
        '<span class="help-inline"></span>' +
        '</div>' +
        '<div class="form-group col-md-5">' +
        '<label for="institution' + i + '">Institute *</label>' +
        '<input type="text" class="form-control" name="institution' + i + '" id="institution' + i + '" placeholder="Institute" />' +
        '<span class="help-inline"></span>' +
        '</div>' +
        '<div class="form-group-btn col-md-1 text-right">' +
        '<label for="removeEdu' + i + '">&nbsp;</label>' +
        '<button id="removeEdu' + i + '" type="button" class="form-control btn btn-danger removeEdu">-</button>' +
        '</div>'+
        '</div></div>';
    $('#nestedForm').append(htm);
}

$("#nestedForm").on("click", ".removeEdu", function() { $(this).parent().parent().parent().remove() });

$(".next").click(function() { $('#tabList li.active').next('li').find('a').trigger('click') });
$(".previous").click(function() { $('#tabList li.active').prev('li').find('a').trigger('click') });
$(document).ready(function() {
    refresh();
});

function refresh() {
    getAllData();
    animate(500);
}

// function getAllData() {
//     $("#resultTable").dataTable().fnDestroy();
//     var table = $('#resultTable').DataTable({});
//     return true;
// }

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
        $.notify("All records display", "info");
        spinner.stop();
    });
    return;
}

function getAllData() {
    $("#resultTable").dataTable().fnDestroy();
    var table = $('#resultTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../student/all/get",
            "type": "POST"
        },
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                "data": "name"
            },
            { "data": "entranceNo" },
            { "data": "username" },
            { "data": "email" },
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
}
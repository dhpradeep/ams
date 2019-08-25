function morrisChart(data, userId) {

    var studentNames = data['studentNames'];
    var subjectNames = data['subjectNames'];
    var records = data['records'];
    var key, subkey;

    var data = [];
    for (key in studentNames) {
        if (key == userId) {
            for (subkey in subjectNames) {
                var one = {
                    y: subjectNames[subkey],
                    a: records[userId][subkey]
                }
                data.push(one);
            }
        }
    }

    Morris.Bar({
        element: 'morris-bar-chart',
        data: data,
        xkey: 'y',

        ykeys: ['a'],
        labels: ['Present', 'Absent'],
        hideHover: 'auto',
        resize: true,
        stacked: true
    });
};

function percent(val = "default") {

    if (val == "program") {
        data = [{
            label: "Sem 1",
            value: 12
        }, {
            label: "Sem 2",
            value: 25
        }, {
            label: "Sem 3",
            value: 30
        }, {
            label: "Sem 4",
            value: 60
        }];

    } else if (val == "semester") {
        data = [{
            label: "section A",
            value: 60
        }, {
            label: "section B",
            value: 30
        }];

    } else if (val == "section") {
        data = [{
            label: "Math",
            value: 15
        }, {
            label: "Science",
            value: 25
        }, {
            label: "English",
            value: 50
        }, {
            label: "Account",
            value: 80
        }];
    } else if (val == "default") {
        data = [{
            label: "BCA",
            value: 12
        }, {
            label: "BBA",
            value: 30
        }, {
            label: "BPH",
            value: 20
        }]
    } else {
        data = null
    }

    Morris.Donut({
        element: 'morris-donut-chart',
        data: data,
        'formatter': function(y, data) { return y + '%' },
        resize: true
    });
}
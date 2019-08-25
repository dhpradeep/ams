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
}
$(function() {

    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug'];

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
                period: '2019-01',
                present: 300,
                absent: 50
            }, {
                period: '2019-02',
                present: 200,
                absent: 10
            }, {
                period: '2019-03',
                present: 350,
                absent: 20
            }, {
                period: '2019-04',
                present: 200,
                absent: 100
            }, {
                period: '2019-05',
                present: 150,
                absent: 25
            }, {
                period: '2019-06',
                present: 210,
                absent: 20
            }, {
                period: '2019-07',
                present: 300,
                absent: 20
            },
            {
                period: '2019-08',
                present: 100,
                absent: 20
            }
        ],
        xkey: 'period',
        xLabelFormat: function(x) { return months[x.getMonth()] },
        ykeys: ['present', 'absent'],
        labels: ['present student', 'absent student'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',

        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

})
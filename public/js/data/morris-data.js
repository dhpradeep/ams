$(function() {

    // var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug'];

    // Morris.Area({
    //     element: 'morris-area-chart',
    //     data: [{
    //             period: '2019-01',
    //             present: 300,
    //             absent: 50
    //         }, {
    //             period: '2019-02',
    //             present: 200,
    //             absent: 10
    //         }, {
    //             period: '2019-03',
    //             present: 350,
    //             absent: 20
    //         }, {
    //             period: '2019-04',
    //             present: 200,
    //             absent: 100
    //         }, {
    //             period: '2019-05',
    //             present: 150,
    //             absent: 25
    //         }, {
    //             period: '2019-06',
    //             present: 210,
    //             absent: 20
    //         }, {
    //             period: '2019-07',
    //             present: 300,
    //             absent: 20
    //         },
    //         {
    //             period: '2019-08',
    //             present: 100,
    //             absent: 20
    //         }
    //     ],
    //     xkey: 'period',
    //     xLabelFormat: function(x) { return months[x.getMonth()] },
    //     ykeys: ['present', 'absent'],
    //     labels: ['present student', 'absent student'],
    //     pointSize: 2,
    //     hideHover: 'auto',
    //     resize: true
    // });

    // Morris.Donut({
    //     element: 'morris-donut-chart',
    //     data: [{
    //         label: "Download Sales",
    //         value: 12
    //     }, {
    //         label: "In-Store Sales",
    //         value: 30
    //     }, {
    //         label: "Mail-Order Sales",
    //         value: 20
    //     }],
    //     resize: true
    // });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: 'Math',
            a: 100,
            b: 10
        }, {
            y: 'Science',
            a: 75,
        }, {
            y: 'English',
            a: 50,
        }, {
            y: 'Social',
            a: 75,
        }, {
            y: 'Data Science',
            a: 50,
        }, {
            y: 'Machine Learning',
            a: 75,
        }],
        xkey: 'y',

        ykeys: ['a'],
        labels: ['Present', 'Absent'],
        hideHover: 'auto',
        resize: true
    });

})
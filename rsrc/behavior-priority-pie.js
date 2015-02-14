/**
 * @provides javelin-behavior-priority-pie
 */

JX.behavior('priority-pie', function(config) {

    var h = JX.$(config.hardpoint);
    var l = c3.generate({
        bindto: h,
        data: {
            columns: [
                ['Wishlist', config.Wishlist],
                ['Low', config.Low],
                ['Normal', config.Normal],
                ['High', config.High],
                ['Unbreak Now!', config.Unbreak],
                ['Needs Triage', config.Triage]
            ],
            type: 'pie'
        },
        color: {
            pattern: ['#3498db', '#f1c40f', '#e67e22', '#c0392b', '#6e5cb6', '#8e44ad' ]
        }
    });
});


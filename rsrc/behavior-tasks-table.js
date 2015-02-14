/**
 * @provides javelin-behavior-tasks-table
 */

JX.behavior('tasks-table', function (config) {
    jQuery( document ).ready(function ($) {
        $('#tasks-list').DataTable({
            "order": [[ 8, "desc" ]],
            "aoColumnDefs": [
                { "bVisible": false, "aTargets": [ 1 ] },
                { "iDataSort": 1, "aTargets": [ 2 ] },
                { "bVisible": false, "aTargets": [ 3 ] },
                { "iDataSort": 3, "aTargets": [ 4 ] },
                { "bVisible": false, "aTargets": [ 6 ] },
                { "iDataSort": 6, "aTargets": [ 7 ] }
            ]
        });
    });
});

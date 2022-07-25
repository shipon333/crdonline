"use strict";
var morris_chart = {
    init: function() {
        $(function() {
            Morris.Donut({
                element: 'donut-color-chart-morris',
                data: [{
                    value: 90,
                    label: "foo"
                },
                    {
                        value: 15,
                        label: "bar"
                    },
                    {
                        value: 10,
                        label: "baz"
                    },
                    {
                        value: 5,
                        label: "A really really long label"
                    }],
                backgroundColor: "rgba(36, 105, 92, 0.5)",
                labelColor: vihoAdminConfig.primary,
                colors: ["rgba(36, 105, 92, 1)", "rgba(186, 137, 93, 1)" ,"rgba(9,9, 9, 1)" ,"rgba(113, 113, 113, 1)" ,"rgba(230, 237, 239, 1)", "rgba(210, 45, 61, 1)" ,"rgba(36, 105, 92, 1)"],
                formatter: function(a) {
                    return a + "%"
                }
            });
        })
    }
};
(function($) {
    "use strict";
    morris_chart.init()
})(jQuery);

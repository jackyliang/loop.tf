{{--<link rel="stylesheet" href="/amcharts/style.css"	type="text/css">--}}

<script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="http://www.amcharts.com/lib/3/serial.js"></script>
<script src="http://www.amcharts.com/lib/3/themes/dark.js"></script>
<script src="http://www.amcharts.com/lib/3/amstock.js"></script>

<script>
    var chartData = generateChartData();

    function generateChartData() {
        var chartData = [];
        var firstDate = new Date( 2015, 7, 8 );
        firstDate.setDate( firstDate.getDate());
        firstDate.setHours( 0, 0, 0, 0 );

        for ( var i = 0; i < 1000; i++ ) {
            var newDate = new Date( firstDate );
            newDate.setHours( 0, i, 0, 0 );

            var a = Math.round( Math.random() * ( 40 + i ) ) + 100 + i;
            var b = Math.round( Math.random() * 100000000 );

            chartData.push( {
                date: newDate,
                value: a
            } );
        }
        return chartData;
    }

    var chart = AmCharts.makeChart( "chartdiv", {

        type: "stock",
        "theme": "dark",

        categoryAxesSettings: {
            minPeriod: "mm"
        },

        dataSets: [ {
            color: "#b0de09",
            fieldMappings: [ {
                fromField: "value",
                toField: "value"
            }, {
                fromField: "volume",
                toField: "volume"
            } ],

            dataProvider: chartData,
            categoryField: "date"
        } ],


        panels: [ {
            showCategoryAxis: false,
            title: "Value",
            percentHeight: 70,

            stockGraphs: [ {
                id: "g1",
                valueField: "value",
                type: "smoothedLine",
                lineThickness: 2,
                bullet: "round"
            } ],


            stockLegend: {
                valueTextRegular: " ",
                markerType: "none"
            }
        },

            {
                stockLegend: {
                    valueTextRegular: " ",
                    markerType: "none"
                }
            }
        ],

        chartScrollbarSettings: {
            graph: "g1",
            usePeriod: "10mm",
            position: "top"
        },

        chartCursorSettings: {
            valueBalloonsEnabled: true
        },

        periodSelector: {
            position: "top",
            dateFormat: "YYYY-MM-DD JJ:NN",
            inputFieldWidth: 150,
            periods: [ {
                period: "hh",
                count: 1,
                label: "1 hour",
                selected: true

            }, {
                period: "hh",
                count: 2,
                label: "2 hours"
            }, {
                period: "hh",
                count: 5,
                label: "5 hour"
            }, {
                period: "hh",
                count: 12,
                label: "12 hours"
            }, {
                period: "MAX",
                label: "MAX"
            } ]
        },

        panelsSettings: {
            usePrefixes: true
        },

        "export": {
            "enabled": true,
            "position": "bottom-right"
        }
    } );

</script>
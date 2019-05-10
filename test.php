<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }

    #chartdiv,
    #chartdiv2 {
        width: 50vw;
        height: 500px;

    }
    </style>
    <title>Document</title>
    <script src="//www.amcharts.com/lib/4/core.js"></script>
    <script src="//www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
</head>

<body>
    <div id="chartdiv"></div>
    <div id="chartdiv2"></div>
    <script>
    /*
     *
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    am4core.useTheme(am4themes_animated);

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    // Add data
    chart.data = [{
        "stage": "I",
        "duration": 7800
    }, {
        "stage": "II",
        "duration": 6000
    }, {
        "stage": "III",
        "duration": 180000
    }, {
        "stage": "IV",
        "duration": 12500
    }, {
        "stage": "V",
        "duration": 5000
    }];

    // Create axes
    var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    xAxis.dataFields.category = "stage";
    xAxis.renderer.grid.template.location = 0;
    xAxis.renderer.minGridDistance = 30;

    var yAxis = chart.yAxes.push(new am4charts.DurationAxis());
    yAxis.baseUnit = "second";
    yAxis.title.text = "Duration";

    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "duration";
    series.dataFields.categoryX = "stage";
    series.columns.template.tooltipText = "{categoryX}: {valueY.formatDuration()}";
    // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
    series.columns.template.adapter.add("fill", (fill, target) => {
        return chart.colors.getIndex(target.dataItem.index * 2);
    });
    // Force global duration format
    chart.durationFormatter.durationFormat = "hh ':' mm ':' ss  ";





    var chart = am4core.create("chartdiv2", am4charts.XYChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.data = [{
            country: "USA",
            visits: 23725
        },
        {
            country: "China",
            visits: 1882
        },
        {
            country: "Japan",
            visits: 1809
        },
        {
            country: "Germany",
            visits: 1322
        },
        {
            country: "UK",
            visits: 1122
        },
        {
            country: "France",
            visits: 1114
        },
        {
            country: "India",
            visits: 984
        },
        {
            country: "Spain",
            visits: 711
        },
        {
            country: "Netherlands",
            visits: 665
        },
        {
            country: "Russia",
            visits: 580
        },
        {
            country: "South Korea",
            visits: 443
        },
        {
            country: "Canada",
            visits: 441
        }
    ];

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.dataFields.category = "country";

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    valueAxis.max = 24000;
    valueAxis.strictMinMax = true;
    valueAxis.renderer.minGridDistance = 30;
    // axis break
    var axisBreak = valueAxis.axisBreaks.create();
    axisBreak.startValue = 2100;
    axisBreak.endValue = 22900;
    axisBreak.breakSize = 0.005;

    // make break expand on hover
    var hoverState = axisBreak.states.create("hover");
    hoverState.properties.breakSize = 1;
    hoverState.properties.opacity = 0.1;
    hoverState.transitionDuration = 1500;

    axisBreak.defaultState.transitionDuration = 1000;
    /*
    // this is exactly the same, but with events
    axisBreak.events.on("over", () => {
      axisBreak.animate(
        [{ property: "breakSize", to: 1 }, { property: "opacity", to: 0.1 }],
        1500,
        am4core.ease.sinOut
      );
    });
    axisBreak.events.on("out", () => {
      axisBreak.animate(
        [{ property: "breakSize", to: 0.005 }, { property: "opacity", to: 1 }],
        1000,
        am4core.ease.quadOut
      );
    });*/

    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.categoryX = "country";
    series.dataFields.valueY = "visits";
    series.columns.template.tooltipText = "{valueY.value}";
    series.columns.template.tooltipY = 0;
    series.columns.template.strokeOpacity = 0;

    // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
    series.columns.template.adapter.add("fill", (fill, target) => {
        return chart.colors.getIndex(target.dataItem.index * 2);
    });
    </script>

</body>

</html>
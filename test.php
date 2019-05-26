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

        /* #chartdiv,
    #chartdiv2 {
        width: 50vw;
        height: 500px;

    } */
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>
    <title>Document</title>
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
</head>

<body>
    <div id="chartdiv"></div>
    <div id="chartdiv2"></div>
    <script>
        /**
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

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

        var colorSet = new am4core.ColorSet();
        // colorSet.saturation = 0.4;

        chart.data = [
    {
        "name": "Others tasks/1st task",
        "fromDate": "2019-04-29 00:59:28",
        "toDate": "2019-04-29 00:59:38"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-04-29 01:00:10",
        "toDate": "2019-04-29 01:00:21"
    },
    {
        "name": "Others tasks/1st task",
        "fromDate": "2019-04-29 03:06:50",
        "toDate": "2019-04-29 03:07:43"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-04-29 14:11:52",
        "toDate": "2019-04-29 14:13:02"
    },
    {
        "name": "Test Project/1stCreatedTask",
        "fromDate": "2019-04-29 01:01:34",
        "toDate": "2019-04-29 03:06:50"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-04-29 17:36:08",
        "toDate": "2019-04-29 17:38:20"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-04-30 11:25:22",
        "toDate": "2019-04-30 12:00:43"
    },
    {
        "name": "Others tasks/1st task",
        "fromDate": "2019-04-30 12:15:36",
        "toDate": "2019-04-30 23:59:59"
    },
    {
        "name": "Others tasks/1st task",
        "fromDate": "2019-05-04 00:00:00",
        "toDate": "2019-05-04 10:43:57"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-05-04 11:00:17",
        "toDate": "2019-05-04 21:42:10"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-04 10:45:03",
        "toDate": "2019-05-04 10:45:33"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-04 21:50:42",
        "toDate": "2019-05-04 22:03:42"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-04 22:09:23",
        "toDate": "2019-05-04 23:59:59"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-05 00:00:00",
        "toDate": "2019-05-05 00:34:10"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-05 00:35:04",
        "toDate": "2019-05-05 00:37:33"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-05 19:26:15",
        "toDate": "2019-05-05 23:21:26"
    },
    {
        "name": "Test Project/1stCreatedTask",
        "fromDate": "2019-05-05 23:33:58",
        "toDate": "2019-05-05 23:59:59"
    },
    {
        "name": "Diplom/prepare",
        "fromDate": "2019-05-09 16:55:05",
        "toDate": "2019-05-09 17:05:07"
    },
    {
        "name": "Diplom/prepare",
        "fromDate": "2019-05-09 17:05:49",
        "toDate": "2019-05-09 21:41:39"
    },
    {
        "name": "Diplom/prepare",
        "fromDate": "2019-05-10 00:40:59",
        "toDate": "2019-05-10 00:41:01"
    },
    {
        "name": "Diplom/prepare",
        "fromDate": "2019-05-10 17:04:40",
        "toDate": "2019-05-10 18:43:09"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-05-23 08:33:11",
        "toDate": "2019-05-23 08:35:52"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-05-23 08:36:58",
        "toDate": "2019-05-23 08:37:02"
    },
    {
        "name": "Others tasks/2ndTask",
        "fromDate": "2019-05-23 08:43:25",
        "toDate": "2019-05-23 08:43:26"
    },
    {
        "name": "Test Project/2ndCreatedTask",
        "fromDate": "2019-05-23 08:37:06",
        "toDate": "2019-05-23 08:37:09"
    }
];

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.inversed = true;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.dateFormatter.dateFormat = "yyyy-MM-dd HH:mm";
        dateAxis.renderer.minGridDistance = 60;
        dateAxis.baseInterval = {
            count: 5,
            timeUnit: "minute"
        };
        let dateFrom = chart.data[0].fromDate.split(" ");
            var parts =dateFrom[0].split('-');
            var dateParsed = new Date(parts[0], parts[1] - 1, parts[2],0,0,0); 
            //console.log(dateParsed.toDateString());
        // dateAxis.max = new Date(parts[0], parts[1] - 1, parts[2],23,59,59).getTime();
        // dateAxis.min = new Date(parts[0], parts[1] - 1, parts[2],0,0,0).getTime();
        dateAxis.strictMinMax = false;
        dateAxis.renderer.tooltipLocation = 0;

        var series1 = chart.series.push(new am4charts.ColumnSeries());
        series1.columns.template.width = am4core.percent(80);
        series1.columns.template.tooltipText = "[font-style: italic]{name}:\n[bold]{openDateX} - {dateX}";

        series1.dataFields.openDateX = "fromDate";
        series1.dataFields.dateX = "toDate";
        series1.dataFields.categoryY = "name";
        series1.columns.template.propertyFields.fill = "color"; // get color from data
        series1.columns.template.propertyFields.stroke = "color";
        series1.columns.template.strokeOpacity = 1;
        // series1.columns.template.adapter.add("fill", (fill, target) => {
        //             return chart.colors.getIndex(target.dataItem.index * 2);
        //         });

        chart.scrollbarX = new am4core.Scrollbar();

        var nameArray = [];
        chart.data.forEach(element => {
            nameArray.push(element.name);
            
        });
        var uniqueNames = [...new Set(nameArray)];
        for (let j = 0; j < uniqueNames.length; j++) {
            for (let i = 0; i < chart.data.length; i++) {
                if (chart.data[i].name === uniqueNames[j])
                    chart.data[i].color = chart.colors.getIndex(j * 2);
            }
        }
        //console.log(chart.data);
    </script>

</body>

</html>
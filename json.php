<?php
function toJSON($label1, $label2, $arr1, $arr2)
{
    for ($i = 0; $i < sizeof($arr1); $i++) {
        # code...
        if ($i === 0) {
            $str = "\n\t{\n\t\t" . '"' . $label1 . '": ' . '"' . $arr1[$i] . '",' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . "\n\t}";
        } else {
            $str .= ",\n\t{\n\t\t" . '"' . $label1 . '": ' . '"' . $arr1[$i] . '",' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . '' . "\n\t}";
        }
    }
    return $str;
}
$labels = ["Others tasks / 1st task", "Test Project / 1stCreatedTask", "Others tasks / 2ndTask", "Test Project / 2ndCreatedTask", "Diplom / prepare",];
$values = [340164, 62328, 40715, 23889, 17152,];
echo toJSON("axisX", "axisY", $labels, $values);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./libs/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>GraphTest1</title>
    <script src="./libs/Chart.min.js"></script>
    <!-- link rel="stylesheet" type="text/css" href="./css/style.css"-->
    <link rel="stylesheet" type="text/css" href="./css/layout.css" />
    <link rel="stylesheet" type="text/css" href="./css/datepicker.css" />
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/datepicker.js"></script>
    <script type="text/javascript" src="./js/eye.js"></script>
    <script type="text/javascript" src="./js/utils.js"></script>
    <script type="text/javascript" src="./js/layout.js"></script>
    <style>
    th {
        text-align: center !important;
    }

    #pie-chart-all-tasks {
        width: 100%;
        height: 500px;
    }
    </style>
</head>

<body>
    <div id="pie-chart-all-tasks"></div>


    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


    <script type="text/javascript">
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-all-tasks", am4charts.PieChart);

        // Add data
        chart.data = [<?php echo toJSON("tasks", "seconds", $labels, $values); ?>];

        // Set inner radius
        chart.innerRadius = am4core.percent(50);

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "seconds"; //values
        pieSeries.dataFields.category = "tasks"; //labels
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

    });
    </script>
</body>

</html>
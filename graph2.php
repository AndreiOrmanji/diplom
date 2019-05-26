<?php
use Twig\Error\Error;

require_once './db.php';

function getTasksID()
{
    //return R::getAll('SELECT DISTINCT task_id, project_id FROM logs WHERE user_id=? ORDER BY project_id', [$_SESSION['id']]);
    //return $array = print_r($array);
    return R::getAll('SELECT DISTINCT a.task_id, a.project_id, b.pr_name, c.t_name FROM logs a, projects b, tasks c WHERE a.project_id = b.id AND a.task_id = c.id  AND a.user_id = ? ORDER BY a.project_id', [$_SESSION['id']]);
}
function getWeekDays($firstDay, $lastDay)
{
    return R::getCol('SELECT DISTINCT date FROM logs WHERE user_id = ? AND date >= ? AND date <= ? ORDER BY date',  [$_SESSION['id'], $firstDay, $lastDay]);
}
function getProjects()
{
    return R::getAll('SELECT DISTINCT a.project_id, b.pr_name FROM logs a, projects b WHERE a.project_id = b.id AND a.user_id= ? ORDER BY a.project_id', [$_SESSION['id']]);
    //return $array = print_r($array);
}

function getLogs()
{
    //return $array = print_r($array);
    return R::getAll('SELECT a.id, a.project_id, b.pr_name, a.task_id, c.t_name, a.new_status, a.time, a.date FROM logs a, projects b, tasks c WHERE a.project_id = b.id AND a.task_id = c.id  AND a.user_id = ?', [$_SESSION['id']]);
}

function toJSON($label1, $label2, $arr1, $arr2)
{
    for ($i = 0; $i < sizeof($arr1); $i++) {
        # code...
        if ($i === 0) {
            $str = "\n\t{\n\t\t" . '"' . $label1 . '": ' . '' . $arr1[$i] . ',' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . "\n\t}";
        } else {
            $str .= ",\n\t{\n\t\t" . '"' . $label1 . '": ' . '' . $arr1[$i] . ',' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . '' . "\n\t}";
        }
    }
    return $str;
}


try {
    $userTasks = getTasksID(); //уникальные записи о задачах 1, 2, 3
    $labelsYallTasks = array();
    for ($i = 0; $i < sizeof($userTasks); $i++) {
        $temp = 0;
        $logs = R::find('logs', ' user_id = ? ',  [$_SESSION['id']]);
        for ($j = 0; $j < sizeof($logs); $j++) {
            if ($logs[$j]['task_id'] === $userTasks[$i]['task_id'] && ($logs[$j]['new_status'] === 'Running')) {
                if ($logs[$j + 1]['task_id'] === $userTasks[$i]['task_id']) {
                    $temp += ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']);
                }
            }
        }
        array_push($labelsYallTasks, $temp);
    }
    $labelsX = array();
    for ($i = 0; $i < sizeof($userTasks); $i++) {
        $str = '"' . $userTasks[$i]['pr_name'] . ' / ' . $userTasks[$i]['t_name'] . '"';
        array_push($labelsX, $str);
    }
} catch (Exception $e) {
    echo "$e";
}

try {
    //Расчеты по проектам
    $projects = getProjects();
    $labelsYProjects = array();
    for ($i = 0; $i < sizeof($projects); $i++) {
        $temp = 0;
        $logs = R::find('logs', ' user_id = ? ',  [$_SESSION['id']]);
        for ($j = 0; $j < sizeof($logs); $j++) {
            if (($logs[$j]['project_id'] === $projects[$i]['project_id']) && ($logs[$j]['new_status'] === 'Running')) {
                if (($logs[$j + 1]['project_id'] === $projects[$i]['project_id'])) {
                    $temp += ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']);
                }
            }
        }
        array_push($labelsYProjects, $temp);
    }
    //$temp = 0;
    $labelsXProjects = array();
    foreach ($projects as $t) {
        //$labelsXProjects .= '"' . $t['pr_name'] . '", ';
        $str = '"' . $t['pr_name'] . '"';
        array_push($labelsXProjects, $str);
    }
} catch (Exception $e) {
    echo "$e";
}

try {
    //II. расчеты для 2 графика по неделям
    $day = date('w');
    $currentWeek = array();
    $firstDay =  date("Y-m-d", strtotime('Monday this week'));
    $lastDay =  date("Y-m-d", strtotime('Sunday this week'));
    $logWeek = R::find('logs', ' user_id = ? AND date >= ? AND date <= ?',  [$_SESSION['id'], $firstDay, $lastDay]);
    $TasksID = getTasksID(); //уникальные записи о задачах 1, 2, 3
    $wDays = getWeekDays($firstDay, $lastDay);
    $labelsYweek = array();
    //echo $firstDay . "  " . $lastDay . "", "\n";
    //echo date("N", strtotime($lastDay));
    $date = date('d-m-Y', strtotime("+1 day", strtotime("10-12-2011")));
    $dayToCompare = $firstDay;
    //echo $dayToCompare . "</br>";
    for ($i = 0; $i < 7; $i++) {
        $temp = 0;
        $logWeek = R::find('logs', ' user_id = ? AND date >= ? AND date <= ?',  [$_SESSION['id'], $firstDay, $lastDay]);
        for ($j = 0; $j < sizeof($logs); $j++) {
            if (($logs[$j]['date'] === $dayToCompare) && ($logs[$j]['new_status'] === 'Running')) {
                if (($logs[$j + 1]['date'] === $dayToCompare)) {
                    // print_r($logs[$j]->export());
                    // print_r($logs[$j+1]->export());
                    $temp += ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']);
                    //echo $dayToCompare.': '.$logs[$j]['t_name'].': '.$temp.'</br>';                  
                }
            }
        }
        if ($i < 6) $dayToCompare    = date('Y-m-d', strtotime("+1 day", strtotime($dayToCompare)));
        array_push($labelsYweek, $temp);
    }
    //print_r($intervals);
    $labelsXweek = ['"Понедельник"', '"Вторник"', '"Среда"', '"Четверг"', '"Пятница"', '"Суббота"', '"Воскресение"'];
} catch (Exception $e) {
    echo "$e";
}

try {
    $labelsYDays = array();
    if (empty($logs)) echo "No activity by " . $_SESSION['email'] . ".";
    else {
        $activity_date = R::getCol('SELECT DISTINCT date FROM logs where user_id=?', [$_SESSION['id']]);
        foreach ($activity_date as $day) {
            $temp = 0;
            $sql = "select * from logs where date = '" . $day . "' and user_id = " . $_SESSION['id'] . "";
            $rows = R::getAll($sql);
            //echo '<pre>'.print_r($rows).'</pre>';
            //$logs = R::convertToBeans( 'logs', $rows );
            //$logs = R::get( 'logs', ' user_id = ? and date = ?',  [$_SESSION['id'],'2019-04-14']);
            //echo '<script>console.log('.print_r($logs->export()).');</script>';
            //echo sizeof($logs);
            for ($j = 1; $j < sizeof($rows); $j++) {
                if (($rows[$j]['new_status'] === 'Running')) {
                    //echo "</br>j=" . $j . " status:" . $rows[$j]['new_status'];
                    for ($k = $j - 1; $k >= 0; $k--) {
                        //echo "</br>k=" . $k;
                        if ($rows[$k]['new_status'] !== 'Paused') {
                            //echo "skipped";
                            continue;
                        } else {
                            //echo " status:".$rows[$k]['new_status']." ".($rows[$j]['timestamp']-$rows[$k]['timestamp'])."</br>";
                            $temp += ($rows[$j]['timestamp'] - $rows[$k]['timestamp']);
                            break;
                        }
                    }
                }
            }
            array_push($labelsYDays, $temp);
            // print_r($intervals);
        }

        $labelsXDays = array();
        foreach ($activity_date as $date) {
            $temp = '"' . $date . '"';
            array_push($labelsXDays, $temp);
            //echo $date;
        }
    }
} catch (Exception $e) {
    echo "$e";
}

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

    #pie-chart-all-tasks,
    #pie-chart-all-projects,
    #bar-chart-by-week,
    #bar-chart-by-pauses {
        width: 790px;
        height: 470px;
    }
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <?php if ($_SESSION['email']) : ?>
    <?= '<div class="container">You are using ' . $_SESSION['email'] . ' as your e-mail adress.</div>'; ?>
    <?php
        try {
            $timeNow = time();
            echo '<div class="container">Tracking starts at ' . date("H:i:s", time()) . '(' . time() . ')</div>
                    <div>Current Time: <span id="current_time"></span></div>';
            $logs = getLogs(); //R::find('logs', ' user_id = ? ',  [$_SESSION['id']]);
            //echo print_r($logs);
            if (empty($logs)) echo "No activity by " . $_SESSION['email'] . ".";
            else {
                echo '
                <div class="container">
                <details>
                <summary>Tables for ' . $_SESSION['email'] . '</summary>';
                $activity_date = R::getCol('SELECT DISTINCT date FROM logs');
                // foreach ($activity_date as $day){
                //     $logs = R::find( 'logs', ' user_id = ? and date = ?',  [$_SESSION['id'],$date]);
                //     echo '<script>console.log('.print_r($logs->export()).');</script>';
                // }
                foreach ($activity_date as $logDate) {
                    echo '
                <details>
                <summary>Table for ' . $logDate . '</summary>
                <table class="table">    
                        <thead>
                        <tr>
                                <th>#</th>
                                <th>User_ID</th>
                                <th>UserName</th>
                                <th>ProjectName</th>
                                <th>TaskName</th>
                                <th>New status</th>
                                <th>Time</th>
                                <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>';
                    foreach ($logs as $log) {
                        if ($log['date'] === $logDate) {
                            echo '<tr>
                                <td class="log_id" style="text-align: center;">' . $log['id'] . '</td>
                                <td class="log_user_id" style="text-align: center;">' . $_SESSION['id'] . '</td>
                                <td class="username" style="text-align: center;">' . $_SESSION['email'] . '</td>
                                <td class="log_pr_name" style="text-align: center;">' . $log['pr_name'] . '</td> 
                                <td class="log_t_name" style="text-align: center;">' . $log['t_name'] . '</td> 
                                <td class="log_new_status" style="text-align: center;">' . $log['new_status'] . '</td>
                                <td class="log_time" style="text-align: center;">' . $log['time'] . '</td>
                                <td class="log_date" style="text-align: center;">' . $log['date'] . '</td>
                                </tr>';
                        }
                    }
                    echo        '</tbody>
                            </table></details>';
                }
                echo '</details></div>';
            }
        } catch (Exception $e) {
            //echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
            //var_dump($task);
            echo "$e";
        }
        ?>

    <div class="container-fluid">
        <div class='row'>
            <div class='col-md-6'>
                <div id="pie-chart-all-tasks">
                </div>
            </div>
            <div class='col-md-6'>
                <div id="pie-chart-all-projects">
                </div>
            </div>
            <div class='col-md-6'>
                <div id="bar-chart-by-week">
                </div>
            </div>

            <div class='col-md-6'>
                <div id="bar-chart-by-pauses">
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <?= "You are not autorized. Go to <a href=\"./login\">Login Page.</a> "; ?>
    <?php endif; ?>
    <!-- Resources -->
    <script src="./libs/core.js"></script>
    <script src="./libs/charts.js"></script>
    <script src="./libs/themes/animated.js"></script>

    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    am4core.ready(function() {

        // Themes begin
        //am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-all-tasks", am4charts.PieChart);

        // Add data
        chart.data = [<?php echo toJSON("tasks", "seconds", $labelsX, $labelsYallTasks); ?>];
        //Legend
        chart.legend = new am4charts.Legend();
        //title
        // var title = chart.titles.create();
        // title.text = "All tasks stats";
        // title.fontSize = 25;
        // title.marginTop = 3;

        // Add bottom label

        // Set inner radius
        chart.innerRadius = am4core.percent(50);

        // Force global duration format
        chart.durationFormatter.durationFormat = "hh 'h:' mm 'm'"; //:' ss  ";

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "seconds"; //values
        pieSeries.dataFields.category = "tasks"; //labels
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template.tooltipText = "{category}: {value.formatDuration()}";

        pieSeries.labels.template.text =
            "[font-style: italic]{category}:\n{value.formatDuration()} ([bold]{value.percent.formatNumber('###.00')}%)";

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        // pieSeries.ticks.template.disabled = true;
        // pieSeries.alignLabels = false;
        //pieSeries.labels.template.text = "{value.formatDuration()}";
        // pieSeries.labels.template.radius = am4core.percent(-20);
        // pieSeries.labels.template.fill = am4core.color("white");

        // pieSeries.labels.template.adapter.add("radius", function(radius, target) {
        //     if (target.dataItem && (target.dataItem.values.value.percent < 10)) {
        //         return 0;
        //     }
        //     return radius;
        // });

        // pieSeries.labels.template.adapter.add("fill", function(color, target) {
        //     if (target.dataItem && (target.dataItem.values.value.percent < 10)) {
        //         return am4core.color("#000");
        //     }
        //     return color;
        // });

        var title = chart.titles.create();
        title.text = "All tasks stats";
        title.fontSize = 25;
    }); // end am4core.ready()
    am4core.ready(function() {

        // Themes begin
        //am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("pie-chart-all-projects", am4charts.PieChart);

        // Add data
        chart.data = [<?php echo toJSON("projects", "seconds", $labelsXProjects, $labelsYProjects); ?>];
        chart.legend = new am4charts.Legend();
        // Set inner radius
        chart.innerRadius = am4core.percent(50);

        // Force global duration format
        chart.durationFormatter.durationFormat = "hh 'h:' mm 'm'  "; //:' ss  ";

        var title = chart.titles.create();
        title.text = "All projects stats";
        title.fontSize = 25;


        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "seconds"; //values
        pieSeries.dataFields.category = "projects"; //labels
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template.tooltipText = "{category}: {value.formatDuration()}";

        pieSeries.labels.template.text =
            "[font-style: italic]{category}:\n{value.formatDuration()} ([bold]{value.percent.formatNumber('###.00')}%)";

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;
        var label = pieSeries.createChild(am4core.Label);
        label.text = "{values.value.sum.formatDuration()}";
        label.horizontalCenter = "middle";
        label.verticalCenter = "middle";
        label.fontSize = 28;
    });
    am4core.ready(function() {

        var chart = am4core.create("bar-chart-by-week", am4charts.XYChart);

        // Add data
        chart.data = [<?php echo toJSON("days", "seconds", $labelsXweek, $labelsYweek); ?>];
        var title = chart.titles.create();
        title.text = "Worktime";
        title.fontSize = 25;
        title.marginBottom = 10;
        // Create axes
        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "days";
        xAxis.renderer.grid.template.location = 0;
        xAxis.renderer.minGridDistance = 30;

        var yAxis = chart.yAxes.push(new am4charts.DurationAxis());
        yAxis.baseUnit = "second";
        yAxis.title.text = "Time used";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "seconds";
        series.dataFields.categoryX = "days";
        series.columns.template.tooltipText = "{categoryX}: {valueY.formatDuration()}";

        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.label.text = "{valueY.formatDuration()}";
        bullet.label.verticalCenter = "bottom";
        //bullet.label.dy = -10;
        //bullet.label.fontSize = 20;
        chart.durationFormatter.durationFormat = "hh 'h:' mm 'm'";

        chart.maskBullets = false;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", (fill, target) => {
            return chart.colors.getIndex(target.dataItem.index * 2);
        });
    });
    am4core.ready(function() {

        var chart = am4core.create("bar-chart-by-pauses", am4charts.XYChart);

        // Add data
        chart.data = [<?php echo toJSON("days", "seconds", $labelsXDays, $labelsYDays); ?>];
        var title = chart.titles.create();
        title.text = "Unused time";
        title.fontSize = 25;
        title.marginBottom = 10;
        // Create axes
        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        xAxis.dataFields.category = "days";
        xAxis.renderer.grid.template.location = 0;
        xAxis.renderer.minGridDistance = 30;

        var yAxis = chart.yAxes.push(new am4charts.DurationAxis());
        yAxis.baseUnit = "second";
        yAxis.title.text = "Time used";

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "seconds";
        series.dataFields.categoryX = "days";
        series.columns.template.tooltipText = "{categoryX}: {valueY.formatDuration()}";
        chart.durationFormatter.durationFormat = "hh 'h:' mm 'm:' ss 's'";
        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.label.text = "{valueY.formatDuration()}";
        bullet.label.verticalCenter = "bottom";
        //bullet.label.dy = -10;
        //bullet.label.fontSize = 20;

        chart.maskBullets = false;

        // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
        series.columns.template.adapter.add("fill", (fill, target) => {
            return chart.colors.getIndex(target.dataItem.index * 2);
        });
    });
    </script>
</body>

</html>
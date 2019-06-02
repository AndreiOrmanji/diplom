<?php
use Twig\Error\Error;

require_once './db.php';
// if (!isset($_SERVER['PHP_AUTH_USER'])) {
//     header('WWW-Authenticate: Basic realm="My Realm"');
//     header('HTTP/1.0 401 Unauthorized');
//     echo 'Text to send if user hits Cancel button';
//     exit;
// } else {
//     echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
//     echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
// }


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

function toJSON($label1, $label2, $label3, $arr1, $arr2, $arr3)
{
    for ($i = 0; $i < sizeof($arr1); $i++) {
        # code...
        if ($i === 0) {
            $str = "\n\t{\n\t\t" . '"' . $label1 . '": ' . '' . $arr1[$i] . ',' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . ',' . "\n\t\t" . '"' . $label3 . '": ' . '' . $arr3[$i] . "\n\t}";
        } else {
            $str = ",\n\t{\n\t\t" . '"' . $label1 . '": ' . '' . $arr1[$i] . ',' . "\n\t\t" . '"' . $label2 . '": ' . '' . $arr2[$i] . ',' . "\n\t\t" . '"' . $label3 . '": ' . '' . $arr3[$i] . "\n\t}";
        }
    }
    return $str;
}


try {

    if (isset($_POST['submit'])) {
        $piece = explode(".", $_POST['user_id'], 2);
        $_SESSION['graph_id'] = $piece[0];
        $_SESSION['graph_email'] = $piece[1];
        $date=array($_POST['date_to_check']);

    }
    if (!isset($_SESSION['graph_id'])) {
        $_SESSION['graph_id'] = $_SESSION['id'];
        $_SESSION['graph_email'] = $_SESSION['email'];
    }

    $result = array();
    $name = array();
    $fromDate = array();
    $toDate = array();

    $daily_log = getLogs();
    $byDate=array();
    $activity_date = R::getCol('SELECT DISTINCT date FROM logs where user_id=?',[$_SESSION['graph_id']]);
    print_r($activity_date);
    //$date = R::getCol('SELECT DISTINCT date FROM logs where user_id=?', [$_SESSION['id']]);
    // print_r($date);
    // echo sizeof($date);
    // echo $date[0];
    for ($j = 0; $j < sizeof($date); $j++) {
        $temp1=array();
        //echo $date[$j];
        for ($i = 0; $i < sizeof($daily_log) ; $i++) {
            if($date[$j]===$daily_log[$i]['date']){
                array_push($temp1,$daily_log[$i]);
                // echo "<pre>",$daily_log[$i]['date'], "</pre>";
                // print_r($daily_log[$i]);
            }
        }
        array_push($byDate,$temp1);
        
    }

    for ($j = 0; $j < count($byDate); $j++) {
       
        for ($i = 0; $i < count($byDate[$j]) - 1; $i++) {

                if (($i === 0) && ($byDate[$j][$i]['new_status'] === "Paused")) {
                    $tmp = $byDate[$j][$i]['pr_name'] . '/' . $byDate[$j][$i]['t_name'];
                    array_push($result, ['name' => $tmp, "fromDate" => $byDate[$j][$i]['date'] . " 00:00:00", "toDate" =>  $byDate[$j][$i]['date'] . ' ' . $byDate[$j][$i]['time']]);
                }
                if (($byDate[$j][$i]['new_status'] === "Running")) {
                    $tmp = $byDate[$j][$i]['pr_name'] . '/' . $byDate[$j][$i]['t_name'];
                    array_push($result, ['name' => $tmp, "fromDate" => $byDate[$j][$i]['date'] . ' ' . $byDate[$j][$i]['time'], "toDate" =>  $byDate[$j][$i + 1]['date'] . ' ' . $byDate[$j][$i + 1]['time']]);
                }
        }
        if ($byDate[$j][sizeof($byDate[$j]) - 1]['new_status'] === "Running") {
            $tmp = $byDate[$j][$i]['pr_name'] . '/' . $byDate[$j][$i]['t_name'];
            array_push($result, ['name' => $tmp, "fromDate" => $byDate[$j][sizeof($byDate[$j]) - 1]['date'] . " " . $byDate[$j][sizeof($byDate[$j]) - 1]['time'], "toDate" => $byDate[$j][sizeof($byDate[$j]) - 1]['date'] . ' 23:59:59']);
        }
        //break;
    }
    //echo  trim(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),"[]");
} catch (Exception $e) {
    echo $e;
}
?>
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
    <?php 
        
        if ($_SESSION['is_head'] === "1") {
            echo
                '<form id="contactForm" action="./info2" method="post">
                <div class="form-group">
            <label for="user_id">Show statistics of:</label></br>';
            $users_to_assign = R::find('users', 'dept_id=? AND id<>?', [$_SESSION["dept_id"], $_SESSION['graph_id']]);
            //$users_to_assign = R::find('users', 'dept_id=?', [$_SESSION["dept_id"]]);
            if (empty($users_to_assign)) {
                echo 'No users in department...';
            } else {
                echo '<select name="user_id" class="custom-select col-sm-2">
                <option selected="selected">' . $_SESSION['graph_id'] . '. ' . $_SESSION['graph_email'] . '</option>';
                foreach ($users_to_assign as $usr) {
                    echo '<option>' . $usr['id'] . '. ' . $usr['email'] . '</option>';
                }
                echo '</select>';
            }
            
        }
        echo '<label for="user_id">Show statistics of:</label></br>';
        echo '<select name="date_to_check" class="custom-select col-sm-2">';
        foreach ($activity_date as $d) {
            echo '<option>' . $d. '</option>';
        }
        echo '</select>';
        echo '<button id="button" class="container col-sm-2 btn btn-success btn-block" name="submit" type="submit">OK!</button></div>
            </form>';
        
    ?>

    <div id="chartdiv"></div>
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

        chart.data = [<?php echo  trim(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),"[]");?>];

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
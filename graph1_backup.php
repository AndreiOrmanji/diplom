<?php
require_once './db.php';

function getTasksID()
{
    return R::getCol('SELECT DISTINCT task_id FROM logs WHERE user_id=' . $_SESSION['id']);
    //return $array = print_r($array);
}
function getWeekDays($firstDay, $lastDay)
{
    return R::getCol('SELECT DISTINCT date FROM logs WHERE user_id = ? AND date >= ? AND date <= ?',  [$_SESSION['id'], $firstDay, $lastDay]);
}
function getProjects()
{
    return R::getAll('SELECT a.project_id, b.pr_name FROM logs a, projects b WHERE a.project_id = b.id AND a.user_id= ? GROUP BY a.project_id', [$_SESSION['id']]);
    //return $array = print_r($array);
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
</head>

<body>
    <div class="container">
        <div class='row'>
            <div class='col-md-6'>
                <canvas id="pie-chart-all-tasks" width="450" height="350"></canvas>
            </div>
            <div class='col-md-6'>
                <canvas id="pie-chart-all-projects" width="450" height="350"></canvas>
            </div>
            <div class='col-md-12'>
                <canvas id="bar-chart-by-week" width="450" height="150"></canvas>
            </div>
        </div>
    </div>
    <?php
    try {
        $userTasks = getTasksID(); //уникальные записи о задачах 1, 2, 3
        $intervals = array();
        for ($i = 0; $i < sizeof($userTasks); $i++) {
            $temp = 0;
            $logs = R::find('logs', ' user_id = ? ',  [$_SESSION['id']]);
            for ($j = 0; $j < sizeof($logs); $j++) {
                if (($logs[$j]['task_id'] === $userTasks[$i]) && ($logs[$j]['new_status'] === 'Running')) {
                    if (($logs[$j + 1]['task_id'] === $userTasks[$i])) {
                        $temp += ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']);
                    }
                }
            }
            array_push($intervals, $temp);
        }
        //echo var_dump($intervals);
        echo "</br>";

        $rraytest = R::getAll('SELECT a.pr_name, b.t_name FROM projects a, tasks b WHERE b.project_id = a.id and b.user_id = ' . $_SESSION['id']);
        $labelsX = "";
        foreach ($rraytest as $t) {
            $labelsX .= '"' . $t['pr_name'] . ' / ' . $t['t_name'] . '", ';
        }

        $temp = 0;
        $labelsYallTasks = "";
        foreach ($intervals as $interval) {
            $temp += $interval;
            $labelsYallTasks .= '' . $interval . ', ';
        }

        //$labelsYProjects.=''.(800-$temp).'';
        //II. расчеты для 2 графика по неделям
        $day = date('w');
        $currentWeek = array();
        $firstDay =  date("Y-m-d", strtotime('Monday this week'));
        $lastDay =  date("Y-m-d", strtotime('Sunday this week'));
        $logWeek = R::find('logs', ' user_id = ? AND date >= ? AND date <= ?',  [$_SESSION['id'], $firstDay, $lastDay]);
        $TasksID = getTasksID(); //уникальные записи о задачах 1, 2, 3
        $wDays = getWeekDays($firstDay, $lastDay);
        //$intervals = array();
        //echo $firstDay."  ".$lastDay."", "\n";
        //echo date("N",strtotime($lastDay));
        //$date = date('d-m-Y', strtotime("+1 day", strtotime("10-12-2011")));
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
            //echo $dayToCompare."</br>";
            //array_push($intervals, $temp);                  
            $intervals[$i] = $temp;
        }
        //print_r($intervals);
        //for ($k=0;$k<7;$k++){
        //echo strtotime("+1 day"), "\n";
        //}
        //echo var_dump($intervals);
        $temp = "";
        foreach ($intervals as $interval) {
            $temp += $interval;
            $labelsYweek .= '' . $interval . ', ';
        }
        //Расчеты по проектам
        $projects = getProjects();
        //print_r($projects);
        $intervals = array();
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
            array_push($intervals, $temp);
        }
        $temp = 0;
        $labelsXProjects = "";
        foreach ($projects as $t) {
            $labelsXProjects .= '"' . $t['pr_name'] . '", ';
        }
        $labelsYProjects = "";
        foreach ($intervals as $interval) {
            $temp += $interval;
            $labelsYProjects .= '' . $interval . ', ';
        }
    } catch (Exception $e) {
        echo "$e";
    }
    // echo date("Y-m-d", strtotime('monday this week')); 
    // echo date("Y-m-d", strtotime('sunday this week'));
    //echo $week_start.' - '.$week_end;

    ?>
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    new Chart(document.getElementById("pie-chart-all-tasks"), {
        type: 'pie',
        data: {
            labels: [<?php echo $labelsX; ?>],
            datasets: [{
                label: "Time (seconds)",
                backgroundColor: ["#235789", "#a1d302", "#5e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9",
                    "#c45850", "#e3b505",
                    "#95190c",
                    "#610345", "#107e7d", "#044b7f", "#93b5c6", "#ddedaa", "#f0cf65", "#d7816a",
                    "#bd4f6c",
                    "#ee6c4d", "#f38d68", "#662c91", "#17a398", "#33312e", "#ed1c24", "#fdfffc",
                    "#020100"
                ],
                data: [<?php echo $labelsYallTasks; ?>]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Распределение времени по задачам'
            }
        }
    });

    new Chart(document.getElementById("pie-chart-all-projects"), {
        type: 'pie',
        data: {
            labels: [<?php echo $labelsXProjects; ?>],
            datasets: [{
                label: "Time (seconds)",
                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#e3b505",
                    "#95190c",
                    "#610345", "#107e7d", "#044b7f", "#93b5c6", "#ddedaa", "#f0cf65", "#d7816a",
                    "#bd4f6c",
                    "#ee6c4d", "#f38d68", "#662c91", "#17a398", "#33312e", "#ed1c24", "#fdfffc",
                    "#235789", "#f1d302", "#020100"
                ],
                data: [<?php echo $labelsYProjects; ?>]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Распределение времени по проектам'
            }
        }
    });

    new Chart(document.getElementById("bar-chart-by-week"), {
        type: 'bar',
        data: {
            labels: ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресение"],
            datasets: [{
                label: "Времени отработано(сек)",
                // backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#f1d302",
                //     "#020100"
                // ],
                backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)",
                    "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"
                ],
                data: [<?php echo $labelsYweek; ?>]
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Отработано за неделю'
            }

        }
    });
    </script>
</body>

</html>
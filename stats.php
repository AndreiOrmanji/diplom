<?php
require_once './db.php';

function returnDate($tResumed)
{
    if (($tResumed === NULL) || ($tResumed === 0) || ($tResumed === "")) {
        return "-----";
    } else {
        return date("d.m.Y", $tResumed);
    }
}

function returnTime($tResumed)
{
    if (($tResumed === NULL) || ($tResumed === 0) || ($tResumed === "")) {
        return "-----";
    } else {
        return date("H:i:s", $tResumed);
    }
}

function getTasksID()
{
    return R::getCol('SELECT DISTINCT task_id FROM logs WHERE user_id=' . $_SESSION['id']);
    //return $array = print_r($array);
}

function getProjects()
{
    return R::getCol('SELECT DISTINCT project_id FROM logs WHERE user_id=' . $_SESSION['id']);
    //return $array = print_r($array);
}

function getLogs()
{
    //return $array = print_r($array);
    return R::getAll('SELECT a.project_id, b.pr_name, a.task_id, c.t_name, a.new_status, a.time, a.date FROM logs a, projects b, tasks c WHERE a.project_id = b.id AND a.task_id = c.id  AND a.user_id = ?', [$_SESSION['id']]);
}

function secConvert($seconds)
{
    $h = floor($seconds / 3600);
    //$h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    return $h . ':' . $m . ':' . $s;
    //return array($h, $m, $s);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stats</title>
    <link rel="stylesheet" href="./libs/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8">
    <script src="./libs/Chart.min.js"></script>
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
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <?php if ($_SESSION['email']) : ?>
        <?= '<div class="container>You are using ' . $_SESSION['email'] . ' as your e-mail adress.</div>'; ?>
        <?php
        try {
            $timeNow = time();
            echo '<div>Tracking starts at ' . date("H:i:s", time()) . '(' . time() . ')</div>
        <div>Current Time: <span id="current_time"></span></div>';
            $logs = getLogs(); //R::find('logs', ' user_id = ? ',  [$_SESSION['id']]);
            //echo print_r($logs);
            if (empty($logs)) echo "No activity by " . $_SESSION['email'] . ".";
            else {
                $activity_date = R::getCol('SELECT DISTINCT date FROM logs;');
                // foreach ($activity_date as $day){
                //     $logs = R::find( 'logs', ' user_id = ? and date = ?',  [$_SESSION['id'],$date]);
                //     echo '<script>console.log('.print_r($logs->export()).');</script>';
                // }
                foreach ($activity_date as $logDate) {
                    echo '
                <div class="container">
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
                            </table></div></details>';
                }
            }
            $userTasks = getTasksID(); //уникальные записи о задачах 1, 2, 3
            $intervals = array();
            for ($i = 0; $i < sizeof($userTasks); $i++) {
                $temp = 0;
                $logs = R::find('logs', ' user_id = ? ', [$_SESSION['id']]);
                for ($j = 0; $j < sizeof($logs); $j++) {
                    if (($logs[$j]['task_id'] === $userTasks[$i]) && ($logs[$j]['new_status'] === 'Running')) {

                        if (($logs[$j + 1]['task_id'] === $userTasks[$i])) {

                            $temp += ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']);
                            //     echo "</br>";         
                            //     print_r($logs[$j]->export());
                            //     echo "</br>";         
                            //     print_r($logs[$j+1]->export());
                            //     echo "</br>";         
                            //     echo ($logs[$j + 1]['timestamp'] - $logs[$j]['timestamp']).'</br>';
                            //     //echo $logs[$j]['date'].': '.$logs[$j]['t_name'].': '.$temp.'</br>';  
                        }
                    }
                }
                array_push($intervals, $temp);

                // echo 'task_id:'.$userTasks[$i].'    ';	
                // echo 'counted:'.$intervals[$i].'</br>';

            }
            // echo var_dump($intervals);
            // echo "</br>";

            $projects_and_tasks = R::getAll('SELECT a.pr_name, b.t_name FROM projects a, tasks b WHERE b.project_id = a.id and b.user_id = ' . $_SESSION['id']);
            //print_r($projects_and_tasks);
            $labelsX = "";
            foreach ($projects_and_tasks as $t) {
                $labelsX .= '"' . $t['pr_name'] . ' / ' . $t['t_name'] . '", ';
            }
            //$labelsX.='"Unused time"';
            $temp = 0;
            $labelsY = "";
            foreach ($intervals as $interval) {
                //$temp += $interval; //2 спорный момент
                $labelsY .= '' . $interval . ', ';
            }
            //print_r($activity_date[$i]);
            //$labelsY.=''.(800-$temp).'';
            $intervals = array();
            foreach ($activity_date as $day) {
                $temp = 0;
                $sql = "select * from logs where date = '" . $day . "'";
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
                array_push($intervals, $temp);
                // print_r($intervals);
            }

            $temp = "";
            $labelsXDays = "";
            foreach ($activity_date as $date) {
                //$temp+=$date;
                $labelsXDays .= '"' . $date . '", ';
                //echo $date;
            }
            $temp = 0;
            $labelsYDays = "";
            foreach ($intervals as $interval) {
                //$temp += $interval; //изменил только что (1 Спорный момент)
                $labelsYDays .= '' . $interval . ', ';
            }
        } catch (Exception $e) {
            //echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
            //var_dump($task);
            echo "$e";
        }
        ?>
    <?php else : ?>
        <?= "You are not autorized. Go to <a href=\"./login\">Login Page.</a> "; ?>
    <?php endif; ?>
    <div class="container">
        <div class='row'>
            <div class='col-md-6'>
                <canvas id="pie-chart-all-tasks" width="450" height="350"></canvas>
            </div>
            <p>
                <input class="inputDate" id="inputDate" value="" size="30" readonly/>
                <!--
                <label id="closeOnSelect"><input type="checkbox"> Close on selection</label>
                -->
            </p>

            <div class='col-md-12'>
                <canvas id="bar-chart-by-pauses" width="450" height="150"></canvas>
            </div>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="./libs/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        function appendLeadingZeroes(n) {
            if (n < 9) {
                return "0" + n;
            }
            return n
        }
        let current_datetime = new Date();
        let formatted_date = current_datetime.getFullYear() + "-" + appendLeadingZeroes(current_datetime.getMonth() + 1) + "-" + appendLeadingZeroes(current_datetime.getDate()) ;
        document.getElementById('inputDate').value = formatted_date;


        new Chart(document.getElementById("bar-chart-by-pauses"), {
            type: 'bar',
            data: {
                labels: [<?php echo $labelsXDays; ?>],
                datasets: [{
                    label: "секунд",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#f1d302",
                        "#020100"
                    ],
                    data: [<?php echo $labelsYDays; ?>]
                }]
            },
            options: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Pauses (secs)'
                }
            }
        });

        new Chart(document.getElementById("pie-chart-all-tasks"), {
            type: 'pie',
            data: {
                labels: [<?php echo $labelsX; ?>],
                datasets: [{
                    label: "секунд",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#e3b505",
                        "#95190c",
                        "#610345", "#107e7d", "#044b7f", "#93b5c6", "#ddedaa", "#f0cf65", "#d7816a",
                        "#bd4f6c",
                        "#ee6c4d", "#f38d68", "#662c91", "#17a398", "#33312e", "#ed1c24", "#fdfffc",
                        "#235789", "#f1d302", "#020100"
                    ],
                    data: [<?php echo $labelsY; ?>]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Распределение времени по задачам'
                }
            }
        });
    </script>
</body>

</html>
<?php
require_once './db.php';

function returnDate($tResumed)
{
    if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
        return "-----";
    } else {
        return date("d.m.Y", $tResumed);
    }
}

function returnTime($tResumed)
{
    if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
        return "-----";
    } else {
        return date("H:i:s", $tResumed);
    }
}
 
function getTasksID (){
    return R::getCol( 'SELECT DISTINCT task_id FROM logs WHERE user_id='.$_SESSION['id'] );
    //return $array = print_r($array);
}

function getProjects (){
    return R::getCol( 'SELECT DISTINCT pr_name FROM logs WHERE user_id='.$_SESSION['id'] );
    //return $array = print_r($array);
}

function secConvert($seconds) {
    $h = floor($seconds / 3600);
    //$h = str_pad($h, 1, "0", STR_PAD_LEFT);
    $m = floor(($seconds / 60) % 60);
    $m = str_pad($m, 2, "0", STR_PAD_LEFT);
    $s = $seconds % 60;
    $s = str_pad($s, 2, "0", STR_PAD_LEFT);
    return $h.':'.$m.':'.$s;
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
    <style>
    th {
        text-align: center!important;
    }
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <?php if($_SESSION['email']) : ?>
    <?="You are using, ". $_SESSION['email'] ." as your e-mail adress.";?>
    <div></div>
    <?php
    $timeNow = time();
    echo '<div>Tracking starts at '.date("H:i:s", time()).'('.time().')</div>';
    echo '<div>Current Time: <span id="current_time"></span></div>';
    $logs = R::find( 'logs', ' user_id = ? ',  [$_SESSION['id']]);
    //echo print_r($logs);
    if(empty($logs)) echo "No activity by ".$_SESSION['email'].".";
        else{
            $dateArray = R::getCol( 'SELECT DISTINCT date FROM logs;' );
            foreach ($dateArray as $logDate) {
                # code...
                
                echo '<div class="container">';
                echo 'Table for '.$logDate.'
                <h6>Current tasks of user <strong><i>'.$_SESSION['email'].'</i></strong></h6>
                <span id="userId" style="display:none;">'.$_SESSION['id'].'</span>
                <table class="table">    
                        <thead>
                        <tr>
                                <th>#</th>
                                <th>User_ID</th>
                                <th>UserName</th>
                                <th>ProjectName</th>
                                <th>TaskName</th>
                                <th>New status</th>
                                <th>Timestamp</th>
                                <th>Time</th>
                                <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>';
                        foreach (array_reverse($logs)as $log) {
                            if ($log['date']===$logDate){
                                echo'<tr>
                                <td class="log_id" style="text-align: center;">'.$log['id'].'</td>
                                <td class="log_user_id" style="text-align: center;">'.$_SESSION['id'].'</td>
                                <td class="username" style="text-align: center;">'.$_SESSION['email'].'</td>
                                <td class="log_pr_name" style="text-align: center;">'.$log['pr_name'].'</td> 
                                <td class="log_t_name" style="text-align: center;">'.$log['t_name'].'</td> 
                                <td class="log_new_status" style="text-align: center;">'.$log['new_status'].'</td>
                                <td class="log_timestamp" style="text-align: center;">'.$log['timestamp'].'</td>
                                <td class="log_time" style="text-align: center;">'.$log['time'].'</td>
                                <td class="log_date" style="text-align: center;">'.$log['date'].'</td>
                                </tr>';
                            }
                        }
                            echo        '</tbody>
                            </table></div>' ;
                    }
                }
                try{
                    $userTasks = getTasksID();//уникальные записи о задачах 1, 2, 3
                    $intervals = array();
                    for($i=0; $i<sizeof($userTasks); $i++){
                        $temp=0;
                        $logs = R::find( 'logs', ' user_id = ? ', [$_SESSION['id']]);
                        for ($j=0; $j<sizeof($logs); $j++){ 
                            if (($logs[$j]['task_id']===$userTasks[$i])&& ($logs[$j]['new_status']==='Running')) {		
                                    if (($logs[$j+1]['task_id']===$userTasks[$i])) {					                    
                                        $temp+=($logs[$j+1]['timestamp']-$logs[$j]['timestamp']);  
                                        // echo "</br>";         
                                        // print_r($logs[$j]->export());
                                        // echo "</br>";         
                                        // print_r($logs[$j+1]->export());
                                        // echo "</br>";         
                                        // echo $dayToCompare.': '.$logs[$j]['t_name'].': '.$temp.'</br>';  
                                    }                
                                }
                            }	
                            array_push($intervals, $temp);
                        
                        // echo 'task_id:'.$userTasks[$i].'    ';	
                        // echo 'counted:'.$intervals[$i].'</br>';
                        
                    }
                    // echo var_dump($intervals);
                    // echo "</br>";
                    $rraytest = R::getAll( 'SELECT pr_name, t_name FROM tasks WHERE user_id='.$_SESSION['id']);
                    //R::getCol( 'SELECT t_name FROM logs;');
                    //print_r($rraytest);
                    // print_r(json_encode($rraytest));
                    $labelsX="";
                    foreach ($rraytest as $t) {
                        $labelsX .= '"'.$t['pr_name'].' / '.$t['t_name'].'", ';
                    }
                    $labelsX.='"Unused time"';
                    $temp=0;
                    $labelsY="";
                    foreach ($intervals as $interval) {
                        $temp+=$interval;
                        $labelsY .= ''.$interval.', ';
                    }
                    $labelsY.=''.(800-$temp).'';
                }
                catch(Exception $e){
                    //echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
                    //var_dump($task);
                    echo "$e";
                  }
                    ?>
            <?php else: ?>
    <?="You are not autorized. Go to <a href=\"./login\">Login Page.</a> ";?>
    <?php endif; ?>
    <?php


    ?>
    <div class='col-md-6' >
    <canvas id="pie-chart" width="800" height="450"></canvas>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./libs/jquery-3.3.1.min.js"></script>
    <script src="./libs/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="./libs/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
    <!--
    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
          labels: [<?php echo $labelsX;?>],
          datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#e3b505","#95190c",
            "#610345","#107e7d","#044b7f","#93b5c6","#ddedaa","#f0cf65","#d7816a","#bd4f6c",
            "#ee6c4d","#f38d68","#662c91","#17a398","#33312e","#ed1c24","#fdfffc","#235789","#f1d302","#020100"],
            data: [<?php echo $labelsY;?>]  
          }]
        },
        options: {
          title: {
            display: true,
            text: 'Predicted world population (millions) in 2050'
          }
        }
    });
    -->
    </script>
</body>

</html>                        
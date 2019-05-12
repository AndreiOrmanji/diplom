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
    $result = array();
    $name = array();
    $fromDate = array();
    $toDate = array();

    $daily_log = getLogs();
    $byDate=array();
    
    $date = R::getCol('SELECT DISTINCT date FROM logs where user_id=?', [$_SESSION['id']]);
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
    echo "<pre>", json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "</pre>";
} catch (Exception $e) {
    echo $e;
}

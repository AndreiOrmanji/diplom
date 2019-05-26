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
    $all_logs = array();
    $daily_log = getLogs();

    $date = R::getCol('SELECT DISTINCT date FROM logs where user_id=?', [$_SESSION['id']]);
    //print_r($date);
    //ПЕРЕБИРАЕМ ДАТЫ ИЗ ЛОГОВ
    for ($j = 0; $j < sizeof($date); $j++) {
        for ($i = 0; $i < sizeof($daily_log) - 1; $i++) {
            // PEREBIRAEM LOGI KAJDOY OTDELINOY DATI
            if ($daily_log[$i]['date'] === $date[$j]) {
                //ESLI PERVAYA ZAPISI NACHINAETSIA S PAUSI, TO SOZDAEM ZAPISI NACHATUYU S DATI V 00:00 DO PERVOY ZAPISI
                if (($i === 0) && ($daily_log[$i]['new_status'] === "Paused")) {
                    $tmp = $daily_log[$i]['pr_name'] . '/' . $daily_log[$i]['t_name'];
                    array_push($result, ['name' => $tmp, "fromDate" => $daily_log[$i]['date'] . " 00:00:00", "toDate" =>  $daily_log[$i]['date'] . ' ' . $daily_log[$i]['time']]);
                }
                //ESLI PERVAYA ZAPISI ZAPUSK, TO 
                if (($daily_log[$i]['new_status'] === "Running")) {
                    $tmp = $daily_log[$i]['pr_name'] . '/' . $daily_log[$i]['t_name'];
                    array_push($result, ['name' => $tmp, "fromDate" => $daily_log[$i]['date'] . ' ' . $daily_log[$i]['time'], "toDate" =>  $daily_log[$i + 1]['date'] . ' ' . $daily_log[$i + 1]['time']]);
                    $i++;
                }
            }
        }
        //ESLI POSLEDNIAYA ZAPISI - ZAPUSK, TO SOZDAEM ZAPISI ZAKANCHIVAYUSHUYUSIA V23:59
        if ($daily_log[sizeof($daily_log) - 1]['new_status'] === "Running") {
            $tmp = $daily_log[$i]['pr_name'] . '/' . $daily_log[$i]['t_name'];
            array_push($result, ['name' => $tmp, "fromDate" => $daily_log[sizeof($daily_log) - 1]['date'] . " " . $daily_log[sizeof($daily_log) - 1]['time'], "toDate" => $daily_log[sizeof($daily_log) - 1]['date'] . ' 23:59:59']);
        }
        //break;
        if (!empty($result)) {
            array_push($all_logs, $result);
            $result = array();
        }
    }
    //echo '<pre>' . toJSON("name", "fromDate", "toDate", $name, $fromDate, $toDate) . '</pre>';
    echo "<pre>", json_encode($all_logs, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "</pre>";
} catch (Exception $e) {
    //throw $th;
    echo $e;
}

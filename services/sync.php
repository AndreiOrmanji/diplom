<?php 
require_once '../db.php';
// $data = json_decode(stripslashes($_POST['data']));
$data = $_POST['data'];
//print_r($data);
try{
        if ($data["newStatus"]==="Finished"){
            $logRecord = R::dispense('logs_tasks_created_finished');
        }
        else{
            $logRecord = R::dispense('logs');
        }
            $logRecord->import($data);
            $logRecord->time = date("H:i:s", $logRecord->timestamp);
            $logRecord->date = date("Y-m-d", $logRecord->timestamp);
            R::store($logRecord);
    // $tmp = $logRecord->export();
    // echo $tmp;
}
catch(Exception $e){
    echo $e;
}
?>
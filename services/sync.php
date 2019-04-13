<?php 
require_once '../db.php';
// $data = json_decode(stripslashes($_POST['data']));
$data = $_POST['data'];
//print_r($data);
try{
        $logRecord = R::dispense ( 'logs' );
        $logRecord->import($data);
        R::store( $logRecord );
    // $tmp = $logRecord->export();
    // echo $tmp;
}
catch(Exception $e){
    echo $e;
}
?>
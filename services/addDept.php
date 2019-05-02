<?php  
require_once '../db.php';
function returnDate($tResumed)
  {
      if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
          return "-----";
      } else {
          return date("Y-m-d", $tResumed);
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
try{
    ob_start();
    if ( isset($_POST['submit']) && ($_SESSION["id"]!=NULL) ) {
        //echo '<pre>'.var_dump($_POST['submit']).'</pre>';
        $dept = R::dispense ('depts');
        $dept->user_id = $_SESSION["id"];                                        
        $dept->dept_name = $_POST['dept_name'];   
        $tmp = explode("|",$_POST['head_id'],2); 
        $dept->head_id = $tmp[0]; 
        $dept_id = R::store( $dept );
        //$dept = R::load( 'clients', $dept_id);
        // $logRecord = R::dispense ('project_logs');
        // $logRecord->userId = $dept['userId'];
        // $logRecord->taskId = $dept['id'];
        // $logRecord->prName = $dept['prName'];
        // $logRecord->newStatus =  'Created';
        // $logRecord->timestamp = $dept['tCreated'];
        // $logRecord->time = returnTime($logRecord->timestamp);
        // $logRecord->date = returnDate($logRecord->timestamp);
        // R::store( $logRecord );
    }
        //echo '<meta http-equiv="Refresh" content="2; url=./clients">';
        //echo '';
        header("Location: ../depts");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($dept);
    
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    echo '<pre>'.var_dump($dept).'</pre>';
    echo "$e";
}

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
        $task = R::dispense ('tasks');
        $task->userId = $_SESSION["id"];                                        //user id
        $task->prName = (empty($_POST['prname'])) ? 'Others tasks' : $_POST['prname'];    //project name
        $task->tName = $_POST['tname'];                                         //task name
        $task->tDesc = $_POST['tdesc'];                                         //description
        $task->tCreated=time();  
        //task created
        $task->tFinished=NULL;                                                  //task finished
        $task->tPaused=NULL;
        $task->timeCounted = 0;                                                 //time already counted
        $task->status = 0; 
        //task is stopped
        $task->tResumed = NULL;
        $task_id = R::store( $task );
        $task = R::load( 'tasks', $task_id);
        $logRecord = R::dispense ('logs');
        $logRecord->userId = $task['userId'];
        $logRecord->taskId = $task['id'];
        $logRecord->prName = $task['prName'];
        $logRecord->tName = $task['tName'];
        $logRecord->newStatus =  'Created';
        $logRecord->timestamp = $task['tCreated'];
        $log->time = returnTime($log->timestamp);
        $log->date = returnDate($log->timestamp);
        R::store($logRecord);
    }
        //echo '<meta http-equiv="Refresh" content="2; url=./tasks">';
        //echo '';
        header("Location: ../tasks");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($task);
    
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    var_dump($task);
    echo "$e";
}
?>
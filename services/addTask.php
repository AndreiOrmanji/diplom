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
        $piece = explode(".",$_POST['user_id']);
        $task->user_id = $piece[0];
        $piece = explode(".",$_POST['prname']);                                     //user id
        $task->project_id = ($piece[0]==='Choose from existing projects') ? 1 : $piece[0];    //project name
        $task->t_name = $_POST['tname'];                                         //task name
        $task->t_desc = $_POST['tdesc'];                                         //description
        // $task->is_billable = (isset($_POST['is_billable']))?1:0;                 //is billable
        // $task->price=$_POST['price'];
        $task->t_created=time();  
        //task created
        $task->t_finished=NULL;                                                  //task finished
        $task->t_paused=NULL;
        $task->time_counted = 0;                                                 //time already counted
        $task->status = 0; 
        //task is stopped
        $task->t_resumed = NULL;
        $task_id = R::store( $task );
        $task = R::load( 'tasks', $task_id);
        $logRecord = R::dispense ('createdlog');
        $logRecord->user_id = $task['user_id'];
        $logRecord->task_id = $task['id'];
        $logRecord->project_id = $task['project_id'];
        $logRecord->newStatus =  'Created';
        $logRecord->timestamp = $task['t_created'];
        $logRecord->time = returnTime($logRecord->timestamp);
        $logRecord->date = returnDate($logRecord->timestamp);
        R::store($logRecord);
    }
        //echo '<meta http-equiv="Refresh" content="2; url=./tasks">';
        //echo '';
        header("Location: ../tasks2");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($task);
    
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    var_dump($task);
    print_r($piece);
    echo "$e";
}
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
        $project = R::dispense ('projects');
        $project->userId = $_SESSION["id"];                                        
        $project->prName = $_POST['prname'];    
        $project->prDesc = $_POST['prdesc']; 
        $project->client = $_POST['client'];                                         
        $project->prCreated=time();  
        $project->prFinished=NULL;                                                  
        $project_id = R::store( $project );
        $project = R::load( 'projects', $project_id);
        // $logRecord = R::dispense ('project_logs');
        // $logRecord->userId = $project['userId'];
        // $logRecord->taskId = $project['id'];
        // $logRecord->prName = $project['prName'];
        // $logRecord->newStatus =  'Created';
        // $logRecord->timestamp = $project['tCreated'];
        // $logRecord->time = returnTime($logRecord->timestamp);
        // $logRecord->date = returnDate($logRecord->timestamp);
        // R::store( $logRecord );
    }
        //echo '<meta http-equiv="Refresh" content="2; url=./projects">';
        //echo '';
        header("Location: ../tasks");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($project);
    
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    echo '<pre>'.var_dump($project).'</pre>';
    echo "$e";
}
?>
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
        $client = R::dispense ('clients');
        $client->userId = $_SESSION["id"];                                        
        $client->clientName = $_POST['client_name'];    
        $client->email = $_POST['email']; 
        $client->phone = $_POST['phone'];                                                                                        
        $client_id = R::store( $client );
        $client = R::load( 'clients', $client_id);
        // $logRecord = R::dispense ('project_logs');
        // $logRecord->userId = $client['userId'];
        // $logRecord->taskId = $client['id'];
        // $logRecord->prName = $client['prName'];
        // $logRecord->newStatus =  'Created';
        // $logRecord->timestamp = $client['tCreated'];
        // $logRecord->time = returnTime($logRecord->timestamp);
        // $logRecord->date = returnDate($logRecord->timestamp);
        // R::store( $logRecord );
    }
        //echo '<meta http-equiv="Refresh" content="2; url=./clients">';
        //echo '';
        header("Location: ../tasks");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($client);
    
}
catch(Exception $e){
    echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
    echo '<pre>'.var_dump($client).'</pre>';
    echo "$e";
}
?>
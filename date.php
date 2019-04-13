<?php 
require_once './db.php';
  function returnDate($tResumed)
  {
      if (($tResumed===NULL) || ($tResumed===0) || ($tResumed==="")) {       
          return "-----";
      } else {
          return date("d-m-Y", $tResumed);
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
  
  $logs = R::find( 'logs', ' user_id = ? ',  [$_SESSION['id']]);
  foreach ($logs as $log) {
    $log->time = returnTime($log->timestamp);
    $log->date = returnDate($log->timestamp);
    R::store($log);
} 
  
?> 
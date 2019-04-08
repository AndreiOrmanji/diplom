<?php  
require_once '../db.php';
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

        if (isset($_POST['check'])) {
            $task->status = 1; //task is running
            $task->tResumed = time();
        }
        else{
            $task->status = 0; //task is stopped
            $task->tResumed = NULL;
        }
        R::store( $task );
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
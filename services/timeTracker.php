<?php
echo "test2 response from timeTracker.php";

$data = json_decode(stripslashes($_POST['data']));
	$data[0][0] = ; //
  // here i would like use foreach:

  foreach($data as $d){
     echo $d;
  }
  echo""


$task = R::findOne( 'tasks', ' id = ? ',  array($_POST['id']));
if ( isset($_POST['submit']) ) {
        //echo '<pre>'.var_dump($_POST['submit']).'</pre>';
        $task = R::dispense ('tasks');
        $task->userId = $_SESSION["id"];
        $task->prName = (empty($_POST['prname']))?'Others tasks':$_POST['prname'];    //project name
        $task->tName = $_POST['tname'];                                         //task name
        $task->tDesc = $_POST['tdesc'];                                         //description
        $task->userId = $_SESSION['id'];                                        //user id
        $task->tCreated=time();                                                 //task created
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
        //echo '<meta http-equiv="Refresh" content="2; url=./tasks">';
        //echo '';
        header("Location: ../tasks");
        exit;
        // foreach($_POST as $key => $value){
        //     $_POST[$key]='';
        // }        
        //var_dump($task);
    }

/*
var arr=[23,42,4,16,8,15];
function swap(arr,i,j){
    let temp=arr[i];
    arr[i]=arr[j];
    arr[j]=temp;
}
console.log(arr);
var ctr=0;
for (let i=1;i<arr.length-1;i++){
	ctr++;
  if(arr[i]>arr[i+1]) {
	swap(arr,i,i+1);
	ctr++;
  	for(let j=i;j>0;j--){
	ctr++;
  		if(arr[j]<arr[j-1]) { 
			ctr++;
			swap(arr,j,j-1);
  		}
  	}  
  }
}
console.log(arr);
console.log(ctr);
https://youtu.be/1IuUR7iy5iU


https://vk.com/id234812677
https://clips.twitch.tv/CulturedPolishedBibimbapCoolCat?tt_content=chat_card&tt_medium=twitch_chat
*/
?>
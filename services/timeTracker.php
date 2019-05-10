<?php
require_once '../db.php';
// $data = json_decode(stripslashes($_POST['data']));
$data = $_POST['data'];
try{
  for ($i=0; $i < sizeof($data); $i++) { 
    # code...
    $task = R::load('tasks',$data[$i]["id"]);
    $task->import($data[$i]);
    //print_r ($task);  
    R::store( $task );
  }
}catch(Exception $e){
  //echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
  //var_dump($task);
  echo "$e";
}
//echo "Updated";


// echo "test2 response from timeTracker.php";
  // here i would like use foreach:

  // foreach($data as $d){
  //    echo $d;
  // }
  // echo""

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
*/
?>
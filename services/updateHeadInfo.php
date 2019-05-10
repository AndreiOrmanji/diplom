<?php
require_once '../db.php';
// $data = json_decode(stripslashes($_POST['data']));
$data = $_POST['data'];
try{
  for ($i=0; $i < sizeof($data); $i++) { 
    # code...
    $users = R::load('users',$data[$i]["user_id"]);
    $users->import($data[$i]);
    //print_r ($users);  
    R::store( $users );
  }
}catch(Exception $e){
  //echo '<div style = "color:red;">'."Task failed!".'</div><hr>';
  //var_dump($users);
  echo "$e";
}
?>
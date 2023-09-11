<?php
include('functions.php');

session_start();


$result = queryMysql( "SELECT * FROM members WHERE user_token != '".$_SESSION['user_token']."'");
if($result->num_rows){
  $row = $result->fetch_array(MYSQLI_ASSOC);
$output = '
<table class = "table table-bordered table-striped">
<tr>
<td>User</td>
<td>Status</td>
<td>Action</td>
</tr> 
';

foreach ($result as $row){

  $status = '';
  $current_timestamp = strtotime(date("Y-m-d H:i:s") . '-10 seconds');
  $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
  $user_last_acivity = fetch_user_last_activity($row['user_token'],$connection);

  if($user_last_acivity > $current_timestamp){
    $status = '<span class= "label label-success">online</span>';
  }
  else{
    $status = '<span class = "label label-danger">offline</span>';
  }

$output.='
<tr>
<td>'.$row['user'].' '.count_unseen_messages($row['user_token'], $_SESSION['user_token'],$connection).'</td>
<td>'.$status.'</td>
<td><button type="button" class="btn btn-info btn-xs start_chat" data-tousertoken="'.$row['user_token'].'" data-tousername="'.$row['user'].'">Chat</button></td>
</tr>
';
}

$output.='</table';

echo $output;
}


?>
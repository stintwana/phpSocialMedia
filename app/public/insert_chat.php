<?php
include('functions.php');

session_start();


$to_user_token = $_POST['to_user_token'];
$from_user_token = $_SESSION['user_token'];
$chat_message = $_POST['chat_message'];
$status = '1';

$sql =" INSERT INTO chat_message (to_user_token, from_user_token, chat_message, timestamp, status) VALUES ('$to_user_token', '$from_user_token', '$chat_message',CURRENT_TIMESTAMP, '$status')";

if($connection->query($sql)===TRUE){

    echo fetch_user_chat_history($_SESSION['user_token'], $_POST['to_user_token'], $connection);
}
else{
    echo "error:".$connection->error;
}   


?>
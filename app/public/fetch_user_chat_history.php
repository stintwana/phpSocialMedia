<?php

session_start();
//fetch_user_chat_history.php

include('functions.php');


echo fetch_user_chat_history($_SESSION['user_token'], $_POST['to_user_token'], $connection);

?>
<?php
//All the code checks if the username exists from the database, If it exits an error is invoked. The results are shown in the signup page.
require_once 'functions.php';

if(isset($_POST['user'])){
$user = sanitizeString($_POST['user']);
$result = queryMysql("SELECT * FROM members WHERE user='$user'");

if($result->num_rows){
    echo"<span class='taken'>&nbsp;X This username is taken, Choose another</span>";
}
else{
    echo "<span class='available'>&nbsp;&#x2714; this username is available for use</span>";
}
}
?>
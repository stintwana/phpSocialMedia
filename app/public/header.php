<?php
session_start();
//code by: Thato monchusi - www.distaxs.000weebhostapp.com
//The Whole Code Is The Navigation
echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta http-equiv='Content-type' content='text/html; charset=utf-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1'/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='styles/bootstrap.min.css'> 
    <link rel='stylesheet' href='styles/styles.css' type='text/css'>
    <script src='js/jquery-3.4.1.min.js'></script> 
    <script src='js/tsn.js'></script>
    <script src="js/bootstrap.min.js"></script>
_INIT;
require_once 'functions.php'; 

echo <<<_MAIN
<title>$userstr</title>
</head>
<body>

_MAIN;
    
if($loggedIn) {
echo <<<_LOGGEDIN
    <div class='menu'> 
<h2 style = 'color:#f8f8ff;margin-left:20px'>KONNECK</h2> 
        <ul>
<li><a data-transition="slide" href='index.php?view=$user_token'>
<img src = 'images/header_ico/home_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Home</a></li> 

<li><a href = '#openModal' data-transition="slidedown" data-toggle = 'modal'><img src = 'images/header_ico/login.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Profile</a></li>  

<li><a data-transition="slide" href='members.php'><img src = 'images/header_ico/konnecktions.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Konnektions</a></li> 

<li><a data-transition="slide" href='notifications.php'><img src = 'images/header_ico/notification_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Notifications</a></li>    

<li><a data-transition="slide" href='messaging.php'><img src = 'images/header_ico/communicate_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>kommunicate</a></li> 
            
<li><a data-transition="slide" href='logout.php'><img src = 'images/header_ico/logout_outline.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Logout</a></li> 

        </ul><div class = 'searchContainer'><form action='' method='post' class='search'>
<input type='text' placeholder = 'Search '  name='search_entered' value='' color:f8f8ff!important;' />
<button type='submit' name='submit' value='Search' style = 'box-shadow:none!important; padding:none!important;color:f8f8ff!important'> <i class='fa fa-search'></i></button>
</form></div>
    </div>
                
_LOGGEDIN;
}

else
{
echo <<<_GUEST
<div class='menu'>
<h2 style = 'color:#f8f8ff;margin-left:20px'>KONNECK</h2> 
    <ul>      
<li><a data-transition="slide" href='signup.php'><img src = 'images/header_ico/register.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Sign Up</a></li> 

       
<li><a data-transition="slide" href='login.php'><img src = 'images/header_ico/login.PNG' style = 'width:30px;height:30px;border-radius: 0!important;
box-shadow: none!important;-moz-box-shadow: none!important;-webkit-box-shadow:none!important;'><br/>Log In</a></li> 
    </ul>
</div>
_GUEST;
}
$userName = '';
$show = '';
if(!empty($_SESSION['user_token']) && $_SESSION['user_token']) {
	$userName =  $_SESSION['user'];		
} else {
	$show = 'hidden';
}
?>

<?php
session_start();
include('rating.php');

$rating = new rating();
if(!empty($_POST['action']) && $_POST['action'] == 'userLogin') {
	$user_token = $_POST['user_token'];
	$password = $_POST['pass'];
	$loginDetails = $rating->user_login($user_token, $password);	
	$loginStatus = 0;
	$userName = "";
	if (!empty($loginDetails)) {
		$loginStatus = 1;
		$_SESSION['user_token'] = $loginDetails[0]['user_token'];
		$_SESSION['user'] = $loginDetails[0]['user'];		
		//$_SESSION['avatar'] = $loginDetails[0]['avatar'];
		$userName = $loginDetails[0]['user'];
	}		
	$data = array(
		"username" => $userName,
		"success"	=> $loginStatus,	
	);
	echo json_encode($data);	
}
if(!empty($_POST['action']) && $_POST['action'] == 'save_rating' 
	&& !empty($_SESSION['user_token']) 
	&& !empty($_POST['rating']) 
	//&& !empty($_POST['user_token'])
	) {
		$user_token = $_SESSION['user_token'];	
		$rating->save_rating($_POST, $user_token);	
		$data = array(
			"success"	=> 1,	
		);
		echo json_encode($data);		
}
if(!empty($_GET['action']) && $_GET['action'] == 'logout') {
	session_unset();
	session_destroy();
	header("Location:index.php");
}
?>
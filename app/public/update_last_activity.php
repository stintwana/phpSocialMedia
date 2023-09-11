<?php
session_start();
include("functions.php");

$query = "UPDATE online_status SET last_activity = NOW() WHERE online_status_id = '".$_SESSION['online_status_id']."'";

$statement = $connection->prepare($query);
$statement->execute();
?>
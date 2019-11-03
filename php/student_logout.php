<?php
/*Initialize the session*/
session_start();
/*Unset all of the session*/
$_SESSION = array();
/*Destroy the session*/
session_destroy();
/*Redirect to login page*/
header("location: student_login.php");
exit;
?>
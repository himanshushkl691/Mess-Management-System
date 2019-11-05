<?php
/*Initialize the session*/
session_start();

/*Unset all of the session*/
$_SESSION = array();

/*Destroy the session*/
session_destroy();

/*Redirect to login page*/
header("location: ../welcome_front_end/main_welcome.html");
exit;
?>

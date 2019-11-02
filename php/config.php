<?php

/*Database credentials for MySQL server user = 'root'*/
define('DB_SERVER','localhost:3306');
define('DB_USERNAME','root');
define('DB_PASSWORD','qwerty123');
define('DB_NAME','MESS_MANAGEMENT');

/*Attempt to connect to MySQL database*/
$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

/*Check connection*/
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

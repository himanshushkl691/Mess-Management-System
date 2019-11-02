<?php
require_once "config.php";

$sql = "select roll_no from STUDENTS where mess_name=?"
$mess_name = $_SESSION["mess_name"];
echo $mess_name;
mysqli_stmt_bind_param($sql,"s",$mess_name);
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
   echo '<option value="'.$row['something'].'">'.$row['something'].'</option>';
}

?>
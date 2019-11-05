<html>
	<head>
		<title> suggestions </title>
	</head>
	 <style>
		table {
  				font-family: arial, sans-serif;
  				border-collapse: collapse;
  				width: 100%;
				}

		td, th {
 				 border: 1px solid black;
  				 text-align: left;
  				 padding: 8px;
				}

		tr:nth-child(even) {
  				background-color: #dddddd;
				}
		thead{
			font-weight:bold;
		}
	</style>
	<body>
        <table>
        <thead>
            <tr>
            	<td>Roll no</td>
                <td>mess</td>
                <td>suggestion</td>
            </tr>
        </thead>
        <tbody>
<?php
session_start();
require_once "config.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$sql = "SELECT * FROM FEEDBACK WHERE mess_name=?";
	$stmt = mysqli_prepare($link,$sql);
	mysqli_stmt_bind_param($stmt,"s",$param_mess_name);
	$param_mess_name = $_SESSION["mess_name"];
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$roll_no,$sugg,$mess_name,$T);
    while(mysqli_stmt_fetch($stmt)) {
    	?>
       	<tr>
                			<td><?php echo $roll_no?></td>
                    		<td><?php echo $mess_name?></td>
                    		<td><?php echo $sugg?></td>
                		</tr>
    	<?php
	}
	mysqli_stmt_close($stmt);
}
	?>
</tbody>
</table>
</body>
</html>

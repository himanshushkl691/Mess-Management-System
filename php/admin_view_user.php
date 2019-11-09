<html>
    <head>
        <title>User</title>
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
            	<td>Roll_no</td>
                <td>Name</td>
                <td>Hostel</td>
            </tr>
        </thead>
        <tbody>
        <?php
        	session_start();
			require_once "config.php";
			//echo $_SESSION["roll_no"];
			$roll_no = $name = $hostel = $messname = "";
			$sql = "SELECT roll_no,name,hostel FROM STUDENT WHERE mess_name = ?";
			if($stmt = mysqli_prepare($link,$sql))
			{
				mysqli_stmt_bind_param($stmt,"s",$messname);
				$messname = $_SESSION["mess_name"];
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt,$roll_no,$name,$hostel);
				while(mysqli_stmt_fetch($stmt))
				{
					?>
                		<tr>
                			<td><?php echo $roll_no?></td>
                    		<td><?php echo $name?></td>
                    		<td><?php echo $hostel?></td>
                		</tr>
            		<?php
				}
			}
				mysqli_stmt_close($stmt);
            ?>
	    </tbody>
            </table>
            <br/>
            <input type="button" class="btn btn-danger" onclick="window.location='student_logout.php'" class="Redirect" value="Logout"/>
    </body>
</html>

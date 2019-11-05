<?php
session_start();
require_once("config.php");
$ID = $ID_err = "";
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
$temp = trim($_POST["ID"]);
if(!empty($temp)){
    $sql = "SELECT id FROM EXTRAS WHERE id=? and mess_name=?";
    if(!is_numeric($temp)){
      $ID_err = "must be a number";
    }
    else{
      if($stmt=mysqli_prepare($link,$sql)){
        mysqli_stmt_bind_param($stmt,"ds",$param_temp,$mess_name);
        $param_temp = $temp;
        $mess_name = $_SESSION["mess_name"];
        if(mysqli_stmt_execute($stmt)){
        /*store result*/
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 0){
          $ID_err = "serial number does not exist.";
        }
        else{
          $ID = $temp;
          $sql = "DELETE FROM EXTRAS WHERE id=? and mess_name=?";
        if($stmt = mysqli_prepare($link,$sql)){
        mysqli_stmt_bind_param($stmt,"ds",$param_id,$param_mess_name);
        $param_id = $ID;
        $param_mess_name = $_SESSION["mess_name"];
        mysqli_stmt_execute($stmt);
        if(empty($ID_err)){
          echo "Entry number: ".$ID."\nEntry Deleted";
        }
        else{
          echo "Some problem occured";
        }
      }

        }
      }
    }
  }
      }
}
?>
<html>
	<head>
     <meta charset="UTF-8">
    <title>EXTRAS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
	<body style="font: 14px sans-serif;">
		<div class="wrapper">
		<h2>Delete Entry</h2>
        <p>select an entry number from below table to delete entry.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($ID_err)) ? 'has-error' : ''; ?>" style="width: 350px; padding: 20px;">
                <label style=>entry number</label>
                <input type="integer" name="ID" class="form-control" value="<?php echo $ID; ?>">
                <span class="help-block"><?php echo $ID_err; ?></span>
             	<input type="submit" class="btn btn-primary" value="Delete">
             	</div> 
        <table>
        <thead>
            <tr>
            	<td>Entry number</td>
            	<td>Roll no</td>
                <td>mess</td>
                <td>total</td>
            </tr>
        </thead>
        <tbody>
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	$sql = "SELECT * FROM EXTRAS WHERE mess_name=?";
	$stmt = mysqli_prepare($link,$sql);
	mysqli_stmt_bind_param($stmt,"s",$param_mess_name);
	$param_mess_name = $_SESSION["mess_name"];
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt,$id,$roll_no,$mess_name,$item_name,$item_price,$item_qty,$total,$T);
    while(mysqli_stmt_fetch($stmt)) {
    	?>
       	<tr>
       						<td><?php echo $id?></td>
                			<td><?php echo $roll_no?></td>
                    		<td><?php echo $mess_name?></td>
                    		<td><?php echo $total?></td>
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

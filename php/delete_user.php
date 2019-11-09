<?php
session_start();
require_once("config.php");
$roll_no = $roll_no_err = "";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
		$temp = trim($_POST["roll_no"]);
		if(empty($temp)){
			$roll_no_err = "Roll no. can not be empty";
		}
		else{
			$sql = "SELECT roll_no from STUDENT where roll_no=? and mess_name=?";
			if($stmt = mysqli_prepare($link,$sql)){
			/*Bind the variables to prepared statement*/
			mysqli_stmt_bind_param($stmt,"ss",$param_roll_no,$param_mess_name);
			$param_roll_no = $temp;
			$param_mess_name = $_SESSION["mess_name"];

			/*Attempt to execute prepared statement*/
			if(mysqli_stmt_execute($stmt)){
				/*Store result*/
				mysqli_stmt_store_result($stmt);
				/*Check if mess_name exist, if yes then verify password*/
				if(mysqli_stmt_num_rows($stmt) == 0){
					$roll_no_err = "Roll no. does not exist in this mess";
				}
				else{
					$roll_no = $temp;
				}
			}
			}
		}
		if(empty($roll_no_err)){
			$sql = "DELETE from STUDENT where roll_no=?";
			if($stmt = mysqli_prepare($link,$sql))
			{
				mysqli_stmt_bind_param($stmt,"s",$param1_roll_no);
				$param1_roll_no = $roll_no;
				if(mysqli_stmt_execute($stmt)){
					echo "Successful deletion";
				}
				else{
					echo "something went wrong";
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>DELETE USER</h2>
        <p>enter a roll no. to delete a user</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($roll_no_err)) ? 'has-error' : ''; ?>">
                <label>Roll number</label>
                <input type="text" name="roll_no" class="form-control" value="<?php echo $roll_no; ?>">
                <span class="help-block"><?php echo $roll_no_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Delete">
            </div>
        </form>
    </div>
</body>
</html>

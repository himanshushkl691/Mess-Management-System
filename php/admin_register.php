<?php
//include config file
require_once "config.php";

//define variables and initialize with empty values
$mess_name = $base = $password = $confirm_password = "";
$mess_name_err = $base_err = $password_err = $confirm_password_err = "";

//processing form data when form is submitted
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
	/*Validate mess_name*/
	$temp = trim($_POST["mess_name"]);
	if(empty($temp)){
		$mess_name_err = "Please enter a mess.";
	}else if(strcmp("A",$temp) != 0 && strcmp("B",$temp) != 0 && strcmp("C",$temp) != 0 && strcmp("D",$temp) != 0 && strcmp("E",$temp) != 0 && strcmp("F",$temp) != 0 && strcmp("G",$temp) != 0 && strcmp("IH",$temp) != 0 && strcmp("LH",$temp) != 0 && strcmp("MLH",$temp) != 0 && strcmp("MBH",$temp) != 0 && strcmp("PG1",$temp) != 0 && strcmp("PG2",$temp) != 0 && strcmp("MBA",$temp) != 0){
		$mess_name_err = "Invalid mess name";
	}else{
		//prepare a select statement
		$sql = "SELECT * FROM MESS_ADMIN WHERE mess_name = ?";

		if($stmt = mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt,"s",$param_mess_name);
			//set parameters
			$param_mess_name = $temp;

			//attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				/*store result*/
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1){
					$mess_name_err = "Admin for this mess already there.";
				}else{
					$mess_name = $temp;
				}
			}else{
				$message = "Something went wrong.Please try again later.";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		/*Close statement*/
		mysqli_stmt_close($stmt);
	}

	/*Base price validation per day*/
	$temp = trim($_POST["base"]);
	if(empty($temp)){
		$base_err = "Please enter base price for your mess.";
	}else if(is_numeric($temp)){
		$base = $temp;
	}else{
		$base_err = "Please enter a valid base price.";
	}

	/*Validate password*/
	if(empty(trim($_POST["password"]))){
		$password_err = "Please enter a password.";
	}else if(strlen(trim($_POST["password"])) < 6){
		$password_err = "Password must have atleast 6 characters.";
	}else{
		$password = trim($_POST["password"]);
	}

	/*Validate confirm password*/
	if(empty(trim($_POST["confirm_password"]))){
		$confirm_password_err = "Please confirm password.";
	}else{
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_err) && ($password != $confirm_password)){
			$confirm_password_err = "Password did not match.";
		}
	}

	/*Check input errors before inserting in databse*/
	if(empty($mess_name_err) && empty($password_err) && empty($confirm_password_err)){
		/*Prepare an insert statement*/
		$sql = "INSERT INTO MESS_ADMIN (mess_name,pass,base) VALUES (?, ?, ?)";
		if($stmt = mysqli_prepare($link,$sql)){
			/*Bind variables to the prepared statement as a parameter*/
			mysqli_stmt_bind_param($stmt,"ssd",$param_mess_name,$param_pass,$param_base);
			$param_mess_name = $mess_name;
			$param_pass = $password;
			$param_base = $base;
			/*Attempt to execute the prepared statement*/
			if(mysqli_stmt_execute($stmt)){
				/*Redirect to login page*/
				header("location: ../welcome_front_end/main_welcome.html");
			}else{
				$message = "Something went wrong.";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		/*Close statement*/
		mysqli_stmt_close($stmt);
	}
	/*Close connection*/
	mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($mess_name_err)) ? 'has-error' : ''; ?>">
                <label>Mess Name</label>
                <input type="text" name="mess_name" class="form-control" value="<?php echo $mess_name; ?>">
                <span class="help-block"><?php echo $mess_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($base_err)) ? 'has-error' : ''; ?>">
                <label>Base Price/Day</label>
                <input type="number" step=0.01 name="base" class="form-control" value="<?php echo $base; ?>">
                <span class="help-block"><?php echo $base_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="admin_login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>

<?php
/*Initialize the section*/
session_start();

/*Check if the user is already logged in, if yes then redirect him to welcome page*/
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: student_welcome.php");
	exit;
}

/*Include config file*/
require_once "config.php";

/*Define variables and initialize with empty value*/
$roll_no = $password = "";
$roll_no_err = $password_err = "";

/*Processing form when form is submitted*/
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){

	/*Check if roll number is empty*/
	$temp = trim($_POST["roll_no"]);
	if(empty($temp)){
		$roll_no_err = "Please enter your roll number.";
	}else{
		$roll_no = $temp;
	}

	/*Check if password is empty*/
	$temp = trim($_POST["password"]);
	if(empty($temp)){
		$password_err = "Please enter a password.";
	}else{
		$password = $temp;
	}

	/*Validate credentials from database*/
	if(empty($roll_no_err) && empty($password_err)){
		/*Prepare a select statement*/
		$sql = "SELECT roll_no,pass FROM STUDENT WHERE roll_no = ?";
		if($stmt = mysqli_prepare($link,$sql)){
			/*Bind the variables to prepared statement*/
			mysqli_stmt_bind_param($stmt,"s",$param_roll_no);
			$param_roll_no = $roll_no;

			/*Attempt to execute prepared statement*/
			if(mysqli_stmt_execute($stmt)){
				/*Store result*/
				mysqli_stmt_store_result($stmt);
				/*Check if username exist, if yes then verify password*/
				if(mysqli_stmt_num_rows($stmt) == 1){
					/*Bind result variables*/
					mysqli_stmt_bind_result($stmt,$roll_no,$h_password);
					if(mysqli_stmt_fetch($stmt)){
						if(strcmp($password,$h_password)==0){
							/*password is correct start a new session*/
							session_start();
							/*Store data in session variables*/
							$_SESSION["loggedin"] = true;
							$_SESSION["roll_no"] = $roll_no;

							/*Redirect to welcome page*/
							header("location: student_welcome.php");
						}else{
							$password_err = "The password you entered was not valid.";
						}
					}
				}else{
					$roll_no_err = "Roll number does not exist.";
				}
			}else{
				echo "Something went wrong.Try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($roll_no_err)) ? 'has-error' : ''; ?>">
                <label>Roll Number</label>
                <input type="text" name="roll_no" class="form-control" value="<?php echo $roll_no; ?>">
                <span class="help-block"><?php echo $roll_no_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="student_register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>

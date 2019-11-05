<?php
/*Initialize the section*/
session_start();

/*Check if the user is already logged in, if yes then redirect him to welcome page*/
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: ../welcome_front_end/welcome_admin.html");
	exit;
}

/*Include config file*/
require_once "config.php";

/*Define variables and initialize with empty value*/
$mess_name = $password = "";
$mess_name_err = $password_err = "";

/*Processing form when form is submitted*/
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){

	/*Check if mess name is empty*/
	$temp = trim($_POST["mess_name"]);
	if(empty($temp)){
		$mess_name_err = "Please enter mess name.";
	}else{
		$mess_name = $temp;
	}

	/*Check if password is empty*/
	$temp = trim($_POST["password"]);
	if(empty($temp)){
		$password_err = "Please enter a password.";
	}else{
		$password = $temp;
	}

	/*Validate credentials from database*/
	if(empty($mess_name_err) && empty($password_err)){
		/*Prepare a select statement*/
		$sql = "SELECT mess_name,pass FROM MESS_ADMIN WHERE mess_name = ?";
		if($stmt = mysqli_prepare($link,$sql)){
			/*Bind the variables to prepared statement*/
			mysqli_stmt_bind_param($stmt,"s",$param_mess_name);
			$param_mess_name = $mess_name;

			/*Attempt to execute prepared statement*/
			if(mysqli_stmt_execute($stmt)){
				/*Store result*/
				mysqli_stmt_store_result($stmt);
				/*Check if mess_name exist, if yes then verify password*/
				if(mysqli_stmt_num_rows($stmt) == 1){
					/*Bind result variables*/
					mysqli_stmt_bind_result($stmt,$mess_name,$h_password);
					if(mysqli_stmt_fetch($stmt)){
						if(strcmp($password,$h_password)==0){
							/*password is correct start a new session*/
							session_start();
							/*Store data in session variables*/
							$_SESSION["loggedin"] = true;
							$_SESSION["mess_name"] = $mess_name;

							/*Redirect to welcome page*/
							header("location: ../welcome_front_end/welcome_admin.html");
						}else{
							$password_err = "The password you entered was not valid.";
						}
					}
				}else{
					$mess_name_err = "Mess name does not exist.";
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
            <div class="form-group <?php echo (!empty($mess_name_err)) ? 'has-error' : ''; ?>">
                <label>Mess Name</label>
                <input type="text" name="mess_name" class="form-control" value="<?php echo $mess_name; ?>">
                <span class="help-block"><?php echo $mess_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="admin_register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>

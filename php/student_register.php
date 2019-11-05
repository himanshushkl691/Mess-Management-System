<?php
//include config file
require_once "config.php";
//define variables and initialize with empty values
$roll_no = $password = $name = $hostel = $room_no = $mess_name = $confirm_password = "";
$roll_no_err = $name_err = $hostel_err = $room_no_err = $mess_name_err = $password_err = $confirm_password_err = "";
//processing form data when form is submitted
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
	/*Validate roll number*/
	if(empty(trim($_POST["roll_no"]))){
		$roll_no_err = "Please enter a roll number.";
	}else if(!preg_match('/(B|P|M|b|p|m)[0-9][0-9][0-9][0-9][0-9][0-9][a-zA-Z][a-zA-Z]/m',trim($_POST["roll_no"]))){
		$roll_no_err = "Invalid roll number";
	}else{
		//prepare a select statement
		$sql = "SELECT * FROM STUDENT WHERE roll_no = ?";
		if($stmt = mysqli_prepare($link,$sql)){
			mysqli_stmt_bind_param($stmt,"s",$param_roll_no);
			//set parameters
			$param_roll_no = trim($_POST["roll_no"]);
			//attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				/*store result*/
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1){
					$roll_no_err = "This roll number is already taken.";
				}else{
					$roll_no = trim($_POST["roll_no"]);
				}
			}else{
				echo "Something went wrong.Please try again later.";
			}
		}
		/*Close statement*/
		mysqli_stmt_close($stmt);
	}
	/*Validate mess name*/
	$temp = trim($_POST["mess_name"]);
	if(empty($temp)){
		$mess_name_err = "Please enter a mess name.";
	}else if(strcmp("A",$temp) == 0 || strcmp("B",$temp) == 0 || strcmp("C",$temp) == 0 || strcmp("D",$temp) == 0 || strcmp("E",$temp) == 0 || strcmp("F",$temp) == 0 || strcmp("G",$temp) == 0 || strcmp("IH",$temp) == 0 || strcmp("LH",$temp) == 0 || strcmp("MLH",$temp) == 0 || strcmp("MBH",$temp) == 0 || strcmp("PG1",$temp) == 0 || strcmp("PG2",$temp) == 0 || strcmp("MBA",$temp) == 0){
		$mess_name = $temp;
	}else{
		$mess_name_err = "Invalid mess name.";
	}
	/*Validate hostel name*/
	$temp = trim($_POST["hostel"]);
	if(empty($temp)){
		$hostel_err = "Hostel field cannot be empty";
	}else if(strcmp("A",$temp) == 0 || strcmp("B",$temp) == 0 || strcmp("C",$temp) == 0 || strcmp("D",$temp) == 0 || strcmp("E",$temp) == 0 || strcmp("F",$temp) == 0 || strcmp("G",$temp) == 0 || strcmp("IH",$temp) == 0 || strcmp("LH",$temp) == 0 || strcmp("MLH",$temp) == 0 || strcmp("MBH",$temp) == 0 || strcmp("PG1",$temp) == 0 || strcmp("PG2",$temp) == 0 || strcmp("MBA",$temp) == 0){
		$hostel = trim($_POST["hostel"]);
	}else{
		$hostel_err = "Hostel does not exist.";
	}
	/*Validate name*/
	if(empty(trim($_POST["name"]))){
		$name_err = "Please fill name.";
	}else{
		$name = trim($_POST["name"]);
	}
	/*Validate room number*/
	if(empty(trim($_POST["room_no"]))){
		$room_no_err = "Please fill your room number.";
	}else if(strlen(trim($_POST["room_no"])) > 3){
		$room_no_err = "Invalid room number.";
	}
	else{
		$room_no = trim($_POST["room_no"]);
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
	if(empty($mess_name_err) && empty($roll_no_err) && empty($password_err) && empty($confirm_password_err) && empty($hostel_err) && empty($name_err) && empty($room_no_err)){
		/*Prepare an insert statement*/
		$sql = "INSERT INTO STUDENT (roll_no,name,pass,hostel,room_no,mess_name) VALUES (?, ?, ?, ?, ?, ?)";
		if($stmt = mysqli_prepare($link,$sql)){
			/*Bind variables to the prepared statement as a parameter*/
			mysqli_stmt_bind_param($stmt,"ssssss",$param_roll_no,$param_name,$param_pass,$param_hostel,$param_room_no,$param_mess_name);
			$param_roll_no = $roll_no;
			$param_name = $name;
			$param_pass = $password;
			$param_hostel = $hostel;
			$param_room_no = $room_no;
			$param_mess_name = $mess_name;
			/*Attempt to execute the prepared statement*/
			if(mysqli_stmt_execute($stmt)){
				/*Redirect to login page*/
				header("location: ../welcome_front_end/main_welcome.html");
			}else{
				$sql = "SELECT mess_name FROM MESS_ADMIN WHERE mess_name = ?";
				if($stmt = mysqli_prepare($link,$sql)){
					/*Bind variables to the prepared statement*/
					mysqli_stmt_bind_param($stmt,"s",$param_mess_name);
					$param_mess_name = $mess_name;
					/*Attempt to execute the prepared statement*/
					if(mysqli_stmt_execute($stmt)){
						mysqli_stmt_store_result($stmt);
						if(mysqli_stmt_num_rows($stmt) == 0){
							$mess_name_err = "Mess does not exist.";
						}
					}else{
						echo "Something went wrong.Try again later.";
					}
				}
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
            <div class="form-group <?php echo (!empty($roll_no_err)) ? 'has-error' : ''; ?>">
                <label>Roll Number</label>
                <input type="text" name="roll_no" class="form-control" value="<?php echo $roll_no; ?>">
                <span class="help-block"><?php echo $roll_no_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($hostel_err)) ? 'has-error' : ''; ?>">
                <label>Hostel</label>
                <input type="text" name="hostel" class="form-control" value="<?php echo $hostel; ?>">
                <span class="help-block"><?php echo $hostel_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($room_no_err)) ? 'has-error' : ''; ?>">
                <label>Room Number</label>
                <input type="text" name="room_no" class="form-control" value="<?php echo $room_no; ?>">
                <span class="help-block"><?php echo $room_no_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($mess_name_err)) ? 'has-error' : ''; ?>">
                <label>Mess Name</label>
                <input type="text" name="mess_name" class="form-control" value="<?php echo $mess_name; ?>">
                <span class="help-block"><?php echo $mess_name_err; ?></span>
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
            <p>Already have an account? <a href="student_login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>

<?php
  session_start();
  require_once "config.php";

  if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST")
  {
  	if(empty(trim($_POST["suggestion"])))
  	{
		$message = "Pls add a suggestion";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>setTimeout(\"location.href = 'student_welcome.php';\",15);</script>";
	}

  	else
  	{
  		$message = "Thank you for your suggestion!!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<script>setTimeout(\"location.href = 'student_welcome.php';\",15);</script>";
    	//echo "Thank you for your suggestion!!";

    	$rollNo = $rollNo_tmp = $Suggestion = $Suggestion_tmp = $mess_name = $insert_suggestion = $mess_name_tmp = "";

    	$Suggestion = $_POST["suggestion"]; 
    	$get_rollNo = "SELECT mess_name from STUDENT WHERE roll_no = ?";

    	if($stmt = mysqli_prepare($link,$get_rollNo))
    	{
    		mysqli_stmt_bind_param($stmt,"s",$rollNo);
    		$rollNo = $_SESSION["roll_no"];

    		mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$mess_name);

			while(mysqli_stmt_fetch($stmt))
			{
				break;
			}

			$insert_suggestion = "INSERT INTO FEEDBACK(`roll_no`,`suggestion`,`mess_name`) VALUES (?,?,?)";
    
    		$stmt = "";
    		if($stmt = mysqli_prepare($link,$insert_suggestion))
			{
				//echo "prepare success";

				mysqli_stmt_bind_param($stmt,"sss",$rollNo_tmp,$Suggestion_tmp,$mess_name_tmp);
				$rollNo_tmp = $rollNo;
				$Suggestion_tmp = $Suggestion;
				$mess_name_tmp = $mess_name;
				mysqli_stmt_execute($stmt);

				//echo "Added success"; 
			}

			else
			{
				$message = "insert prepare fail";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script>setTimeout(\"location.href = 'student_welcome.php';\",15);</script>";

				//echo "insert prepare fail";
				//echo ''.htmlspecialchars(mysqli_error($link));
			}
		}

		else
		{
			$message = "getmess prepare fail";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script>setTimeout(\"location.href = 'student_welcome.php';\",15);</script>";
			//echo "getmess prepare fail";
		}

	}	
  }

?>

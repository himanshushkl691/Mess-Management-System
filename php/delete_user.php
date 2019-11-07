<?php>

  session_start();
    require_once "config.php";

 if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST")
  {
     if(empty(trim($_POST["roll_no"])))
     {
	 echo "Pls enter a roll_no to delete";
     }
  
     else
    {
        $roll_no = $roll_no_err = "";

         $roll_no = $_POST["roll_no"];
       
         $get_roll_no = "DELETE roll_no from STUDENT WHERE roll_no = ?";
	  
        if($stmt = mysqli_prepare($link,$get_rollno))
	{
		mysqli_stmt_bind_param($stmt,"s",$param_roll_no);

	      $param_roll_no = $roll_no;

	    if(mysqli_stmt_execute($stmt)){
	     mysqli_stmt_store_result($stmt);

              if(mysqli_stmt_num_rows($stmt) ==1) {
	       mysqli_stmt_bind_result($stmt,$roll_no);

	       if(mysqli_stmt_fetch($stmt)) {

		   if(strcmp($roll_no,$get_roll_no) ==0) {
			    
		    session_start(); 	
	}
       
	
        

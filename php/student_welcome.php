<?php
session_start();
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header("location: student_welcome.php");
  exit;
}
?>

<!Doctype html>
<html>
<head>
<style>

  body{ font: 14px sans-serif; }
  .welcome{ width: 350px; padding: 10px; }

  .btn-group button {
    background-color: #4CAF50; /* Green background */
    border: 1px solid green; /* Green border */
    color: white; /* White text */
    padding: 10px 24px; /* Some padding */
    cursor: pointer; /* Pointer/hand icon */
    float: left; /* Float the buttons side by side */
  }

/*Clear floats (clearfix hack) */
  .btn-group:after {
    content: "";
    clear: both;
    display: table;
  }

  .btn-group button:not(:last-child) {
    border-right: none; /* Prevent double borders */
  }

/* Add a background color on hover */
  .btn-group button:hover {
    background-color: #3e8e41;
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body>
<div class = "welcome">
<br/>

<div class="btn-group" style="width:100%">
    <input type="button" class="btn btn-basic" onclick="window.location='student_extras.php'" class="Redirect" value="View extras"/>
</div>
<br/>
<br/>

<div>
  <form action="suggestion_add.php" method="post">
    Suggestions: <input type="text" name="suggestion"><br>
    <input type="submit" class="btn btn-primary">
  </form>
</div>
<br/>
<br/>
<input type="button" class="btn btn-danger" onclick="window.location='student_logout.php'" class="Redirect" value="Logout"/>
</div>
</body>
</html>


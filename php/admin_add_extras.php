<?php
session_start();
require_once "config.php";
$roll_no = $item_name = $item_price = $item_qty = "";
$roll_no_err = $item_name_err = $item_price_err = $item_qty_err = "";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
		/*Check if the user is already logged in, if yes then redirect him to welcome page*/
		$mess_name = $_SESSION["mess_name"];

		$temp = trim($_POST["roll_no"]);
		if(empty($temp)){
			$roll_no_err = "Please enter a roll no";
		}
		/*else if(!mysqli_stmt_execute($stmt)){
			$roll_no_err = "Roll no does not exist in this mess";
		}*/
		else{
			$roll_no = $temp;
		}

		$temp = trim($_POST["item_name"]);
		if(empty($temp)){
			$item_name_err = "Item name cannot be empty";
		}
		else{
			$item_name = $temp;
		}

		$temp = trim($_POST["item_price"]);
		if(empty($temp)){
			$item_price_err = "Please enter the price of the item";
		}
		else if(!is_numeric($temp)){
			$item_price_err = "item price must be a number";
		}
		else{
			$item_price = $temp;
		}

		$temp = (int)trim($_POST["item_qty"]);
		if(empty($temp)){
			$item_qty_err = "Please enter the quantity";
		}
		else if(!is_int($temp)){
			$item_qty_err = "item quantity must be an integer number";
		}
		else{
			$item_qty = $temp;
		}

		if(empty($roll_no_err) && empty($item_name_err) && empty($item_price_err) && empty($item_qty_err)){
			$sql = "INSERT INTO EXTRAS (roll_no,mess_name,item_name,item_price,item_qty,total) values (?,?,?,?,?,?)";
			if($stmt = mysqli_prepare($link,$sql)){
			/*Bind variables to the prepared statement as a parameter*/
				mysqli_stmt_bind_param($stmt,"sssdid",$param_roll_no,$param_mess_name,$param_item_name,$param_item_price,$param_item_qty,$param_total);
				$param_roll_no=$roll_no;
				$param_mess_name=$mess_name;
				$param_item_name=$item_name;
				$param_item_price=$item_price;
				$param_item_qty=$item_qty;
				$param_total = $item_price*$item_qty;
				if(mysqli_stmt_execute($stmt)){
				/*Redirect to login page*/
					$message = "Extras added successfully";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<script>setTimeout(\"location.href = '../welcome_front_end/welcome_admin.html';\",15);</script>";

					//echo "Success";
				}else{
				$message = "Some error occured";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<script>setTimeout(\"location.href = '../welcome_front_end/welcome_admin.html';\",15);</script>";
				//echo "Some error occured";
			}
			}
		}
		/*mysqli_stmt_close($stmt);*/
		/*Close connection*/
		mysqli_close($link);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Extras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Add Extras</h2>
        <p>Please fill this form to add extras.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($roll_no_err)) ? 'has-error' : ''; ?>">
                <label>Roll no</label>
                <input type="text" name="roll_no" class="form-control" value="<?php echo $roll_no; ?>">
                <span class="help-block"><?php echo $roll_no_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($item_name_err)) ? 'has-error' : ''; ?>">
                <label>Item name</label>
                <input type="text" name="item_name" class="form-control" value="<?php echo $item_name; ?>">
                <span class="help-block"><?php echo $item_name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($item_price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="number" step="0.01" name="item_price" class="form-control" value="<?php echo $item_price; ?>">
                <span class="help-block"><?php echo $item_price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($item_qty_err)) ? 'has-error' : ''; ?>">
                <label>quantity</label>
                <input type="integer" name="item_qty" class="form-control" value="<?php echo $item_qty; ?>">
                <span class="help-block"><?php echo $item_qty_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
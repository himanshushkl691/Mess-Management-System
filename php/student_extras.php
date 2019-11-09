<html>
    <head>
        <title>Extras</title>
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
    <body>
        <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Item name</td>
                <td>Item quantity</td>
                <td>Item price</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
        <?php

            session_start();
            require_once "config.php";
            //echo $_SESSION["roll_no"];
            $itemName = $itemQuantity = $itemPrice = $total = "";
            $sumTotal = 0;
            $sql = "SELECT ID,item_name,item_qty,item_price,total FROM EXTRAS WHERE roll_no = ?";
            if($stmt = mysqli_prepare($link,$sql))
            {   
                mysqli_stmt_bind_param($stmt,"s",$rollNo);
                $rollNo = $_SESSION["roll_no"];

                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$id,$itemName,$itemQuantity,$itemPrice,$total);
                
                while(mysqli_stmt_fetch($stmt))
                {
                    //printf("%s %s %s %s \n",$itemName,$itemQuantity,$itemPrice,$total);
                    $sumTotal = $sumTotal + $total;
                    ?>
                        <tr>
                            <td><?php echo $id?></td>
                            <td><?php echo $itemName?></td>
                            <td><?php echo $itemQuantity?></td>
                            <td><?php echo $itemPrice?></td>
                            <td><?php echo $total?></td>
                        </tr>
                    <?php
                }

                //echo $sumTotal;
                mysqli_stmt_close($stmt);
            }
            ?>
            </tbody>
            </table>
            <br/>
            <div>Total = <?php echo $sumTotal?>
            <br/>
            <br/>
            <input type="button" class="btn btn-danger" onclick="window.location='student_logout.php'" class="Redirect" value="Logout"/>
    </body>
</html>

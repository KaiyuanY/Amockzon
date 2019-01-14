<?php

session_start();
if (!$_SESSION['loggedin']) {
  header("Location: login.php");
}
require_once ("db_connect.php");

$user_id = $_SESSION['user_id'];

//get all cart items
$sql_getcart = "SELECT * FROM Carts WHERE user_id = $user_id";
$result_cart = $db->query($sql_getcart);
$can_check_out = false;
if (!$result_cart || $result_cart->num_rows == 0) {
	$can_check_out = false;
}else{
	$can_check_out = true;
}
if($can_check_out){
	//adding items to orders table
	while($row = $result_cart->fetch_array()){
		$cart_id = $row['cart_id'];
        $amount = $row['amount'];
        $product_id = $row['product_id'];
        //$current_time = time();
        $sql_order = "INSERT INTO Orders (user_id, product_id, amount)
        				VALUES ($user_id, $product_id, $amount)";
       	$result_order = $db->query($sql_order);
        //echo $sql_order."<br>";
	}
	//deleting current cart
	$sql_delete = "DELETE FROM Carts WHERE user_id = $user_id";
	$result_delete = $db->query($sql_delete);
	//echo $sql_delete;
}

?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="bootstrap-3.3.7/favicon.ico">

    <title>Amockzon - Check Out</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap-3.3.7/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
    	body {
  			padding-top: 70px;
  			padding-bottom: 30px;
		}
    </style>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap-3.3.7/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
    	<?php
    	if($can_check_out){
    		echo "<div class='alert alert-success' role='alert'>
        			<strong>Congrats!</strong> You have successfully made the purchases! 
        			Go to <a href='orders.php'> Orders Page</a> or <a href='index.php'> Home Page</a>.
      			</div>";
      	}
      	else{
      		echo "<div class='alert alert-danger' role='alert'>
        			<strong>Oh snap!</strong> Your cart is empty.
        			Go back to <a href='index.php'>Home page</a>.
      			</div>";
      	}
      	?>
    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bootstrap-3.3.7/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.7/assets/js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>

<?php
session_start();

$product_id = $_REQUEST['product_id'];
$user_id = $_SESSION['user_id'];
$success = false;
if(!$user_id || !$product_id){
	$success = false;
}
else{
	$success = true;
}
//echo $product_id."<br>".$user_id."<br>".$success;

require_once ("db_connect.php");
//check if the product was added to cart before
$sql_check_amount = "SELECT * FROM Carts 
						WHERE user_id = $user_id
						AND product_id = $product_id";
$result_check_amount = $db->query($sql_check_amount);
if ($result_check_amount->num_rows != 0) {
	//means already added before
	//simply add 1 to the amount
	$row = $result_check_amount->fetch_array();
	$amount = $row['amount'];
	$amount = $amount + 1;
	$sql = "UPDATE Carts
			SET amount = $amount
			WHERE user_id = $user_id
			AND product_id = $product_id";
	$result = $db->query($sql);
	if(!$result){
		$success = false;
	}
}
else{
	//means that this product hasnt been added before
	//add it to cart
	$sql = "INSERT INTO Carts (user_id, product_id, amount)
			VALUES ('".$user_id."', '".$product_id."', 1)";
	$result = $db->query($sql);
	if (!$result) {
		$success = false;
	}
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

    <title>Amockzon</title>

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
    	if($success){
    		echo "<div class='alert alert-success' role='alert'>
        			<strong>Success!</strong> You have one item to your cart. 
        			You can <a href='viewCart.php'>check out</a> or <a href='index.php'>continue shopping</a>.
      			</div>";
      	}
      	else{
      		echo "<div class='alert alert-danger' role='alert'>
        			<strong>Error occured!</strong> Your request can not be completed at this time. click <a href='index.php'>here</a> to go back to home page.
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

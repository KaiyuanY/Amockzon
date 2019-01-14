<?php


session_start();

if(empty($_POST["email"])){
    header("Location: signup.php");
}
if(empty($_POST["password"])||$_POST["password"]!=$_POST["confirmPassword"]){
    header("Location: signup.php");
}
if(empty($_POST["name"])){
    header("Location: signup.php");
}

require_once ("db_connect.php");

$email = $db->escape_string($_POST["email"]);
$password = $db->escape_string($_POST["password"]);
$fullname = $db->escape_string($_POST["name"]);

$sql = "INSERT INTO Users (email,name,password,master_user) 
		VALUES ('$email','$fullname', '" . md5($password) . "', 'false');";
//echo $sql;
$success = false;
$result = $db->query($sql);
if(!$result){
    //exit($db->error);
    $success = false;
}
else{
	$success = true;
    //echo "You have successfully created your account: $email";
    $_SESSION["loggedin"] = true;
}

?>

<!-- <h1>Go to your <a href="profile.php"> profile </a> page</h1> -->
 
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="bootstrap-3.3.7/favicon.ico">

    <title>Sign Up</title>

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
        			<strong>Well done!</strong> You have successfully signed up on Amockzon! 
        			Go to <a href='index.php'> Home Page</a>.
      			</div>";
      	}
      	else{
      		echo "<div class='alert alert-danger' role='alert'>
        			<strong>Oh snap!</strong> Email Address already exitsts. Sign up failed.
        			Go back to <a href='signup.php'>sign up page</a>.
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

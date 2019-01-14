<?php

if(empty($_GET["code"])){
    header("Location: login.php");
}

require_once "db_connect.php";

$requestCode = $db->escape_string($_GET["code"]);

$sql = "SELECT * FROM Password_recover WHERE reset_code = '$requestCode'";

$result = $db->query($sql);
if(!$result){
    exit($db->error);
}

$resetInfo = $result->fetch_array();
$can_reset = false;
if($resetInfo["code_used"] || $result->num_rows<1){
    $can_reset = false;
    //echo "The link you are using has expired or doesn't exisit, go to <a href='login.php'>Login</a> Page";
}
else{
    $can_reset = true;
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

    <title>Sign Up</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap-3.3.7/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signup.css" rel="stylesheet">

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
            if(!$can_reset){
                echo "<div class='alert alert-danger' role='alert'>The link you are using has expired or doesn't exisit, go to <a href='login.php'>Login</a> Page</div>";
            }
            else{
                echo"
                <form class='form-signin' method='post' action='resetpasswordconfirm.php'>
                    <h2 class='form-signin-heading'>Enter Your new Password</h2>
        
                    <label for='inputPassword' class='sr-only'>Password</label>
                    <input type='password' style='margin-bottom:0px;' name='password' class='form-control' placeholder='Password' required autofocus>
                    <label for='comfirmPassword' class='sr-only'>Confirm Password</label>
                    <input type='password' name='confirmPassword' class='form-control' placeholder='Confirm Password' required>
                    <input type='hidden' name='code' value='$requestCode' />
                    <button class='btn btn-lg btn-primary btn-block' type='submit'>Reset</button>
                </form>";
            }
      ?>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.7/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

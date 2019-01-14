<?php

if(empty($_POST["code"])||empty($_POST["password"])||empty($_POST["confirmPassword"])){
    header("Location: login.php");
}

if($_POST["password"] != $_POST["confirmPassword"]){
    exit( "Password doesn't match, please try again");
}

require_once "db_connect.php";


$requestCode = $db->escape_string($_POST["code"]);
$resetPassword = $db->escape_string($_POST["password"]);


$sql = "SELECT * FROM Password_recover WHERE reset_code = '$requestCode'";

$result = $db->query($sql);
if(!$result){
    exit($db->error);
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

            if($resetInfo["code_used"] || $result->num_rows<1){
                echo "<div class='alert alert-danger' role='alert'>The link you are using has expired or doesn't exisit, go to <a href='login.php'>Login</a> Page</div>";
            }
            else{
                $resetInfo = $result->fetch_array();
                $resetSql = "UPDATE Users SET password = md5($resetPassword) WHERE user_id = " . $resetInfo["user_id"];
                $updateCode = "UPDATE Password_recover SET code_used = TRUE WHERE reset_code = $requestCode";
                $resetResult = $db->query($resetSql);
                if(!$resetResult){
                    exit($db->error);
                }
                $updateCodeResult = $db->query($updateCode);
                echo "<div class='alert alert-success' role='alert'>You have successfully updated your password, go to <a href='login.php'>Login</a> Page</div>";
            }
            
        ?>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.7/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

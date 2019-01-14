<?php


if(empty($_POST["email"])){
    header("Location: login.php");
}

require_once ("db_connect.php");

$email = $db->escape_string($_POST["email"]);

$sql = "SELECT * FROM Users WHERE email = '$email'";

$result = $db->query($sql);
if(!$result){
    exit($db->error);
}
else if ($result->num_rows==1){
    $userInfo = $result->fetch_array();
    $genHash = md5(rand());
    $sql = "INSERT INTO Password_recover (user_id,  reset_code) VALUES (" . $userInfo['user_id'] . ",'$genHash');";
    $codeResult = $db->query($sql);
    if(!$codeResult){
        exit($db->error);
    }
    $resetLink = "http://kaiyuany.student.uscitp.com/itp300/final_project/resetpassword.php?code=$genHash";
    //echo ($userInfo["email"] . "ITP Password reset e-mail" . "Please visit the link to reset your password: <a href='$resetLink'>$resetLink</a>");
    mail($userInfo["email"], "Amockzon Passworld reset e-mail", "Please visit the link to reset your password: <a href='$resetLink'>$resetLink</a>");
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
        <div class='alert alert-success' role='alert'>
            Thanks for submitting your request, if a matched user is found, you should receive a password reset link within 5 mins.
        </div>"
        
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

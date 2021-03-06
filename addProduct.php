<?php
session_start();

//check if it is a master user
$user_id = $_SESSION["user_id"];
$master_user = $_SESSION["master_user"];

if(!$master_user){
	//you are not supposed to be here
	header("Location: index.php");
}
require_once ("db_connect.php");


$sql_category = "SELECT * FROM Categories";
$result_category = $db->query($sql_category);
if(!$result_category){
    exit("SQL Error: " . $mysqli->error);
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

    <title>Add Product</title>

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

      <form class="form-signin" method="post" action="upload.php" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Add Product</h2>
        <label for="inputName" class="sr-only">Product Name</label>
        <input type="name" name="name" class="form-control" placeholder="Product Name" required autofocus>
        <label for="inputDescription" class="sr-only">Description</label>
        <input type="text" name="description" class="form-control" placeholder="Description" required >
        <select name='category_id' style='height:40px; width:300px;'>
        	<?php
        		$sql_category = "SELECT * FROM Categories";
                $result_category = $db->query($sql_category);
                if(!$result_category){
                	exit("SQL Error: " . $mysqli->error);
                }
                while($row = $result_category->fetch_array()){
                  echo "<option value='".$row['category_id']."'>" . $row['category'] . "</option>";
                }
        	?>
        </select>
        <label for="price" class="sr-only">Password</label>
        <input type="number" step='any' min='0' style="margin-bottom:0px;" name="price" class="form-control" placeholder="Price" required>
        <label for="fileToUpload" class="sr-only">img</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.7/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

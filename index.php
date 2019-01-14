<?php
session_start();

if(!$_SESSION["loggedin"]){
    if(empty($_POST)) {
        header("Location: login.php");
    }else{
        require_once ("db_connect.php");
        $email = $db->escape_string($_POST["email"]);
        $password = $db->escape_string($_POST["password"]);
        //echo  "$email, $password";
        $sql = "SELECT * FROM Users WHERE `email` = '" . $email . "' AND `password` = '". md5($password) . "'";
        $result = $db->query($sql);
        if(!$result){
            exit("SQL Error: " . $mysqli->error);
        }
        if($result->num_rows == 1){
            $_SESSION["loggedin"] = true;
            $row = $result->fetch_array();
            //echo $row['email'] . $row['name'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["master_user"] = $row["master_user"];
            //$_SESSION["email"] = $row['email'];
            
        }else{
            header("Location: login.php");
        }
    }
}
require_once ("db_connect.php");
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

    <title>Amockzon - Home</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap-3.3.7/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="home.css" rel="stylesheet">

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

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">Amockzon</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Search by Category <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php
                  // echo "<li><a href=''>I am here</a></li>";
                  // echo "Before while loop";
                  $sql_category = "SELECT * FROM Categories";
                  $result_category = $db->query($sql_category);
                  if(!$result_category){
                    exit("SQL Error: " . $mysqli->error);
                  }
                  while($row = $result_category->fetch_array()){
                    echo "<li><a href='search.php?category_id=".$row['category_id']."'>" . $row['category'] . "</a></li>";
                  }
                  // echo "I am out of while loop";
                ?>
              </ul>
            </li> <!--end of dropdown -->
            <form class="navbar-form navbar-left" method="get" action="search.php">
              <div class="form-group">
                <input type="text" name="product_name" class="form-control" placeholder="Search for product" required>
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
            <li class="active"><a href="">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="viewCart.php">Cart</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php
              if($_SESSION["master_user"]){
                echo "<li><a href='addProduct.php'>Add Product</a></li>";
              }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Welcome back, <?php  echo $_SESSION["name"]; ?>!</h1>
        <!-- <p>Amockzon is a premium shopping website for your fantastic shopping experience. We have the best quality of products and a world fastest delivery system. Join us today! To view documentation for this project, press "Learn more".</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
      </div>
    </div>
    <div class='container'>
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="product_img/overview1.jpg" style="height:500px; width:1140px;" alt="First slide">
          </div>
          <div class="item">
            <img src="product_img/overview2.jpg" style="height:500px; width:1140px;" alt="Second slide">
          </div>
          <div class="item">
            <img src="product_img/overview3.jpg" style="height:500px; width:1140px;" alt="Third slide">
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <div class="container">
      
      <!-- <div class="row">
        <div class="col-md-4">
          <h2>Founder's notes</h2>
          <p>Hi, welcome to Amockzon! Enjoy your shopping. We guarantee to provide you the best experience ever!</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        
      </div> -->

      <hr>

      <footer>
        <p>&copy; 2016 Amockzon</p>
      </footer>
    </div> 


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

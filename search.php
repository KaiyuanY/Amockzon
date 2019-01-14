<?php
session_start();
require_once ("db_connect.php");

$search_category_id = $db->escape_string($_REQUEST['category_id']);
$search_product_name = $db->escape_string($_REQUEST['product_name']);
if(!$search_category_id && !$search_product_name){
    //no parameter passed in
    header("Location: index.php");
}
// if($search_product_name){echo $search_category_id;}

// echo $search_product_name;
//if sesarch by name
if(!empty($search_product_name)){
    $sql = "SELECT * FROM Products WHERE product_name LIKE '%".$search_product_name."%'";
}
else{//search by category
    $sql = "SELECT * FROM Products WHERE category_id = $search_category_id";
}
//echo $sql;
$result = $db->query($sql);
$search_result = false;
if($result->num_rows == 0){
    $search_result = false;
}
else{
    $search_result = true;
}

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

    <title>Amockzon - Search Products</title>

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
          <a class="navbar-brand" href="index.php">Amockzon</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Search by Category <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php
                  // echo "<li><a href=''>I am here</a></li>";
                  // echo "Before while loop";
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
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="viewCart.php">Cart</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <?php
            if(!$search_result){
                echo "<div class='alert alert-danger' role='alert'>";
            }
            else{
                echo "<div class='alert alert-success' role='alert'>";
            }
            if(!empty($search_product_name)){
                echo "<p>Product name searched: ".$search_product_name.".</p>";
            }
            else{
                $temp = $db->query("SELECT * FROM Categories WHERE category_id=$search_category_id");
                $category_row = $temp->fetch_array();
                echo "<p>Category searched: ".$category_row['category'].".</p>";
            }
            if(!$search_result){
                echo "<p>No search result found! Please try other search terms of categories.</p></div>";
            }
            else{
                echo "<p>Found ".$result->num_rows." matching results.</p></div>";
            }
        ?>
      </div>
    </div>

    <div class="container">
      <?php
        while($row = $result->fetch_array()){
            echo "<div class='col-md-4'>
                    <h3>".$row['product_name']."</h3>
                    <img src='".$row['img_url']."' class='img-thumbnail' style='height:200px; width:200px;'>
                    <p><strong>Description: </strong>".$row['details']."</p>
                    <p><strong>Price: </strong>$".$row['price']."</p>
                    <p><strong>Sold: </strong>".$row['trade_volume']."</p>
                    <p><a class='btn btn-default' href='addToCart.php?product_id=".$row['product_id']."' role='button'>Add to Cart &raquo;</a></p>
                </div>";
        }


      ?>
      <!-- <div class="row"> -->
        <!-- <div class="col-md-4">
          <h3>Founder's notes</h3>
          <p>Hi, welcome to Amockzon! Enjoy your shopping. We guarantee to provide you the best experience ever!</p>
          <p><a class="btn btn-default" href="#" role="button">Add to Cart &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h3>Founder's notes</h3>
          <p>Hi, welcome to Amockzon! Enjoy your shopping. We guarantee to provide you the best experience ever!</p>
          <p><a class="btn btn-default" href="#" role="button">Add to Cart &raquo;</a></p>
        </div> -->
        
      <!-- </div> -->

      <!-- <hr>

      <footer>
        <p>&copy; 2016 Amockzon</p>
      </footer> -->
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
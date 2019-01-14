<?php
session_start();
//if not logged in, can not view cart, go log in first
if (!$_SESSION['loggedin']) {
  header("Location: login.php");
}
require_once ("db_connect.php");

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Carts WHERE user_id = $user_id";
$result = $db->query($sql);
$num_cart = $result->num_rows;
$empty_cart = true;
if ($num_cart != 0) {
  $empty_cart = false;
}

//getting product details
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

    <title>Amockzon - Cart</title>

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
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="viewCart.php">Cart</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- message for how many product you have in your cart -->
    <div class="jumbotron">
      <div class="container">
        <?php
            if($empty_cart){
                echo "<div class='alert alert-danger' role='alert'><p>Your cart is empty.</p></div>";
            }
            else{
                echo "<div class='alert alert-success' role='alert'><p>Great! You have ".$num_cart." products in your cart.</p></div>";
            }
        ?>
      </div>
    </div>

    <div class="container">
      <div class="col-md-6">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th> Product Name </th>
                <th> Amount </th>
                <th> Price </th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <?php
                $total_price = 0.00;
                if($empty_cart){
                  //do nothing
                }
                $count = 1;
                
                while($row = $result->fetch_array()){
                  $cart_id = $row['cart_id'];
                  $amount = $row['amount'];
                  $product_id = $row['product_id'];
                  $sql_product = "SELECT * FROM Products
                                  WHERE Products.product_id=$product_id";
                  $result_product = $db->query($sql_product);
                  if (!$result_product) {
                    exit();
                  }
                  $product = $result_product->fetch_array();
                  $product_name = $product['product_name'];
                  $price = $amount * $product['price'];
                  $total_price += $price;
                  echo "<tr>
                          <td>$count</td>
                          <td> $product_name </td>
                          <td> $amount </td>
                          <td> $$price </td>
                          <td><a href='removeItem.php?cart_id=".$cart_id."'> Remove </a></td>
                        </tr>";
                  $count++;
                }//end of wile loop

              ?>
            </tbody>
          </table>
          <?php
            echo "<p><strong>Total Price</strong>: $$total_price <a class='btn btn-primary' 
                  href='checkout.php' role='button'>Check Out &raquo;</a>";

          ?>
        </div>
      
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
<?php

session_start();
//if not logged in, can not view cart, go log in first
if (!$_SESSION['loggedin']) {
  header("Location: login.php");
}
require_once ("db_connect.php");

$cart_id = $db->escape_string($_REQUEST['cart_id']);
//delete that specific cart item
$sql = "DELETE FROM Carts WHERE cart_id = $cart_id";
$result = $db->query($sql);
if (!$result) {
	exit("SQL Error: Something wrong happened when removing, " . $mysqli->error);
}
//go back to cart after deleting
header("Location: viewCart.php");
?>

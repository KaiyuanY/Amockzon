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

$uploaded = false;
//check if there was an add
$product_name = $db->escape_string($_REQUEST['name']);
$details = $db->escape_string($_REQUEST['description']);
$category_id = $db->escape_string($_REQUEST['category_id']);
$price = $db->escape_string($_REQUEST['price']);
if(!$product_name || !$details || !$category_id || !$price){
	exit("Parameter not passed in, plz go back and check.");
}

$target_dir = "product_img/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
if($uploadOk == 0){
	exit("<br>Failed to add product.");
}

//now actually add to database
$img_url = $target_file;

$sql = "INSERT INTO Products (product_name, img_url, category_id, details, price, trade_volume)
		VALUES ('$product_name', '$img_url', $category_id, '$details', $price, 0)";
//echo $sql;
$result = $db->query($sql);
if(!$result){
	exit("SQL Error: ". $mysqli->error);
}
echo "You have successfully added $product_name to our database. Thank you for choosing Amockzon!<br>
		You can <a href='addProduct.php'>add more product</a> or go to <a href='index.php'>home page</a>.";
?>
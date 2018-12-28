<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
//$_SESSION['cid']=$row['coupon_id'];
//$var = $_POST["cid"];
//echo $var;

$var=$_REQUEST['buybtn'];
echo $var;

?>
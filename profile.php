<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//include config file
require_once "config.php";  

$user = $_SESSION['username'];
$uid=$_SESSION['id'];


$result = mysqli_query($link,"select * from login where id=$uid");
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
$acbalance = $row['acbalance'];

if (isset($_POST['updatebtn']))
{
    $uname=$_POST['username'];
    $uemail = $_POST['email'];
    $sql = "UPDATE login SET `username` ='$uname' WHERE id = $uid";
    $esql = "UPDATE login SET `email` ='$uemail' WHERE id =$uid";
    mysqli_query($link,$sql);
    mysqli_query($link,$esql);
    echo '<script>alert("Profile successfully updated")</script>';
}

?>
<html>
<head>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/lg.css">
    <style>
        body{
            background-image: url("img/profile.jpg");
            background-position: center center;
            background-size: cover;
            font: 14px sans-serif;
        }
    </style>
</head>
<body>
<div class="login-page">
      <div class="form">
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $row['username']?>" class="input-xlarge">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $row['username']?>" class="input-xlarge">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo $row['email']?>" class="input-xlarge">
            <div>
        	    <input name="updatebtn" type="submit" class="btn btn-primary"/>
            </div>
            <a href="welcome.php">Go back </a>
            </form>
    </div>  
  </div>
  </body>
  </html>
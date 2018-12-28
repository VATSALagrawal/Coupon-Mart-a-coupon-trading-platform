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
?>
<?php
$total = 0;
$uid = $_SESSION["id"] ;
$user = $_SESSION["username"] ;                            
                            
$acsql = "select * from login where id= $uid ";
$result = mysqli_query($link,$acsql);
$row = mysqli_fetch_assoc($result);
$acbalance=  $row['acbalance'];
if (isset($_POST["addmoney"]))
{
    $b = 0 ;
    $b = $acbalance + $_POST['money'];

    $status = "";

    $addmoney = "UPDATE login SET `acbalance` = $b WHERE id =$uid";
    if (!mysqli_query($link,$addmoney)) {
        echo mysql_errno($link) . ": " . mysql_error($link) . "\n";
        $status="payment failed";
    }
    else 
    {
        $status="payment success";
    }
    echo '<script>alert("'.$status.'")</script>';
    echo '<script>window.location="addmoney.php"</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Money to Wallet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/lg.css">
    <style>
        body{
            background-image: url("img/addmoney.jpg");
            background-position: center center;
            background-size: cover;
            font: 14px sans-serif; 
        }    
    </style>
</head>
<body>
    <div class="login-page">
    <div class="form">
    <h1>ADD MONEY TO YOUR WALLET</h1>
    <BR>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label> Your Account Balance is </label>
        <span><?php echo $acbalance ;?> </span> <br><br>
        <label>Enter Amount to Add </label>
        <input type="text" class="form-control" name="money"/> <br><br>
        <input type="submit" class="btn btn-success" name="addmoney" value="Add Money"/>
        <br><br><a class="btn btn-primary" href="welcome.php">Go back </a>
    </form>
    </div>
    </div>
</body>
</html>


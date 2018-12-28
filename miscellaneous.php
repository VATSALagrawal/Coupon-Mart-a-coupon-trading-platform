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

if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["cid"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["cid"],  
                    );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="miscellaneous.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["cid"],  
                );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  
                        
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="top.css">
</head>
<body>
    <!--<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger" >Sign Out of Your Account</a>
    </p>
    <table width="40% 100% 30%">
    <tr>
    <td><span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu </span></td>
    <td> <h1>Coupon Bank</h1> </td>
    <td> </td>
    </tr>
    </table>
    -->
    <h1>Coupon Bank</h1>
    <div class="topnav">
    <a href="#" class="active" style="cursor:pointer" onclick="openNav()">&#9776;</span>
    <a href="welcome.php">Home</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
    <div class="search-container">
    <form action="/action_page.php">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    </div>
    <a href="cart.php" >View Cart</a>
    <a class="aright" href="logout.php" >Sign Out</a>
    </div>
    
    <div id="mySidenav" class="sidenav active">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="profile.php">Profile Information</a>
        <a href="add_coupon.php">Add Coupon</a>
        <a href="reset-password.php">Change Password</a>
    </div>
    
    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script>
    <div class="cbox" style="padding:10px ; margin:5px ; border-radius:20px ">
                        <H2>MISCELLEANEOUS </H2> 
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'miscellaneous' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x1=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                            ?>
                                            <form  method="post" action="miscellaneous.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'> 
                                            <!-- <span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'> <?php echo $row["coupon_code"];?> </span>
                                            -->
                                            <span style='padding:10px ; margin:5px ; text-transform:uppercase ; font-size:1.5em '><?php echo $row["app_web"];?></span>
                                            <span style='padding:10px ; margin:5px ;font-size:1.5em'><?php echo $row["price"]."₹";?> </span>
                                            <input class="btn btn-success" type='submit' name='add_to_cart' style='padding:10px ; margin:5px ' value='Add to Cart'/>
                                            <p style='padding:10px ; margin:5px text-transform:uppercase ; font-size:1.5em '><?php echo $row["descrip"]?></p>
                                            </div>
                                            </form>
                                            
                                            <?php
                                    } 
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
</body>
</html>
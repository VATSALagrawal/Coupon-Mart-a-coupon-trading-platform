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
                echo '<script>window.location="welcome.php"</script>';  
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
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["item_id"] == $_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="cart.php"</script>';  
                }  
           }  
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
    <!-- Including jQuery is required. -->
 
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 
    <!-- Including our scripting file. -->

    <script type="text/javascript" src="search_script.js"></script>

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
    <a href="about.html">About</a>
    <div class="search-container">
    <form action="search_result.php" method="post">
      <input type="text" id="search" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    <div id="display"></div>
    </div>
    <a href="cart.php" >View Cart</a>
    <a class="aright" href="logout.php" >Sign Out</a>
    </div>
    
    <div id="mySidenav" class="sidenav active">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="profile.php">Profile Information</a>
        <a href="add_coupon.php">Add Coupon</a>
        <a href="reset-password.php">Change Password</a>
        <a href="bought_coupon.php">Bought Coupons</a>
        <a href="addmoney.php">Add Money</a>
    </div>
    
    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script>

    <table width="100%">
        <tr>
            <td width="50%">
                <div class="cbox" style="padding:10px ; margin:5px ;">
                        <H2>TRAVEL <a href="travel.php" style="font-size:15px">View All Travel Coupons</a> </H2> 
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'travel' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x1=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                        if ($x1<2)
                                        {
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px '> 
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
                                        $x1=$x1+1;
                                    } 
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
            </td>
            <td width="50%" class="im" style="background-image:url(img/travel.jpg) ; background-size:100% 100%"></td>
        </tr>
        <tr>
            <td class="im" style="background-image:url(img/food.png) ; background-size:100% 100%"></td>
            <td>
                <div class="cbox" style="padding:10px ; margin:5px">
                        <H2>FOOD <a href="food.php" style="font-size:15px">View All Food Coupons</a></H2>
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'food' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x2=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                        if($x2<2)
                                        {
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
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
                                        $x2=$x2+1;
                                    }
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="cbox" style="padding:10px ; margin:5px ">
                        <H2>RECHARGE <a href="recharge.php" style="font-size:15px">View All Recharge Coupons</a> </H2>
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'recharge' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x3=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                        if($x3<2)
                                        {
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'> 
                                            <!--
                                            <span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'> <?php echo $row["coupon_code"];?> </span>
                                            -->
                                            <span style='padding:10px ; margin:5px ; text-transform:uppercase ; font-size:1.5em '><?php echo $row["app_web"];?></span>
                                            <span style='padding:10px ; margin:5px ;font-size:1.5em'><?php echo $row["price"]."₹";?> </span>
                                            <input class="btn btn-success" type='submit' name='add_to_cart' style='padding:10px ; margin:5px ' value='Add to Cart'/>
                                            <p style='padding:10px ; margin:5px text-transform:uppercase ; font-size:1.5em '><?php echo $row["descrip"]?></p>
                                            </div>
                                            </form>
                                            
                                            <?php
                                        }
                                        $x3=$x3+1;
                                    }
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
            </td>
            <td class="im" style="background-image:url(img/recharge.jpg) ; background-size:100% 100%"></td>
        </tr>
        <tr>
            <td class="im" style="background-image:url(img/fashion2.jpg) ; background-size:100% 100%"></td>
            <td>
                <div class="cbox" style="padding:10px ; margin:5px">
                        <H2>FASHION <a href="fashion.php" style="font-size:15px">View All Fashion Coupons</a> </H2>
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'fashion' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x4=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                        if($x4<2)
                                        {
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'> 
                                            <!--
                                            <span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'> <?php echo $row["coupon_code"];?> </span>
                                            -->
                                            <span style='padding:10px ; margin:5px ; text-transform:uppercase ; font-size:1.5em '><?php echo $row["app_web"];?></span>
                                            <span style='padding:10px ; margin:5px ;font-size:1.5em'><?php echo $row["price"]."₹";?> </span>
                                            <input class="btn btn-success" type='submit' name='add_to_cart' style='padding:10px ; margin:5px ' value='Add to Cart'/>
                                            <p style='padding:10px ; margin:5px text-transform:uppercase ; font-size:1.5em '><?php echo $row["descrip"]?></p>
                                            </div>
                                            </form>
                                            
                                            <?php
                                        }    
                                        $x4=$x4+1;
                                    }
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="cbox" style="padding:10px ; margin:5px">
                        <H2>ENTERTAINMENT <a href="entertainment.php" style="font-size:15px">View All Entertainment Coupons</a> </H2>
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'entertainment' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x5=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    {
                                        if($x5<2)
                                        { 
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'> 
                                            <!--
                                            <span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'> <?php echo $row["coupon_code"];?> </span>
                                            -->
                                            <span style='padding:10px ; margin:5px ; text-transform:uppercase ; font-size:1.5em '><?php echo $row["app_web"];?></span>
                                            <span style='padding:10px ; margin:5px ;font-size:1.5em'><?php echo $row["price"]."₹";?> </span>
                                            <input class="btn btn-success" type='submit' name='add_to_cart' style='padding:10px ; margin:5px ' value='Add to Cart'/>
                                            <p style='padding:10px ; margin:5px text-transform:uppercase ; font-size:1.5em '><?php echo $row["descrip"]?></p>
                                            </div>
                                            </form>
                                            
                                            <?php
                                        }
                                        $x5=$x5+1;
                                    }
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>
                </div>
            </td>
            <td class="im" style="background-image:url(img/entertainment.png) ; background-size:100% 100%"></td>
        </tr>
        <tr>
            <td>
                <div class="cbox" style="padding:10px ; margin:5px">
                        <H2>MISCELLANEOUS <a href="miscellaneous.php" style="font-size:15px">View All Miscellaneous Coupons</a> </H2>  
                        <?php
                            $sqlTravel = "SELECT * FROM coupons WHERE category = 'miscellaneous' ";
                            $resultTravel= $link->query($sqlTravel);
                            $num = mysqli_num_rows($resultTravel);
                            if($num > 0)
                                {
                                    $x6=0;
                                    while($row=$resultTravel->fetch_assoc())
                                    { 
                                        if($x6<2)
                                        {
                                            ?>
                                            <form  method="post" action="welcome.php?action=add&cid=<?php echo $row["coupon_id"]; ?>">
                                            <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'> 
                                            <!--
                                            <span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'> <?php echo $row["coupon_code"];?> </span>
                                            -->
                                            <span style='padding:10px ; margin:5px ; text-transform:uppercase ; font-size:1.5em '><?php echo $row["app_web"];?></span>
                                            <span style='padding:10px ; margin:5px ;font-size:1.5em'><?php echo $row["price"]."₹";?> </span>
                                            <input class="btn btn-success" type='submit' name='add_to_cart' style='padding:10px ; margin:5px ' value='Add to Cart'/>
                                            <p style='padding:10px ; margin:5px text-transform:uppercase ; font-size:1.5em '><?php echo $row["descrip"]?></p>
                                            </div>
                                            </form>
                                            
                                            <?php
                                        }    
                                        $x6=$x6+1;
                                    }
                                }
                            else 
                            {
                                echo "<p>sorry No coupons available yet</p>";
                            }
                        ?>  
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
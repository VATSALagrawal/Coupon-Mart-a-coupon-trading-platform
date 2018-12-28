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

$total = 0;
$uid = $_SESSION["id"] ;
$user = $_SESSION["username"] ;                            
                            
$acsql = "select * from login where id= $uid ";
$result = mysqli_query($link,$acsql);
$row = mysqli_fetch_assoc($result);
$acbalance=  $row['acbalance'];

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/pay.css">
    <!-- Including jQuery is required. -->
 
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 
    <!-- Including our scripting file. -->

    <script type="text/javascript" src="search_script.js"></script>
</head>
<body>
<div style="clear:both"></div>  
                <br />  
                <h3>Order Details</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="10%">S.no</th>  
                               <th width="40%">Description</th>
                               <th width="20%">Applicable Website</th>  
                               <th width="20%">Price</th>  
                               <th width="10%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {    
                               $s=1;
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                                   $cid=$values['item_id'];
                                   $cselect = "select * from coupons where coupon_id='$cid'";
                                   $result = mysqli_query($link,$cselect);
                                   while ($row = mysqli_fetch_assoc($result))
                                   {
                                       $total=$total+$row["price"];
                                       $_SESSION["amount"]=$total;
                          ?>  
                          <tr>  
                               <td><?php echo $s ;?></td>
                               <td><?php echo $row["descrip"] ;?></td>
                               <td><?php echo $row["app_web"] ;?></td>
                               <td><?php echo $row["price"] ;?></td>
                               <td><a href="welcome.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php    
                                   }
                                   $s=$s+1;
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">₹ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
           <div>
                <form action="cart.php" method="post">
                    <input class="btn btn-success" type='submit' name='payment' style='padding:10px ; margin:5px ' value='Pay Using Wallet'/>
                    <input class="btn btn-primary" type='submit' name='payment' style='padding:10px ; margin:5px ' value='Pay Using Card'/>
                    <span class="bal" >Your Account balance is : <?php echo $acbalance; ?> </span>
                </form>
           </div>
           <br/>
           <a class="btn btn-primary" href="welcome.php">Go Back</a> <br>   
      </body>  
 </html>

<?php

if(isset($_POST["payment"]))  
 {  
    //echo '<script>alert("total is '.$total.'")</script>' ;
    if ($acbalance >= $total)
    {
        $b=$acbalance - $total;
        $status = "";
        $deduct = "UPDATE login SET `acbalance` = $b WHERE id =$uid";
        if (!mysqli_query($link,$deduct)) {
            echo mysql_errno($link) . ": " . mysql_error($link) . "\n";
            $status="payment failed";
        }
        else 
        {
            $status="payment success";
            if(!empty($_SESSION["shopping_cart"]))  
            {  
                foreach($_SESSION["shopping_cart"] as $keys => $values)  
                {  
                    $cid=$values['item_id'];
                    mysqli_query($link,"insert into bought_by values ('$cid',$uid)");
                    //$status.="coupon added";
                    unset($_SESSION["shopping_cart"][$keys]);
                    $copsql = "select * from coupons where coupon_id = $cid";
                    $res = mysqli_query($link,$copsql);
                    while($r = mysqli_fetch_assoc($res))
                    {
                        $added_by= $r["added_by"];
                        $cprice = $r["price"];
                        $add_to_seller = "UPDATE login SET `acbalance` = `acbalance` + $cprice WHERE username ='$added_by' ";
                        mysqli_query($link,$add_to_seller);
                        $status.=" money added to seller " ;
                    }
                    
                }
            }
        }
    }
    else 
    {
        $status = "Insuffient balance in account";
    }
    echo '<script>alert("'.$status.'")</script>';
    echo '<script>window.location="cart.php"</script>';
}  
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "cancel")  
      {  
            unset($_SESSION["amount"]) ;
            echo '<script>alert("Payment Cancelled")</script>';  
            echo '<script>window.location="cart.php"</script>';  
      }     
 }  

 ?>
   
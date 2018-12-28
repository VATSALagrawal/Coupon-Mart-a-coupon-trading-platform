<?php
// Initialize the session
session_start();
  
// Include config file
require_once "config.php";
/*
if(isset($_POST["coupon_rating"]))  
 {  
      if(isset($_SESSION["crating"]))  
      {  
           $item_array_id = array_column($_SESSION["crating"], "item_id");  
           if(!in_array($_GET["cid"], $item_array_id))  
           {  
                $count = count($_SESSION["crating"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["cid"],  
                     'item_rating'          =>     $_POST["rating"]  
                    );  
                $_SESSION["crating"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Rated")</script>';  
                echo '<script>window.location="bought_coupon.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["cid"],  
                'item_rating'          =>     $_POST["rating"]  
                );  
           $_SESSION["crating"][0] = $item_array;  
      }     
}
*/
if(isset($_POST["coupon_rating"]))  
 {  
    $cid=$_GET['cid'];
    $rating = $_POST['rating'];
    $rate = "UPDATE coupons SET `rating`= (`rating` + $rating)/2 where coupon_id='$cid'";
    mysqli_query($link,$rate);
    //echo '<script>alert("'.$cid." "."$rating".'")</script>';
    echo '<script>alert("Coupon rated successfully")</script>';
 }
/*
if(!empty($_SESSION["crating"]))  
{    
    foreach($_SESSION["crating"] as $keys => $values)  
        {  
            $cid=$values['item_id'];
            $rating = $values['item_rating'];
            $rate = "UPDATE coupons SET `rating`= (`rating` + $rating)/2 where coupon_id='$cid'";
            mysqli_query($link,$rate);
        }
}
*/      

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bought Coupons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="display.css" />
</head>
<body>
    <h1>Purchased Coupons</h1>
    <?php 
        $uid = $_SESSION['id'];
        $sql = "select * from bought_by where user_id = $uid ";
        $result = mysqli_query($link,$sql);
        while ($row = mysqli_fetch_assoc($result))
        {
            $csql = "select * from coupons where coupon_id=".$row['coupon_id']."";
            $cresults = mysqli_query($link,$csql);
            while($r = mysqli_fetch_assoc($cresults))
            {
                //echo "
                ?>
                <div style='border: 2px solid black ; border-radius:15px ; padding:10px ; margin:10px'>
                <table>
                    <tr>
                        <td><span style='padding:10px ; margin:5px ; font-weight:bold'>Coupon Code </span></td> 
                        <td><span style='border:2px solid lightslategray ;border-radius:10px ; background-color:azure ; padding:5px ; margin:2px'><?php echo $r["coupon_code"] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><br><span style='padding:10px ; margin:5px ; font-weight:bold'>Price </span></td>
                        <td><br><span style='padding:10px ; margin:5px '><?php echo $r["price"] ?></span></td>
                    </tr>
                    <tr>
                        <td><span style='padding:10px ; margin:5px ;font-weight:bold'>Applicable Website </span></td>
                        <td><span style='padding:10px ; margin:5px '><?php echo $r["app_web"] ?></span></td>
                    </tr>
                    <tr>
                        <td><span style='padding:10px ; margin:5px ;font-weight:bold'>Description </span></td>
                        <td><p style='padding:10px ; margin:5px '><?php echo $r["descrip"] ?></p></td>
                    </tr>
                    
                    <tr>
                        <form method="post" action="bought_coupon.php?action=add&cid=<?php echo $r["coupon_id"];?>">
                            <td ><span style="margin:5px">Please rate your coupon out of 10</span></td>
                            <td><input type="text" name="rating" class="form-control" /></td>
                            <td><input type="submit" name="coupon_rating" style="margin-top:10px;" class="btn btn-success" value="Rate Coupon" /></td>
                        </form>
                    </tr>
                </table>
                </div> 

                <?php                                   
            }
        } 
    ?>
    <b><a class="btn btn-primary" style="font-size:1.5em ; margin:5px " href="welcome.php">Go back</a><b>
    
</body>
</html>
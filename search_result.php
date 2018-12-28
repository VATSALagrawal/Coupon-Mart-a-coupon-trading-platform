<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</html>
<?php
// Initialize the session
session_start();
  
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$search_result="";
$search_err = "";
$c=0;
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
                echo '<script>window.location="search_result.php"</script>';  
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

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $search_result=$_POST["search"];
    if (!empty($search_result))
    {
        $name = strtolower($search_result);
        $c=1;
    
        //Search query.
        $Query = "SELECT * FROM coupons WHERE descrip LIKE '%$name%' OR app_web LIKE '%$name%'";

        //Query execution.
        $ExecQuery = MySQLi_query($link,$Query);

        //Creating unordered list to display result.
        //Fetching result from database.
        while ($row = MySQLi_fetch_array($ExecQuery)) 
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
        echo "<a class='btn btn-primary' style='margin:10px' href='welcome.php'>Go Back </a>";
    }
    else 
    {
        echo"<h1><b>Sorry No Results found<b><h1>";
        //echo '<script>window.location="welcome.php"</script>';
    }
}
?>
 

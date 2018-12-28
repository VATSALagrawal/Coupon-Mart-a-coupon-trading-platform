<?php
// Include config file
require_once "config.php";

//start the session 
session_start();
 
// Define variables and initialize with empty values
$coupon_code = $category = $price = $description = $app_web = "";
$coupon_code_err = $category_err = $price_err = $description_err = $app_web_err = "";
$userid ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    // Validate Required Fields
    if(empty(trim($_POST["coupon_code"]))){
        $coupon_code_err = "Please enter Coupon code";     
    } else{
        $coupon_code = trim($_POST["coupon_code"]);
    }
    
    if(empty(trim($_POST["price"]))){
        $price_err = "Please enter coupon value";     
    } else{
        $price = trim($_POST["price"]);
    }

    if(empty(trim($_POST["category"]))){
        $category_err = "Please select Coupon Category";     
    } else{
        $category = trim($_POST["category"]);
    }
    
    if(empty(trim($_POST["description"]))){
        $description_err = "Please describe your coupon";     
    } else{
        $description = trim($_POST["description"]);
    }
    
    if(empty(trim($_POST["app_web"]))){
        $app_web_err = "Please Enter Applicable Website or App";     
    } else{
        $app_web = trim($_POST["app_web"]);
    }

    // Check input errors before inserting in database
    if(empty($coupon_code_err) && empty($category_err) && empty($price_err) && empty($app_web_err)&& empty($description_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO coupons (coupon_code, added_by ,category , price , descrip , app_web ) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_coupon_code, $param_user_id,$param_category,$param_price,$param_descrip,$param_app_web);
            
            // Set parameters
            $param_coupon_code = $coupon_code;
            $param_user_id= $_SESSION["username"];
            $param_category =$category;
            $param_app_web = $app_web;
            $param_descrip=$description;
            $param_price=$price;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "Your Coupon was Successfully Added" ;
                header("location: add_coupon.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Coupon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ 
            background-image: url("img/addcoupon.jpeg");
            background-position: center center;
            background-size: cover;
            font: 14px sans-serif;
        }
        .wrapper{ 
            width: 350px; 
            padding: 20px; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Add Coupon</h2>
        <p>Please Describe Your Coupon</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($coupon_code_err)) ? 'has-error' : ''; ?>">
                <label>Coupon Code</label>
                <input type="text" name="coupon_code" class="form-control" value="<?php echo $coupon_code; ?>">
                <span class="help-block"><?php echo $coupon_code_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Coupon Value </label>
                <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                <span class="help-block"><?php echo $price_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                <label>Category of Coupon </label>
                <br>
                <input type="radio" name="category"
                <?php if (isset($category) && $category=="travel") echo "checked";?>
                value="travel">Travel
                <br>

                <input type="radio" name="category"
                <?php if (isset($category) && $category=="food") echo "checked";?>
                value="food">Food
                <br>
                <input type="radio" name="category"
                <?php if (isset($category) && $category=="recharge") echo "checked";?>
                value="recharge">Recharge
                <br>
                <input type="radio" name="category"
                <?php if (isset($category) && $category=="fashion") echo "checked";?>
                value="fashion">Fashion
                <br>
                <input type="radio" name="category"
                <?php if (isset($category) && $category=="entertainment") echo "checked";?>
                value="entertainment">Entertainment
                <br>
                <input type="radio" name="category"
                <?php if (isset($category) && $category=="miscellaneous") echo "checked";?>
                value="miscellaneous">Miscellaneous
                <br>
                <span class="help-block"><?php echo $category_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>Describe Your Coupon</label>
                <textarea name="description" rows="5" cols="40" class="form-control" value="<?php echo $description; ?>"></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>Applicable Website or App</label>
                <input type="text" name="app_web" class="form-control" value="<?php echo $app_web; ?>">
                <span class="help-block"><?php echo $app_web_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Go To Home Page <a href="welcome.php">Home</a></p>
        </form>
    </div>    
</body>
</html>
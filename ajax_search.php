<?php

//Including Database configuration file.

include "config.php";

//Getting value of "search" variable from "script.js".

if (isset($_POST['search'])) 
{
    //Search box value assigning to $Name variable.
    $Name = $_POST['search'];
    $name = strtolower($Name);
    
    //Search query.
    $Query = "SELECT app_web FROM coupons WHERE app_web LIKE '%$name%' LIMIT 3 ";

    //Query execution.
    $ExecQuery = MySQLi_query($link,$Query);

    //Creating unordered list to display result.
    echo "<div>";
    //Fetching result from database.
    while ($Result = MySQLi_fetch_array($ExecQuery)) 
    {
?>
    <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->

    <br><span onclick="fill('<?php echo $Result['app_web' ]; ?>')">
    <a>
    <!-- Assigning searched result in "Search box" in "ajax_search.php" file. -->
           <?php echo $Result['app_web']; ?>
    </span></a>
    <!-- Below php code is just for closing parenthesis. Don't be confused. -->
    <?php
    }
}
?>
</div>
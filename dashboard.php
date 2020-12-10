<?php
session_start();
include('inc/functions.php');



// if logged_on is set to true
 if ($_SESSION["logged_on"]) {
        
        // Gets the current logged in user from the $session
        $logged_in_user = $_SESSION["user_id"];
        // Get the user details from datebase
        $show_user_details = get_user_details_id($logged_in_user); 
             
        // gets the value of the is_admin column
        $is_admin = $show_user_details['is_admin'];
      
        $all_candles = get_all_candles();
        // If the user_id in the URL and the session id do not match, log the user out (to prevent people accessing other peoples profiles)

        // If use is not an admin, log them out
        if ($is_admin != "1"){ 
            logout();
        } 
 
if (isset($_POST['logout'])) {
    logout();
}

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candles - Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Welcome to the Dashboard </h3>

<?php
var_dump($_SESSION["user_id"]);
echo "<a href='newcandle.php?id=$user_id'>Add Candle</a>";
echo "<ul>";
foreach($all_candles as $single_candle) {
echo "<li>";
$candle_id = $single_candle['candle_id'];
echo $single_candle['candle_title'] . " $" . $single_candle['candle_price'] . " QTY:" . $single_candle['candle_qty'] . " " . "ID: " . $single_candle['candle_id'] . " " . "<a href='editcandle.php?id=$candle_id'>Edit Candle</a>";
echo "</li>";
}
echo "</ul>";

?>
<a href="orders.php">Orders</a>
<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>


</body>
</html>
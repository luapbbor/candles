<?php
session_start();
include('inc/functions.php');

// if logged_on is set to true
 if ($_SESSION["logged_on"]) {
    // if the id is set in the url
    if(isset($_GET['id'])){
        // gets the user_id from the url
        $user_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
        // gets an array of the user details with the id in the URL
        $show_user_details = get_user_details_id($user_id); 
        // gets the id of the logged in user session
        $logged_in_user = $_SESSION["user_id"];
          
        // Gets all the orders for the logged in user
        $order_details = get_all_user_orders($logged_in_user);
        
        // gets the value of the is_admin column
        $is_admin = $show_user_details['is_admin'];

        $user_address = get_user_address($user_id);
        
        if ($is_admin == 1) {
            header("Location: dashboard.php?id=$user_id"); 
        }

        // If the user_id in the URL and the session id do not match, log the user out (to prevent people accessing other peoples profiles)
        if ($user_id != $logged_in_user) {
            logout();
        }   
    } else {
        logout();
    }
    $message =  "you are logged on";
    
  } else {
      header("Location: index.php");
}

// If the enter_address button is presssed

if(isset($_POST['update_address'])){
    // Get all the input from form and filter it
  $street_no = filter_input(INPUT_POST, 'street_no', FILTER_SANITIZE_NUMBER_INT);
  $street_name = filter_input(INPUT_POST, 'street_name', FILTER_SANITIZE_STRING);
  $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
  $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_NUMBER_INT);

  if(update_user_address($user_id, $street_no, $street_name,$city,$state,$postcode)){
    header("Location: profile.php?id=$user_id");
  }

}

// Pressing the logout button runs the logout function
if (isset($_POST['logout'])) {
    logout();
}
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>candles</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Your Profile</h3>
<?php 
echo "Hi, " . $show_user_details['name'];
echo "<br>";
?>
<?php echo "Registered email address: " . $show_user_details['email'];
echo "<br>";
?>
<h3>Your Delivery Address</h3>
<?php 
    $current_street_no = $user_address['street_no'];
    $current_street_name = $user_address['street_name'];
    $current_city = $user_address['city'];
    $current_state = $user_address['state'];
    $current_postcode = $user_address['postcode'];

    echo "<form method='post'>";
    echo "<label for='street_no'> Street Number</label>";
    echo "<input id='street_no' type='number' name='street_no' value='$current_street_no'><br>";
    echo "<label for='street_name'> Street Name</label>";
    echo "<input id='street_name' type='text' name='street_name' value='$current_street_name'><br>";
    echo "<label for='city'> City</label>";
    echo "<input id='city' type='text' name='city' value='$current_city'><br>";
    echo "<label for='state'> State</label>";
    echo "<input id='state' type='text' name='state' value='$current_state'><br>";
    echo "<label for='postcode'> Postcode</label>";
    echo "<input id='postcode' type='number' name='postcode' value='$current_postcode'><br>"; 
  echo "<input type='submit' id='update_address' name='update_address' value='Update Address' class='button'>";
  echo "</form>";


?>

<h3>Your Orders</h3>
<?php 
foreach ($order_details as $order_item) {
echo "Order No: #" . $order_item['order_id'] . " Cost: $" . $order_item['order_total_cost'] . " Date Ordered: ". $order_item['order_date'];
echo "<br>";
}
?>
<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>

</body>
</html>
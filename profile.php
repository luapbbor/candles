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
            header("Location: dashboard.php"); 
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

if(isset($_POST['enter_address'])){
    // Get all the input from form and filter it
  $street_no = filter_input(INPUT_POST, 'street_no', FILTER_SANITIZE_NUMBER_INT);
  $street_name = filter_input(INPUT_POST, 'street_name', FILTER_SANITIZE_STRING);
  $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
  $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
  $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_NUMBER_INT);

  if(add_user_address($user_id, $street_no, $street_name,$city,$state,$postcode)){
    header("Location: profile.php?id=$user_id");
  }

}

if(isset($_POST['phone_no_button'])){
    $leading_zero = 0;
    $phone_no_input = filter_input(INPUT_POST, 'phone_no', FILTER_SANITIZE_NUMBER_INT);
    $phone_no = $leading_zero . $phone_no_input;
    if (update_user_phone_no($phone_no,$user_id)){
        header("Location: profile.php?id=$user_id");
    } else {
        $error_message = "Sorry, we could not update your phone number";
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
echo "Registered email address: " . $show_user_details['email'];
echo "<br>";
echo "<a href='resetpassword.php?id=$user_id'>Reset Password</a>";
if ($show_user_details['phone_no'] == 0) {
  echo "<form method='post'>";
  echo "<label for='phone_no'>Phone No</label>";
  echo "<input id='phone_no' type='tel' name='phone_no'><br>"; 
  echo "<input type='submit' id='phone_no_button' name='phone_no_button' value='Add Phone Number' class='button'>";
  echo "</form>";
} else {
  $_SESSION['edit_phone_source'] = "profile.php";
  echo "Phone: " . "0" . $show_user_details['phone_no'] . "</br>";
  echo "<a href='editphone.php?id=$user_id'>Edit Phone</a>";
}

?>
<h3>Your Delivery Address</h3>
<?php 

if ($user_address != true) {
    echo "You have not entered a delivery address";
    echo "<form method='post'>";
    echo "<label for='street_no'> Street Number</label>";
    echo "<input id='street_no' type='number' name='street_no'><br>";
    echo "<label for='street_name'> Street Name</label>";
    echo "<input id='street_name' type='text' name='street_name'><br>";
    echo "<label for='city'> City</label>";
    echo "<input id='city' type='text' name='city'><br>";
    echo "<label for='state'> State</label>";
    echo "<input id='state' type='text' name='state'><br>";
    echo "<label for='postcode'> Postcode</label>";
    echo "<input id='postcode' type='number' name='postcode'><br>"; 
  echo "<input type='submit' id='enter_address' name='enter_address' value='Add Address' class='button'>";
  echo "</form>";
} else {
   echo $user_address['street_no'] . " " . $user_address['street_name'] . "<br>";
   echo $user_address['city'] . "<br>";
   echo $user_address['state'] . "<br>";
   echo $user_address['postcode'] . "<br>";
   $_SESSION['edit_address_source'] = "profile.php";
   echo "<a href='editaddress.php?id=$user_id'>Edit Address</a>";
}

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
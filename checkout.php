<?php

include('inc/functions.php');
session_start();
$cart_items = $_SESSION['cart_items'];

if ($_SESSION['logged_on'] != "True") {
    header("Location: logon.php");
} else {
    $user_id = $_SESSION['user_id'];
    $user_details = get_user_details_id($user_id);
    $user_address = get_user_address($user_id);
}

// If the button to place the order is pressed
if(isset($_POST['place_order'])){
    $date_formatted = format_current_date(); 
    $total_order_cost = $_SESSION['total_order_cost'];
    add_order($user_id, $total_order_cost, $date_formatted);
    // Gets the last order inserted into the orders table
    $last_order = return_last_inserted_row();
    $order_id = $last_order['order_id'];
    // Loop through each item in the cart_item session to get the candle title and candle_id
    foreach ($cart_items as $item) {
      $candle_title = $item[0];   
        $candle_id = $item[3];   
        // Insert the data into the candles_ordered table 

        if (add_candle_order($candle_id, $candle_title, $order_id, $user_id)){
           // Clears the cart items from the session 
           clear_cart();
           header("Location: orderplaced.php?id=$order_id");  
        }
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

if (isset($_POST['clear_cart'])) {
  clear_cart();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card - Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>

<h3>Checkout</h3>

<?php 
if($cart_items != null){
  echo "<h4>Your Details </h4>";
  echo $user_details['name'] . "<br>";
  echo "Email: " . $user_details['email'] . "<br>";
    if ($user_details['phone_no'] == null) {
      echo "<form method='post'>";
      echo "<label for='phone_no'>Phone No</label>";
      echo "<input id='phone_no' type='tel' name='phone_no'><br>"; 
      echo "<input type='submit' id='phone_no_button' name='phone_no_button' value='Add Phone Number' class='button'>";
      echo "</form>";
    } else {
      $_SESSION['edit_phone_source'] = "checkout.php";
      echo "Phone: " . "0" . $user_details['phone_no'] . "</br>";
      echo "<a href='editphone.php?id=$user_id'>Edit Phone</a>";
    }


  echo "<h4> Delivery Address</h4>";

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
      $_SESSION['edit_address_source'] = "checkout.php";
      echo "<a href='editaddress.php?id=$user_id'>Edit Address</a>";
      echo "<br>";
    }


$items_in_cart = count($cart_items);

  if ($items_in_cart > 0) {
    foreach ($cart_items as $item) {
      $candle_title = $item[0];   
        $candle_id = $item[3];   
        $candle_qty = $item[2];
        $candle_price = $item[1];
        $candle_total_cost = $candle_qty * $candle_price;
        $total_cost += $candle_total_cost;
        
        // Insert the data into the candles_ordered table 
        echo "<br>"; 
      echo $candle_title;
      echo "<br>";
      echo "QTY: " . $candle_qty;
      echo "<br>";
      echo "Price: $" . $candle_price;
      echo "<br>"; 
      echo "Total: $" . $candle_total_cost;
      echo "<br>"; 
      echo "<br>"; 
      
    }
    session_start();
    $_SESSION['total_order_cost'] = $total_cost;
    echo "Total Order Cost: $" . $total_cost;
    echo "<form method='post'>";
    echo "<input type='submit' id='clear_cart' name='clear_cart' value='Empty Cart' class='button'>";
    echo "</form>";
  } 

  echo "<form method='post'>";
  echo "<input type='submit' id='place_order_button' name='place_order' value='Place Order' class='button'>";
  echo "</form>";

}else {
  echo "Your cart is empty !";
}

?>
</body>
</html>
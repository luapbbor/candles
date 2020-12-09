<?php

include('inc/functions.php');
session_start();
$cart_items = $_SESSION['cart_items'];

if ($_SESSION['logged_on'] != "True") {
    header("Location: logon.php");
} else {
    $user_id = $_SESSION['user_id'];
    $user_details = get_user_details_id($user_id);
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
<h4>Your Details </h4>


<?php

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
} else {
  echo "Your cart is empty !";
}

?>

<?php
echo "<form method='post'>";
echo "<input type='submit' id='place_order_button' name='place_order' value='Place Order' class='button'>";
echo "</form>";
?>
</body>
</html>
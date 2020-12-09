<?php

include('inc/functions.php');
session_start();
$cart_items = $_SESSION['cart_items'];



if (isset($_POST['clear_cart'])) {
 clear_cart();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candles - Cart</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Product Cart</h3>

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
  echo "Total Order Cost: $" . $total_cost;
  echo "<form method='post'>";
  echo "<input type='submit' id='clear_cart' name='clear_cart' value='Empty Cart' class='button'>";
  echo "</form>";
} else {
  echo "Your cart is empty !";
}

?>

<a href="checkout.php" class="button">Checkout</a>
</body>
</html>
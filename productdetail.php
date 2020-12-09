<?php

include('inc/functions.php');

if (isset($_GET['id'])) {
 $candle_id = $_GET['id'];
 $candle_detail = get_single_candle($candle_id);
}

if(isset($_POST['add_cart'])){
    session_start();
    $cart_item_qty = filter_input(INPUT_POST, 'cart_item_qty', FILTER_SANITIZE_NUMBER_INT);
    $cart_candle_id = $candle_detail['candle_id'];
    $cart_candle_title = $candle_detail['candle_title'];
    $cart_candle_price = $candle_detail['candle_price'];
    $cart_item = array($cart_candle_title,$cart_candle_price,$cart_item_qty, $cart_candle_id);
    $_SESSION['cart_items'][] = $cart_item;
    $cart_items = $_SESSION['cart_items'];
    var_dump($cart_items);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candles - Product Details</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Product Detail </h3>
<?php
echo "<form method='post'>";
echo $candle_detail['candle_title'];
echo "<br>";
echo "<b>Description: </b>";
echo "<br>";
echo $candle_detail['candle_desc'];
echo "<br>";
echo "<b>Price: </b>";
echo "<br>";
echo $candle_detail['candle_price'];
echo "<br>";
echo "<b>QTY Available: </b>";
echo "<br>";
echo $candle_detail['candle_qty'];
echo "<br>";
echo $candle_detail['candle_category'];
echo "<br>";
echo "<br>";
$img_src = $candle_detail['candle_image_path'];
echo "<img src='$img_src' alt='candle image'>";
echo "<label for='cart_item_qty'>QTY</label>";
echo "<input type='number' name='cart_item_qty'>";
echo "<input type='submit' id='add_cart' name='add_cart' value='Add To Cart' class='button'>";
echo "</form>";

?>

<a href='cart.php'>Go to cart</a>
<script>


</script>

</body>
</html>
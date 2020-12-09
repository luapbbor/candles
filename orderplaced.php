<?php

if (isset($_GET['id'])) {
   $order_id = $_GET['id'];
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card - Order Placed</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>

<h3>Your order has been placed !</h3>
<?php 
echo "Your order number is # " . "$order_id";
?>
</body>
</html>
<?php
session_start();
include('inc/functions.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candles - Products</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Products </h3>

<?php

 
 foreach(get_all_candles() as $candles){
   $candle_id = $candles['candle_id']; 
   echo "<a href='productdetail.php?id=$candle_id'>"; 
   echo $candles['candle_title'];
   echo "<br>";
   echo "<b>Description: </b>";
   echo "<br>";
   echo $candles['candle_desc'];
   echo "<br>";
   echo "<b>Price: </b>";
   echo "<br>";
   echo $candles['candle_price'];
   echo "<br>";
   echo $candles['candle_category'];
   echo "<br>";
   echo "<br>";
   $img_src = $candles['candle_image_path'];
   echo "<img src='$img_src' alt='candle image'>";
   echo "</a>";
   
 }

?>


</body>
</html>
<?php
include('inc/functions.php');
$featured_candles = get_featured_candles();

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
<?php
echo date("d-m-Y H:i");
?>
<h4 id="grid" class="headline-secondary">Bec's Candles</h4>

<a href="register.php">Create Account</a>

<a href="logon.php">Logon</a>

  <div class="row">
    <div class="col-12 theme">
    <?php
     foreach($featured_candles as $featured_candle) {
       $featured_img_src = $featured_candle['candle_image_path'];
       echo "<img src='$featured_img_src'>";
     }
     ?>

    </div>
  </div>
  <div class="row">
    <div class="col-6 theme">.col-6</div>
    <div class="col-6 theme">.col-6</div>
  </div>
  <div class="row">
    <div class="col-4 theme">.col-4</div>
    <div class="col-4 theme">.col-4</div>
    <div class="col-4 theme">.col-4</div>
  </div>
  <div class="row">
    <div class="col-3 theme">.col-3</div>
    <div class="col-3 theme">.col-3</div>
    <div class="col-3 theme">.col-3</div>
    <div class="col-3 theme">.col-3</div>
  </div>
  <div class="row">
    <div class="col-5 theme">.col-5</div>
    <div class="col-7 theme">.col-7</div>
  </div>
  <div class="row">
    <div class="col-8 theme">.col-8</div>
    <div class="col-4 theme">.col-4</div>
  </div>
  <div class="row">
    <div class="col-7 theme centered">.centered .col-7</div>
  </div>


<script>
</script>
    
</body>
</html>

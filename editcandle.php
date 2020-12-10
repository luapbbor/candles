<?php
session_start();
include('inc/functions.php');



// if logged_on is set to true
 if ($_SESSION["logged_on"]) {
    // if the id is set in the url
    if(isset($_GET['id'])){
        // gets the user_id from the url
        $candle_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
        
        // Put the array for a single candle into a variable
        $show_candle = get_single_candle($candle_id);
        
        
        // gets the logged in user from session
        $logged_in_user = $_SESSION["user_id"];
        // Gets the details for the logged in user
        $show_user_details = get_user_details_id($logged_in_user);
        // gets the value of the is_admin column
        $is_admin = $show_user_details['is_admin'];
        // If the user is not an admin, log them out
        if ($is_admin != "1") {
            logout();
        }   
    } else {
        logout();
    }
    $message =  "you are logged on";
    
  } else {
      header("Location: index.php");
}

if (isset($_POST['logout'])) {
    logout();
}

// Add new candle form submit

// If the button for add_candle was clicked
if (isset($_POST['edit_candle'])) {
  $candle_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $candle_desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $candle_price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  $candle_qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);
  $candle_featured = filter_input(INPUT_POST, 'featured', FILTER_SANITIZE_NUMBER_INT);
    
   // Else call the function to create a new user
    if(edit_candle($candle_title, $candle_desc, $candle_price, $candle_qty, $candle_featured,$candle_id)){
      header("Location: dashboard.php?id=$logged_in_user");         
       
    } else {
        $error_message = "Sorry, there was an error creating the candle";           
    }  
} 

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
         
 
if(isset($_POST['change_image'])){
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

// // Allow certain file formats
// if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
// || $imageFileType != "gif" ) {
//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//   $uploadOk = 0;
// }


if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["image_upload"]["name"])). " has been uploaded.";
      if(edit_candle_image($target_file, $candle_id)){
        header("Location: dashboard.php?id=$logged_in_user");  
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
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
  var_dump($target_file);
  
  $candle_title = $show_candle['candle_title'];
  $candle_desc = $show_candle['candle_desc'];
  $candle_qty = $show_candle['candle_qty'];
  $candle_price = $show_candle['candle_price'];
  $candle_image_path = $show_candle['candle_image_path'];
  $candle_featured = $show_candle['candle_featured'];
  if($candle_featured == "1"){
    $checked = "checked";
  } else {
    $checked = "";
  }
  
  echo "You are an administrator !";
  echo "<br>";
  echo "<h3>Edit Candle</h3>";
  echo "<form method='post' enctype='multipart/form-data'>";
  echo "<label for='title'>Title</label>";
  echo "<input type='text' name='title' value='$candle_title'>";
  echo "<label for='description'>Description</label>";
  echo "<input type='text' name='description' value='$candle_desc'>";
  echo "<label for='qty'>Quantity Available</label>";
  echo "<input type='number' name='qty' value='$candle_qty'>";
  echo "<label for='price'>Price</label>";
  echo "<input type='number' name='price' step='any' value='$candle_price'>";
  echo "<label for='featured'>Featured (Featured images show on the home page)</label><br>";
  echo "<input type='checkbox' name='featured' value='$candle_featured' $checked>";
  echo "<input type='submit' id='edit_candle_button' name='edit_candle' value='Edit Candle' class='button'>";
  echo "</form>";
  echo "<form method='post' action='#' enctype='multipart/form-data'>";
  echo "<img src='$candle_image_path'>";
  echo "<label for='image_upload'>Change Image</label>";
  echo "<input type='file' name='image_upload' id='image_upload'>";
  echo "<input type='submit' id='change_image_button' name='change_image' value='Change Image' class='button'>";
  echo "</form>";
  echo "<a href='dashboard.php?id=$user_id'>Cancel</a>";


?>


<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>


</body>
</html>
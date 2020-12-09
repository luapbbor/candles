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
        
        // gets the value of the is_admin column
        $is_admin = $show_user_details['is_admin'];
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

if (isset($_POST['logout'])) {
    logout();
}

// Add new candle form submit

// If the button for add_candle was clicked
if (isset($_POST['add_candle'])) {
    
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
    $qty = filter_input(INPUT_POST, 'qty', FILTER_SANITIZE_NUMBER_INT);

    // variables for image upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
// Image upload
$check = getimagesize($_FILES["image_upload"]["tmp_name"]);
if($check !== false) {
  echo "File is an image - " . $check["mime"] . ".";
  $uploadOk = 1;
} else {
  echo "File is not an image.";
  $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["image_upload"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }   

    // If the form fields are empty
  if (empty($title)|| empty($description)|| empty($price) ) {
    $error_message = "Please fill in required fields - title, description, price, category ";
    } else {
    // Else call the function to create a new user
    if(add_new_candle($title, $description, $price, $qty, $target_file)){
       $error_message = "The candle has been added !";
       
    } else {
        $error_message = "Sorry, there was an error creating the candle";           
    }
}





}   

// If the button for add_category was clicked
if (isset($_POST['add_category'])) {
    echo "yuou pressed";
    $new_category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

    // If the form fields are empty
  if (empty($new_category)) {
    $error_message = "Please fill in required fields - category ";
    } else {
    // Else call the function to create a new user
    if(add_new_category($new_category)){
       $message = "The category has been added !";
       
    } else {
        $error_message = "Sorry, there was an error creating the candle";           
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
<h3>profile page </h3>
<?php echo $selected_category; ?>
<?php 
 
  
  echo "You are an administrator !";
  echo "<br>";
  echo "<h3>Add New Candle</h3>";
  echo "<form method='post' action='#' enctype='multipart/form-data'>";
  echo "<label for='title'>Title</label>";
  echo "<input type='text' name='title'>";
  echo "<label for='description'>Description</label>";
  echo "<input type='text' name='description'>";
  echo "<label for='qty'>Quantity Available</label>";
  echo "<input type='number' name='qty'>";
  echo "<label for='price'>Price</label>";
  echo "<input type='number' name='price' step='any'>";
  echo "<label for='image_upload'>Image</label>";
  echo "<input type='file' name='image_upload' id='image_upload'>";
  echo "<input type='submit' id='add_candle_button' name='add_candle' value='Add Candle' class='button'>";
  echo "</form>";
  echo "<h3>Add Category</h3>";
  echo "<form method='post'>";
  echo "<label for='category'>Category Name</label>";
  echo "<input type='text' name='category'>";
  
 
  
  echo "<input type='submit' id='add_category_button' name='add_category' value='Add Category' class='button'>";
  echo "</form>";

?>
<?php echo $show_user_details['email'];?>
<?php echo $error_message; ?>
<?php echo $message ?>
<?php echo $target_file ?>

<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>


</body>
</html>
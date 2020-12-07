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
    // $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $selected_category = $_POST['category'];
   
    // If the form fields are empty
  if (empty($title)|| empty($description)|| empty($price)|| empty($selected_category)) {
    $error_message = "Please fill in required fields - title, description, price, category ";
    } else {
    // Else call the function to create a new user
    if(add_new_candle($title, $description, $price, $selected_category)){
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
  echo "<form method='post' action='#'>";
  echo "<label for='title'>Title</label>";
  echo "<input type='text' name='title'>";
  echo "<label for='description'>Description</label>";
  echo "<input type='text' name='description'>";
  echo "<label for='price'>Price</label>";
  echo "<input type='number' name='price'>";
  echo "<select id='categories'>Select a category";
  foreach(get_categories() as $category) {
    echo "<option value='" . $category['category_id'] . "' name='category'>" . $category['category_name'] . "</option>";    
}
echo "</select>";
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


<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>


</body>
</html>
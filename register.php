<?php
include('inc/functions.php');

$error_message = "";
$logon_password = null;
$get_password = null;

// If the button for create_user was clicked
if (isset($_POST['create_user'])) {
  // Get all the input from form and filter it
  $name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   
  // If password or email are empty
  if (empty($password)|| empty($email)) {
      $error_message = "Please fill in required fields - Email, password. ";
   // else check if the email already exists in the db
  } elseif (check_email_exists($email)) {      
       $error_message = "This email already exists";
  } else {
      // Else call the function to create a new user
      $date_registered = format_current_date();
      if(add_new_user($name,$email,$password,$date_registered)){
         header("Location: logon.php?new_user=true");  
      } else {
          $error_message = "Sorry, there was an error creating the user";           
      }
  }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>candles - register</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Create Account</h3>
<form method="post">
<label for="name"> Name</label>
  <input id="name" type="text" name="name"><br>
<label for="email"> Email</label>
  <input id="email" type="email" name="email"><br>
  <label for="password"> Password</label>
  <input id="password" type="password" name="password"><br>
  <input type="submit" id="create_user_button" name='create_user' value="Create" class="button">
  <a href="index.php" class="button button-secondary">Cancel</a>
</form>
<?php echo $error_message ?>


</body>
</html>

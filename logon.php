<?php 

$message = "";

if (isset($_GET['new_user'])) {
 $message = "Congratulations, you have created an account, please logon";
}

// If the button for logon was clicked
if (isset($_POST['logon'])) {
    include('inc/functions.php');
    // Get all the input from form and filter it
    $logon_password = filter_input(INPUT_POST, 'logon_password', FILTER_SANITIZE_STRING);
    $logon_email = filter_input(INPUT_POST, 'logon_email', FILTER_SANITIZE_EMAIL); 
    // If email or password are empty
    if (empty($logon_password)|| empty($logon_email)) {
        $error_message = "Please fill in required fields - Email, password. ";      
    } else {
    // gets the hashed password from the database
    $get_password = get_user_details($logon_email); 
    $get_user_id = get_user_details($logon_email);
    // validates the hashed password with the password entered
    $valid = password_verify ( $logon_password, $get_password['password'] );  
    // If the email addres already exists in the database
    if (check_email_exists($logon_email)) {
      if ( $valid ) {
        session_start();
        $user_id = $get_user_id['user_id'];
        $_SESSION["logged_on"] = "True";
        $_SESSION["user_id"] = $user_id;
        header("Location: profile.php?id=$user_id");        
       } else {
         $error_message = "password is incorrect";
       }
  
    } else {
        $error_message = "Email address is not registered";
    }
  
  }  
  }
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
<h3>Logon</h3>
<?php echo $message; ?>
<form method="post">
<label for="logon_email"> Email</label>
  <input id="logon_email" type="email" name="logon_email"><br>
  <label for="logon_password"> Password</label>
  <input id="logon_password" type="password" name="logon_password"><br>
  <input type="submit" id="logon_button" name='logon' value="Logon" class="button">
  <a href="index.php" class="button button-secondary">Cancel</a>
</form>

</body>
</html>
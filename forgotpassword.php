<?php
include('inc/functions.php');

// If the forgot password button is pressed
if (isset($_POST['forgot_password_button'])) {
   $email_address = filter_input(INPUT_POST, 'forgot_password_email', FILTER_SANITIZE_EMAIL);
   $user_details = get_user_details($email_address);
   send_email_single_user($email_address);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candles - Forgot Password</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Forgot Password</h3>
<form method="post">

<label for="forgot_password_email"> Email</label>
  <input id="forgot_password_email" type="forgot_password_email" name="forgot_password_email"><br>
    <input type="submit" id="forgot_password_button" name='forgot_password_button' value="Send" class="button">
  <a href="index.php" class="button button-secondary">Cancel</a>
</form>
<?php echo $error_message ?>


</body>
</html>

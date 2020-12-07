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
        
        if ($is_admin == 1) {
            header("Location: dashboard.php?id=$user_id"); 
        }

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
<h3>profile page </h3>
<?php 


?>
<?php echo $show_user_details['email'];?>
<?php echo $message ?>


<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>

</body>
</html>
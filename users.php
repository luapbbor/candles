<?php
session_start();
include('inc/functions.php');          
        // gets the id of the logged in user session
        $logged_in_user = $_SESSION["user_id"];

        // gets an array of the user details with the id in the URL
        $show_user_details = get_user_details_id($logged_in_user); 
        
        // gets the value of the is_admin column
        $is_admin = $show_user_details['is_admin'];

if ($is_admin = "1"){
    $all_users = get_all_users();
} else {
  logout();
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
    <title>Candles - Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
<h3>Welcome to the Dashboard </h3>
<?php
echo "<h4>Registered Users</h4>";
echo "<ul>";
foreach ($all_users as $single_user) {
echo "<li>";
echo "User ID: #" . $single_user['user_id'] . " " . $single_user['name'] . " " . $single_user['email'] . " " . $single_user['phone_no'];
echo "</li>";
}
echo "</ul>";
?>
<a href="dashboard.php">Candles<a>
<form method="post">
<input type="submit" id="logout_button" name='logout' value="Logout" class="button">
</form>


</body>
</html>
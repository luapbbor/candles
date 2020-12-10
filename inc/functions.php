<?php

// --------------------------------------------------------------------------//
// -------------------------  DATABASE FUNCTIONS  ---------------------------//
// --------------------------------------------------------------------------//

// --------------------------------------------------------------------------//
// -------------------------       SELECTS        ---------------------------//
// --------------------------------------------------------------------------//


// This function checks if the email address entered when creating a user already exists
function check_email_exists($email) {
    include('dbconnect.php');      
    $sql = 'SELECT * FROM users WHERE email = ?';      
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$email,PDO::PARAM_STR);
      $results->execute();
      return $results->fetch(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
      echo $e->getMessage();
      return false;
      } 
}

// This function checks the details from an email address entered in a form
function get_user_details($email) {
    include('dbconnect.php');      
    $sql = 'SELECT * FROM users WHERE email = ?';      
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$email,PDO::PARAM_STR);
      $results->execute();
      return $results->fetch(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
      echo $e->getMessage();
      return false;
      } 
}

// This function gets the details for a user via the ID in the url
function get_user_details_id($id) {
    include('dbconnect.php');      
    $sql = 'SELECT * FROM users WHERE user_id = ?';      
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$id,PDO::PARAM_INT);
      $results->execute();
      return $results->fetch(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
      echo $e->getMessage();
      return false;
      } 
}

// This function gets the details for a user via the ID in the url
function get_all_users() {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM users';      
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}


// This function gets a list of all the candle categories
function get_categories() {
    include('dbconnect.php');      
    $sql = 'SELECT * FROM categories';      
    try {
      $results = $db->prepare($sql);
      $results->execute();
      return $results->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
      echo $e->getMessage();
      return false;
      } 
}

// This function gets a list of all the candles
function get_all_candles() {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM candles';      
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// This function gets a single candle via the ID in the URL
function get_single_candle($candle_id) {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM candles WHERE candle_id = ?';      
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$candle_id,PDO::PARAM_INT);
    $results->execute();
    return $results->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// This function gets all candles that are featured
function get_featured_candles() {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM candles WHERE candle_featured = 1';      
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// Gets the last inserted order_id from the orders table
function return_last_inserted_row(){
  include('dbconnect.php');
  $sql = 'SELECT * FROM orders ORDER BY order_id DESC limit 1 ';
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetch(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;

}

// This function gets a single order via the ID in the URL
function get_single_order($order_id) {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM orders WHERE order_id = ?';      
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$order_id,PDO::PARAM_INT);
    $results->execute();
    return $results->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// This function gets a single order via the ID in the URL
function get_all_orders() {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM orders';      
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// This function gets a all orders from the user_id session variable
function get_all_user_orders($user_id) {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM orders WHERE order_user_id = ?';      
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$user_id,PDO::PARAM_INT);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}

// This function gets the address related for a particular user
function get_user_address($user_id) {
  include('dbconnect.php');      
  $sql = 'SELECT * FROM address WHERE user_id = ?';      
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$user_id,PDO::PARAM_INT);
    $results->execute();
    return $results->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
    echo $e->getMessage();
    return false;
    } 
}




// --------------------------------------------------------------------------//
// -------------------------      INSERTS        ---------------------------//
// --------------------------------------------------------------------------//

// This function adds a new user into the database table "users"
// @param $email, $password etc are all obtained from the form input
function add_new_user($name, $email,$password, $date_registered) {
    include('dbconnect.php');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users(name, email, password, date_registered) VALUES(?,?,?,?)';
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$name,PDO::PARAM_STR);
      $results->bindValue(2,$email,PDO::PARAM_STR);
      $results->bindValue(3,$password,PDO::PARAM_STR);
      $results->bindValue(4,$date_registered,PDO::PARAM_STR);
      $results->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
      return true;
  }

// This function adds a users address into the address table
// @params are all obtained from the form input except $user_id which is obtained from $_SESSION
function add_user_address($user_id, $street_no, $street_name,$city, $state, $postcode) {
  include('dbconnect.php');
  $sql = 'INSERT INTO address(user_id,street_no,street_name,city, state, postcode) VALUES(?,?,?,?,?,?)';
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$user_id,PDO::PARAM_INT);
    $results->bindValue(2,$street_no,PDO::PARAM_INT);
    $results->bindValue(3,$street_name,PDO::PARAM_STR);
    $results->bindValue(4,$city,PDO::PARAM_STR);
    $results->bindValue(5,$state,PDO::PARAM_STR);
    $results->bindValue(6,$postcode,PDO::PARAM_INT);
    $results->execute();
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}

  // This function adds a new candle into the database table "candles"
// @param $email, $password etc are all obtained from the form input
function add_new_candle($title, $description, $price, $qty, $target_file, $featured) {
    include('dbconnect.php');
    $sql = 'INSERT INTO candles(candle_title, candle_desc, candle_price, candle_qty, candle_image_path, candle_featured) VALUES(?,?,?,?,?,?)';
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$title,PDO::PARAM_STR);
      $results->bindValue(2,$description,PDO::PARAM_STR);
      $results->bindValue(3,$price,PDO::PARAM_INT);
      // $results->bindValue(4,$selected_category,PDO::PARAM_STR);
      $results->bindValue(4,$qty,PDO::PARAM_INT);
      $results->bindValue(5,$target_file,PDO::PARAM_STR);
      $results->bindValue(6,$featured,PDO::PARAM_INT);
      
      $results->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
      return true;
  }



// This function adds a new category into the database table "categories"
// @param $category is obtained from the form input
function add_new_category($category) {
    include('dbconnect.php');
    $sql = 'INSERT INTO categories(category_name) VALUES(?)';
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$category,PDO::PARAM_STR);      
      $results->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
      return true;
  }

// This function is activated when the user clicks place order
// It adds the order details into the order table
// @param $user_id is obtained from the session id
function add_order($user_id, $total_cost, $date) {
  include('dbconnect.php');
  $sql = 'INSERT INTO orders(order_user_id, order_total_cost, order_date) VALUES(?,?,?)';
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$user_id,PDO::PARAM_INT);   
    $results->bindValue(2,$total_cost,PDO::PARAM_INT);   
    $results->bindValue(3,$date,PDO::PARAM_STR);     
    $results->execute();
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}

// This function is activated when the user clicks place order
// It adds the order details into the order table
// @param $user_id is obtained from the session id
function add_candle_order($candle_id, $candle_title, $order_id, $user_id) {
  include('dbconnect.php');
  $sql = 'INSERT INTO candles_ordered(candle_id, candle_title, order_id, user_id) VALUES(?,?,?,?)';
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$candle_id,PDO::PARAM_INT);   
    $results->bindValue(2,$candle_title,PDO::PARAM_STR); 
    $results->bindValue(3,$order_id,PDO::PARAM_INT);   
    $results->bindValue(4,$user_id,PDO::PARAM_INT);     
    $results->execute();
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}



// --------------------------------------------------------------------------//
// -------------------------      UPDATES        ---------------------------//
// --------------------------------------------------------------------------//

// This function updates the users address
// @params are all obtained from the form input apart from $user_id which is obtained from $_SESSION
function update_user_address($street_no, $street_name,$city,$state,$postcode, $user_id){
  include('dbconnect.php');
    
  $sql = "UPDATE address SET street_no = ?, street_name = ?,city = ?, state = ?, postcode = ? WHERE user_id = ?";
    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$street_no,PDO::PARAM_INT);
    $results->bindValue(2,$street_name,PDO::PARAM_STR);
    $results->bindValue(3,$city,PDO::PARAM_STR);
    $results->bindValue(4,$state,PDO::PARAM_STR);
    $results->bindValue(5,$postcode,PDO::PARAM_INT);
    $results->bindValue(6,$user_id,PDO::PARAM_INT);
    $results->execute();
    $db = null;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}

// This function updates the users address
// @params are all obtained from the form input apart from $user_id which is obtained from $_SESSION
function update_user_phone_no($phone_no,$user_id){
  include('dbconnect.php');
    
  $sql = "UPDATE users SET phone_no = ? WHERE user_id = ?";
    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$phone_no,PDO::PARAM_INT);
    $results->bindValue(2,$user_id,PDO::PARAM_INT);
    $results->execute();
    $db = null;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}


// This function updates the users address
// @params are all obtained from the form input apart from $user_id which is obtained from $_SESSION
function reset_password($new_password, $user_id){
  include('dbconnect.php');
  $new_password = password_hash($new_password, PASSWORD_DEFAULT);
  $sql = "UPDATE users SET password = ? WHERE user_id = ?";
    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$new_password,PDO::PARAM_STR);
    $results->bindValue(2,$user_id,PDO::PARAM_INT);
    $results->execute();
    $db = null;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}

// This function updates the candle
// @params are all obtained from the form input apart from $candle_id which is obtained from the URL
function edit_candle($candle_title, $candle_desc, $candle_price, $candle_qty, $candle_featured, $candle_id){
  include('dbconnect.php');
    
  $sql = "UPDATE candles SET candle_title = ?, candle_desc = ?, candle_price = ?, candle_qty = ?, candle_featured = ? WHERE candle_id = ?";
    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$candle_title,PDO::PARAM_STR);
    $results->bindValue(2,$candle_desc,PDO::PARAM_STR);
    $results->bindValue(3,$candle_price,PDO::PARAM_STR);
    $results->bindValue(4,$candle_qty,PDO::PARAM_INT);
    $results->bindValue(5,$candle_featured,PDO::PARAM_INT);
    $results->bindValue(6,$candle_id,PDO::PARAM_INT);
    $results->execute();
    $db = null;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}

// This function updates the path for the candles
function edit_candle_image($candle_image_path, $candle_id) {
  include('dbconnect.php');
    
  $sql = "UPDATE candles SET candle_image_path = ? WHERE candle_id = ?";
    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$candle_image_path,PDO::PARAM_STR);
    $results->bindValue(2,$candle_id,PDO::PARAM_INT);
    $results->execute();
    $db = null;
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
    return true;
}


// --------------------------------------------------------------------------//
// -------------------------       DELETES       ---------------------------//
// --------------------------------------------------------------------------//


// --------------------------------------------------------------------------//
// -------------------------       FUNCTIONS       ---------------------------//
// --------------------------------------------------------------------------//

// This function logs the user out and removes all session variables
function logout() {
// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("Location: index.php");  
}

// This function clears items from the shopping cart
function clear_cart() {
  session_start();
  unset($_SESSION['cart_items']);
  }

// This function gets the current date and formats it;

function format_current_date() {
$date = date("d-m-Y"); 
return $date;
}

function send_email_single_user($email_address) {

// the message
$msg = "Please reset your password";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail($email_address,"Reset Password",$msg);

}

?>
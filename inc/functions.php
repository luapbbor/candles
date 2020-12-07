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

// This function checks the details from an email address entered in a form
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



// --------------------------------------------------------------------------//
// -------------------------      INSERTS        ---------------------------//
// --------------------------------------------------------------------------//

// This function adds a new user into the database table "users"
// @param $email, $password etc are all obtained from the form input
function add_new_user($email,$password) {
    include('dbconnect.php');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users(email, password) VALUES(?,?)';
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$email,PDO::PARAM_STR);
      $results->bindValue(2,$password,PDO::PARAM_STR);
      $results->execute();
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
      return true;
  }

  // This function adds a new candle into the database table "candles"
// @param $email, $password etc are all obtained from the form input
function add_new_candle($title, $description, $price, $selected_category) {
    include('dbconnect.php');
    $sql = 'INSERT INTO candles(candle_title, candle_desc, candle_price, candle_category) VALUES(?,?,?,?)';
    try {
      $results = $db->prepare($sql);
      $results->bindValue(1,$title,PDO::PARAM_STR);
      $results->bindValue(2,$description,PDO::PARAM_STR);
      $results->bindValue(3,$price,PDO::PARAM_INT);
      $results->bindValue(4,$selected_category,PDO::PARAM_STR);
      
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

// --------------------------------------------------------------------------//
// -------------------------      UPDATES        ---------------------------//
// --------------------------------------------------------------------------//


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
}

?>
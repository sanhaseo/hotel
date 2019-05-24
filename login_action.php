<?php

# Access session.
session_start();

include_once 'header.php';

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require 'connect_db.php';
    
    # Get connection, load, and validate functions.
    require 'login_tools.php';
    
    # Check login.
    //list($check, $data) = validate($dbc, $_POST['email'], $_POST['pass']);
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

    $q = "SELECT user_id, first_name, last_name FROM users WHERE email='$email' AND password=SHA1('$password')";
    $r = mysqli_query($dbc, $q);
    if (mysqli_num_rows($r) == 1) {
        $login_error = false;

        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        
        mysqli_close($dbc);

        if (!empty($_SESSION['confirm'])) {
            load('confirm.php');
        }
        load('home.php');
    }
    else {
        $login_error = true;
    }
    
    # On success set session data and display logged in page.
    // if ($check) {
        
    //     $_SESSION['idUser'] = $data['idUser'];
    //     $_SESSION['first_name'] = $data['first_name'];
    //     $_SESSION['last_name'] = $data['last_name'];
        
    //     if (!empty($_SESSION['confirm'])) {
    //         load('confirm.php');
    //     }
        
    //     load('home.php');
    // }
    
    // # Or on failure set errors.
    // else {
    //     $errors = $data;
    // }
    
    # Close database connection.
    mysqli_close($dbc);
}

# Continue to display login page on failure.
include 'login.php';

?>
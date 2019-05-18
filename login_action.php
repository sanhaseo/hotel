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
    list($check, $data) = validate($dbc, $_POST['email'], $_POST['pass']);
    
    # On success set session data and display logged in page.
    if ($check) {
        
        $_SESSION['idUser'] = $data['idUser'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        
        if (!empty($_SESSION['confirm'])) {
            load('confirm.php');
        }
        
        load('home.php');
    }
    
    # Or on failure set errors.
    else {
        $errors = $data;
    }
    
    # Close database connection.
    mysqli_close($dbc);
}

# Continue to display login page on failure.
include 'login.php';

?>
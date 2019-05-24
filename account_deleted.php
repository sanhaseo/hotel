<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require 'login_tools.php';
    load();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_GET['user_id'];
    
    require 'connect_db.php';
    
    $q = "DELETE FROM reservation WHERE user_id = $user_id";
    if (!mysqli_query($dbc, $q)) {
        include_once 'header.php';
        echo '<h2>Error!</h2><p>Query was not successful.</p>';
    }
    else {
        $q = "DELETE FROM users WHERE user_id = $user_id";
        if (mysqli_query($dbc, $q)) {
            
            # Clear existing variables.
            $_SESSION = array();

            include_once 'header.php';

            # Destroy the session.
            session_destroy();
            
            echo '<h2>Goodbye!</h2><p>Your account has been deleted.</p>';
        }
        else {
            include_once 'header.php';
            echo '<h2>Error!</h2><p>Query was not successful.</p>';
        }
    }
    
    mysqli_close($dbc);
}

?>
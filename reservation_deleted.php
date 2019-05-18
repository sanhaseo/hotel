<?php

# Access session.
session_start();

include_once 'header.php';

# Redirect if not logged in.
if (!isset($_SESSION['idUser'])) {
    require 'login_tools.php';
    load();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $reservation_id = $_GET['reservation_id'];
    
    require 'connect_db.php';
    
    $q = "DELETE FROM reservation WHERE reservation_id = $reservation_id";
    
    if (mysqli_query($dbc, $q)) {
        echo '<h2>Success!</h2><p>Reservation has been cancelled.</p>';
    }
    else {
        echo '<h2>Error!</h2><p>Query was not successful.</p>';
    }
    
    mysqli_close($dbc);
}

?>
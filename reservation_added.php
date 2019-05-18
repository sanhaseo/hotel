<?php

# Access session.
session_start();

include_once 'header.php';

# Redirect if not logged in.
if (!isset($_SESSION['idUser'])) {
    require 'login_tools.php';
    load();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = $_SESSION['idUser'];
    $room_id = $_POST['room_id'];
    $date = $_POST['date'];
    $num_of_guests = $_POST['num_of_guests'];
    $card_type = $_POST['card_type'];
    $card_number = $_POST['card_number'];
    
    require 'connect_db.php';
    
    $q = "INSERT INTO reservation (idUser, room_id, date, num_of_guests, card_type, card_number) "
         . "values ($idUser, $room_id, '$date', $num_of_guests, '$card_type', '$card_number')";
    if (mysqli_query($dbc, $q)) {
        echo '<h2>Success!</h2><p>Reservation has been made.</p>';
        echo '<p>You can view/change your reservation at <a href="reservation_list.php" style="text-decoration:underline">My Reservations</a>.</p>';
    }
    else {
        echo '<h2>Error!</h2><p>Query was not successful.</p>';
    }
    
    mysqli_close($dbc);
}

?>
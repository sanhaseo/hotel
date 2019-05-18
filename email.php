<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['idUser'])) {
    require 'login_tools.php';
    load();
}

include_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require 'connect_db.php';
    
    $idUser = $_SESSION['idUser'];
    $reservation_id = $_GET['reservation_id'];
    
    $q = "SELECT * FROM userTable WHERE idUser = $idUser";
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    
    $q2 = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
    $r2 = mysqli_query($dbc, $q2);
    if ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        $room_id = $row2['room_id'];
        $date = $row2['date'];
        $num_of_guests = $row2['num_of_guests'];
        $card_type = $row2['card_type'];
        $card_number = $row2['card_number'];
        
        $q3 = "SELECT * FROM room WHERE room_id = $room_id";
        $r3 = mysqli_query($dbc, $q3);
        $row3 = mysqli_fetch_array($r3, MYSQLI_ASSOC);
        
        $room_name = $row3['room_name'];
        $capacity = $row3['capacity'];
        $price = $row3['price'];
        
        
        $to = $email;
        $subject = "Invoice (Reservation ID: $reservation_id)";
        $message = "Hello $first_name $last_name,\n"
                   . "Thank you for making a reservatin with us. Below is the invoice for your order.\n\n"
                   . "Reservation ID: $reservation_id\n"
                . "Room: $room_name\n"
                . "Date: $date\n"
                . "Price: $$price per person\n"
                . "Capacity: $capacity\n"
                . "Number of Guests: $num_of_guests\n"
                . "Card Type: $card_type\n"
                . "Card Number: $card_number\n\n"
                . "Total Price: $".$price*$num_of_guests."\n\n\n"
                . "We hope to see you again soon.\n\n"
                . "Hotel Reservation System.";
        $from = "do-not-reply@reservation.com";
        $header = "from:" . $from;
        
        mail($to,$subject,$message, $header);
        
        echo "<h2>Success!</h2><p>Invoice email has been sent to $email.</p>";
    }
    else {
        echo '<h2>Error!</h2><p>No reservation with reservation_id='.$reservation_id.".</p>";
    }
    
    mysql_close($dbc);
}

?>
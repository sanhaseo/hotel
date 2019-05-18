<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['idUser'])) {
    require 'login_tools.php';
    load();
}

include_once 'header.php';

if (isset($_GET['reservation_id'])) {
    $_SESSION['reservation_id'] = $_GET['reservation_id'];
}

if (isset($_SESSION['reservation_id'])) {
    $reservation_id = $_SESSION['reservation_id'];
    
    require 'connect_db.php';
    
    # Check if update has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['num_of_guests'])) {
            $q = "UPDATE reservation SET num_of_guests = {$_POST['num_of_guests']} WHERE reservation_id = $reservation_id";
            mysqli_query($dbc, $q);
        }
        if (!empty($_POST['card_type'])) {
            $q = "UPDATE reservation SET card_type = \"{$_POST['card_type']}\" WHERE reservation_id = $reservation_id";
            mysqli_query($dbc, $q);
        }
        if (!empty($_POST['card_number'])) {
            $q = "UPDATE reservation SET card_number = \"{$_POST['card_number']}\" WHERE reservation_id = $reservation_id";
            mysqli_query($dbc, $q);
        }
    }
    
    # Display invoice
    $q = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
    $r = mysqli_query($dbc, $q);
    if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $q2 = "SELECT * FROM room WHERE room_id = ".$row['room_id'];
        $r2 = mysqli_query($dbc, $q2);
        $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
        
        echo '<form method="post" action="invoice.php">';
        echo '<h2>Reservation Detail</h2>';
        echo '<p><strong>Reservation ID:</strong> '.$row['reservation_id'].'</p>';
        echo '<p><strong>Room:</strong> '.$row2['room_name'].'</p>';
        //echo '<p><img src="'.$row2['room_img'].'"></p>';
        echo '<p><strong>Date:</strong> '.$row['date'].'</p>';
        
        echo '<table>';
        echo '<tr><td></td><td style="text-align: left">Update</td></tr>';
        echo '<tr><td style="text-align: left; width: 270px"><strong>Number of Guests:</strong> '.$row['num_of_guests'].' </td>';
        echo '<td style="text-align: left">'
             . '<input type="number" name="num_of_guests" min="1" max="'.$row2['capacity'].'" value="'.$row['num_of_guests'].'" autofocus /></td></tr>';
        
        echo '<tr><td style="text-align: left"><strong>Card Type:</strong> '.$row['card_type'].' </td>';
        echo '<td style="text-align: left"><select name="card_type"><option value="Visa">Visa</option>'
                . '<option value="Master Card">Master Card</option><option value="Discover">Discover</option></select></td></tr>';
        
        echo '<tr><td style="text-align: left"><strong>Card Number:</strong> '.$row['card_number'].' </td>';
        echo '<td style="text-align: left">'
             . '<input type="text" name="card_number" pattern="\d*" minlength="16" maxlength="16" value="'.$row['card_number'].'" /></td></tr>';
        
        echo '</table>';
        
        echo '<p><strong>Total Price:</strong> $'.number_format($row['num_of_guests']*$row2['price'], 2).'</p>';
        echo '<input type="submit" value="Update Reservation" />';
        echo ' | <button type="button"><a href="email.php?reservation_id='.$reservation_id.'">Email Invoice</a></button>';
        echo ' | <button type="button"><a href="reservation_deleted.php?reservation_id='.$reservation_id.'">Cancel Reservation</a></button></form>';
    }
    else {
        echo '<h2>Error!</h2><p>No reservation with reservation_id='.$reservation_id.".</p>";
    }
    
    mysqli_close($dbc);
}
else {
    echo '<h2>Error!</h2><p>Something wrong with my code!</p>';
}

?>
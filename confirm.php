<?php

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['confirm']['room_id'] = $_POST['room_id'];
    $_SESSION['confirm']['date'] = $_POST['date'];
    $_SESSION['confirm']['num_of_guests'] = $_POST['num_of_guests'];
    $_SESSION['confirm']['card_type'] = $_POST['card_type'];
    $_SESSION['confirm']['card_number'] = $_POST['card_number'];
    
    require 'login_tools.php';
    load('login.php');
}

include_once 'header.php';

if (!empty($_SESSION['confirm'])) {
    $_POST['room_id'] = $_SESSION['confirm']['room_id'];
    $_POST['date'] = $_SESSION['confirm']['date'];
    $_POST['num_of_guests'] = $_SESSION['confirm']['num_of_guests'];
    $_POST['card_type'] = $_SESSION['confirm']['card_type'];
    $_POST['card_number'] = $_SESSION['confirm']['card_number'];
}

// if (empty($_POST['room_id']) || empty($_POST['date'])) {
//     echo '<h2>Error!</h2><p>Please select a room and a date.</p>';
// }
// elseif (empty($_POST['num_of_guests']) || empty($_POST['card_type']) || empty($_POST['card_number'])) {
//     echo '<h2>Error!</h2><p>Please enter <i>number of guests</i>, <i>card type</i>, and <i>card number</i>.</p>';
//     echo '<form method="post" action="payment.php">';
//     echo '<input type="hidden" name="room_id" value="'.$_POST['room_id'].'" />';
//     echo '<input type="hidden" name="date" value="'.$_POST['date'].'" />';
//     echo '<input type="submit" value="Back" /></form>';
// }

$room_id = $_POST['room_id'];
$date = $_POST['date'];
$num_of_guests = $_POST['num_of_guests'];
$card_type = $_POST['card_type'];
$card_number = $_POST['card_number'];

require 'connect_db.php';

$q2 = "SELECT * FROM room WHERE room_id = $room_id";
$r2 = mysqli_query($dbc, $q2);
if ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
    $room_name = $row2['room_name'];
    $room_img = $row2['room_img'];
    $capacity = $row2['capacity'];
    $price = $row2['price'];

    $q = "SELECT * FROM reservation WHERE room_id = $room_id AND reservation_date = '$date'";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 0) {
        echo '<h2>Sorry!</h2>';
        echo "<p><strong>$room_name</strong> is not available on <strong>$date</strong>. Please try another date or room.</p>";
    }
    else {
        echo '<h2>Order Summary</h2>';
        echo '<p><strong>Room:</strong> '.$room_name.'</p>';
        echo '<p><strong>Date:</strong> '.$date.'</p>';

        echo '<p><strong>Price:</strong> $'.$price.' per person</p>';
        echo '<p><strong>Capacity:</strong> '.$capacity.'</p>';

        echo '<p><strong>Number of Guests:</strong> '.$num_of_guests.'</p>';
        echo '<p><strong>Card Type:</strong> '.$card_type.'</p>';
        echo '<p><strong>Card Number:</strong> '.$card_number.'</p>';

        echo '<p><strong>Total Price:</strong> $'.$price*$num_of_guests.'</p>';

        echo '<form method="post" action="reservation_added.php">';
        echo '<input type="hidden" name="room_id" value="'.$room_id.'" />';
        echo '<input type="hidden" name="date" value="'.$date.'" />';
        echo '<input type="hidden" name="num_of_guests" value="'.$num_of_guests.'" />';
        echo '<input type="hidden" name="card_type" value="'.$card_type.'" />';
        echo '<input type="hidden" name="card_number" value="'.$card_number.'" />';
        echo '<input type="submit" value="Place Order" /></form>';
    }
}
else {
    echo "<h2>Error!</h2><p>No room with room_id=$room_id</p>";
}


?>
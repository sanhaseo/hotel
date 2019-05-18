<?php

# Access session.
session_start();

include_once 'header.php';

if (isset($_POST['room_id']) && isset($_POST['date'])) {
    $room_id = $_POST['room_id'];
    $date = $_POST['date'];
    
    require 'connect_db.php';
    
    $q2 = "SELECT * FROM room WHERE room_id = $room_id";
    $r2 = mysqli_query($dbc, $q2);
    if ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        $room_name = $row2['room_name'];
        $room_img = $row2['room_img'];
        $capacity = $row2['capacity'];
        $price = $row2['price'];
        
        $q = "SELECT * FROM reservation WHERE room_id = $room_id AND date = '$date'";
        $r = mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) > 0) {
            echo '<h2>Sorry!</h2>';
            echo "<p><strong>$room_name</strong> is not available on <strong>$date</strong>. Please try another date or room.</p>";
        }
        else {
            echo '<h2>Good News!</h2>';
            echo "<p><strong>$room_name</strong> is available on <strong>$date</strong>.</p>";
            
            echo '<p><img src="'.$room_img.'" /></p>';
            echo '<p><strong>$'.$price.'</strong> per person</p>';
            echo '<p>Capacity: <strong>'.$capacity.'</strong></p>';
            
            echo '<form method="post" action="confirm.php">';
            
            echo '<table>';
            echo '<tr><td style="text-align: left">Number of Guests </td>'
                 . '<td style="text-align: left"><input type="number" name="num_of_guests" min="1" max="'.$capacity.'" autofocus/></td></tr>';
            echo '<tr><td style="text-align: left">Card Type </td><td style="text-align: left"><select name="card_type"><option value="Visa">Visa</option>'
                 . '<option value="Master Card">Master Card</option><option value="Discover">Discover</option></select></td></tr>';
            echo '<tr><td style="text-align: left">Card Number (16 digits) </td>'
                 . '<td style="text-align: left"><input type="text" name="card_number" pattern="\d*" minlength="16" maxlength="16" /></td></tr>';
            echo '</table><br />';
            
            echo '<input type="hidden" name="room_id" value="'.$_POST['room_id'].'" />';
            echo '<input type="hidden" name="date" value="'.$_POST['date'].'" />';
            
            echo '<input type="submit" value="Proceed to Make Reservation" />';
            echo '</form>';
        }
    }
    else {
        echo "<h2>Error!</h2><p>No room with room_id=$room_id</p>";
    }
}
else {
    echo '<h2>Error!</h2><p>Please select a room and a date.</p>';
}

?>
<?php

# Access session.
session_start();

$_SESSION['confirm'] = array();

include_once 'header.php';

# Open database connection.
require 'connect_db.php';

# Retrieve rooms from 'shop' database table.
$q = "SELECT * FROM room";
$r = mysqli_query($dbc, $q);
# Display body section.

echo '<form method="post" action="payment.php">';
echo '<table><tr>';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo '<td><h3>'.$row['room_name'].'</h3>'
            . '<img src='.$row['room_img'].'><br /><br />'
            #. '<span style="font-size:smaller">'.$row['room_desc'].'</span><br /><br />'
            . '<strong>$'.$row['price'].'</strong> per person<br />'
            . 'Capacity: <strong>'.$row['capacity'].'</strong><br /><br />'
            . '<input type="radio" name="room_id" value="'.$row['room_id'].'" id="'.$row['room_id'].'" /> '
            . '<label for="'.$row['room_id'].'">Select '.$row['room_name'].'</label></td>';
}
echo '</tr></table>';
echo '<p>Select Date <input type="date" name="date" /></p>';
echo '<p><input type="submit" value="Check Availability" /></p>';

# Close database connection.
mysqli_close($dbc);

?>
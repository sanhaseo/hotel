<?php # Display home page.

// Access session.
session_start();

$_SESSION['confirm'] = array();

include_once 'header.php';

// Open database connection.
require 'connect_db.php';

// Retrieve rooms the room table.
$q = "SELECT * FROM room";
$r = mysqli_query($dbc, $q);

// Display body section.
echo '<form method="post" action="payment.php">';
echo '<table><tr>';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo '<td><h3>'.$row['room_name'].'</h3>';
    echo '<img src='.$row['room_img'].' /><br /><br />';
    echo '<strong>$'.$row['price'].'</strong> per person<br />';
    echo 'Capacity: <strong>'.$row['capacity'].'</strong><br /><br />';
    echo '<input type="radio" name="room_id" value="'.$row['room_id'].'" id="'.$row['room_id'].'" /> ';
    echo '<label for="'.$row['room_id'].'">Select '.$row['room_name'].'</label></td>';
}
echo '</tr></table>';
echo '<p>Select Date <input type="date" name="date" /></p>';
echo '<p><input type="submit" value="Check Availability" /></p>';

mysqli_close($dbc);

?>
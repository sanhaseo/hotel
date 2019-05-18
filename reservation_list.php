<?php

# Access session.
session_start();

$_SESSION['confirm'] = array();

include_once 'header.php';

echo '<h2>My Reservations</h2>';

if (isset($_SESSION['idUser'])) {
    $idUser = $_SESSION['idUser'];
    
    # Open database connection.
    require 'connect_db.php';
    
    $q = "SELECT * FROM reservation WHERE idUser = $idUser";
    $r = mysqli_query($dbc, $q);
    if (mysqli_num_rows($r) > 0) {
        echo '<table border="1" cellpadding="3"><tr><th>Reservation ID</th><th>Room</th><th>Date</th><th></th></tr>';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<tr><td>'.$row['reservation_id'].'</td>';
            $q2 = "SELECT * FROM room WHERE room_id = ".$row['room_id'];
            $r2 = mysqli_query($dbc, $q2);
            $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
            
            echo '<td>'.$row2['room_name'].'</td><td>'.$row['date'].'</td>';
            echo '<td><a href="invoice.php?reservation_id='.$row['reservation_id'].'" style="text-decoration: underline">View/Change</a></td></tr>';
        }
    }
    else {
        echo '<p>There is currently no reservation.</p>';
    }
    
    mysqli_close($dbc);
}
else {
    echo '<p>There is currently no reservation.</p>';
}

?>
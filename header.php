<head>
    <style>
        a {
            color: black;
            text-decoration: none;
        }
        div {
            background-color: yellowgreen;
            width: 1375px;
            text-align: center;
        }
        body {
            background-image: URL(http://10feettall.co.uk/wp-content/themes/puzzles2/images/bg/pattern_1.png);
            margin-left: auto;
            margin-right: auto;
            width: 1375px;
        }
        td {
            text-align: center;
        }
    </style>
</head>

<?php

# Access session.
session_start();

echo '<div><h1>Hotel Reservation System</h1></div>';

# Create navigation links
if (isset($_SESSION['idUser'])) {
    echo '<p><button type="button"><a href="home.php">Home</a></button> |'
         . ' <button type="button"><a href="profile.php">My Profile</a></button> |'
         . ' <button type="button"><a href="reservation_list.php">My Reservations</a></button> |'
         . ' <button type="button"><a href="logout.php">Logout</a></button></p>';
}
else {
    echo '<p><button type="button"><a href="home.php">Home</a></button> | '
         . '<button type="button"><a href="login.php">Login</a></button></p>';
}

echo '<br />';

?>
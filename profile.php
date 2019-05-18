<?php

# Access session.
session_start();

$_SESSION['confirm'] = array();

# Redirect if not logged in.
if (!isset($_SESSION['idUser'])) {
    require 'login_tools.php';
    load();
}

include_once 'header.php';

$idUser = $_SESSION['idUser'];

require 'connect_db.php';

# Check if update has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['first_name'])) {
        $q = "UPDATE userTable SET first_name = '{$_POST['first_name']}' WHERE idUser = $idUser";
        mysqli_query($dbc, $q);
    }
    if (isset($_POST['last_name'])) {
        $q = "UPDATE userTable SET last_name = '{$_POST['last_name']}' WHERE idUser = $idUser";
        mysqli_query($dbc, $q);
    }
}

# Display invoice
$q = "SELECT * FROM userTable WHERE idUser = $idUser";
$r = mysqli_query($dbc, $q);
if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo '<form method="post" action="profile.php">';
    echo '<h2>User Profile</h2>';
    
    echo '<table>';
    echo '<tr><td></td><td style="text-align: left">Update</td></tr>';
    echo '<tr><td style="text-align: left; width: 270px"><strong>First Name:</strong> '.$row['first_name'].' </td>';
    echo '<td style="text-align: left">'
             . '<input type="text" name="first_name" value="'.$row['first_name'].'" autofocus /></td></tr>';
    echo '<tr><td style="text-align: left"><strong>Last Name:</strong> '.$row['last_name'].' </td>';
    echo '<td style="text-align: left">'
             . '<input type="text" name="last_name" value="'.$row['last_name'].'" /></td></tr>';
    
    echo '</table>';
    
    echo '<p><strong>Email Address:</strong> '.$row['email'].'</p>';
    echo '<p><strong>Registration Date:</strong> '.$row['reg_date'].'</p>';
    
    echo '<input type="submit" value="Update Profile" />';
    //echo ' | <button type="button"><a href="change_password.php">Change Password</a></button>';
    echo ' | <button type="button"><a href="account_deleted.php?idUser='.$idUser.'">Delete Account</a></button></form>';
}
else {
    echo '<h2>Error!</h2><p>No user with idUser='.$idUser.".</p>";
}

mysqli_close($dbc);

?>
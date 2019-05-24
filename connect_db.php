<?php # Connect to the database.

$servername = "localhost";
$username = "sanha";
$password = "123";
$database = "hotel";

// Create connection
$dbc = new mysqli($servername, $username, $password, $database);
// Check connection
if ($dbc->connect_error) {
	die ("Connection failed: ".$dbc->connect_error);
}

// Set encoding to match PHP script encoding.
mysqli_set_charset($dbc, 'utf8');

?>
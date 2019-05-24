<?php # DISPLAY COMPLETE LOGGED OUT PAGE.

# Access session.
session_start();

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require 'login_tools.php';
    load();
}

# Clear existing variables.
$_SESSION = array();

include_once 'header.php';

# Destroy the session.
session_destroy();

# Display body section.
echo '<h2>Goodbye!</h2><p>You are now logged out.</p>';

?>
<?php # DISPLAY COMPLETE LOGIN PAGE.

session_start();

include_once 'header.php';

# Display any error messages if present.
if (isset($errors) && !empty($errors)) {
    echo '<h2>Error!</h2>';
    echo '<p id="err_msg">There was a problem:<br />';
    foreach ($errors as $msg) {
        echo " - $msg<br />";
    }
    echo 'Please try again or <a href="register.php" style="text-decoration:underline">Register</a></p>';
}

?>

<!-- Display body section. -->
<h2>Login</h2>
<form action="login_action.php" method="post">
    <table>
        <tr><td style="text-align: left">Email Address </td><td><input type="text" name="email" autofocus /></td></tr>
        <tr><td style="text-align: left">Password </td><td><input type="password" name="pass" /></td></tr>
    </table>
    <br /><input type="submit" value="Login" /> | <button type="button"><a href="register.php">Register</a></button>
</form>
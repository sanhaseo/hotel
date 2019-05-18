<?php # DISPLAY COMPLETE REGISTRATION PAGE.

session_start();

include_once 'header.php';

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Connect to the database.
    require 'connect_db.php';
    
    # Initialize an error array.
    $errors = array();
    
    # Check for a first name.
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    }
    else {
        $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    }
    
    # Check for a last name.
    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name.';
    }
    else {
        $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    }
    
    # Check for an email address.
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    }
    else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }
    
    # Check for a password and matching input passwords.
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        }
        else {
            $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
    }
    else {
        $errors[] = 'Enter your password.';
    }
    
    # Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT idUser FROM userTable WHERE email='$e'";
        $r = mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
        }
    }
    
    # On success register user inserting into 'users' database table.
    if (empty($errors)) {
        $q = "INSERT INTO userTable(first_name, last_name, email, pass, reg_date) VALUES('$fn', '$ln', '$e', SHA1('$p'), NOW())";
        $r = mysqli_query($dbc, $q);
        if ($r) {
            echo '<h2>Registered!</h2><p>You are now registered.</p>';
            if (isset($_SESSION['confirm'])) {
                echo '<p><button type="button"><a href="confirm.php">Proceed to Make Reservation</a></button></p>';
            }
        }
        
        # Close database connection.
        mysqli_close($dbc);
        
        exit();
    }
    
    # Or report errors.
    else {
        echo '<h2>Error!</h2><p id="err_msg">The following error(s) occured:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />";
        }
        echo '<p>Please try again.</p>';
        
        # Close database connection.
        mysqli_close($dbc);
    }
}

?>

<!-- Display body section with sticky form. -->
<h2>Register</h2>
<form action="register.php" method="post">
    <table>
    <tr><td style="text-align: left">First Name </td>
        <td><input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" autofocus /></td></tr>
    <tr><td style="text-align: left">Last Name </td>
        <td><input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) echo $_POST['lasst_name']; ?>" /></td></tr>
    <tr><td style="text-align: left">Email Address </td>
        <td><input type="text" name="email" size="20" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td></tr>
    <tr><td style="text-align: left">Password </td>
        <td><input type="password" name="pass1" size="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" /></td></tr>
    <tr><td style="text-align: left">Confirm Password </td>
        <td><input type="password" name="pass2" size="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" /></td></tr>
    </table>
    <p><input type="submit" value="Register" /></p>
    
</form>
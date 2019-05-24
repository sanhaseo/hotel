<?php # Display registration page.

session_start();

include_once 'header.php';

# Check form submitted.
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     # Connect to the database.
//     require 'connect_db.php';
    
//     # Initialize an error array.
//     $errors = array();
    
//     # Check for a first name.
//     if (empty($_POST['first_name'])) {
//         $errors[] = 'Enter your first name.';
//     }
//     else {
//         $fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
//     }
    
//     # Check for a last name.
//     if (empty($_POST['last_name'])) {
//         $errors[] = 'Enter your last name.';
//     }
//     else {
//         $ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
//     }
    
//     # Check for an email address.
//     if (empty($_POST['email'])) {
//         $errors[] = 'Enter your email address.';
//     }
//     else {
//         $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
//     }
    
//     # Check for a password and matching input passwords.
//     if (!empty($_POST['pass1'])) {
//         if ($_POST['pass1'] != $_POST['pass2']) {
//             $errors[] = 'Passwords do not match.';
//         }
//         else {
//             $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
//         }
//     }
//     else {
//         $errors[] = 'Enter your password.';
//     }
    
//     # Check if email address already registered.
//     if (empty($errors)) {
//         $q = "SELECT idUser FROM userTable WHERE email='$e'";
//         $r = mysqli_query($dbc, $q);
//         if (mysqli_num_rows($r) != 0) {
//             $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
//         }
//     }
    
//     # On success register user inserting into 'users' database table.
//     if (empty($errors)) {
//         $q = "INSERT INTO userTable(first_name, last_name, email, pass, reg_date) VALUES('$fn', '$ln', '$e', SHA1('$p'), NOW())";
//         $r = mysqli_query($dbc, $q);
//         if ($r) {
//             echo '<h2>Registered!</h2><p>You are now registered.</p>';
//             if (isset($_SESSION['confirm'])) {
//                 echo '<p><button type="button"><a href="confirm.php">Proceed to Make Reservation</a></button></p>';
//             }
//         }
        
//         # Close database connection.
//         mysqli_close($dbc);
        
//         exit();
//     }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database.
    require 'connect_db.php';
    
    // Sanitize user inputs.
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    
    // Check if email is already registered.
    $q = "SELECT user_id FROM users WHERE email='$email'";
    $r = mysqli_query($dbc, $q);

    // If not, insert user into the users table.
    if (mysqli_num_rows($r) == 0) {
        // $q = "INSERT INTO users (first_name, last_name, email, password, reg_date) ".
        //         "VALUES ('$first_name', '$last_name', '$email', SHA1('$password'), NOW())";

        $password_hash = sha1($password);
        $q = "INSERT INTO users (first_name, last_name, email, password, reg_date) ".
                "VALUES ('$first_name', '$last_name', '$email', '$password_hash', NOW())";

        $r = mysqli_query($dbc, $q);
        if ($r) {
            echo '<h2>Registered!</h2><p>You are now registered.</p>';
            if (isset($_SESSION['confirm'])) {
                echo '<p><button type="button"><a href="confirm.php">Proceed to Make Reservation</a></button></p>';
            }
        }
        else {
            echo '<p>Registration failed</p>';
        }
        
        mysqli_close($dbc);
        
        exit();
    }
    else { // else report error.
        echo '<p>Email address already registered. <a href="login.php">Login</a></p>';
        mysqli_close($dbc);
    }
}

?>

<!-- Display body section with sticky form. -->
<h2>Register</h2>
<form action="register.php" method="post">
    <table>
    <tr>
        <td style="text-align: left">First Name </td>
        <td><input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" autofocus /></td>
    </tr>
    <tr>
        <td style="text-align: left">Last Name </td>
        <td><input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></td>
    </tr>
    <tr>
        <td style="text-align: left">Email Address </td>
        <td><input type="text" name="email" size="20" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td>
    </tr>
    <tr>
        <td style="text-align: left">Password </td>
        <td><input type="password" name="password1" size="20" value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>" /></td>
    </tr>
    <tr>
        <td style="text-align: left">Confirm Password </td>
        <td><input type="password" name="password2" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password2']; ?>" /></td>
    </tr>
    </table>
    <p><input type="submit" value="Register" /></p>
    
</form>
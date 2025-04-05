<?php
session_start();
require '../../config.php'; // Connect to the database

if (!isset($_POST['email'], $_POST['username'], $_POST['password'])) {
    header("Location: ../../auth.php"); // Redirect to auth page if no data
    exit();
}

$email = trim($_POST['email']); // Email
$username = trim($_POST['username']); // Login
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash Password
$registration_code = rand(100000, 999999); // Code Generator for email

// Save data in session for email confirmation
$_SESSION['reg_email'] = $email;
$_SESSION['reg_username'] = $username;
$_SESSION['reg_password'] = $password;
$_SESSION['reg_code'] = $registration_code;
$_SESSION['last_code_time'] = time();

// Send code for Email Confirmation
mail($email, "Verification Email", "Thanks for using this repository from TheFuZeeXD! your code:" . $registration_code . 
"
        Sincerely,
TheFuZeeXD", "From: no-reply@yourdomain.com");

// Go to email confirmation page
header("Location: ../mail/verify_email.php");
exit();
?>

<?php
session_start();
require '../../config.php'; // Connect to the database

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: ../../auth.php?error=empty");
        exit();
    }

    $username = trim($_POST['username']); // Login
    $password = $_POST['password']; // Password

    // Checking the user in the database
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error preparing request: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // User exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $email, $hashed_password);
        $stmt->fetch();

        // Password Verification
        if (password_verify($password, $hashed_password)) { 
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            setcookie("auth_user", $username, time() + (14 * 24 * 60 * 60), "/");

            header("Location: ../../yourdocument.html"); // Redirect to complete page
            exit();
        } else {
            header("Location: ../../auth.php?error=wrong_password"); // Redirect to Auth page wrong password
            exit();
        }
    } else {
        header("Location: ../auth.php?error=user_not_found"); // Redirect to Auth page user not found
        exit();
    }

    $stmt->close();
}

$conn->close();

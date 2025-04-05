<?php
session_start();
require '../../config.php'; // Connect to the database

if (!isset($_SESSION['reset_email'])) { // Check if the session variable is set
    header("Location: ../../auth.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password']; // New password
    $confirm_password = $_POST['confirm_password']; // Confirm password

    if ($new_password !== $confirm_password) {
        echo "Error: The passwords do not match!"; // Error message
    } else {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];

        // Update password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Deleting session data
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_code']);

        echo "Password changed successfully! <a href='../../auth.php'>Login</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Setting a new password</title>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
        <link rel="stylesheet" href="../../resource/style/reset_password.css">
</head>
<body>
    <div class="Screen">
    <div class="ResetPasswordComf">
    <h2>Enter new password</h2>
    <form action="reset_password.php" method="post">
        <input type="password" name="password" placeholder="new password" required><br>
        <input type="password" name="confirm_password" placeholder="repeat password" required><br>
        <button type="submit">Change password</button>
    </form>
    </div>
    </div>

    <footer>
        <h1>© 2025 TheFuZeeXD</h1>
        </footer>
</body>
</html>

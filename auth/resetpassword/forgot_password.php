<?php
session_start();
require '../../config.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if a user with such email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Save the email in the session for further verification
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code'] = rand(100000, 999999);
        $_SESSION['last_code_time'] = time(); // We record the time of sending the code

        // We send the code to email
        mail($email, "Reset Password", "Thanks for using this repository from TheFuZeeXD! your code: " . $_SESSION['reset_code'] . 
        "
        Sincerely,
        TheFuZeeXD", "From: no-reply@yourdomain.com");

        // Redirect to the code entry page
        header("Location: ../mail/enter_code.php");
        exit();
    } else {
        $error_message = "Account not found!"; // Error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="../../resource/style/auth.css">
</head>
<body>
 <section id="ContentWindowSection">
                <div class="resetPasseword">
                <h2>Forgot password?</h2>
                <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <form action="forgot_password.php" method="post">
                <input type="email" name="email" placeholder="mail" required><br>
                <h3>Password recovery is a process by which a user can regain access to their account if they have forgotten or lost their password.</h3> 
                <p onclick="loginSection()">I'll try to log in</p>
                <button type="submit">Reset</button>
                </form>
                </div>
 </section>
 <script src="../../resource/javascript/auth.js"></script>
</body>
</html>

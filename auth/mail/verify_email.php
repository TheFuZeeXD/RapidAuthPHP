<?php
session_start();
require '../../config.php'; // Connect to the database

if (!isset($_SESSION['reg_email'], $_SESSION['reg_username'], $_SESSION['reg_password'], $_SESSION['reg_code'])) {
    header("Location: ../registration/register.php");
    exit();
}

$email = $_SESSION['reg_email']; // Email
$username = $_SESSION['reg_username']; // Login
$password = $_SESSION['reg_password']; // Password
$registration_code = $_SESSION['reg_code']; // Registration code
$cooldown_time = 60; // Cooldown time in seconds
$time_left = isset($_SESSION['last_code_time']) ? $cooldown_time - (time() - $_SESSION['last_code_time']) : 0;
$time_left = max($time_left, 0); // Don't allow negative time left

$error_message = ""; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['code_submit'])) {
        $entered_code = trim($_POST['code']);
        if ($entered_code == $registration_code) {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, reg_date) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $username, $email, $password);
            $stmt->execute();
            $stmt->close();

             // Clear session
            unset($_SESSION['reg_email'], $_SESSION['reg_username'], $_SESSION['reg_password'], $_SESSION['reg_code']);
            header("Location: ../../yourdocument.html");
            exit();
        } else {
            $error_message = "Error: Invalid code!"; // Error
        }
    }

    // Resend code
    if (isset($_POST['resend_code'])) { 
        if ($time_left > 0) {
            $error_message = "Wait $time_left s. Before resending.";
        } else {
            $_SESSION['resend_code'] = rand(100000, 999999);
            $_SESSION['last_code_time'] = time();
            mail($email, "Verifycation Email", "Thanks for using this repository from TheFuZeeXD! your code: " . $_SESSION['resend_code'] . 
            "
            Sincerely,
            TheFuZeeXD", "From: no-reply@yourdomain.com");         
            $time_left = $cooldown_time;
            $error_message = "New code sent!"; // Notification
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration | Verifycation Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="../../resource/style/verify_email.css">
</head>
<body>
    <div class="Screen">
        <div class="VerifyEmail">
    <h2>Enter the code sent to your email  <?php echo htmlspecialchars($email); ?></h2>
    <form action="verify_email.php" method="post">
        <input type="text" name="code" placeholder="enter code" required><br>
        <p>Enter the code sent to your email<br>
        Didn't receive the code? Check your spam folder</p>
        <button type="submit" name="code_submit">Confim</button>
        <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    </form>

    <br>

    <form action="verify_email.php" method="post">
        <button type="submit" name="resend_code" id="resend_button">Resend code</button>
        <span id="timeLeft"></span>
    </form>
    </div>
    </div>

    <footer>
        <h1>© 2025 TheFuZeeXD</h1>
        </footer>
    <script>
    
    let cooldownTime = <?php echo isset($_SESSION['last_code_time']) ? max(0, $_SESSION['last_code_time'] + $cooldown_time - time()) : 0; ?>;
        let button, countdown;

        function updateTimer() {
            if (cooldownTime > 0) {
                button.disabled = true;
                countdown.innerText = `Wait ${cooldownTime} s.`; // Update countdown text
                cooldownTime--;
                setTimeout(updateTimer, 1000);
            } else {
                button.disabled = false;
                countdown.innerText = "";
            }
        }

        window.onload = function() {
            button = document.getElementById("resend_button");
            countdown = document.getElementById("countdown");
            updateTimer();
        }
    </script>
</body>
</html>

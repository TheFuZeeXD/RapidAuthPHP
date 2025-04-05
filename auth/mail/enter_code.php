<?php
session_start();

// If the session is not set, redirect to the auth page
if (!isset($_SESSION['reset_email'])) {
    header("Location: ../../auth.php");
    exit();
}

$email = $_SESSION['reset_email'];
$cooldown_time = 60; // Cooldown time for reseding the code (in seconds)

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code_submit'])) {
    $entered_code = trim($_POST['code']);

    if (empty($entered_code)) {
        $error_message = "Enter code!"; // Error
    } elseif (isset($_SESSION['reset_code']) && $entered_code == $_SESSION['reset_code']) {
        header("Location: ../resetpassword/reset_password.php"); // Redirect to password reset page 
        exit();
    } else {
        $error_message = "Error: Invalid code!"; // Error
    } 
}

// Resending code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resend_code'])) {
    if (isset($_SESSION['last_code_time']) && (time() - $_SESSION['last_code_time']) < $cooldown_time) {
        $remaining_time = $cooldown_time - (time() - $_SESSION['last_code_time']);
        $error_message = "Wait $remaining_time seconds before resending.";
    } else {
        $_SESSION['reset_code'] = rand(100000, 999999);
        $_SESSION['last_code_time'] = time(); // We record the time of sending the code

       // We send the code to email
        mail($email, "Reset Password", "Thanks for using this repository from TheFuZeeXD! your code: " . $_SESSION['reset_code'] . 
        "
        Sincerely,
        TheFuZeeXD", "From: no-reply@yourdomain.com");
         $success_message = "New code sent to email!"; // Success
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Reset Password | Code Verifycation</title>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
           <link rel="stylesheet" href="../../resource/style/enter_code.css">
    <script>
        let cooldownTime =  <?php echo isset($_SESSION['last_code_time']) ? max(0, $_SESSION['last_code_time'] + $cooldown_time - time()) : 0; ?>;
        let button, countdown;

        function updateTimer() {
            if (cooldownTime > 0) {
                button.disabled = true;
                countdown.innerText = "Wait " + cooldownTime + " s."; // Update countdown text
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
</head>
<body>

    <div class="Screen">
    <div class="ResetCode">
    <h2>Enter the code sent to your email</h2>
    
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?> 
    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
    <?php endif; ?>

    <form action="enter_code.php" method="post">
        <input type="text" name="code" placeholder="enter code" required><br>
        <button type="submit" name="code_submit">Confim</button>
    </form>

    <br>

    <form action="enter_code.php" method="post">
        <button type="submit" name="resend_code" id="resend_button">Resend code</button>
        <span id="countdown"></span>
    </form>
</div>
</div>
<footer>
    <h1>© 2025 TheFuZeeXD</h1>
    </footer>
</body>
</html>

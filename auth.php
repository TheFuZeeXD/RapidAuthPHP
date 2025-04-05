<?php
session_start();
require 'config.php'; // Connect to the database

// If there is a cookie, we try to log in automatically
if (isset($_COOKIE['auth_user'])) {
    $username = $_COOKIE['auth_user'];

    $stmt = $conn->prepare("SELECT id, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $email);
        $stmt->fetch();

        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        header("Location: yourdocument.html"); // Complete Login
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Email
    $username = trim($_POST['username']); // Login
    $password = trim($_POST['password']); // Password

    // We check if such email or login already exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "email_used"; // Error
    } else {
        //If the email and login are free, we pass the data to register.php
        $_SESSION['post_data'] = $_POST;
        header("Location: auth/registration/register.php");
        exit();
    }

    $stmt->close();
}


$error_message = "";

if (isset($_GET['error'])) { // Error handling
    switch ($_GET['error']) {
        case 'empty':
            $error_message = "Error: All fields must be filled in!";
            break;
        case 'wrong_password':
            $error_message = "Error: Invalid password!";
            break;
        case 'user_not_found':
            $error_message = "Error: User not found!";
            break;
        case 'email_used':
            $error_message = "Error: Mail/Login already in use!";
            break;

    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>TheFuZeeXD | Register/LogIn</title>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="resource/style/auth.css">
</head>
<body>

 <section id="ContentWindowSection">
  <div class="Screen">
   <div class="LogIn">
    <h2>Login</h2>
    <?php if (!empty($error_message)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?> 
    <form action="auth/authorization/login.php" method="post">
       <input type="text" name="username" placeholder="username" required><br>
       <input type="password" name="password" placeholder="password" required><br>
        <p onclick="resetSection()">Forgot password?</p>
        <button type="submit">Login</button>
        <h3 onclick="RegisterSection()">I don't have account</h3>
        
    </form>
   </div>
  </div>
 </section>

 <footer>
    <h1>© 2025 TheFuZeeXD</h1>
    </footer>
    <script src="resource/javascript/auth.js"></script>
</body>
</html>

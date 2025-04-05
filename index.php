<?php
session_start(); 
require 'config.php';

$authUser = isset($_COOKIE['auth_user']) ? $_COOKIE['auth_user'] : null; // Check if the user is auth
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
<style>
    a {
        background-color: black;
        border-radius:20px;
        padding:9px 29px;
        color:white;
        text-decoration:none;
        font-weight:800;
        font-size:30px;
        text-align: center;
        display:block;
        margin: auto;
        max-width: 70%;
        transition-duration: 0.2s;
    }

    a:hover {
        background-color: rgb(1, 232, 209);
        color: black;
    }

    p {
        text-align: center;
        margin: auto;
    }
    </style>
</head>
<body>
    <p>Check Authorization:</p>
    <?php if ($authUser): ?>
                <div onclick="location.href='yourdocument.html'" id="Profile" class="nav-item">
            <a>Profile</a>
        </div>   
        <?php else: ?>
        <div onclick="location.href='auth.php'" id="Profile" class="nav-item">
            <a>Login/Registration</a>
        </div>       
        <?php endif; ?>
</body>
</html>
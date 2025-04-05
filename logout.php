<?php
session_start();
session_destroy();

// Delete cookie
setcookie("auth_user", "", time() - 3600, "/");
setcookie("auth_token", "", time() - 3600, "/");

header("Location: index.php");
exit();
?>

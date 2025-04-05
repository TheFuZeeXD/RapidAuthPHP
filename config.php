<meta charset="utf-8">
<?php // This is DataBase MySQL connection file 
$servername = "localhost";
$username = "your_username"; // change to your database username
$password = "password"; // change to your database password
$dbname = "database_name"; // change for your database name

$conn = new mysqli($servername, $username, $password, $dbname); // Connect to the database

if ($conn->connect_error) {
    die("Connect error: " . $conn->connect_error); // Connect die
}
?>

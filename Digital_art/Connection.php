<?php
// Database connection file (config.php)
$servername = "localhost";
$username = "root";
$password = "";
$database = "art_marketplace";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

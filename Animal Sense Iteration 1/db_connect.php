<?php
$servername = "localhost：8888";
$username = "root";
$password = "Lc7ertRNAZs3";
$dbname = "bitnami_wordpress";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>

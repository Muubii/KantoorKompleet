<?php
$servername = "mysql";
$username = "root";
$password = "password";
$database = "Kantoor Compleet";


// Create connection
$conn = new mysqli($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

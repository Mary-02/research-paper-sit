<?php
$servername = "localhost"; // Change if using a remote database
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if no password)
$dbname = "papers_website"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

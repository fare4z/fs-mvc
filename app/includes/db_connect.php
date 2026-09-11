<?php
// db_connect.php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "student_portal_db";

// 1. Create the Object-Oriented Connection
$conn = new mysqli($hostname, $username, $password, $database);

// 2. Check for connection errors using the object's properties
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Database connected successfully!";

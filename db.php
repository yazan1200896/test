<?php
// Database configuration
$host = 'localhost';  // Change if using a different host
$dbname = 'android';  // Replace with your actual database name
$username = 'root';  // Replace with your MySQL username
$password = '';  // Replace with your MySQL password (default is empty for XAMPP)

// Create the PDO instance and handle connection
try {
    // Establish connection to the database
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle the connection error
    die("Connection failed: " . $e->getMessage());
}
?>

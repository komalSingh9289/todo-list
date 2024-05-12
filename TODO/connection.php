<?php
$host = 'localhost';
$dbname = 'todo'; 
$username = 'root';
$password = '';

// Form data


// Connect to the database
try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}


?>
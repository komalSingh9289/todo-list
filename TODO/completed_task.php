<?php

// Check if the task ID is received

if(isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    // Include your database connection script
    require 'connection.php';

    try {
        // Prepare SQL statement to insert completed task
        $sql = "INSERT INTO completed (taskID) VALUES (:taskId)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':taskId', $taskId);

        // Execute the statement
        $stmt->execute();

        // Return success response
        
} catch(PDOException $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}
}

?>

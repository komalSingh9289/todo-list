<?php

require 'connection.php';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if taskId is set in the POST data
    if (isset($_POST['taskId'])) {
        // Retrieve the taskId from the POST data
        $taskId = $_POST['taskId'];

        try {
            

            // Prepare the SQL statement to delete the task
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :taskId");

            // Bind the taskId parameter
            $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Check if any rows were affected
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                // Task deleted successfully
                $response = array('success' => true, 'message' => 'Task deleted successfully');
            } else {
                // No rows affected, task might not exist
                $response = array('success' => false, 'message' => 'Task not found or already deleted');
            }
        } catch (PDOException $e) {
            // Handle database connection errors
            $response = array('success' => false, 'message' => 'Database error: ' . $e->getMessage());
        }

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If taskId is not set in the POST data, send an error response
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Task ID not provided'));
    }
} else {
    // If the request method is not POST, send an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed'));
}
?>

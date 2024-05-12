<?php

require 'connection.php';

try {

	if(isset($_POST['taskId'], $_POST['isChecked'])) {

    // Retrieve taskId and isChecked from the POST data
    $taskId = $_POST['taskId'];
       $isChecked = $_POST['isChecked'];

    $isCheckedValue = $isChecked === 'true' ? 1 : 0;
    


// Prepare SQL statement to update task status
$sql = "UPDATE tasks SET is_checked = :is_checked WHERE id = :task_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':is_checked', $isCheckedValue);
$stmt->bindParam(':task_id', $taskId);
$stmt->execute();

}	
} catch(PDOException $e) {
    // Display error message if something goes wrong
    echo "Error: " . $e->getMessage();
}




?>